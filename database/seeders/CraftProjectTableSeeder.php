<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Craft;
use App\Models\Project;

class CraftProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = config('data.craft_project');

        foreach ($data as $row) {
            $project = Project::where('id', $row['project_id'])->first();
            $craft = Craft::where('id', $row['craft_id'])->first();
            $project->crafts()->attach($craft->id);
        }

    }
}
