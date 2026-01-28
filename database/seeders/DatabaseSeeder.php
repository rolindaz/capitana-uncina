<?php

namespace Database\Seeders;

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
            UsersTableSeeder::class,
            CategoriesTableSeeder::class,
            CategoryTranslationsTableSeeder::class,
            ColorwaysTableSeeder::class,
            ColorwayTranslationsTableSeeder::class,
            ProjectsTableSeeder::class,
            ProjectTranslationsTableSeeder::class,
            FibersTableSeeder::class,
            FiberTranslationsTableSeeder::class,
            YarnsTableSeeder::class,
            ProductionStatusesTableSeeder::class,
            ProductionStatusTranslationsTableSeeder::class,
            ColorwayYarnTableSeeder::class,
            StashItemsTableSeeder::class,
            ProjectYarnTableSeeder::class,
            FiberYarnTableSeeder::class,
            CraftsTableSeeder::class,
            CraftTranslationsTableSeeder::class,
            CraftProjectTableSeeder::class,
        ]);
    }
}
