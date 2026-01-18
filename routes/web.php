<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\YarnController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    $recentUpdates = \App\Models\Project::latest('created_at')->take(10)->get();
    return view('dashboard', compact('recentUpdates'));
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('/projects', ProjectController::class)->middleware(['auth', /* 'verified' */]);
Route::resource('/yarns', YarnController::class)->middleware(['auth', /* 'verified' */]);

require __DIR__.'/auth.php';
