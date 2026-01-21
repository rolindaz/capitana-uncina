<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Yarn;
use App\Models\Fiber;
use App\Models\Colorway;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class YarnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        /* definisco l'array di parametri accettati per l'ordinamento dei filati */
        $allowedSorts = [
            'name',
            'brand',
            'created_at',
            'updated_at',
        ];

        /* verifico che il parametro per l'ordinamento presente nella request sia uno di quelli che ho definito io, sennò di default va comunque a data di creazione */
        $sort = $request->query('sort', 'created_at');
        if (!in_array($sort, $allowedSorts, true)) {
            $sort = 'created_at';
        }

        /* Stessa cosa per la direzione dell'ordinamento (ascendente o discendente) */
        $direction = $request->query('direction', 'desc');
        $direction = $direction === 'asc' ? 'asc' : 'desc';

        /* Prendo i filati e li ordino per il parametro di default nella direzione di default - con paginate li rendo una variabile paginabile  */
        $yarns = Yarn::query()
            ->orderBy($sort, $direction)
            ->paginate(9)
            ->withQueryString();

        /* Vado alla lista di filati */
        return view('admin.yarns.index', compact('yarns', 'sort', 'direction'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $fibers = Fiber::all();
        $colorways = Colorway::all();
        $weight = config('data.yarns.weight');
        $category = config('data.yarns.category');

        return view('admin.yarns.create', compact([
            'fibers',
            'colorways',
            'weight',
            'category'
        ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $v_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'ply' => ['nullable', 'numeric', 'min:0'],
            'unit_weight' => ['required', 'numeric', 'min:0'],
            'color_type' => ['nullable', 'string', 'max:255'],
            'meterage' => ['nullable', 'numeric', 'min:0'],
            'fiber_types_number' => ['required', 'numeric', 'min:0'],
            'fibers' => ['required', 'array'],
            'fibers.*.fiber_id' => ['required', 'exists:fibers,id'],
            'fibers.*.percentage' => ['nullable', 'numeric', 'min:0'],
            'image_path' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'min_hook_size' => ['nullable', 'decimal:0,2', 'min:0'],
            'max_hook_size' => ['nullable', 'decimal:0,2', 'min:0'],
            'min_needle_size' => ['nullable', 'decimal:0,2', 'min:0'],
            'max_needle_size' => ['nullable', 'decimal:0,2', 'min:0']
        ]);

        /* dd($v_data); */

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = Storage::putFile('yarns', $v_data['image_path']);
        }

        $newYarn = Yarn::create([
            'name' => $v_data['name'],
            'slug' => Str::slug($v_data['name']),
            'brand' => $v_data['brand'],
            'weight' => $v_data['weight'],
            'category' => $v_data['category'],
            'ply' => $v_data['ply'] ?? null,
            'unit_weight' => $v_data['unit_weight'],
            'meterage' => $v_data['meterage'] ?? null,
            'fiber_types_number' => $v_data['fiber_types_number'],
            'image_path' => $imagePath,
            'min_hook_size' => $v_data['min_hook_size'] ?? null,
            'max_hook_size' => $v_data['max_hook_size'] ?? null,
            'min_needle_size' => $v_data['min_needle_size'] ?? null,
            'max_needle_size' => $v_data['max_needle_size'] ?? null,
        ]);

        // Attach fibers to pivot table (fiber_yarn)
        foreach ($v_data['fibers'] ?? [] as $fiberData) {
            $newYarn->fibers()->attach(
                $fiberData['fiber_id'],
                ['percentage' => $fiberData['percentage'] ?? null]
            );
        }

        return redirect()
            ->route('yarns.index')
            ->with('success', 'Yarn created');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $yarn = Yarn::query()
            ->with([
                'fibers.translation',
                'fiberYarns',
                'projectYarns',
            ])
            ->where('slug', $slug)
            ->first();

        // Fallback: allow linking by numeric id when a slug is missing
        if (!$yarn && ctype_digit($slug)) {
            $yarn = Yarn::query()
                ->with([
                    'fibers.translation',
                    'colorways.translation',
                ])
                ->findOrFail((int) $slug);
        }

        if (!$yarn) {
            abort(404);
        }

        return view('admin.yarns.show', compact('yarn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $yarn = Yarn::query()
            ->with('fibers')
            ->findOrFail($id);

        $fibers = Fiber::query()
            ->with('translation')
            ->get();

        $colorways = Colorway::query()
            ->with('translation')
            ->get();

        $weight = config('data.yarns.weight');
        $categories = config('data.yarns.category');

        return view('admin.yarns.edit', compact([
            'yarn',
            'fibers',
            'colorways',
            'weight',
            'categories'
        ]));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Yarn $yarn)
    {
        $v_data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'brand' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'string', 'max:255'],
            'category' => ['required', 'string', 'max:255'],
            'ply' => ['nullable', 'numeric', 'min:0'],
            'unit_weight' => ['required', 'numeric', 'min:0'],
            'color_type' => ['nullable', 'string', 'max:255'],
            'meterage' => ['nullable', 'numeric', 'min:0'],
            'fiber_types_number' => ['required', 'numeric', 'min:0'],
            'fibers' => ['required', 'array'],
            'fibers.*.fiber_id' => ['required', 'exists:fibers,id'],
            'fibers.*.percentage' => ['nullable', 'numeric', 'min:0'],
            'image_path' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'min_hook_size' => ['nullable', 'decimal:0,2', 'min:0'],
            'max_hook_size' => ['nullable', 'decimal:0,2', 'min:0'],
            'min_needle_size' => ['nullable', 'decimal:0,2', 'min:0'],
            'max_needle_size' => ['nullable', 'decimal:0,2', 'min:0']
        ]);

        $yarn->fill([
            'name' => $v_data['name'],
            'slug' => Str::slug($v_data['name']),
            'brand' => $v_data['brand'],
            'weight' => $v_data['weight'],
            'category' => $v_data['category'],
            'ply' => $v_data['ply'] ?? null,
            'unit_weight' => $v_data['unit_weight'],
            'meterage' => $v_data['meterage'] ?? null,
            'fiber_types_number' => $v_data['fiber_types_number'],
            'min_hook_size' => $v_data['min_hook_size'] ?? null,
            'max_hook_size' => $v_data['max_hook_size'] ?? null,
            'min_needle_size' => $v_data['min_needle_size'] ?? null,
            'max_needle_size' => $v_data['max_needle_size'] ?? null,
        ]);

        if ($request->hasFile('image_path')) {
            if (!empty($yarn->image_path)) {
                Storage::delete($yarn->image_path);
            }

            $yarn->image_path = Storage::putFile('yarns', $v_data['image_path']);
        }

        $yarn->save();

        // Sync fibers composition (fiber_yarn)
        $fiberSyncData = [];
        foreach ($v_data['fibers'] ?? [] as $fiberData) {
            if (empty($fiberData['fiber_id'])) {
                continue;
            }
            $fiberSyncData[$fiberData['fiber_id']] = [
                'percentage' => $fiberData['percentage'] ?? null,
            ];
        }
        $yarn->fibers()->sync($fiberSyncData);

        return redirect()
            ->route('yarns.show', $yarn->slug ?? $yarn->id)
            ->with('success', 'Yarn updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Yarn $yarn)
    {
        if (!empty($yarn->image_path)) {
            Storage::delete($yarn->image_path);
        }

        // Prevent FK constraint failures (no cascade configured in migrations)

        // Pivot tables
        $yarn->projects()->detach();
        $yarn->projectYarns()->delete();
        $yarn->colorways()->detach();
        $yarn->fibers()->detach();
        $yarn->fiberYarns()->delete();

        $yarn->deleteOrFail();

        return redirect()->route('yarns.index');
    }
}
