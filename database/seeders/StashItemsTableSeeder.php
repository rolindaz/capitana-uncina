<?php

namespace Database\Seeders;

use App\Models\StashItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StashItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stash = config('data.stash');

        foreach ($stash as $data) {
            $newStashItem = new StashItem;

            $newStashItem->user_id = 1;
            $newStashItem->colorway_yarn_id = $data['colorway_yarn_id'];
            $newStashItem->quantity = $data['quantity'];
            $newStashItem->meterage = $data['meterage'];
            $newStashItem->weight = $data['weight'];

            $newStashItem->save();
        }
    }
}
