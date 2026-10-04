<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    // Returns the disk name configured for portfolio uploads
    public function disk(): string
    {
        return config('portfolio.disk');
    }

    // Stores an uploaded file in the given folder and returns its stored path
    public function store(UploadedFile $file, string $directory): string
    {
        return $file->store($directory, $this->disk());
    }

    // Deletes a stored file if a path is given
    public function delete(?string $path): void
    {
        if ($path) {
            Storage::disk($this->disk())->delete($path);
        }
    }

    // Returns the public URL of a stored file, or null when there is none
    public function url(?string $path): ?string
    {
        return $path ? Storage::disk($this->disk())->url($path) : null;
    }
}
