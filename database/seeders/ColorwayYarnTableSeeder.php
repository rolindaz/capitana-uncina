<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ColorwayYarn;

class ColorwayYarnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colorway_yarns = config('data.colorway_yarn');

        foreach ($colorway_yarns as $cy) {
            $newCy = new ColorwayYarn;

            $newCy->colorway_id = $cy['colorway_id'];
            $newCy->yarn_id = $cy['yarn_id'];
            $newCy->production_status_id = $cy['production_status_id'];

            $newCy->save();
        }
    }
}
