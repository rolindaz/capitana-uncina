<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Fiber;

class FibersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $fibers = config('data.fibers');

        
        foreach ($fibers as $fiber) {
            $newFiber = new Fiber;
            
            $newFiber->key = $fiber['key'];

            $newFiber->save();
        }
    }
}
