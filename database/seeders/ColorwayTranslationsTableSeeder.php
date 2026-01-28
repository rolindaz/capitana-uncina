<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ColorwayTranslation;

class ColorwayTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = config('data.locales');

        foreach($locales as $locale) {

            $configKey = "data.{$locale}.colorways.colorways";
            $colorway_translations = config($configKey);
            
            foreach ($colorway_translations as $data) {
                $newData = new ColorwayTranslation;
                
                $newData->colorway_id = $data['colorway_id'];
                $newData->locale = $locale;
                $newData->name = $data['name'];
                $newData->slug = $data['slug'];
    
                $newData->save();
            }
        }
    }
}
