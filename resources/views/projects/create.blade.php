@extends('layouts.admin')

{{-- @dd($yarns) --}}

@section('content')

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
            <label class="text-danger" for="craft">
                Tecnica
            </label>
            <input class="ms-2" type="text" name="craft" id="craft">
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
            <select class="ms-2 w-50 form-select" name="status" id="status">
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
        <div>
            <label for="started">
                Iniziato
            </label>
            <input class="ms-2" type="date" name="started" id="started">
        </div>
        <div class="d-flex align-items-center">
            <label for="completed">
                Completato
            </label>
            <input class="ms-2" type="date" name="completed" id="completed">
        </div>
        <div>
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
        <div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="correct" id="correct_true" value="1">
                <label class="form-check-label" for="correct_true">
                    Ho seguito lo schema
                </label>
            </div>
            <div class="form-check">
              <input class="form-check-input" type="radio" name="correct" id="correct_false" value="0">
              <label class="form-check-label" for="correct_false">
                L'ho usato per ispirarmi
              </label>
            </div>
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
        <div class="d-flex align-items-center">
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

@endsection