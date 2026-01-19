@extends('layouts.admin')

@section('title', 'Modifica il tuo progetto')

@section('content')

{{-- @dd($project) --}}

{{-- Controllo errori di valutazione --}}

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
    <form class="precise-font w-75 mb-5" action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
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
                id="name"
                value="{{ old('name', $project->name) }}">
            </div>
            <div>
                <label for="craft">
                Tecniche utilizzate
                </label>
                <div id="craft" class="form-control gold-border mt-3 px-3 d-flex gap-4 flex-wrap justify-content-between">
                    @foreach ($crafts as $craft)
                        <div class="form-check">
                            <input class="form-check-input" name="craft_ids[]" type="checkbox" value="{{ $craft->id }}" id="craft-{{ $craft->id }}" {{ collect(old('craft_ids', $project->crafts->pluck('id')->all()))->contains($craft->id) ? 'checked' : '' }}>
                            <label class="form-check-label" for="craft-{{ $craft->id }}">
                                {{ $craft->name }}
                            </label>
                        </div>      
                    @endforeach
                </div>
            </div>
            <div class="d-flex align-items-center">
                <label for="category_id">
                    Categoria
                </label>
                <select class="ms-2 w-50 form-select" name="category_id" id="category_id">
                    <option value="" disabled {{ old('category_id', $project->category_id) ? '' : 'selected' }}>
                        Seleziona la categoria
                    </option>
                    <x-category-options :categories="$categories" :selected="old('category_id', $project->category_id)" />
                </select>
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div class="d-flex align-items-center">
                <label for="status">
                    Stato
                </label>
                <select class="status ms-2 w-50 form-select" name="status" id="status">
                    <option selected {{ old('status', $project->status) ? $project->status : 'selected' }}>
                        Seleziona lo stato
                    </option>
                    @foreach ($status as $data)
                        <option value="{{ $data }}" {{ old('status', $project->status) == $data ? 'selected' : '' }}>
                            {{ $data }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="started">
                <label for="started">
                    Iniziato
                </label>
                <input class="ms-2" type="date" name="started" id="started" value="{{ old('started', $project->started) }}">
            </div>
            <div class="completed align-items-center">
                <label for="completed">
                    Completato
                </label>
                <input class="ms-2" type="date" name="completed" id="completed" value="{{ old('completed', $project->completed) }}">
            </div>
            <div class="execution_time">
                <label for="execution_time">
                    Ore di lavoro totali
                </label>
                <input class="w-25 ms-2" type="number" name="execution_time" id="execution_time" value="{{ old('execution_time', $project->execution_time) }}">
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div>
                <label for="designer_name">
                    Nome del(la) designer
                </label>
                <input
                class="ms-2"
                type="text"
                name="designer_name"
                id="designer_name"
                value="{{ old('designer_name', $project->designer_name) }}">
            </div>
            <div>
                <label for="pattern_name">
                    Nome dello schema
                </label>
                <input
                class="ms-2"
                type="text"
                name="pattern_name"
                id="pattern_name"
                value="{{ old('pattern_name', $project->pattern_name) }}">
            </div>
            <div class="d-flex align-items-center">
                <label for="pattern_url">
                    Link dello schema
                </label>
                <input
                class="ms-2 w-75"
                type="url"
                name="pattern_url"
                id="pattern_url"
                value="{{ old('pattern_url', $project->pattern_url) }}">
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div class="d-flex align-items-center">
                <label for="size">
                    Taglia
                </label>
                <select class="ms-2 w-50 form-select" name="size" id="size">
                    <option {{ old('size', $project->size) ? '' : 'selected' }}>
                        Seleziona la taglia
                    </option>
                    @foreach ($sizes as $size)
                        <option value="{{ $size }}" {{ old('size', $project->size) == $size ? 'selected' : '' }}>
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Contenitore input filati complesso --}}
            <div id="yarns-container">
                @php
                    $yarnRows = old('yarns');
                    if (!is_array($yarnRows)) {
                        $yarnRows = $project->projectYarns
                            ->map(fn ($py) => [
                                'yarn_id' => $py->yarn_id,
                                'colorway_id' => $py->colorway_id,
                                'quantity' => $py->quantity,
                            ])
                            ->values()
                            ->all();
                    }

                    if (empty($yarnRows)) {
                        $yarnRows = [[
                            'yarn_id' => null,
                            'colorway_id' => null,
                            'quantity' => null,
                        ]];
                    }
                @endphp

                @foreach ($yarnRows as $index => $row)
                    <div class="yarns d-flex align-items-center {{ $index > 0 ? 'mt-3' : '' }}">
                        <div class="yarn-row d-flex form-control gold-border justify-content-between gap-3">
                            {{-- Filato --}}
                            <div class="yarn-column">
                                <label for="yarn_id_{{ $index }}">
                                    Filato
                                </label>
                                <select class="ms-2 form-select" name="yarns[{{ $index }}][yarn_id]" id="yarn_id_{{ $index }}">
                                    <option {{ empty($row['yarn_id']) ? 'selected' : '' }}>
                                        Seleziona il filato
                                    </option>
                                    @foreach ($yarns as $yarn)
                                        <option value="{{ $yarn->id }}" {{ (string)($row['yarn_id'] ?? '') === (string)$yarn->id ? 'selected' : '' }}>
                                            {{ $yarn->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Colore --}}
                            <div class="yarn-column">
                                <label for="colorway_id_{{ $index }}">
                                    Colore
                                </label>
                                <select class="ms-2 form-select" name="yarns[{{ $index }}][colorway_id]" id="colorway_id_{{ $index }}">
                                    <option {{ empty($row['colorway_id']) ? 'selected' : '' }}>
                                        Seleziona il colore
                                    </option>
                                    @foreach ($colorways as $colorway)
                                        <option value="{{ $colorway->id }}" {{ (string)($row['colorway_id'] ?? '') === (string)$colorway->id ? 'selected' : '' }}>
                                            {{ $colorway->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- Quantità --}}
                            <div class="yarn-column">
                                <label for="quantity_{{ $index }}">
                                    Quantità
                                </label>
                                <input class="ms-2 form-select" type="number" name="yarns[{{ $index }}][quantity]" id="quantity_{{ $index }}" value="{{ $row['quantity'] ?? '' }}" />
                            </div>

                            @if ($index === 0)
                                <button type="button" id="add-yarn-btn" class="btn btn-secondary">
                                    +
                                </button>
                            @else
                                <button type="button" class="btn btn-sm btn-danger remove-yarn-btn">Rimuovi</button>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
            <div>
                <label for="destination_use">
                    Per chi è?
                </label>
                <input
                class="ms-2"
                type="text"
                name="destination_use"
                id="destination_use"
                value="{{ old('destination_use', $project->destination_use) }}">
            </div>
            <div>
                <label for="notes">
                    Note
                </label>
                <textarea
                class="mt-2 form-control gold-border"
                name="notes"
                id="notes"
                rows="5">{{ old('notes', $project->notes) }}</textarea>
            </div>
        </div>
        <div class="form-control blue-border mb-3 d-flex gap-4 flex-wrap">
            <label for="image_path">
                Immagine
            </label>
            <input id="image_path" name="image_path" type="file">
            @if($project->image_path)
                <img class="img-fluid w-25" src="{{ asset('storage/' . $project->image_path) }}" alt="copertina">
            @endif
        </div>
        <button type="submit" class="btn btn-warning">
            Salva
        </button>
    </form> 
</div>

@vite(['resources/js/projects-form.js'])
@endsection