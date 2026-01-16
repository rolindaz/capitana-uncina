<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Yarn;
use App\Models\Fiber;
use App\Models\Colorway;

class YarnController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $yarns = Yarn::with([
            'translation',
            'fibers'
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
            'meterage' => ['nullable', 'numeric'],
            'fiber_types_number' => ['required', 'numeric'],
            'image_path' => ['nullable', 'image', 'mimes:png,jpg,jpeg'],
            'min_hook_size' => ['nullable', 'decimal:1,2'],
            'max_hook_size' => ['nullable', 'decimal:1,2'],
            'min_needle_size' => ['nullable', 'decimal:1,2'],
            'max_needle_size' => ['nullable', 'decimal:1,2']
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
