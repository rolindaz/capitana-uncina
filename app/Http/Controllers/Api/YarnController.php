<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Yarn;

class YarnController extends Controller
{
    public function index()
    {
        /* Prendo tutti i miei filati */
        $yarns = Yarn::query()
            ->with([
                'projectYarns.project.translation',
                'projectYarns.colorway.translation',
                'fiberYarns.fiber.translation',
            ])
            ->get();

        /* Nascondo la relazione traduzione per una visualizzazione più immediata e lineare delle informazioni dall'API */
        foreach ($yarns as $yarn) {
            foreach ($yarn->projectYarns as $projectYarn) {
                $project = $projectYarn->project;
                if ($project) {
                    $project->makeHidden(['translation']);
                }

                $colorway = $projectYarn->colorway;
                if ($colorway) {
                    $colorway->makeHidden(['translation']);
                }
            }

            foreach ($yarn->fiberYarns as $fiberYarn) {
                $fiber = $fiberYarn->fiber;
                if ($fiber) {
                    $fiber->makeHidden(['translation']);
                }
            }
        }

        /* Ritorno una risposta in formato json con i filati */
        return response()->json([
            'success' => true,
            'data' => $yarns,
        ]);
    }

    public function show(Yarn $yarn)
    {
        /* Prendo il mio filato */
        $yarn->load([
            'projectYarns.project.translation',
            'fiberYarns.fiber.translation',
            'projectYarns.colorway.translation',
        ]);

        /* Nascondo la relazione traduzione del filato e dei modelli associati */
        foreach ($yarn->projectYarns as $projectYarn) {
            $project = $projectYarn->project;
            if ($project) {
                $project->makeHidden(['translation']);
            }

            $colorway = $projectYarn->colorway;
            if ($colorway) {
                $colorway->makeHidden(['translation']);
            }
        }

        foreach ($yarn->fiberYarns as $fiberYarn) {
            $fiber = $fiberYarn->fiber;
            if ($fiber) {
                $fiber->makeHidden(['translation']);
            }
        }

        /* Ritorno una risposta in formato json con il filato */
        return response()->json([
            'success' => true,
            'data' => $yarn,
        ]);
    }
}
