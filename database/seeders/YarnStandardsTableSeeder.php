<?php

namespace Database\Seeders;

use App\Models\YarnStandard;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class YarnStandardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $yarn_standards = config('data.yarns.yarn_standards');

        foreach ($yarn_standards as $ys) {
            $newYs = new YarnStandard;

            $newYs->code = $ys['code'];
            $newYs->key = $ys['key'];

            $newYs->save();
        }
    }
}
