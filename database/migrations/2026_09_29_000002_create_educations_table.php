<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Creates the educations table (many per portfolio)
    public function up(): void
    {
        Schema::create('educations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('portfolio_id')->constrained()->cascadeOnDelete();
            $table->string('school');
            $table->string('degree');
            $table->unsignedSmallInteger('year_started');
            $table->unsignedSmallInteger('year_graduated')->nullable();
        });
    }

    // Drops the educations table
    public function down(): void
    {
        Schema::dropIfExists('educations');
    }
};
