<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Craft;

class CraftsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $crafts = config('data.crafts');

        foreach($crafts as $craft) {
            $newCraft = new Craft;

            $newCraft->key = $craft['key'];

            $newCraft->save();
        }
    }
}
