<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ProjectController;
use App\Http\Controllers\Api\YarnController;

/* Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum'); */

// API Progetti

Route::get('projects', [ProjectController::class, 'index']);

Route::get('projects/{project}', [ProjectController::class, 'show']);

// API Filati

Route::get('yarns', [YarnController::class, 'index']);
Route::get('yarns/{yarn}', [YarnController::class, 'show']);
