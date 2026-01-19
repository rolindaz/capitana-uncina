<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Project;
use App\Models\Yarn;
use Illuminate\Support\Collection;

class DashboardController extends Controller
{
    public function index()
    {
        $projects = Project::with('translation')
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Project $project) {
                $label = $project->name ?? $project->pattern_name ?? ('#' . $project->id);

                return (object) [
                    'description' => "Progetto aggiunto: {$label}",
                    'created_at' => $project->created_at,
                ];
            });

        $yarns = Yarn::query()
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Yarn $yarn) {
                $label = trim(($yarn->name ?? '') . (isset($yarn->brand) ? " ({$yarn->brand})" : ''));
                $label = $label !== '' ? $label : ('#' . $yarn->id);

                return (object) [
                    'description' => "Filato aggiunto: {$label}",
                    'created_at' => $yarn->created_at,
                ];
            });

        $categories = Category::with('translation')
            ->latest()
            ->take(5)
            ->get()
            ->map(function (Category $category) {
                $label = $category->name ?? $category->key ?? ('#' . $category->id);

                return (object) [
                    'description' => "Categoria aggiunta: {$label}",
                    'created_at' => $category->created_at,
                ];
            });

        /** @var Collection<int, object{description:string, created_at:mixed}> $recentUpdates */
        $recentUpdates = $projects
            ->merge($yarns)
            ->merge($categories)
            ->sortByDesc('created_at')
            ->values()
            ->take(10);

        return view('dashboard', compact('recentUpdates'));
    }
}
