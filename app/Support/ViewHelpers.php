<?php

namespace App\Support;

class ViewHelpers
{
    // Splits comma- or line-separated text into a clean list of items
    public static function split(?string $text): array
    {
        return array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', (string) $text))));
    }

    // Returns a display name for a social platform key
    public static function socialLabel(string $key): string
    {
        return [
            'facebook'  => 'Facebook',
            'github'    => 'GitHub',
            'linkedin'  => 'LinkedIn',
            'instagram' => 'Instagram',
            'website'   => 'Website',
        ][$key] ?? ucfirst($key);
    }
}
