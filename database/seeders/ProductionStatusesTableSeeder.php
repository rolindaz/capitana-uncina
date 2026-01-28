<?php

namespace Database\Seeders;

use App\Models\ProductionStatus;
use Illuminate\Database\Seeder;

class ProductionStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $p_statuses = config('data.production_statuses');

        foreach ($p_statuses as $ps) {
            $newPs = new ProductionStatus;

            $newPs->key = $ps;

            $newPs->save();
        }
    }
}
