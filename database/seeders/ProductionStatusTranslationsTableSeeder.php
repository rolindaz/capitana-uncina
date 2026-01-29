<?php

namespace Database\Seeders;

use App\Models\ProductionStatusTranslation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionStatusTranslationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $locales = config('data.locales');

        foreach ($locales as $locale) {
            $configKey = 'data.' . $locale . '.production_statuses.production_statuses';

            $psTranslation = config($configKey);

            foreach ($psTranslation as $data) {
                $newPst = new ProductionStatusTranslation;

                $newPst->production_status_id = $data['production_status_id'];
                $newPst->locale = $locale;
                $newPst->label = $data['label'];

                $newPst->save();
            }
        }
    }
}
