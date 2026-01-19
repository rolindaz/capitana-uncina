@extends('layouts.admin')

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
    <form class="precise-font w-75 mb-5" action="{{ route('yarns.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div>
                <label for="name">
                    Nome
                </label>
                <input class="ms-2" type="text" name="name" id="name">
            </div>
            <div>
                <label for="brand">
                    Marca
                </label>
                <input class="ms-2" type="text" name="brand" id="brand">
            </div>
            <div>
                <label for="image_path">
                    Immagine
                </label>
                <input class="ms-2" type="file" name="image_path" id="image_path">
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div>
                <label for="fiber_types_number">
                    Tipologie di fibra
                </label>
                <input class="ms-2" type="number" name="fiber_types_number" id="fiber_types_number">
            </div>
            {{-- Contenitore input fibre complesso --}}
            <div id="fibers-container">
                <div class="fibers d-flex align-items-center">
                    <div class="fiber-row gold-border d-flex form-control justify-content-between gap-3">
                        <div class="fiber-column">
                            <label for="fiber_id_0">
                                Fibra
                            </label>
                            <select class="ms-2 form-select" name="fibers[0][fiber_id]" id="fiber_id_0">
                                <option selected>
                                    Seleziona la fibra
                                </option>
                                @foreach ($fibers as $fiber)
                                    <option value="{{ $fiber->id }}">
                                        {{ $fiber->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="fiber-column">
                            <label for="percentage_0">
                                Percentuale
                            </label>
                            <input class="ms-2 form-select" type="number" name="fibers[0][percentage]" id="percentage_0"/>
                        </div>
                        <button type="button" id="add-fiber-btn" class="btn btn-secondary">
                            +
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div class="form-control blue-border mb-3 py-3 px-3 d-flex flex-column gap-4">
            <div>
                <label for="unit_weight">
                    Peso Unitario
                </label>
                <input class="ms-2" type="number" name="unit_weight" id="unit_weight">
            </div>
            <div>
                <label for="meterage">
                    Metraggio
                </label>
                <input class="ms-2" type="number" name="meterage" id="meterage">
            </div>
            <div>
                <label for="ply">
                    Fili
                </label>
                <input class="ms-2" type="number" name="ply" id="ply">
            </div>
            <div class="d-flex align-items-center">
                <label for="weight">
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
                <label for="category">
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
        </div>
        <div class="form-control blue-border mb-3 py-3 px-5 d-flex flex-column gap-4">
                <div class="row row-cols-3 px-5 align-items-center">
                    <h6 class="col mb-0 border-end">
                        Uncinetto
                    </h6>
                    <div class="col">
                        <label for="min_hook_size">
                            Minimo
                        </label>
                        <input class="ms-2" type="number" step="0.01" inputmode="decimal" name="min_hook_size" id="min_hook_size"
                        style="width: 100px;">
                    </div>
                    <div class="col">
                        <label for="max_hook_size">
                            Massimo
                        </label>
                        <input class="ms-2" type="number" step="0.01" inputmode="decimal" name="max_hook_size" id="max_hook_size"
                        style="width: 100px;">
                    </div>
                </div>
                <div class="row row-cols-3 px-5 align-items-center">
                    <h6 class="col mb-0 border-end">
                        Ferri
                    </h6>
                    <div class="col">
                        <label for="min_needle_size">
                            Minimo
                        </label>
                        <input class="ms-2" type="number" step="0.01" inputmode="decimal" name="min_needle_size" id="min_needle_size"
                        style="width: 100px;">
                    </div>
                    <div class="col">
                        <label for="max_needle_size">
                            Massimo
                        </label>
                        <input class="ms-2" type="number" step="0.01" inputmode="decimal" name="max_needle_size" id="max_needle_size"
                        style="width: 100px;">
                    </div>
                </div>
            </div>
            <button type="submit" class="btn btn-form">
                Salva
            </button>
        </div>
    </form>
</div>

@vite('resources/js/yarns-form.js')

@endsection