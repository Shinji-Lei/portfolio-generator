<?php

namespace Database\Seeders;

use App\Models\Portfolio;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoPortfolioSeeder extends Seeder
{
    // Creates a demo user with three sample portfolios, one per template
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => 'demo@example.com'],
            ['name' => 'Demo User', 'password' => Hash::make('password')]
        );

        $samples = [
            ['Alex Rivera', 'Full-Stack Developer', 'simple'],
            ['Maria Santos', 'UI/UX Designer', 'modern'],
            ['Jon Reyes', 'Mobile App Developer', 'creative'],
        ];

        foreach ($samples as [$name, $title, $template]) {
            $portfolio = Portfolio::create([
                'user_id'            => $user->id,
                'full_name'          => $name,
                'professional_title' => $title,
                'email'              => strtolower(str_replace(' ', '.', $name)) . '@example.com',
                'contact_number'     => '+63 912 345 6789',
                'address'            => 'Cebu City, Philippines',
                'about'              => 'Passionate about building clean, useful software and learning something new every day.',
                'languages'          => 'English, Filipino, Cebuano',
                'interests'          => 'Open source, photography, basketball',
                'selected_template'  => $template,
            ]);

            // Education
            $portfolio->educations()->create([
                'school' => 'Cebu Eastern College', 'degree' => 'BS Information Technology',
                'year_started' => 2022, 'year_graduated' => 2026,
            ]);

            // Skills
            foreach (['Laravel', 'PHP', 'JavaScript', 'Tailwind CSS', 'MySQL'] as $skill) {
                $portfolio->skills()->create(['skill_name' => $skill]);
            }

            // Projects
            $portfolio->projects()->create([
                'project_name' => 'Task Manager', 'description' => 'A CRUD task manager with authentication.',
                'technologies' => 'Laravel, MySQL, Tailwind', 'github_link' => 'https://github.com/example/task-manager',
                'demo_link' => 'https://example.com/task-manager',
            ]);

            // Work experience
            $portfolio->experiences()->create([
                'company' => 'Sample Tech Inc.', 'position' => 'Junior Developer',
                'description' => 'Built and maintained internal web tools.',
                'year_started' => 2025, 'year_ended' => null,
            ]);

            // Social links
            $portfolio->socialLinks()->create([
                'github' => 'https://github.com/example', 'linkedin' => 'https://linkedin.com/in/example',
            ]);
        }
    }
}
