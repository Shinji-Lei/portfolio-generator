<?php

namespace App\Models;

use App\Services\FileUploadService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Portfolio extends Model
{
    // The only three templates the app supports
    public const TEMPLATES = ['simple', 'modern', 'creative'];

    // Columns that may be mass assigned
    protected $fillable = [
        'user_id',
        'full_name',
        'professional_title',
        'profile_picture',
        'email',
        'contact_number',
        'address',
        'about',
        'resume',
        'certificates',
        'languages',
        'interests',
        'selected_template',
    ];

    // The user who owns this portfolio
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Education entries, oldest start year first
    public function educations(): HasMany
    {
        return $this->hasMany(Education::class)->orderBy('year_started');
    }

    // Skill entries
    public function skills(): HasMany
    {
        return $this->hasMany(Skill::class);
    }

    // Project entries
    public function projects(): HasMany
    {
        return $this->hasMany(Project::class);
    }

    // Work experience entries, newest first
    public function experiences(): HasMany
    {
        return $this->hasMany(Experience::class)->orderByDesc('year_started');
    }

    // The single row of social links
    public function socialLinks(): HasOne
    {
        return $this->hasOne(SocialLink::class);
    }

    // Public URL of the profile picture, or null when none was uploaded
    protected function profilePictureUrl(): Attribute
    {
        return Attribute::get(fn () => app(FileUploadService::class)->url($this->profile_picture));
    }

    // Public URL of the uploaded resume PDF, or null when none was uploaded
    protected function resumeUrl(): Attribute
    {
        return Attribute::get(fn () => app(FileUploadService::class)->url($this->resume));
    }

    // Up to two initials of the full name, used when there is no profile picture
    protected function initials(): Attribute
    {
        return Attribute::get(function () {
            return collect(preg_split('/\s+/', trim((string) $this->full_name)))
                ->filter()
                ->take(2)
                ->map(fn ($part) => mb_strtoupper(mb_substr($part, 0, 1)))
                ->implode('');
        });
    }

    // Limits results to portfolios owned by the given user
    public function scopeOwnedBy(Builder $query, int $userId): Builder
    {
        return $query->where('user_id', $userId);
    }

    // Filters by name, email, or title when a search term is given
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (blank($term)) {
            return $query;
        }

        return $query->where(function (Builder $q) use ($term) {
            $q->where('full_name', 'like', "%{$term}%")
              ->orWhere('email', 'like', "%{$term}%")
              ->orWhere('professional_title', 'like', "%{$term}%");
        });
    }

    // Sorts by name (A-Z / Z-A) or date (newest / oldest) using a sort key
    public function scopeSortBy(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'name_asc'  => $query->orderBy('full_name'),
            'name_desc' => $query->orderByDesc('full_name'),
            'date_asc'  => $query->oldest(),
            default     => $query->latest(),
        };
    }
}
