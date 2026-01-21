@extends('layouts.admin')

{{-- @dd($colorways) --}}

@section('title', 'Aggiungi un progetto')

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
    <form class="precise-font w-75 mb-5" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- Informazioni principali / obbligatorie --}}
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            {{-- Nome --}}
            <div>
                <label for="name">
                    Nome
                </label>
                <input class="ms-2" type="text" name="name" id="name">
            </div>
            {{-- Tecniche --}}
            <div>
                <label>
                    Tecniche
                </label>
                <div class="form-control gold-border mt-3 px-3 d-flex gap-4 flex-wrap justify-content-between">
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
            {{-- Categoria --}}
            <div class="d-flex align-items-center">
                <label for="category">
                    Categoria
                </label>
                <select class="ms-2 w-50 form-select" name="category_id" id="category">
                    <option selected value="">
                        Seleziona la categoria
                    </option>
                    <x-category-options :categories="$categories" />
                </select>
            </div>
            {{-- Immagine --}}
            <div>
                <label for="image">
                    Immagine
                </label>
                <input class="ms-2" type="file" name="image_path" id="image">
            </div>
        </div>
        {{-- Informazioni tempistiche progetto --}}
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            {{-- Stato --}}
            <div class="d-flex align-items-center">
                <label for="status">
                    Stato
                </label>
                <select class="status ms-2 w-50 form-select" name="status" id="status">
                    <option selected value="">
                        Seleziona
                    </option>
                    @foreach ($status as $data)
                        <option value="{{ $data }}">
                            {{ $data }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Iniziato --}}
            <div class="started">
                <label for="started">
                    Iniziato
                </label>
                <input class="ms-2" type="date" name="started" id="started">
            </div>
            {{-- Completato --}}
            <div class="completed align-items-center">
                <label for="completed">
                    Completato
                </label>
                <input class="ms-2" type="date" name="completed" id="completed">
            </div>
            {{-- Tempo di lavoro totale --}}
            <div class="execution_time">
                <label for="execution_time">
                    Ore di lavoro totali
                </label>
                <input class="w-25 ms-2" type="number" name="execution_time" id="execution_time">
            </div>
        </div>
        {{-- Informazioni schema --}}
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            {{-- Designer --}}
            <div>
                <label for="designer_name">
                    Nome del(la) designer
                </label>
                <input class="ms-2" type="text" name="designer_name" id="designer_name">
            </div>
            {{-- Nome schema --}}
            <div>
                <label for="pattern_name">
                    Nome dello schema
                </label>
                <input class="ms-2" type="text" name="pattern_name" id="pattern_name">
            </div>
            {{-- Link schema --}}
            <div class="d-flex align-items-center">
                <label for="pattern_url">
                    Link dello schema
                </label>
                <input class="ms-2" type="url" name="pattern_url" id="pattern_url">
            </div>
        </div>
        {{-- Informazioni aggiuntive --}}
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            {{-- Taglia --}}
            <div class="d-flex align-items-center">
                <label for="size">
                    Taglia
                </label>
                <select class="ms-2 w-50 form-select" name="size" id="size">
                    <option selected value="">
                        Seleziona la taglia
                    </option>
                    @foreach ($sizes as $size)
                        <option value="{{ $size }}">
                            {{ $size }}
                        </option>
                    @endforeach
                </select>
            </div>
            {{-- Filati --}}
            <div id="yarns-container">
                <div class="yarns d-flex align-items-center">
                    <div class="yarn-row d-flex form-control gold-border justify-content-between gap-3">
                        {{-- Filato --}}
                        <div class="yarn-column">
                            <label for="yarn_id_0">
                                Filato
                            </label>
                            <select class="ms-2 form-select" name="yarns[0][yarn_id]" id="yarn_id_0">
                                <option selected value="">
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
                            <label for="colorway_id_0">
                                Colore
                            </label>
                            <select class="ms-2 form-select" name="yarns[0][colorway_id]" id="colorway_id_0">
                                <option selected value="">
                                    Seleziona il colore
                                </option>
                                @foreach ($colorways as $colorway)
                                    <option value="{{ $colorway->id }}">
                                        {{ $colorway->key }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        {{-- Quantità --}}
                        <div class="yarn-column">
                            <label for="quantity_0">
                                Quantità
                            </label>
                            <input class="ms-2 form-select" type="number" name="yarns[0][quantity]" id="quantity_0"/>
                        </div>
                        <button type="button" id="add-yarn-btn" class="btn btn-secondary">
                            +
                        </button>
                    </div>
                </div>
            </div>
            {{-- Per chi è --}}
            <div>
                <label for="destination_use">
                    Per chi è?
                </label>
                <input class="ms-2" type="text" name="destination_use" id="destination_use">
            </div>
            {{-- Note --}}
            <div>
                <label for="notes">
                    Note
                </label>
                <textarea class="mt-2 form-control gold-border" name="notes" id="notes" rows="5"></textarea>
            </div>
        </div>
        {{-- Pulsante salva --}}
        <button type="submit" class="btn btn-form">
            Salva
        </button>
    </form>
</div>

@vite(['resources/js/projects-form.js'])

@endsection