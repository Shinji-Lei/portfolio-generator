<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Runs all seeders; comment out the demo one for a clean production database
    public function run(): void
    {
        $this->call(DemoPortfolioSeeder::class);
    }
}
