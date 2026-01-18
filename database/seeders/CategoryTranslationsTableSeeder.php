<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CategoryTranslation;

class CategoryTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = config('data.locales');

        foreach($locales as $locale) {

            $configKey = "data.{$locale}.categories.categories";
            $category_translations = config($configKey);
            
            foreach ($category_translations as $data) {
                $newData = new CategoryTranslation;
                
                $newData->category_id = $data['category_id'];
                $newData->locale = $locale;
                $newData->name = $data['name'];
                $newData->slug = $data['slug'];
    
                $newData->save();
            }
        }
    }
}
