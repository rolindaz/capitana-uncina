<?php

namespace App\Http\Controllers;

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
    public function index()
    {
        $yarns = Yarn::with([
            'translation',
            'fibers.translation'
        ])->get();

        return view('yarns.index', compact('yarns'));
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

        return view('yarns.create', compact([
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
            'ply' => ['nullable', 'numeric'],
            'unit_weight' => ['required', 'numeric'],
            'color_type' => ['nullable', 'string', 'max:255'],
            'meterage' => ['nullable', 'numeric'],
            'fiber_types_number' => ['required', 'numeric'],
            'fibers' => ['required', 'array'],
            'fibers.*.fiber_id' => ['required', 'exists:fibers,id'],
            'fibers.*.percentage' => ['nullable', 'numeric'],
            'image_path' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'min_hook_size' => ['nullable', 'decimal:1,2'],
            'max_hook_size' => ['nullable', 'decimal:1,2'],
            'min_needle_size' => ['nullable', 'decimal:1,2'],
            'max_needle_size' => ['nullable', 'decimal:1,2']
        ]);

        /* dd($v_data); */

        $imagePath = null;
        if ($request->hasFile('image_path')) {
            $imagePath = Storage::putFile('yarns', $v_data['image_path']);
        }

        $newYarn = Yarn::create([
            'name' => $v_data['name'],
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

        $newYarn->yarn_translations()->create([
            'locale' => app()->getLocale(),
            'color_type' => $v_data['color_type'] ?? null,
            'slug' => Str::slug($v_data['name'])
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
                'translation',
                'fibers.translation',
                'fiberYarns',
                'colorways.translation',
            ])
            ->whereHas('translation', function ($query) use ($slug) {
                $query->where('slug', $slug)
                    ->where('locale', app()->getLocale());
            })
            ->first();

        // Fallback: allow linking by numeric id when a slug is missing
        if (!$yarn && ctype_digit($slug)) {
            $yarn = Yarn::query()
                ->with([
                    'translation',
                    'fibers.translation',
                    'colorways.translation',
                ])
                ->findOrFail((int) $slug);
        }

        if (!$yarn) {
            abort(404);
        }

        return view('yarns.show', compact('yarn'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
