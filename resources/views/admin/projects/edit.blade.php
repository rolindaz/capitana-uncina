@extends('layouts.admin')

@section('title', 'Modifica il tuo progetto')

@section('content')

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
                    <option selected>
                        Seleziona la categoria
                    </option>
                    <x-category-options :categories="$categories" />
                </select>
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div class="d-flex align-items-center">
                <label for="status">
                    Stato
                </label>
                <select class="status ms-2 w-50 form-select" name="status" id="status">
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