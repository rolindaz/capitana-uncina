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
                'projectYarns.colorway',
                'fiberYarns.fiber.translation',
            ])
            ->get();

        // Hide nested translations (Projects still expose accessor fields via $appends).
        foreach ($yarns as $yarn) {
            foreach ($yarn->projectYarns as $projectYarn) {
                $project = $projectYarn->project;
                if ($project) {
                    $project->makeHidden(['translation']);
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
            'projectYarns.colorway',
        ]);

        foreach ($yarn->projectYarns as $projectYarn) {
            $project = $projectYarn->project;
            if ($project) {
                $project->makeHidden(['translation']);
            }
        }

        return response()->json([
            'success' => true,
            'data' => $yarn,
        ]);
    }
}
