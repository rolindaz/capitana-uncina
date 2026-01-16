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

<div class="container">
    <form action="{{ route('yarns.update', $yarn) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-control mb-3">
            <label for="name">
                Nome
            </label>
            <input 
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $yarn->name) }}">
        </div>
        <div class="form-control mb-3">
            <label for="brand">
                Marca
            </label>
            <input 
            type="text"
            name="brand"
            id="brand"
            value="{{ old('brand', $yarn->brand) }}">
        </div>
        <div class="form-control mb-3">
            <label for="weight">
                Peso Standard
            </label>
            <select name="weight" id="weight">
                @foreach ($weight as $data)
                    <option value="{{ $data }}" {{ old('weight', $yarn->weight) == $data ? 'selected' : '' }}>
                        {{ $data }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-control mb-3">
            <label for="category">
                Categoria Standard
            </label>
            <select name="category" id="category">
                @foreach ($categories as $category)
                    <option value="{{ $category }}" {{ old('category', $yarn->category) == $category ? 'selected' : '' }}>
                        {{ $category }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- Contenitore input fibre complesso --}}
        <div id="fibers-container">
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
                    <div class="fiber-row d-flex form-control justify-content-between gap-3">
                        <div class="fiber-column">
                            <label class="text-danger" for="fiber_id_{{ $index }}">
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
                            <label class="text-danger" for="percentage_{{ $index }}">
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
        <div class="form-control mb-3 d-flex gap-4 flex-wrap">
            <label for="image_path">
                Immagine
            </label>
            <input id="image_path" name="image_path" type="file">
            @if($yarn->image_path)
                <img class="img-fluid w-25" src="{{ asset('storage/' . $yarn->image_path) }}" alt="copertina">
            @endif
        </div>
        <button type="submit" class="btn btn-warning">
            Salva
        </button>
    </form> 
</div>

@vite('resources/js/yarns-form.js')

@endsection