<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\CraftTranslation;

class CraftTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = config('data.locales');

        foreach($locales as $locale) {

            $configKey = "data.{$locale}.crafts.crafts";
            $craft_translations = config($configKey);
            
            foreach ($craft_translations as $data) {
                $newData = new CraftTranslation;
                
                $newData->craft_id = $data['craft_id'];
                $newData->locale = $data['locale'];
                $newData->name = $data['name'];
                $newData->description = $data['description'];
                $newData->slug = $data['slug'];
    
                $newData->save();
            }
        }
    }
}
