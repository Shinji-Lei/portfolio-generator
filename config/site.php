<?php

// Public contact details and social links shown in the footer.
// Override any value with the matching variable in .env (or Railway Variables).
return [
    'email'    => env('SITE_EMAIL', 'hello@example.com'),
    'phone'    => env('SITE_PHONE', '+63 900 000 0000'),
    'location' => env('SITE_LOCATION', 'Philippines'),
    'hours'    => env('SITE_HOURS', 'Mon - Fri, 9:00 AM - 6:00 PM'),

    // Network => profile URL (generic homepages until you add your own)
    'social' => [
        'facebook'  => env('SITE_FACEBOOK', 'https://facebook.com'),
        'instagram' => env('SITE_INSTAGRAM', 'https://instagram.com'),
        'linkedin'  => env('SITE_LINKEDIN', 'https://linkedin.com'),
        'github'    => env('SITE_GITHUB', 'https://github.com'),
        'x'         => env('SITE_X', 'https://x.com'),
    ],
];
