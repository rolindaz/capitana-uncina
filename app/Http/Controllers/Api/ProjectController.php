<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Project;

class ProjectController extends Controller
{
    public function index() {

        /* Prendo tutti i miei progetti */
        $projects = Project::query()
            ->with([
                'translation',
                'category.translation',
                'crafts.translation',
                'projectYarns.yarn',
                'projectYarns.colorway.translation',
            ])
            ->get();

        /* Nascondo la relazione traduzione per una visualizzazione più immediata e lineare delle informazioni dall'API */
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

        /* Ritorno una risposta in formato json con i progetti */
        return response()->json(
            [
                "success" => true,
                "data" => $projects
            ]
        );
    }

    public function show(Project $project) {

        /* Prendo il mio progetto */
        $project->load([
            'translation',
            'category.translation',
            'crafts.translation',
            'projectYarns.yarn',
            'projectYarns.colorway.translation'
        ]);

        /* Nascondo la relazione traduzione del progetto e dei modelli associati */
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

        /* Ritorno una risposta in formato json con il progetto */
        return response()->json(
            [
                "success" => true,
                "data" => $project
            ]
        );
    }
}
