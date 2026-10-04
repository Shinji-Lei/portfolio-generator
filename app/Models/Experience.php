<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Experience extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'portfolio_id',
        'company',
        'position',
        'description',
        'year_started',
        'year_ended',
    ];

    // The portfolio this job belongs to
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    // Returns a display range such as "2022 - Present"
    public function period(): string
    {
        return $this->year_started . ' - ' . ($this->year_ended ?? 'Present');
    }
}
