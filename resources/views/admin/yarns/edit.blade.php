@extends('layouts.admin')

@section('title', 'Modifica il filato')

@section('content')

{{-- Mostra errori di validazione --}}
@if ($errors->any())
    <div class="alert alert-danger">
        <strong>Validation Errors:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container d-flex justify-content-center">
    <form class="precise-font w-75 mb-5" action="{{ route('yarns.update', $yarn) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div>
                <label for="name">
                    Nome
                </label>
                <input 
                type="text"
                name="name"
                class="ms-2"
                id="name"
                value="{{ old('name', $yarn->name) }}">
            </div>
            <div>
                <label for="brand">
                    Marca
                </label>
                <input 
                type="text"
                name="brand"
                id="brand"
                value="{{ old('brand', $yarn->brand) }}">
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div>
                <label for="fiber_types_number">
                Tipologie di fibra
                </label>
                <input class="ms-2" type="number" name="fiber_types_number" id="fiber_types_number" value="{{ old('fiber_types_number', $yarn->fiber_types_number) }}">
            </div>
            {{-- Contenitore input fibre complesso --}}
            <div id="fibers-container" class="mb-3">
            @php
                $fiberRows = old('fibers');
                if (!is_array($fiberRows)) {
                    $fiberRows = $yarn->fiberYarns
                        ->map(fn($row) => ['fiber_id' => $row->fiber_id, 'percentage' => $row->percentage])
                        ->values()
                        ->all();
                }

                if (empty($fiberRows)) {
                    $fiberRows = [['fiber_id' => null, 'percentage' => null]];
                }
            @endphp

            @foreach ($fiberRows as $index => $fiberRow)
                @php
                    $selectedFiberId = $fiberRow['fiber_id'] ?? null;
                    $selectedPercentage = $fiberRow['percentage'] ?? null;
                @endphp

                <div class="fibers d-flex align-items-center {{ $index > 0 ? 'mt-3' : '' }}">
                    <div class="fiber-row gold-border d-flex form-control justify-content-between gap-3">
                        <div class="fiber-column">
                            <label for="fiber_id_{{ $index }}">
                                Fibra
                            </label>
                            <select class="ms-2 form-select" name="fibers[{{ $index }}][fiber_id]" id="fiber_id_{{ $index }}">
                                <option value="" {{ empty($selectedFiberId) ? 'selected' : '' }}>
                                    Seleziona la fibra
                                </option>
                                @foreach ($fibers as $fiber)
                                    <option value="{{ $fiber->id }}" {{ (string) $selectedFiberId === (string) $fiber->id ? 'selected' : '' }}>
                                        {{ $fiber->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fiber-column">
                            <label for="percentage_{{ $index }}">
                                Percentuale
                            </label>
                            <input class="ms-2 form-select" type="number" name="fibers[{{ $index }}][percentage]" id="percentage_{{ $index }}" value="{{ $selectedPercentage }}"/>
                        </div>

                        @if ($index === 0)
                            <button type="button" id="add-fiber-btn" class="btn btn-secondary">
                                +
                            </button>
                        @else
                            <button type="button" class="btn btn-sm btn-danger remove-fiber-btn">Rimuovi</button>
                        @endif
                    </div>
                </div>
            @endforeach
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div>
                <label for="unit_weight">
                Peso Unitario
                </label>
                <input class="ms-2" type="number" name="unit_weight" id="unit_weight" value="{{ old('unit_weight', $yarn->unit_weight) }}">
            </div>
            <div>
                <label for="meterage">
                    Metraggio
                </label>
                <input class="ms-2" type="number" name="meterage" id="meterage" value="{{ old('meterage', $yarn->meterage) }}">
            </div>
            <div>
                <label for="ply">
                    Fili
                </label>
                <input class="ms-2" type="number" name="ply" id="ply" value="{{ old('ply', $yarn->ply) }}">
            </div>
            <div class="d-flex align-items-center">
                <label for="weight">
                Peso Standard
                </label>
                <select class="weight ms-2 w-50 form-select" name="weight" id="weight">
                    @foreach ($weight as $data)
                    <option value="{{ $data }}" {{ old('weight', $yarn->weight) == $data ? 'selected' : '' }}>
                        {{ $data }}
                    </option>
                    @endforeach
                </select>
            </div>
            <div class="d-flex align-items-center">
                <label for="category">
                    Categoria Standard
                </label>
                <select class="weight ms-2 w-50 form-select" name="category" id="category">
                    @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ old('category', $yarn->category) == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-5 d-flex flex-column gap-4">
                <div class="row row-cols-3 px-5 align-items-center">
                    <h6 class="col mb-0 border-end">
                        Uncinetto
                    </h6>
                    <div class="col">
                        <label for="min_hook_size">
                            Minimo
                        </label>
                        <input class="ms-2" type="number" step="0.01" inputmode="decimal" name="min_hook_size" id="min_hook_size"
                        style="width: 100px;"
                        value="{{ old('min_hook_size', $yarn->min_hook_size) }}">
                    </div>
                    <div class="col">
                        <label for="max_hook_size">
                            Massimo
                        </label>
                        <input class="ms-2" type="number" step="0.01" inputmode="decimal" name="max_hook_size" id="max_hook_size"
                        style="width: 100px;"
                        value="{{ old('max_hook_size', $yarn->max_hook_size) }}">
                    </div>
                </div>
                <div class="row row-cols-3 px-5 align-items-center">
                    <h6 class="col mb-0 border-end">
                        Ferri
                    </h6>
                    <div class="col">
                        <label for="min_needle_size">
                            Minimo
                        </label>
                        <input class="ms-2" type="number" step="0.01" inputmode="decimal" name="min_needle_size" id="min_needle_size"
                        style="width: 100px;"
                        value="{{ old('min_needle_size', $yarn->min_needle_size) }}">
                    </div>
                    <div class="col">
                        <label for="max_needle_size">
                            Massimo
                        </label>
                        <input class="ms-2" type="number" step="0.01" inputmode="decimal" name="max_needle_size" id="max_needle_size"
                        style="width: 100px;"
                        value="{{ old('max_needle_size', $yarn->max_needle_size) }}">
                    </div>
                </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-5 d-flex flex-column gap-4">
            <label for="image_path">
                Immagine
            </label>
            <input id="image_path" name="image_path" type="file">
            @if($yarn->image_path)
                <img class="img-fluid w-25" src="{{ asset('storage/' . $yarn->image_path) }}" alt="copertina">
            @endif
        </div>
        <button type="submit" class="btn btn-form">
            Salva
        </button>
    </form> 
</div>

@vite('resources/js/yarns-form.js')

@endsection