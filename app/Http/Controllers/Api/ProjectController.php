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
                'projectYarns.yarn',
                'projectYarns.colorway.translation',
            ])
            ->get();

        $projects->each(function (Project $project) {
            $project->makeHidden(['translation']);

            if ($project->category) {
                $project->category->makeHidden(['translation']);
            }

            $project->crafts->each(function ($craft) {
                $craft->makeHidden(['translation']);
            });

            $project->projectYarns->each(function ($projectYarn) {
                if ($projectYarn->colorway) {
                    $projectYarn->colorway->makeHidden(['translation']);
                }
            });
        });

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
            'projectYarns.yarn',
            'projectYarns.colorway.translation'
        ]);

        $project->makeHidden(['translation']);

        if ($project->category) {
            $project->category->makeHidden(['translation']);
        }

        $project->crafts->each(function ($craft) {
            $craft->makeHidden(['translation']);
        });

        $project->projectYarns->each(function ($projectYarn) {
            if ($projectYarn->colorway) {
                $projectYarn->colorway->makeHidden(['translation']);
            }
        });

        return response()->json(
            [
                "success" => true,
                "data" => $project
            ]
        );
    }
}
