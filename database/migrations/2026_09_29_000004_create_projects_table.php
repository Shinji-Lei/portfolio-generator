<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Creates the projects table (many per portfolio)
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();
            $table->string('project_name');
            $table->text('description')->nullable();
            $table->string('technologies')->nullable();
            $table->string('github_link')->nullable();
            $table->string('demo_link')->nullable();
        });
    }

    // Drops the projects table
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
