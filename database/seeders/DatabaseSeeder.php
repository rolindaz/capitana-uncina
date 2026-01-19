<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategoriesTableSeeder::class,
            CategoryTranslationsTableSeeder::class,
            ColorwaysTableSeeder::class,
            ProjectsTableSeeder::class,
            ProjectTranslationsTableSeeder::class,
            FibersTableSeeder::class,
            FiberTranslationsTableSeeder::class,
            YarnsTableSeeder::class,
            ProjectYarnTableSeeder::class,
            FiberYarnTableSeeder::class,
            CraftsTableSeeder::class,
            CraftTranslationsTableSeeder::class,
        ]);
    }
}
