<?php

return [

    // Filesystem disk used for profile pictures and resumes (see config/filesystems.php)
    'disk' => env('PORTFOLIO_DISK', 'public'),

    // The three supported templates; keys must match Portfolio::TEMPLATES
    'templates' => [
        'simple' => [
            'name'        => 'Simple',
            'description' => 'Minimal white layout with a sidebar profile, elegant typography, and clean sections.',
        ],
        'modern' => [
            'name'        => 'Modern',
            'description' => 'Dark mode with glassmorphism cards, gradient buttons, and smooth animations.',
        ],
        'creative' => [
            'name'        => 'Creative',
            'description' => 'Colorful gradients, a hero banner, a timeline layout, and an animated project showcase.',
        ],
    ],

];
