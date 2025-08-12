<?php

namespace Database\Seeders;

use App\Models\JournalCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ini_set('memory_limit', '1024M');
        if (App::environment('local', 'development')) {
            $this->call([
                UniveristasFakultasProdiSeeder::class,
                UserSeeder::class,
                JournalCategorySeeder::class,
                JournalSeeder::class,
                JournalAuthorSeeder::class,


            ]);
        }
    }
}
