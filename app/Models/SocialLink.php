<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SocialLink extends Model
{
    public $timestamps = false;

    protected $fillable = ['portfolio_id', 'facebook', 'github', 'linkedin', 'instagram', 'website'];

    // The portfolio these links belong to
    public function portfolio(): BelongsTo
    {
        return $this->belongsTo(Portfolio::class);
    }

    // Returns only the links that were filled in, keyed by platform name
    public function filled(): array
    {
        return array_filter($this->only(['facebook', 'github', 'linkedin', 'instagram', 'website']));
    }
}
