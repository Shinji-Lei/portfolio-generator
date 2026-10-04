<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Creates the social_links table (one row per portfolio)
    public function up(): void
    {
        Schema::create('social_links', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->unique()->constrained()->cascadeOnDelete();
            $table->string('facebook')->nullable();
            $table->string('github')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('website')->nullable();
        });
    }

    // Drops the social_links table
    public function down(): void
    {
        Schema::dropIfExists('social_links');
    }
};
