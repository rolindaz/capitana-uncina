<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Yarn;

class YarnsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $yarns = config('data.yarns.yarns');

        foreach($yarns as $yarn) {
            $newYarn = new Yarn;

            $newYarn->key = $yarn['key'];
            $newYarn->name = $yarn['name'];
            $newYarn->brand = $yarn['brand'];
            $newYarn->weight = $yarn['weight'];
            $newYarn->category = $yarn['category'];
            $newYarn->ply = $yarn['ply'];
            $newYarn->unit_weight = $yarn['unit_weight'];
            $newYarn->meterage = $yarn['meterage'];
            $newYarn->fiber_types_number = $yarn['fiber_types_number'];
            $newYarn->image_path = $yarn['image_path'];
            $newYarn->min_hook_size = $yarn['min_hook_size'];
            $newYarn->max_hook_size = $yarn['max_hook_size'];
            $newYarn->min_needle_size = $yarn['min_needle_size'];
            $newYarn->max_needle_size = $yarn['max_needle_size'];

            $newYarn->save();
        }
    }
}
