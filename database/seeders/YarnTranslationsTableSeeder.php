<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\YarnTranslation;

class YarnTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = config('data.locales');

        foreach($locales as $locale) {

            $configKey = "data.{$locale}.yarns.yarns";
            $yarn_translations = config($configKey);
            
            foreach ($yarn_translations as $data) {
                $newData = new YarnTranslation;
                
                $newData->yarn_id = $data['yarn_id'];
                $newData->locale = $data['locale'];
                $newData->color_type = $data['color_type'];
                $newData->slug = $data['slug'];
    
                $newData->save();
            }
        }
    }
}
