{{-- Shared create/edit form. Expects: $portfolio, $action, $method, $resetUrl --}}
@php
    // Build the starting rows for each repeater: old input first, then saved data, then one blank row
    $blankEducation  = ['school' => '', 'degree' => '', 'year_started' => '', 'year_graduated' => ''];
    $blankProject    = ['project_name' => '', 'technologies' => '', 'description' => '', 'github_link' => '', 'demo_link' => ''];
    $blankExperience = ['company' => '', 'position' => '', 'year_started' => '', 'year_ended' => '', 'description' => ''];

    $rowsFor = function (string $relation, array $blank) use ($portfolio) {
        $saved = $portfolio->exists
            ? $portfolio->{$relation}->map(fn ($m) => $m->only(array_keys($blank)))->values()->all()
            : [];

        return array_values(old($relation, $saved)) ?: [$blank];
    };

    $educations  = $rowsFor('educations', $blankEducation);
    $projects    = $rowsFor('projects', $blankProject);
    $experiences = $rowsFor('experiences', $blankExperience);
    $skills      = array_values(old('skills', $portfolio->exists ? $portfolio->skills->pluck('skill_name')->all() : []));
    $links       = $portfolio->socialLinks;
@endphp

<form method="POST" action="{{ $action }}" enctype="multipart/form-data" novalidate
      x-data="{ loading: false }" @submit="loading = true" class="space-y-6">
    @csrf
    @if ($method !== 'POST') @method($method) @endif

    {{-- All validation errors in one place --}}
    @if ($errors->any())
        <div class="rounded-2xl border border-rose-500/30 bg-rose-500/10 p-4 text-sm text-rose-200" role="alert">
            <p class="font-semibold text-rose-100">Please fix the following:</p>
            <ul class="mt-2 list-disc space-y-1 pl-5 marker:text-rose-400">
                @foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach
            </ul>
        </div>
    @endif

    {{-- Personal information --}}
    <x-form-section title="Personal Information" description="The basics that appear at the top of your portfolio." icon="user">
        {{-- Profile picture with live preview --}}
        <div x-data="{ preview: @js($portfolio->profile_picture_url) }" class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center">
            <div class="flex h-24 w-24 shrink-0 items-center justify-center overflow-hidden rounded-full bg-gradient-to-br from-violet-500 via-fuchsia-500 to-indigo-500 text-2xl font-semibold text-white shadow-lg shadow-violet-900/40 ring-4 ring-white/10">
                {{-- FIXED: x-on:error instead of @error (Blade treats @error as a directive) --}}
                <template x-if="preview"><img :src="preview" x-on:error="preview = null" alt="Profile picture preview" class="h-full w-full object-cover"></template>
                <template x-if="!preview"><span>{{ $portfolio->initials ?: '?' }}</span></template>
            </div>
            <div class="flex-1">
                <label for="profile_picture" class="block text-sm font-medium text-slate-300">Profile picture</label>
                <input id="profile_picture" name="profile_picture" type="file" accept=".jpg,.jpeg,.png,.webp"
                       @change="preview = $event.target.files[0] ? URL.createObjectURL($event.target.files[0]) : preview"
                       class="mt-1 block w-full text-sm text-slate-400 file:mr-4 file:cursor-pointer file:rounded-xl file:border file:border-violet-400/30 file:bg-violet-500/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-200 hover:file:bg-violet-500/20">
                <p class="mt-1 text-xs text-slate-500">JPG, JPEG, PNG, or WEBP. Maximum 2 MB.</p>
                @error('profile_picture')<p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="grid gap-5 sm:grid-cols-2">
            <x-field label="Full name" name="full_name" :value="$portfolio->full_name" required placeholder="Juan Dela Cruz" />
            <x-field label="Professional title" name="professional_title" :value="$portfolio->professional_title" required placeholder="Full-Stack Developer" />
            <x-field label="Email" name="email" type="email" :value="$portfolio->email" required placeholder="you@example.com" />
            <x-field label="Contact number" name="contact_number" type="tel" :value="$portfolio->contact_number" required placeholder="+63 912 345 6789" />
            <x-field class="sm:col-span-2" label="Address" name="address" :value="$portfolio->address" placeholder="City, Country" />
            <x-field class="sm:col-span-2" label="About me" name="about" :value="$portfolio->about" textarea :rows="5" required
                     placeholder="Write a short introduction about yourself." hint="Up to 2000 characters." />
        </div>
    </x-form-section>

    {{-- Education --}}
    <x-form-section title="Education" description="Add every school you want to show." icon="academic-cap">
        <x-repeater title="Education" :rows="$educations" :blank="$blankEducation" add-label="Add education">
            <x-row-input label="School" group="educations" field="school" placeholder="University or school name" />
            <x-row-input label="Degree" group="educations" field="degree" placeholder="BS Information Technology" />
            <x-row-input label="Year started" group="educations" field="year_started" type="number" placeholder="2022" />
            <x-row-input label="Year graduated" group="educations" field="year_graduated" type="number" placeholder="2026" />
        </x-repeater>
    </x-form-section>

    {{-- Skills --}}
    <x-form-section title="Skills" description="Type a skill and press Enter or the Add button." icon="bolt">
        <div x-data="skillsInput(@js($skills))">
            <div class="flex gap-2">
                <input type="text" x-model="input" @keydown.enter.prevent="add()" @keydown.comma.prevent="add()"
                       placeholder="e.g. Laravel" aria-label="New skill"
                       class="block w-full rounded-xl border-white/10 bg-white/5 px-3.5 py-2.5 text-sm text-slate-100 shadow-sm placeholder:text-slate-500 focus:border-violet-400 focus:bg-white/10 focus:ring-2 focus:ring-violet-400/30">
                <button type="button" @click="add()" class="rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 px-5 py-2.5 text-sm font-semibold text-white shadow-md shadow-violet-900/30 transition hover:brightness-110">Add</button>
            </div>
            {{-- A skill typed but not yet added is still submitted --}}
            <input type="hidden" name="skills[]" :value="input.trim()" :disabled="!input.trim()">
            <div class="mt-4 flex flex-wrap gap-2">
                <template x-for="(skill, i) in skills" :key="skill">
                    <span class="inline-flex items-center gap-1.5 rounded-full bg-violet-500/10 py-1.5 pl-3.5 pr-2 text-sm font-medium text-violet-200 ring-1 ring-inset ring-violet-400/30">
                        <span x-text="skill"></span>
                        <button type="button" @click="remove(i)" class="rounded-full p-0.5 text-violet-300 transition hover:bg-violet-500/30 hover:text-white" :aria-label="'Remove ' + skill">
                            <svg class="h-3.5 w-3.5" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path d="M6.28 5.22a.75.75 0 0 0-1.06 1.06L8.94 10l-3.72 3.72a.75.75 0 1 0 1.06 1.06L10 11.06l3.72 3.72a.75.75 0 1 0 1.06-1.06L11.06 10l3.72-3.72a.75.75 0 0 0-1.06-1.06L10 8.94 6.28 5.22Z"/></svg>
                        </button>
                        <input type="hidden" name="skills[]" :value="skill">
                    </span>
                </template>
            </div>
            @error('skills.*')<p class="mt-2 text-sm text-rose-400">{{ $message }}</p>@enderror
        </div>
    </x-form-section>

    {{-- Projects --}}
    <x-form-section title="Projects" description="Show off what you have built." icon="folder">
        <x-repeater title="Project" :rows="$projects" :blank="$blankProject" add-label="Add project">
            <x-row-input label="Project name" group="projects" field="project_name" placeholder="Task Manager" />
            <x-row-input label="Technologies used" group="projects" field="technologies" placeholder="Laravel, MySQL, Tailwind" />
            <x-row-input label="Description" group="projects" field="description" textarea full placeholder="What does it do?" />
            <x-row-input label="GitHub link" group="projects" field="github_link" type="url" placeholder="https://github.com/you/project" />
            <x-row-input label="Live demo link" group="projects" field="demo_link" type="url" placeholder="https://your-demo.com" />
        </x-repeater>
    </x-form-section>

    {{-- Work experience --}}
    <x-form-section title="Work Experience" description="Leave the end year empty for your current job." icon="briefcase">
        <x-repeater title="Experience" :rows="$experiences" :blank="$blankExperience" add-label="Add experience">
            <x-row-input label="Company" group="experiences" field="company" placeholder="Company name" />
            <x-row-input label="Position" group="experiences" field="position" placeholder="Junior Developer" />
            <x-row-input label="Year started" group="experiences" field="year_started" type="number" placeholder="2024" />
            <x-row-input label="Year ended" group="experiences" field="year_ended" type="number" placeholder="Leave blank if current" />
            <x-row-input label="Description" group="experiences" field="description" textarea full placeholder="What did you do there?" />
        </x-repeater>
    </x-form-section>

    {{-- Social links --}}
    <x-form-section title="Social Links" description="Full links, starting with https://" icon="link">
        <div class="grid gap-5 sm:grid-cols-2">
            <x-field label="Facebook" name="social_links[facebook]" type="url" :value="$links?->facebook" placeholder="https://facebook.com/you" />
            <x-field label="GitHub" name="social_links[github]" type="url" :value="$links?->github" placeholder="https://github.com/you" />
            <x-field label="LinkedIn" name="social_links[linkedin]" type="url" :value="$links?->linkedin" placeholder="https://linkedin.com/in/you" />
            <x-field label="Instagram" name="social_links[instagram]" type="url" :value="$links?->instagram" placeholder="https://instagram.com/you" />
            <x-field class="sm:col-span-2" label="Personal website" name="social_links[website]" type="url" :value="$links?->website" placeholder="https://yourname.com" />
        </div>
    </x-form-section>

    {{-- Optional extras --}}
    <x-form-section title="Additional Information" description="Optional details to round out your portfolio." icon="document">
        <div class="space-y-5">
            <div>
                <label for="resume" class="block text-sm font-medium text-slate-300">Resume (PDF)</label>
                <input id="resume" name="resume" type="file" accept="application/pdf,.pdf"
                       class="mt-1 block w-full text-sm text-slate-400 file:mr-4 file:cursor-pointer file:rounded-xl file:border file:border-violet-400/30 file:bg-violet-500/10 file:px-4 file:py-2 file:text-sm file:font-semibold file:text-violet-200 hover:file:bg-violet-500/20">
                @if ($portfolio->resume_url)
                    <p class="mt-1 text-xs text-slate-500">Current file: <a href="{{ $portfolio->resume_url }}" target="_blank" rel="noopener" class="font-medium text-violet-300 hover:text-cyan-300 hover:underline">view resume</a>. Uploading a new one replaces it.</p>
                @else
                    <p class="mt-1 text-xs text-slate-500">PDF only. Maximum 5 MB.</p>
                @endif
                @error('resume')<p class="mt-1 text-sm text-rose-400">{{ $message }}</p>@enderror
            </div>
            <x-field label="Certificates" name="certificates" :value="$portfolio->certificates" textarea :rows="3" placeholder="One per line or separated by commas" />
            <x-field label="Languages" name="languages" :value="$portfolio->languages" placeholder="English, Filipino, Cebuano" />
            <x-field label="Interests" name="interests" :value="$portfolio->interests" placeholder="Open source, photography" />
        </div>
    </x-form-section>

    {{-- Form buttons --}}
    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">
        <button type="button" @click="if (confirm('Reset the form and discard your changes?')) window.location.href = @js($resetUrl)"
                class="rounded-xl border border-white/10 bg-white/5 px-6 py-3 text-sm font-semibold text-slate-300 transition hover:bg-white/10 hover:text-white">
            Reset Form
        </button>
        <button type="submit" :disabled="loading" :class="loading ? 'opacity-70 cursor-wait' : 'hover:shadow-lg hover:shadow-violet-700/40 hover:brightness-110'"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-gradient-to-r from-violet-600 to-fuchsia-600 px-8 py-3 text-sm font-semibold text-white shadow-md shadow-violet-900/40 transition">
            <svg x-show="loading" x-cloak class="h-4 w-4 animate-spin" viewBox="0 0 24 24" fill="none" aria-hidden="true"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" class="opacity-25"/><path fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4Z" class="opacity-75"/></svg>
            <span x-text="loading ? 'Saving...' : 'Save Portfolio'">Save Portfolio</span>
        </button>
    </div>
</form>

@push('scripts')
<script>
    // Registers the Alpine helpers used by the repeaters and the skills input
    document.addEventListener('alpine:init', () => {
        // Generic list of rows that can be added and removed
        Alpine.data('repeater', (rows, blank) => ({
            rows: rows.map((row, i) => ({ ...row, _k: i })),
            next: rows.length,
            add() { this.rows.push({ ...blank, _k: this.next++ }); },
            remove(i) { this.rows.splice(i, 1); },
        }));

        // Tag-style skills input that avoids duplicates
        Alpine.data('skillsInput', (initial) => ({
            skills: initial,
            input: '',
            add() {
                const value = this.input.replace(/,/g, '').trim();
                if (value && !this.skills.includes(value)) this.skills.push(value);
                this.input = '';
            },
            remove(i) { this.skills.splice(i, 1); },
        }));
    });
</script>
@endpush