<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Yarn;
use App\Models\Colorway;

class YarnController extends Controller
{
    public function index() {

    $yarns = Yarn::query()
    ->with([
        'projectYarns.project.translation',
        'projectYarns.colorway',
        'fiberYarns.fiber.translation'
    ])
    ->get();

    return response()->json([
        "success" => true,
        "data" => $yarns
    ]);
    }

    public function show(Yarn $yarn) {

    $yarn->load([
        'projectYarns.project.translation',
        'fiberYarns.fiber.translation',
        'projectYarns.colorway'
    ]);

    return response()->json([
        "success" => true,
        "data" => $yarn
    ]);
    }
}
