<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = config('data.categories');

        
        foreach ($categories as $category) {
            $newCategory = new Category;
            
            $newCategory->key = $category['key'];
            $newCategory->parent_id = $category['parent_id'];

            $newCategory->save();
        }
    }
}
