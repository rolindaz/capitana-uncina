@extends('layouts.admin')

{{-- @dd($categories) --}}

@section('content')

<form class="w-50" action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
        <div>
            <label for="name">
                Nome
            </label>
            <input class="ms-2" type="text" name="name" id="name">
        </div>
        <div class="d-flex align-items-center">
            <label for="category">
                Categoria
            </label>
            <select class="ms-2 w-50 form-select" name="category" id="category">
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
            <input class="ms-2" type="file" name="image" id="image">
        </div>
    </div>
</form>

@endsection