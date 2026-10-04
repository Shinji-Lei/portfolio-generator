<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePortfolioRequest extends FormRequest
{
    // Any logged-in user may create a portfolio
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    // Removes blank repeater rows and empty skills before validation runs
    protected function prepareForValidation(): void
    {
        $this->merge([
            'educations'  => $this->withoutBlankRows($this->input('educations')),
            'projects'    => $this->withoutBlankRows($this->input('projects')),
            'experiences' => $this->withoutBlankRows($this->input('experiences')),
            'skills'      => $this->cleanSkills($this->input('skills')),
        ]);
    }

    // Validation rules for the whole portfolio form
    public function rules(): array
    {
        return [
            // Personal information
            'full_name'          => ['required', 'string', 'max:255'],
            'professional_title' => ['required', 'string', 'max:255'],
            'email'              => ['required', 'email:rfc', 'max:255'],
            'contact_number'     => ['required', 'regex:/^[0-9+\-\s()]{7,20}$/'],
            'address'            => ['nullable', 'string', 'max:500'],
            'about'              => ['required', 'string', 'max:2000'],
            'profile_picture'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'resume'             => ['nullable', 'file', 'mimes:pdf', 'max:5120'],

            // Optional extras
            'certificates'       => ['nullable', 'string', 'max:1000'],
            'languages'          => ['nullable', 'string', 'max:1000'],
            'interests'          => ['nullable', 'string', 'max:1000'],

            // Education rows
            'educations'                  => ['nullable', 'array', 'max:10'],
            'educations.*.school'         => ['required', 'string', 'max:255'],
            'educations.*.degree'         => ['required', 'string', 'max:255'],
            'educations.*.year_started'   => ['required', 'integer', 'digits:4', 'between:1950,2100'],
            'educations.*.year_graduated' => ['nullable', 'integer', 'digits:4', 'between:1950,2100', 'gte:educations.*.year_started'],

            // Skills
            'skills'   => ['nullable', 'array', 'max:50'],
            'skills.*' => ['string', 'max:100'],

            // Project rows
            'projects'                => ['nullable', 'array', 'max:20'],
            'projects.*.project_name' => ['required', 'string', 'max:255'],
            'projects.*.description'  => ['nullable', 'string', 'max:1000'],
            'projects.*.technologies' => ['nullable', 'string', 'max:255'],
            'projects.*.github_link'  => ['nullable', 'url', 'max:255'],
            'projects.*.demo_link'    => ['nullable', 'url', 'max:255'],

            // Work experience rows
            'experiences'                => ['nullable', 'array', 'max:15'],
            'experiences.*.company'      => ['required', 'string', 'max:255'],
            'experiences.*.position'     => ['required', 'string', 'max:255'],
            'experiences.*.description'  => ['nullable', 'string', 'max:1000'],
            'experiences.*.year_started' => ['required', 'integer', 'digits:4', 'between:1950,2100'],
            'experiences.*.year_ended'   => ['nullable', 'integer', 'digits:4', 'between:1950,2100', 'gte:experiences.*.year_started'],

            // Social links
            'social_links.facebook'  => ['nullable', 'url', 'max:255'],
            'social_links.github'    => ['nullable', 'url', 'max:255'],
            'social_links.linkedin'  => ['nullable', 'url', 'max:255'],
            'social_links.instagram' => ['nullable', 'url', 'max:255'],
            'social_links.website'   => ['nullable', 'url', 'max:255'],
        ];
    }

    // Human-friendly error messages
    public function messages(): array
    {
        return [
            'contact_number.regex'  => 'Enter a valid contact number (digits, spaces, + - ( ) only, 7-20 characters).',
            'profile_picture.image' => 'The profile picture must be an image.',
            'profile_picture.mimes' => 'The profile picture must be a JPG, JPEG, PNG, or WEBP file.',
            'profile_picture.max'   => 'The profile picture may not be larger than 2 MB.',
            'resume.mimes'          => 'The resume must be a PDF file.',
            'resume.max'            => 'The resume may not be larger than 5 MB.',
            '*.gte'                 => 'The end year cannot be earlier than the start year.',
            '*.url'                 => 'Enter a full link starting with http:// or https://.',
        ];
    }

    // Friendlier field names in error messages
    public function attributes(): array
    {
        return [
            'educations.*.school'         => 'school',
            'educations.*.degree'         => 'degree',
            'educations.*.year_started'   => 'start year',
            'educations.*.year_graduated' => 'graduation year',
            'projects.*.project_name'     => 'project name',
            'projects.*.github_link'      => 'GitHub link',
            'projects.*.demo_link'        => 'live demo link',
            'experiences.*.company'       => 'company',
            'experiences.*.position'      => 'position',
            'experiences.*.year_started'  => 'start year',
            'experiences.*.year_ended'    => 'end year',
            'skills.*'                    => 'skill',
        ];
    }

    // Drops repeater rows where every field is empty
    private function withoutBlankRows(mixed $rows): array
    {
        return collect(is_array($rows) ? $rows : [])
            ->filter(fn ($row) => is_array($row) && collect($row)->contains(fn ($v) => filled($v)))
            ->values()
            ->all();
    }

    // Trims skills and drops empty or duplicate ones
    private function cleanSkills(mixed $skills): array
    {
        return collect(is_array($skills) ? $skills : [])
            ->map(fn ($s) => is_string($s) ? trim($s) : '')
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
