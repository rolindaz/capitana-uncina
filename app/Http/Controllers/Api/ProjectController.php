<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index() {

        $projects = Project::query()
        ->with([
            'translation',
            'category.translation',
            'crafts.translation',
            'projectYarns.yarn'
        ])
        ->get();

        return response()->json(
            [
                "success" => true,
                "data" => $projects
            ]
        );
    }

    public function show(Project $project) {

        $project->load([
            'translation',
            'category.translation',
            'crafts.translation',
            'projectYarns.yarn'
        ]);

        return response()->json(
            [
                "success" => true,
                "data" => $project
            ]
        );
    }
}
