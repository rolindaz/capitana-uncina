@extends('layouts.admin')

{{-- @dd($project) --}}

@section('title', $project->name)

@section('content')

<div class="row g-4 align-items-start mb-4">
    
    {{-- Immagine progetto --}}
    <div class="col-12 col-md-4 col-lg-3">
        @if($project->image_path)
            <figure class="polaroid mb-0">
                <img
                    class="polaroid-img"
                    src="{{ asset('storage/' . $project->image_path) }}"
                    alt="{{ $project->name }}"
                >
                <figcaption class="polaroid-caption handwriting">
                    {{ $project->name }}
                </figcaption>
            </figure>
        @else
            <div class="polaroid mb-0">
                <div class="polaroid-img d-flex align-items-center justify-content-center text-muted handwriting">
                    Nessuna immagine
                </div>
                <div class="polaroid-caption handwriting">
                    {{ $project->name }}
                </div>
            </div>
        @endif
    </div>

    {{-- Informazioni progetto --}}
    <div class="col-12 col-md-8 col-lg-9 precise-font">

        {{-- Intestazione con titolo e pulsanti --}}
        <div class="d-flex justify-content-between align-items-start gap-3">

            {{-- Titolo --}}
            <div>
                <h1 class="h3 mb-1 handwriting">{{ $project->name }}</h1>
                <div class="text-muted small">
                    Creato: {{ $project->created_at?->diffForHumans() ?? '—' }} · Ultima modifica: {{ $project->updated_at?->diffForHumans() ?? '—' }}
                </div>
            </div>
            
            {{-- Pulsanti per modifica ed eliminazione --}}
            <div class="d-flex gap-2 flex-wrap justify-content-end">
                <x-admin.edit-button route="projects.edit" :model="$project"/>

                <x-admin.delete-modal
                    id="deleteProjectModal"
                    :action="route('projects.destroy', $project)"
                    message="Sei sicuro di voler eliminare questo progetto? L'azione è irreversibile."
                    triggerText="Elimina"
                    triggerClass="action-button action-button--delete"
                />
            </div>
        </div>

        {{-- Card con dettagli --}}
        <div class="row g-3 mt-3">

            {{-- Categoria --}}
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase small fw-semibold text-muted mb-2">
                            Categoria
                        </div>
                        <div class="fs-6">
                            {{ $project->category?->breadcrumb ?: '—' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Tecniche --}}
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase fw-semibold small text-muted mb-2">
                            Tecniche
                        </div>
                        @forelse ($project->crafts as $craft)
                            <span class="badge text-bg-light me-1 mb-1">{{ $craft->name ?? '—' }}</span>
                        @empty
                            <div class="text-muted">—</div>
                        @endforelse
                    </div>
                </div>
            </div>

        </div>
        <div class="row g-3 mt-2">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase fw-semibold small text-muted mb-2">
                            Modello
                        </div>
                        <div>
                            <strong class="me-2">
                                Designer:
                            </strong>
                            {{ $project->designer_name? $project->designer_name : '-' }}
                        </div>
                        <div>
                            <strong class="me-2">
                                Schema:
                            </strong>
                            @if ($project->pattern_url)
                            <a target="_blank" href={{ $project->pattern_url}}>
                                {{ $project->pattern_name? $project->pattern_name : '-' }}
                            </a>
                            @else
                            {{ $project->pattern_name? $project->pattern_name : '-' }}
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase fw-semibold small text-muted mb-2">
                            Dettagli
                        </div>
                        @if($project->destination_use)
                            <div>
                                {{ $project->destination_use }}
                            </div>
                        @endif
                        @if($project->size)
                            <div>
                                Taglia: {{ $project->size }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Filati usati --}}
    <div class="card">
        <div class="handwriting fs-3 text-center my-2">
            Filati usati
        </div>
        <div class="row row-cols-2 flex-wrap" style="max-height: fit-content;">
            @forelse ($project->projectYarns as $used_yarn)
                <div class="card-body">
                    <div class="d-flex flex-wrap align-items-center gap-2 py-2 border-bottom">
                        <a href={{ env('VITE_BASE_URL') . '/yarns/' . $used_yarn?->yarn?->slug }} style="color: black;">
                            <strong>{{ $used_yarn->yarn->name ?? '—' }}</strong>
                        </a>
                                <span class="text-muted">{{ $used_yarn->yarn->brand ?? '' }}</span>
                                @if($used_yarn->colorway?->image_path)
                                    <img class="color-thumb" src="{{ asset('storage/' . $used_yarn->colorway->image_path) }}" alt="{{ $project->name }}">
                                @endif
                                <span class="badge text-bg-light">
                                    Quantità: {{ (int) $used_yarn->quantity }} gomitoli
                                </span>
                                <span class="badge text-bg-light">
                                    {{ $used_yarn->weight }} g
                                </span>
                                <span class="badge text-bg-light">
                                    {{ $used_yarn->meterage }} m
                                </span>
                    </div>
                </div>
            @empty
                <div class="text-center precise-font text-muted mb-3">Nessun filato associato.</div>
            @endforelse
        </div>
    </div>
    
    {{-- Note --}}
    <section class="notebook-sheet">
        <div class="notebook-sheet-header d-flex justify-content-between align-items-center gap-3">
            <h2 class="h5 mb-0 table-head-font text-uppercase">Note</h2>
        </div>

        <div class="notebook-sheet-body precise-font">
            @php
                $notes = $project->notes ?? null;
            @endphp

            @if(!empty($notes))
                <p class="mb-0">{!! nl2br(e($notes)) !!}</p>
            @else
                <p class="mb-0 text-muted">
                </p>
            @endif
        </div>
    </section>

    {{-- Pulsante torna indietro --}}
    <div class="d-flex justify-content-start mt-4 precise-font">
        <a href="{{ route('projects.index') }}" class="action-button action-button--go-back">
            Torna ai progetti
        </a>
    </div>
</div>
@endsection