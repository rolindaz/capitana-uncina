<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectTranslation;

class ProjectTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = config('data.locales');

        foreach($locales as $locale) {

            $configKey = "data.{$locale}.projects.projects";
            $project_translations = config($configKey);
            
            foreach ($project_translations as $data) {
                $newData = new ProjectTranslation;
                
                $newData->project_id = $data['project_id'];
                $newData->locale = $data['locale'];
                $newData->name = $data['name'];
                $newData->notes = $data['notes'];
                $newData->craft = $data['craft'];
                $newData->status = $data['status'];
                $newData->destination_use = $data['destination_use'];
                $newData->slug = $data['slug'];
    
                $newData->save();
            }
        }
    }
}
