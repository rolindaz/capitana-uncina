@extends('layouts.admin')

@section('title', 'Modifica il tuo progetto')

@section('content')
<div class="container">
    <form action="{{ route('projects.update', $project) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-control mb-3">
            <label for="title">
                Titolo
            </label>
            <input 
            type="text"
            name="title"
            id="title"
            value="{{ $project->name }}">
        </div>
        <div class="form-control mb-3">
            <label for="type_id">
                Tipologia
            </label>
            <select name="type_id" id="type_id">
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" {{ $project->category_id == $category->id ? 'selected' : '' }}>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-control mb-3">
            <label for="title">
                Tecnologia utilizzata
            </label>
            <input 
            type="text"
            name="tech"
            id="tech"
            value="{{ $project->tech }}">
        </div>
        <div class="form-control mb-3 d-flex gap-4 flex-wrap">
            <label for="craft">
                Tecniche utilizzate
            </label>
            <div id="craft" class="d-flex gap-4">
                @foreach ($crafts as $craft)
                    <div class="form-check">
                        <input class="form-check-input" name="crafts[]" type="checkbox" value="{{ $craft->id }}" id="craft-{{ $craft->id }}" {{ $project->crafts->contains($craft->id) ? 'checked' : '' }}>
                        <label class="form-check-label" for="craft-{{ $craft->id }}">
                            {{ $craft->name }}
                        </label>
                    </div>      
                @endforeach
            </div>
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