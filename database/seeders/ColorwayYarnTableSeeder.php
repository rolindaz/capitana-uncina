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
        $stash = config('data.colorway_yarn');

        foreach ($stash as $cy) {
            $newCy = new ColorwayYarn;

            $newCy->colorway_id = $cy['colorway_id'];
            $newCy->yarn_id = $cy['yarn_id'];
            $newCy->quantity = $cy['quantity'];
            $newCy->meterage = $cy['meterage'];
            $newCy->weight = $cy['weight'];

            $newCy->save();
        }
    }
}
