<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NewsletterSubscriber extends Model
{
    // Only the email address may be mass assigned
    protected $fillable = ['email'];
}
