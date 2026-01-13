<?php

namespace Database\Seeders;

use App\Models\FiberYarn;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FiberYarnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fiber_yarn = config('data.fiber_yarn');

        foreach($fiber_yarn as $data) {

            $newData = new FiberYarn;

            $newData->fiber_id = $data['fiber_id'];
            $newData->yarn_id = $data['yarn_id'];
            $newData->percentage = $data['percentage'];

            $newData->save();
        }
    }
}
