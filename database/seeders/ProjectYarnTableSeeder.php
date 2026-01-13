<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ProjectYarn;

class ProjectYarnTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $project_yarn = config('data.project_yarn');

        
        foreach ($project_yarn as $data) {
            $newData = new ProjectYarn;
            
            $newData->project_id = $data['project_id'];
            $newData->yarn_id = $data['yarn_id'];
            $newData->colorway_id = $data['colorway_id'];
            $newData->quantity = $data['quantity'];
            $newData->meterage = $data['meterage'];
            $newData->weight = $data['weight'];

            $newData->save();
        }
    }
}
