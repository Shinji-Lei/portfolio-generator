<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Education extends Model
{
    // Table name is set because "education" is uncountable in Laravel's pluralizer
    protected $table = 'educations';

    public $timestamps = false;

    protected $fillable = ['portfolio_id', 'school', 'degree', 'year_started', 'year_graduated'];

    // The portfolio this entry belongs to
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }
}
