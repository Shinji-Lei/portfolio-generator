<?php

namespace App\Support;

use App\Models\Education;
use App\Models\Experience;
use App\Models\Portfolio;
use App\Models\Project;
use App\Models\Skill;
use App\Models\SocialLink;

class SamplePortfolio
{
    // Builds an unsaved demo portfolio (with relations loaded) for template previews
    public static function make(string $template): Portfolio
    {
        $portfolio = new Portfolio([
            'full_name'          => 'Alex Rivera',
            'professional_title' => 'Full-Stack Developer',
            'email'              => 'alex.rivera@example.com',
            'contact_number'     => '+63 912 345 6789',
            'address'            => 'Cebu City, Philippines',
            'about'              => 'I build clean, responsive web applications and enjoy turning ideas into useful products. Currently focused on Laravel and modern JavaScript.',
            'certificates'       => 'Laravel Fundamentals, Responsive Web Design',
            'languages'          => 'English, Filipino, Cebuano',
            'interests'          => 'Open source, photography, basketball',
            'selected_template'  => $template,
        ]);

        // Attach related records in memory only; nothing is saved to the database
        $portfolio->setRelation('educations', collect([
            new Education(['school' => 'Cebu Eastern College', 'degree' => 'BS Information Technology', 'year_started' => 2022, 'year_graduated' => 2026]),
        ]));
        $portfolio->setRelation('skills', collect(
            array_map(fn ($name) => new Skill(['skill_name' => $name]), ['Laravel', 'PHP', 'JavaScript', 'Tailwind CSS', 'MySQL', 'Git'])
        ));
        $portfolio->setRelation('projects', collect([
            new Project(['project_name' => 'Task Manager', 'description' => 'A CRUD task manager with authentication.', 'technologies' => 'Laravel, MySQL, Tailwind', 'github_link' => 'https://github.com/example/task-manager', 'demo_link' => 'https://example.com/task-manager']),
            new Project(['project_name' => 'Weather Dashboard', 'description' => 'Live weather data with charts and saved locations.', 'technologies' => 'JavaScript, Chart.js', 'github_link' => 'https://github.com/example/weather', 'demo_link' => null]),
        ]));
        $portfolio->setRelation('experiences', collect([
            new Experience(['company' => 'Sample Tech Inc.', 'position' => 'Junior Developer', 'description' => 'Built and maintained internal web tools.', 'year_started' => 2025, 'year_ended' => null]),
        ]));
        $portfolio->setRelation('socialLinks', new SocialLink([
            'github' => 'https://github.com/example', 'linkedin' => 'https://linkedin.com/in/example',
        ]));

        return $portfolio;
    }
}
