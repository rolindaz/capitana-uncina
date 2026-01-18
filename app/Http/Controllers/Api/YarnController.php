<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Yarn;

class YarnController extends Controller
{
    public function index() {

    $yarns = Yarn::query()
    ->with([
        'translation',
        'projectYarns.project.translation',
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
        'translation',
        'projectYarns.project.translation',
        'fiberYarns.fiber.translation'
    ]);

    return response()->json([
        "success" => true,
        "data" => $yarn
    ]);
    }
}
