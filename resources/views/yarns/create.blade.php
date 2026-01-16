@extends('layouts.admin')



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

<form class="w-50 mb-5" action="{{ route('yarns.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
        <div>
            <label class="text-danger" for="name">
                Nome
            </label>
            <input class="ms-2" type="text" name="name" id="name">
        </div>
        <div>
            <label class="text-danger" for="brand">
                Marca
            </label>
            <input class="ms-2" type="text" name="brand" id="brand">
        </div>
        <div class="d-flex align-items-center">
            <label class="text-danger" for="weight">
                Standard Peso
            </label>
            <select class="weight ms-2 w-50 form-select" name="weight" id="weight">
                <option selected>
                    Seleziona
                </option>
                @foreach ($weight as $data)
                    <option value="{{ $data }}">
                        {{ $data }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="d-flex align-items-center">
            <label class="text-danger" for="category">
                Standard Categoria
            </label>
            <select class="category ms-2 w-50 form-select" name="category" id="category">
                <option selected>
                    Seleziona
                </option>
                @foreach ($category as $data)
                    <option value="{{ $data }}">
                        {{ $data }}
                    </option>
                @endforeach
            </select>
        </div>
        {{-- <div>
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
        </div> --}}
    </div>
    <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
        <div>
            <label class="text-danger" for="fiber_types_number">
                Tipologie di fibra
            </label>
            <input class="ms-2" type="number" name="fiber_types_number" id="fiber_types_number">
        </div>
        <div>
            <label for="meterage">
                Metraggio
            </label>
            <input class="ms-2" type="number" name="meterage" id="meterage">
        </div>
        <div>
            <label class="text-danger" for="unit_weight">
                Peso Unitario
            </label>
            <input class="ms-2" type="number" name="unit_weight" id="unit_weight">
        </div>
        <div>
            <label for="color_type">
                Tipo Colore
            </label>
            <input class="ms-2" type="text" name="color_type" id="color_type">
        </div>
        <div>
            <label for="image_path">
                Immagine
            </label>
            <input class="ms-2" type="file" name="image_path" id="image_path">
        </div>
    </div>
    <div class="form-control mb-3 py-3 px-3 d-flex flex-column gap-4">
        <div>
            <label for="ply">
                Fili
            </label>
            <input class="ms-2" type="number" name="ply" id="ply">
        </div>
        <div>
            <label for="min_hook_size">
                Misura uncinetto minima
            </label>
            <input class="ms-2" type="number" name="min_hook_size" id="min_hook_size">
        </div>
        <div>
            <label for="max_hook_size">
                Misura uncinetto massima
            </label>
            <input class="ms-2" type="number" name="max_hook_size" id="max_hook_size">
        </div>
        <div>
            <label for="min_needle_size">
                Misura ferri minima
            </label>
            <input class="ms-2" type="number" name="min_needle_size" id="min_needle_size">
        </div>
        <div>
            <label for="max_needle_size">
                Misura ferri massima
            </label>
            <input class="ms-2" type="number" name="max_needle_size" id="max_needle_size">
        </div>
        {{-- Contenitore input fibre complesso --}}
        {{-- <div id="fibers-container">
            <div class="yarns d-flex align-items-center">
                <div class="yarn-row d-flex form-control justify-content-between gap-3">
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
        </div> --}}
    </div>
    <button type="submit" class="btn btn-info">
        Salva
    </button>
</form>

@endsection