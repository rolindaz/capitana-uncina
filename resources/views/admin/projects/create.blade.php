@extends('layouts.admin')

{{-- @dd($colorways) --}}

@section('content')

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

<form class="w-50 mb-5" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
        <div>
            <label class="text-danger" for="name">
                Nome
            </label>
            <input class="ms-2" type="text" name="name" id="name">
        </div>
        <div>
            <label class="text-danger">
                Tecniche
            </label>
            <div class="form-control mt-3 px-3 d-flex gap-4 flex-wrap justify-content-between">
                @foreach ($crafts as $craft)
                    <div class="form-check">
                        <input class="form-check-input" name="craft_ids[]" type="checkbox" value="{{ $craft->id }}" id="craft-{{ $craft->id }}">
                        <label class="form-check-label" for="craft-{{ $craft->id }}">
                            {{ $craft->name }}
                        </label>
                    </div>      
                @endforeach
            </div>
        </div>
        <div class="d-flex align-items-center">
            <label class="text-danger" for="category">
                Categoria
            </label>
            <select class="ms-2 w-50 form-select" name="category_id" id="category">
                <option selected>
                    Seleziona la categoria
                </option>
                <x-category-options :categories="$categories" />
            </select>
        </div>
        <div>
            <label for="image">
                Immagine
            </label>
            <input class="ms-2" type="file" name="image_path" id="image">
        </div>
    </div>
    <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
        <div class="d-flex align-items-center">
            <label class="text-danger" for="status">
                Stato
            </label>
            <select class="status ms-2 w-50 form-select" name="status" id="status">
                <option selected>
                    Seleziona
                </option>
                @foreach ($status as $data)
                    <option value="{{ $data }}">
                        {{ $data }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="started">
            <label for="started">
                Iniziato
            </label>
            <input class="ms-2" type="date" name="started" id="started">
        </div>
        <div class="completed align-items-center">
            <label for="completed">
                Completato
            </label>
            <input class="ms-2" type="date" name="completed" id="completed">
        </div>
        <div class="execution_time">
            <label for="execution_time">
                Ore di lavoro totali
            </label>
            <input class="w-25 ms-2" type="number" name="execution_time" id="execution_time">
        </div>
    </div>
    <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
        <div>
            <label for="pattern_name">
                Nome dello schema
            </label>
            <input class="ms-2" type="text" name="pattern_name" id="pattern_name">
        </div>
        <div class="d-flex align-items-center">
            <label for="pattern_url">
                Link dello schema
            </label>
            <input class="ms-2" type="url" name="pattern_url" id="pattern_url">
        </div>
    </div>
    <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
        <div class="d-flex align-items-center">
            <label for="size">
                Taglia
            </label>
            <select class="ms-2 w-50 form-select" name="size" id="size">
                <option selected>
                    Seleziona la taglia
                </option>
                @foreach ($sizes as $size)
                    <option value="{{ $size }}">
                        {{ $size }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- Contenitore input filati originale --}}
        {{-- <div class="d-flex align-items-center">
            <label class="text-danger" for="yarn_id">
                Filato
            </label>
            <select class="ms-2 w-50 form-select" name="yarn_id" id="yarn_id">
                <option selected>
                    Seleziona il filato
                </option>
                @foreach ($yarns as $yarn)
                    <option value="{{ $yarn->id }}">
                        {{ $yarn->name }}
                    </option>
                @endforeach
            </select>
        </div> --}}
        {{-- Contenitore input filati complesso --}}
        <div id="yarns-container">
            <div class="yarns d-flex align-items-center">
                <div class="yarn-row d-flex form-control justify-content-between gap-3">
                    {{-- Filato --}}
                    <div class="yarn-column">
                        <label class="text-danger" for="yarn_id_0">
                            Filato
                        </label>
                        <select class="ms-2 form-select" name="yarns[0][yarn_id]" id="yarn_id_0">
                            <option selected>
                                Seleziona il filato
                            </option>
                            @foreach ($yarns as $yarn)
                                <option value="{{ $yarn->id }}">
                                    {{ $yarn->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Colore --}}
                    <div class="yarn-column">
                        <label class="text-danger" for="colorway_id_0">
                            Colore
                        </label>
                        <select class="ms-2 form-select" name="yarns[0][colorway_id]" id="colorway_id_0">
                            <option selected>
                                Seleziona il colore
                            </option>
                            @foreach ($colorways as $colorway)
                                <option value="{{ $colorway->id }}">
                                    {{ $colorway->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Quantità --}}
                    <div class="yarn-column">
                        <label class="text-danger" for="quantity_0">
                            Quantità
                        </label>
                        <input class="ms-2 form-select" type="number" name="yarns[0][quantity]" id="quantity_0"/>
                    </div>
                    <button type="button" id="add-yarn-btn" class="btn btn-secondary">
                        +
                    </button>
                </div>
            </div>
            {{-- <div class="d-flex gap-2 mt-3">
                <button id="create-yarn-btn" type="button" class="btn btn-info" data-bs-toggle="modal" data-bs-target="#CreateYarnModal">
                    Aggiungi nuovo filato
                </button>
            </div>
            <div class="create-yarn-form my-4 form-control" style="display: none;">
                        <div class="mb-3 py-3 px-3 d-flex flex-column gap-4">
                            <div>
                                <label class="text-danger" for="new_yarn[name]">
                                    Nome
                                </label>
                                <input class="ms-2" type="text" name="new_yarn[name]" id="new_yarn[name]">
                            </div>
                            <div>
                                <label class="text-danger" for="new_yarn[brand]">
                                    Marca
                                </label>
                                <input class="ms-2" type="text" name="new_yarn[brand]" id="new_yarn[brand]">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="weight">
                                    Peso
                                </label>
                                <input class="ms-2" type="text" name="weight" id="weight">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="category">
                                    Categoria
                                </label>
                                <input class="ms-2" type="text" name="category" id="category">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="ply">
                                    Fili
                                </label>
                                <input class="ms-2" type="number" name="ply" id="ply">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="unit_weight">
                                    Peso unitario
                                </label>
                                <input class="ms-2" type="number" name="unit_weight" id="unit_weight">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="meterage">
                                    Metraggio
                                </label>
                                <input class="ms-2" type="number" name="meterage" id="meterage">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="fiber_types_number">
                                    Tipologie di fibra
                                </label>
                                <input class="ms-2" type="number" name="fiber_types_number" id="fiber_types_number">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="min_hook_size">
                                    Misura uncinetto minima
                                </label>
                                <input class="ms-2" type="number" name="min_hook_size" id="min_hook_size">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="max_hook_size">
                                    Misura uncinetto massima
                                </label>
                                <input class="ms-2" type="number" name="max_hook_size" id="max_hook_size">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="min_needle_size">
                                    Misura ferri minima
                                </label>
                                <input class="ms-2" type="number" name="min_needle_size" id="min_needle_size">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="max_needle_size">
                                    Misura ferri massima
                                </label>
                                <input class="ms-2" type="number" name="max_needle_size" id="max_needle_size">
                            </div>
                            <div class="d-flex align-items-center">
                                <label class="text-danger" for="color_type">
                                    Tipologia colore
                                </label>
                                <input class="ms-2" type="number" name="color_type" id="color_type">
                            </div>
                            <div>
                                <label for="image_path">
                                    Immagine
                                </label>
                                <input class="ms-2" type="file" name="image_path" id="image_path">
                            </div>
                        </div>
            </div> --}}
        </div>
        <div>
            <label for="destination_use">
                Per chi è?
            </label>
            <input class="ms-2" type="text" name="destination_use" id="destination_use">
        </div>
        <div>
            <label for="notes">
                Note
            </label>
            <textarea class="mt-2 form-control" name="notes" id="notes" rows="5"></textarea>
        </div>
    </div>
    <button type="submit" class="btn btn-info">
        Salva
    </button>
</form>

{{-- <x-create-yarn-modal/> --}}

@vite(['resources/js/projects-form.js'])

@endsection