<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Creates the main portfolios table, owned by a user
    public function up(): void
    {
        Schema::create('portfolios', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            // Personal information
            $table->string('full_name');
            $table->string('professional_title');
            $table->string('profile_picture')->nullable();
            $table->string('email');
            $table->string('contact_number', 30);
            $table->string('address', 500)->nullable();
            $table->text('about');

            // Optional extras
            $table->string('resume')->nullable();
            $table->text('certificates')->nullable();
            $table->text('languages')->nullable();
            $table->text('interests')->nullable();

            // One of: simple, modern, creative
            $table->string('selected_template', 20)->default('simple');

            $table->timestamps();

            // Speeds up the search and sort on the Manage page
            $table->index(['user_id', 'full_name']);
        });
    }

    // Drops the portfolios table
    public function down(): void
    {
        Schema::dropIfExists('portfolios');
    }
};
