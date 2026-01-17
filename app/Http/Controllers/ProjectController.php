<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\Yarn;
use App\Models\Colorway;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Craft;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with([
            'translation',
            'crafts.translation'
            ])
        ->orderByDesc('created_at')
        ->get();

        return view('admin.projects.index', compact('projects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()
            ->with('translation')
            ->get();
        
        $yarns = Yarn::all();

        $colorways = Colorway::query()
            ->with('translation')
            ->get();
        
        $sizes = config('data.projects.sizes');
        $status = config('data.projects.status');
        $crafts = Craft::query()
            ->with('translation')
            ->get();

        return view('admin.projects.create', compact([
            'categories',
            'sizes',
            'yarns',
            'colorways',
            'status',
            'crafts'
            ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /* dd($request); */

        // Clean up placeholder values
        $yarns = $request->input('yarns', []);
        foreach ($yarns as &$yarn) {
            // If colorway_id is the placeholder text, set it to null
            if (isset($yarn['colorway_id']) && !is_numeric($yarn['colorway_id'])) {
                $yarn['colorway_id'] = null;
            }
        }
        $request->merge(['yarns' => $yarns]);

        // Clean up size if it's a placeholder
        $size = $request->input('size');
        if ($size && !is_numeric($size) && strpos($size, 'Seleziona') !== false) {
            $request->merge(['size' => null]);
        }

        $validated_data = $request->validate([
            'name' => ['required', 'string'],
            'craft_ids' => ['required', 'array'],
            'craft_ids.*' => ['exists:crafts,id'],
            'category_id' => ['required', 'exists:categories,id'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],

            'status' => ['required', 'string'],
            'started' => ['nullable', 'date'],
            'completed' => ['nullable', 'date'],
            'execution_time' => ['nullable', 'numeric'],

            'pattern_name' => ['nullable', 'string'],
            'pattern_url' => ['nullable', 'url'],

            'size' => ['nullable', 'string'],
            /* 'yarn_id' => ['required', 'exists:yarns,id'], */
            'yarns' => ['nullable', 'array'],
            'yarns.*.yarn_id' => ['required', 'exists:yarns,id'],
            'yarns.*.colorway_id' => ['nullable', 'sometimes', 'exists:colorways,id'],
            'yarns.*.quantity' => ['nullable', 'numeric', 'min:0'],
            'destination_use' => ['nullable', 'string'],
            'notes' => ['nullable', 'string']
        ]);
        
        /* dd($validated_data); */

        $newProject = Project::create([
            'pattern_name' => $validated_data['pattern_name'],
            'pattern_url' => $validated_data['pattern_url'],
            'category_id' => $validated_data['category_id'],
            'started' => $validated_data['started'],
            'completed' => $validated_data['completed'],
            'execution_time' => $validated_data['execution_time'],
            'size' => $validated_data['size']
            ]);
            
        if(array_key_exists('image_path', $validated_data)) {
            // dump("l'immagine c'è");
            $img_url = Storage::putFile('projects', $validated_data['image_path']);
            $newProject->image_path = $img_url;
            $newProject->save();
        }
                
        $newProject->translation()->create([
            'locale' => app()->getLocale(),
            'name' => $validated_data['name'],
            'notes' => $validated_data['notes'],
            'status' => $validated_data['status'],
            'destination_use' => $validated_data['destination_use'],
            'slug' => Str::slug($validated_data['name'])
        ]);

        // Versione appending di yarn per un solo filato selezionabile
        /* if (!empty($validated_data['yarn_id'])) {
            $newProject->yarns()->attach($validated_data['yarn_id']);
        } */

        foreach($validated_data['yarns'] ?? [] as $yarnData) {
            $newProject->yarns()->attach(
                $yarnData['yarn_id'],
                [
                    'colorway_id' => $yarnData['colorway_id'] ?? null,
                    'quantity' => $yarnData['quantity'] ?? null
                ]
            );
        }

        /* // creazione del nuovo filato, se inserito:

        if ($request->filled('new_yarn_name')) {
            $yarn = Yarn::create([
                'name' => $request->input('new_yarn_name'),
                'brand' => $request->input('new_yarn_brand')
            ]);

            // e lo attacco al progetto

            $newProject->yarns()->attach($yarn->id);
        } */

        if (!empty($validated_data['craft_ids'])) {
            $newProject->crafts()->attach($validated_data['craft_ids']);
        }

        return redirect()
            ->route('admin.projects.index')
            ->with('success', 'Project created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $project = Project::query()
        ->with([
            'translation',
            'category.translation',
            'projectYarns.yarn.translation',
            'projectYarns.colorway.translation'
            ])
        ->whereHas('translation', function ($query) use ($slug) {
            $query->where('slug', $slug)
              ->where('locale', app()->getLocale());
        })
        ->firstOrFail();

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $project = Project::query()
            ->with([
                'translation',
                'category.translation',
                'crafts.translation',
            ])
            ->findOrFail($id);

        $categories = Category::query()
            ->with('translation')
            ->get();

        $crafts = Craft::query()
            ->with('translation')
            ->get();

        $status = config('data.projects.status');

        return view('admin.projects.edit', compact(['project', 'categories', 'crafts', 'status']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        /* dd($project); */

        $validated_data = $request->validate([
            'name' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'craft_ids' => ['required', 'array'],
            'craft_ids.*' => ['exists:crafts,id'],
            'image_path' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],

            'status' => ['required', 'string'],
            /* 'started' => ['nullable', 'date'],
            'completed' => ['nullable', 'date'],
            'execution_time' => ['nullable', 'numeric'],

            'pattern_name' => ['nullable', 'string'],
            'pattern_url' => ['nullable', 'url'],

            'size' => ['nullable', 'string'],
            'yarn_id' => ['required', 'exists:yarns,id'],
            'yarns' => ['nullable', 'array'],
            'yarns.*.yarn_id' => ['required', 'exists:yarns,id'],
            'yarns.*.colorway_id' => ['nullable', 'sometimes', 'exists:colorways,id'],
            'yarns.*.quantity' => ['nullable', 'numeric', 'min:0'],
            'destination_use' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'] */
        ]);

        /* dd($validated_data); */

        $project->category_id = $validated_data['category_id'];

        if ($request->hasFile('image_path')) {
            if (!empty($project->image_path)) {
                Storage::delete($project->image_path);
            }

            $project->image_path = Storage::putFile('projects', $validated_data['image_path']);
        }

        $project->save();

        $project->project_translations()->updateOrCreate(
            ['locale' => app()->getLocale()],
            [
                'name' => $validated_data['name'],
                'status' => $validated_data['status'],
                'slug' => Str::slug($validated_data['name']),
            ]
        );

        $project->crafts()->sync($validated_data['craft_ids']);

        $project->unsetRelation('translation');

        return redirect()
            ->route('projects.show', $project->slug ?? Str::slug($validated_data['name']))
            ->with('success', 'Project updated');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        if (!empty($project->image_path)) {
            Storage::delete($project->image_path);
        }

        // Prevent FK constraint failures (no cascade configured in migrations)
        $project->crafts()->detach();
        $project->projectYarns()->delete();
        $project->project_translations()->delete();

        $project->deleteOrFail();
        
        return redirect()->route('projects.index');
    }
}
