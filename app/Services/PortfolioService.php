<?php

namespace App\Services;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Throwable;

class PortfolioService
{
    // Columns copied straight from the validated form data
    private const FIELDS = [
        'full_name', 'professional_title', 'email', 'contact_number',
        'address', 'about', 'certificates', 'languages', 'interests',
    ];

    public function __construct(private FileUploadService $uploads)
    {
    }

    // Creates a portfolio with all its child records and uploaded files
    public function create(User $user, array $data, ?UploadedFile $picture, ?UploadedFile $resume): Portfolio
    {
        $stored = [];

        try {
            return DB::transaction(function () use ($user, $data, $picture, $resume, &$stored) {
                // Store uploads first so their paths can be saved with the row
                $attributes = Arr::only($data, self::FIELDS);
                if ($picture) {
                    $attributes['profile_picture'] = $stored[] = $this->uploads->store($picture, 'profile-pictures');
                }
                if ($resume) {
                    $attributes['resume'] = $stored[] = $this->uploads->store($resume, 'resumes');
                }

                // Save the portfolio and its related rows
                $portfolio = $user->portfolios()->create($attributes);
                $this->syncChildren($portfolio, $data);

                return $portfolio;
            });
        } catch (Throwable $e) {
            // Remove any files stored before the failure so nothing is orphaned
            foreach ($stored as $path) {
                $this->uploads->delete($path);
            }
            throw $e;
        }
    }

    // Updates a portfolio, replacing its child records and swapping uploaded files
    public function update(Portfolio $portfolio, array $data, ?UploadedFile $picture, ?UploadedFile $resume): Portfolio
    {
        $newFiles = [];
        $oldFiles = [];

        try {
            DB::transaction(function () use ($portfolio, $data, $picture, $resume, &$newFiles, &$oldFiles) {
                // Replace the profile picture and remember the old file for cleanup
                $attributes = Arr::only($data, self::FIELDS);
                if ($picture) {
                    $oldFiles[] = $portfolio->profile_picture;
                    $attributes['profile_picture'] = $newFiles[] = $this->uploads->store($picture, 'profile-pictures');
                }

                // Replace the resume and remember the old file for cleanup
                if ($resume) {
                    $oldFiles[] = $portfolio->resume;
                    $attributes['resume'] = $newFiles[] = $this->uploads->store($resume, 'resumes');
                }

                // Save the changes and rebuild the related rows
                $portfolio->update($attributes);
                $this->syncChildren($portfolio, $data);
            });
        } catch (Throwable $e) {
            // Roll back newly stored files if the database update failed
            foreach ($newFiles as $path) {
                $this->uploads->delete($path);
            }
            throw $e;
        }

        // Only delete the old files once the database update has succeeded
        foreach ($oldFiles as $path) {
            $this->uploads->delete($path);
        }

        return $portfolio;
    }

    // Deletes a portfolio (children cascade in the database) and its files
    public function delete(Portfolio $portfolio): void
    {
        $files = [$portfolio->profile_picture, $portfolio->resume];

        $portfolio->delete();

        foreach ($files as $path) {
            $this->uploads->delete($path);
        }
    }

    // Rebuilds education, skills, projects, experiences, and social links from form data
    private function syncChildren(Portfolio $portfolio, array $data): void
    {
        // Education rows
        $portfolio->educations()->delete();
        $portfolio->educations()->createMany($data['educations'] ?? []);

        // Skill rows (the form sends a plain list of names)
        $portfolio->skills()->delete();
        $portfolio->skills()->createMany(
            collect($data['skills'] ?? [])->map(fn ($name) => ['skill_name' => $name])->all()
        );

        // Project rows
        $portfolio->projects()->delete();
        $portfolio->projects()->createMany($data['projects'] ?? []);

        // Work experience rows
        $portfolio->experiences()->delete();
        $portfolio->experiences()->createMany($data['experiences'] ?? []);

        // Single row of social links
        $portfolio->socialLinks()->updateOrCreate([], $data['social_links'] ?? []);
    }
}
