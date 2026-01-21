<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Yarn;

class YarnController extends Controller
{
    public function index()
    {
        $yarns = Yarn::query()
            ->with([
                'projectYarns.project.translation',
                'projectYarns.colorway.translation',
                'fiberYarns.fiber.translation',
            ])
            ->get();

        // Hide nested translations (name/slug are exposed via $appends on related models).
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

        return response()->json([
            'success' => true,
            'data' => $yarns,
        ]);
    }

    public function show(Yarn $yarn)
    {
        $yarn->load([
            'projectYarns.project.translation',
            'fiberYarns.fiber.translation',
            'projectYarns.colorway.translation',
        ]);

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

        return response()->json([
            'success' => true,
            'data' => $yarn,
        ]);
    }
}
