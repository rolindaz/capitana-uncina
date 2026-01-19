<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Colorway;

class ColorwaysTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $colorways = config('data.colorways');

        foreach($colorways as $data) {
            $newColorway = new Colorway;

            $newColorway->color_code = $data['color_code'];
            $newColorway->key = $data['key'];
            $newColorway->image_path = $data['image_path'];

            $newColorway->save();
        }
    }
}
