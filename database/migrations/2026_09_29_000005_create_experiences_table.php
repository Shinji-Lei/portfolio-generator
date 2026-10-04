<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Creates the experiences table (many per portfolio)
    public function up(): void
    {
        Schema::create('experiences', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();
            $table->string('company');
            $table->string('position');
            $table->text('description')->nullable();
            $table->unsignedSmallInteger('year_started');
            // Null means the person still works there
            $table->unsignedSmallInteger('year_ended')->nullable();
        });
    }

    // Drops the experiences table
    public function down(): void
    {
        Schema::dropIfExists('experiences');
    }
};
