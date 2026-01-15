<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = config('data.projects.projects');

        foreach($projects as $project) {
            $newProject = new Project;

            $newProject->category_id = $project['category_id'];
            $newProject->started = $project['started'];
            $newProject->completed = $project['completed'];
            $newProject->execution_time = $project['execution_time'];
            $newProject->image_path = $project['image_path'];
            $newProject->pattern_name = $project['pattern_name'];
            $newProject->pattern_url = $project['pattern_url'];
            $newProject->size = $project['size'];
            $newProject->correct = $project['correct'];

            $newProject->save();
        }
    }
}
