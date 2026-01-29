<?php

namespace Database\Seeders;

use App\Models\YarnType;
use Illuminate\Database\Seeder;

class YarnTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $yarn_types = config('data.yarns.yarn_types');

        foreach ($yarn_types as $yt) {
            $newYt = new YarnType;

            $newYt->yarn_standard_id = $yt['yarn_standard_id'];
            $newYt->base_key = $yt['base_key'];
            $newYt->key = $yt['key'];
            $newYt->name = $yt['name'];
            $newYt->ply = $yt['ply'];

            $newYt->save();
        }
    }
}
