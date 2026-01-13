<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\FiberTranslation;

class FiberTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = config('data.locales');

        foreach($locales as $locale) {

            $configKey = "data.{$locale}.fibers.fibers";
            $fiber_translations = config($configKey);
            
            foreach ($fiber_translations as $data) {
                $newData = new FiberTranslation;
                
                $newData->fiber_id = $data['fiber_id'];
                $newData->locale = $data['locale'];
                $newData->name = $data['name'];
                $newData->slug = $data['slug'];
    
                $newData->save();
            }
        }
    }
}
