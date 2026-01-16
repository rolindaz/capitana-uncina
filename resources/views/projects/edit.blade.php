@extends('layouts.admin')

@section('title', 'Modifica il tuo progetto')

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

<div class="container">
    <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-control mb-3">
            <label for="name">
                Titolo
            </label>
            <input 
            type="text"
            name="name"
            id="name"
            value="{{ old('name', $project->name) }}">
        </div>
        <div class="form-control mb-3">
            <label for="category_id">
                Categoria
            </label>
            <select name="category_id" id="category_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ (int) old('category_id', $project->category_id) === $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-control mb-3 d-flex gap-4 flex-wrap">
            <label for="craft">
                Tecniche utilizzate
            </label>
            <div id="craft" class="d-flex gap-4">
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
        <div class="form-control mb-3">
            <label for="status">
                Stato
            </label>
            <select name="status" id="status">
                @foreach ($status as $data)
                    <option value="{{ $data }}" {{ old('status', $project->status) == $data ? 'selected' : '' }}>
                        {{ $data }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-control mb-3 d-flex gap-4 flex-wrap">
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
@endsection