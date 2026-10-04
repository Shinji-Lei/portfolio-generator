<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'portfolio_id',
        'project_name',
        'description',
        'technologies',
        'github_link',
        'demo_link',
    ];

    // The portfolio this project belongs to
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    // Splits the comma-separated technologies string into a clean array for badges
    public function technologyList(): array
    {
        return array_values(array_filter(array_map('trim', explode(',', (string) $this->technologies))));
    }
}
