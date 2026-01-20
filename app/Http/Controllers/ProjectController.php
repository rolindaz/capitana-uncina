<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\ProjectTranslation;
use App\Models\Yarn;
use App\Models\Colorway;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\Craft;
use Illuminate\Database\QueryException;

class ProjectController extends Controller
{
    private function isUniqueConstraintViolation(QueryException $e): bool
    {
        // Most DB drivers use SQLSTATE 23000 for integrity/unique violations.
        return $e->getCode() === '23000';
    }

    private function uniqueProjectSlug(string $name, string $locale, ?int $ignoreProjectId = null): string
    {
        $base = Str::slug($name);
        if ($base === '') {
            $base = 'project';
        }

        $candidate = $this->truncateSlugBase($base, 0);
        $counter = 2;

        while (
            ProjectTranslation::query()
                ->where('locale', $locale)
                ->where('slug', $candidate)
                ->when($ignoreProjectId !== null, fn ($q) => $q->where('project_id', '!=', $ignoreProjectId))
                ->exists()
        ) {
            $suffix = '-' . $counter;
            $candidate = $this->truncateSlugBase($base, strlen($suffix)) . $suffix;
            $counter++;
        }

        return $candidate;
    }

    private function truncateSlugBase(string $base, int $reservedSuffixLength): string
    {
        $max = 255 - $reservedSuffixLength;
        if ($max < 1) {
            return '';
        }

        return strlen($base) > $max ? substr($base, 0, $max) : $base;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $allowedSorts = [
            'name',
            'category',
            'created_at',
            'updated_at',
        ];

        $sort = $request->query('sort', 'created_at');
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        $direction = $request->query('direction', 'desc');
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        $locale = app()->getLocale();

        $query = Project::query()->with([
            'translation',
            'crafts.translation',
            'category.translation'
        ]);

        if ($sort === 'name') {
            $query->orderBy(
                ProjectTranslation::query()
                    ->select('name')
                    ->whereColumn('project_id', 'projects.id')
                    ->where('locale', $locale)
                    ->limit(1),
                $direction
            );
        } elseif ($sort === 'category') {
            $query->orderBy(
                CategoryTranslation::query()
                    ->select('name')
                    ->whereColumn('category_id', 'projects.category_id')
                    ->where('locale', $locale)
                    ->limit(1),
                $direction
            );
        } else {
            $query->orderBy($sort, $direction);
        }

        $projects = $query
            ->paginate(12)
            ->withQueryString();

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

        $colorways = Colorway::all();
        
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

            'designer_name' => ['nullable', 'string'],
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
            'designer_name' => $validated_data['designer_name'],
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
                
        $locale = app()->getLocale();
        $attempts = 0;
        while (true) {
            $attempts++;

            $slug = $this->uniqueProjectSlug($validated_data['name'], $locale);

            try {
                $newProject->translation()->create([
                    'locale' => $locale,
                    'name' => $validated_data['name'],
                    'notes' => $validated_data['notes'],
                    'status' => $validated_data['status'],
                    'destination_use' => $validated_data['destination_use'],
                    'slug' => $slug,
                ]);
                break;
            } catch (QueryException $e) {
                if (!$this->isUniqueConstraintViolation($e) || $attempts >= 5) {
                    throw $e;
                }
            }
        }

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
            ->route('projects.index')
            ->with('success', 'Project created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Project $project)
    {
        $project->load([
            'translation',
            'category.translation',
            'category.parent.translation',
            'category.parent.parent.translation',
            'crafts.translation',
            'projectYarns.colorway.translation'
        ]);

        return view('admin.projects.show', compact('project'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $project->load([
            'translation',
            'category.translation',
            'crafts.translation',
            'projectYarns.colorway.translation'
        ]);

        $yarns = Yarn::all();

        $categories = Category::query()
            ->with('translation')
            ->get();

        $colorways = Colorway::query()
        ->with('translation')
        ->get();

        $crafts = Craft::query()
            ->with('translation')
            ->get();

        $status = config('data.projects.status');
        $sizes = config('data.projects.sizes');

        return view('admin.projects.edit', compact([
            'project',
            'categories',
            'crafts',
            'status',
            'sizes',
            'yarns',
            'colorways'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {

        /* dd($project); */

        // Clean up placeholder values (same idea as store)
        $yarns = $request->input('yarns', []);
        $yarns = array_values(array_filter($yarns, function ($yarn) {
            return isset($yarn['yarn_id']) && is_numeric($yarn['yarn_id']);
        }));

        foreach ($yarns as &$yarn) {
            if (isset($yarn['colorway_id']) && !is_numeric($yarn['colorway_id'])) {
                $yarn['colorway_id'] = null;
            }

            if (array_key_exists('quantity', $yarn) && ($yarn['quantity'] === '' || $yarn['quantity'] === null)) {
                $yarn['quantity'] = null;
            }
        }
        unset($yarn);

        $request->merge(['yarns' => $yarns]);

        $size = $request->input('size');
        if ($size && !is_numeric($size) && strpos($size, 'Seleziona') !== false) {
            $request->merge(['size' => null]);
        }

        $v_data = $request->validate([
            'name' => ['required', 'string'],
            'category_id' => ['required', 'exists:categories,id'],
            'craft_ids' => ['required', 'array'],
            'craft_ids.*' => ['exists:crafts,id'],

            'status' => ['required', 'string'],
            'started' => ['nullable', 'date'],
            'completed' => ['nullable', 'date'],
            'execution_time' => ['nullable', 'numeric'],
            
            'designer_name' => ['nullable', 'string'],
            'pattern_name' => ['nullable', 'string'],
            'pattern_url' => ['nullable', 'url'],

            'size' => ['nullable', 'string'],
            'yarns' => ['nullable', 'array'],
            'yarns.*.yarn_id' => ['required', 'exists:yarns,id'],
            'yarns.*.colorway_id' => ['nullable', 'sometimes', 'exists:colorways,id'],
            'yarns.*.quantity' => ['nullable', 'numeric', 'min:0'],
            'destination_use' => ['nullable', 'string'],
            'notes' => ['nullable', 'string'],

            'image_path' => ['nullable', 'image', 'mimes:jpg,png,jpeg'],
        ]);

        /* dd($v_data); */

        // If status is not completed, clear completed-specific fields
        if (!in_array($v_data['status'], ['Completed', 'Completato'], true)) {
            $v_data['completed'] = null;
            $v_data['execution_time'] = null;
        }

        $project->category_id = $v_data['category_id'];
        $project->started = $v_data['started'] ?? null;
        $project->completed = $v_data['completed'] ?? null;
        $project->execution_time = $v_data['execution_time'] ?? ($project->execution_time ?? null);
        $project->designer_name = $v_data['designer_name'] ?? null;
        $project->pattern_name = $v_data['pattern_name'] ?? null;
        $project->pattern_url = $v_data['pattern_url'] ?? null;
        $project->size = $v_data['size'] ?? null;

        // Aggiornamento immagine
        if ($request->hasFile('image_path')) {
            if (!empty($project->image_path)) {
                Storage::delete($project->image_path);
            }
            $project->image_path = Storage::putFile('projects', $v_data['image_path']);
        }

        $project->save();

        $locale = app()->getLocale();
        $attempts = 0;
        while (true) {
            $attempts++;

            $slug = $this->uniqueProjectSlug($v_data['name'], $locale, $project->id);

            try {
                $project->project_translations()->updateOrCreate(
                    [
                        'locale' => $locale,
                        'project_id' => $project->id,
                    ],
                    [
                        'name' => $v_data['name'],
                        'notes' => $v_data['notes'],
                        'destination_use' => $v_data['destination_use'],
                        'status' => $v_data['status'],
                        'slug' => $slug,
                    ]
                );
                break;
            } catch (QueryException $e) {
                if (!$this->isUniqueConstraintViolation($e) || $attempts >= 5) {
                    throw $e;
                }
            }
        }

        $project->crafts()->sync($v_data['craft_ids']);

        // Rebuild pivot rows (supports multiple yarn rows)
        $project->yarns()->detach();
        foreach ($v_data['yarns'] ?? [] as $yarnData) {
            $project->yarns()->attach(
                $yarnData['yarn_id'],
                [
                    'colorway_id' => $yarnData['colorway_id'] ?? null,
                    'quantity' => $yarnData['quantity'] ?? null,
                ]
            );
        }

        $project->unsetRelation('translation');

        return redirect()
            ->route('projects.show', $project)
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
