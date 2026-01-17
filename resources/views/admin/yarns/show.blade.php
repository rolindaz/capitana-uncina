@extends('layouts.admin')

{{-- @dd($yarn) --}}

@section('title', $yarn->name . ' - ' . $yarn->brand)

{{-- <x-yarns.go-back-button/> --}}





@section('content')

<div class="row g-4 align-items-start mb-4">
    <div class="col-12 col-md-4 col-lg-3">
        @php
            $yarnTitle = trim(($yarn->name ?? '').' - '.($yarn->brand ?? ''));
        @endphp

        @if($yarn->image_path)
            <figure class="polaroid mb-0">
                <img
                    class="polaroid-img"
                    src="{{ asset('storage/' . $yarn->image_path) }}"
                    alt="{{ $yarnTitle }}"
                >
                <figcaption class="polaroid-caption handwriting">
                    {{ $yarnTitle }}
                </figcaption>
            </figure>
        @else
            <div class="polaroid mb-0">
                <div class="polaroid-img d-flex align-items-center justify-content-center text-muted handwriting">
                    Nessuna immagine
                </div>
                <div class="polaroid-caption handwriting">
                    {{ $yarnTitle }}
                </div>
            </div>
        @endif
    </div>

    <div class="col-12 col-md-8 col-lg-9 precise-font">
        <div class="d-flex justify-content-between align-items-start gap-3">
            <div>
                <h1 class="h3 mb-1 handwriting">{{ $yarn->name }} <span class="text-muted">{{ $yarn->brand }}</span></h1>
                <div class="text-muted small">
                    Creato: {{ $yarn->created_at?->diffForHumans() ?? '—' }} · Ultima modifica: {{ $yarn->updated_at?->diffForHumans() ?? '—' }}
                </div>
            </div>

            <div class="d-flex gap-2 flex-wrap justify-content-end">
                <x-admin.edit-button route="yarns.edit" :model="$yarn"/>

                <x-admin.delete-modal
                    id="deleteYarnModal"
                    :action="route('yarns.destroy', $yarn)"
                    message="Sei sicuro di voler eliminare questo filato? L'azione è irreversibile."
                    triggerText="Elimina"
                    triggerClass="btn btn-danger"
                />
            </div>
        </div>

        <div class="row g-3 mt-3">
            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase small text-muted mb-2">Marca</div>
                        <div class="fs-6">{{ $yarn->brand ?? '—' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase small text-muted mb-2">Categoria</div>
                        <div class="fs-6">{{ $yarn->category ?? '—' }}</div>
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase small text-muted mb-2">Fibre</div>
                        @forelse ($yarn->fiberYarns as $fiber_composition)
                            <div class="d-flex align-items-center justify-content-between py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                <span>{{ $fiber_composition->fiber->name ?? '—' }}</span>
                                <span class="badge text-bg-light">{{ $fiber_composition->percentage }}%</span>
                            </div>
                        @empty
                            <div class="text-muted">Nessuna composizione fibre.</div>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="col-12 col-lg-6">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase small text-muted mb-2">Dati filato</div>
                        <div class="d-flex flex-wrap gap-2">
                            @if(!empty($yarn->weight))
                                <span class="badge text-bg-light">Weight: {{ $yarn->weight }}</span>
                            @endif
                            @if(!empty($yarn->ply))
                                <span class="badge text-bg-light">Ply: {{ $yarn->ply }}</span>
                            @endif
                            @if(!empty($yarn->unit_weight))
                                <span class="badge text-bg-light">{{ $yarn->unit_weight }} g</span>
                            @endif
                            @if(!empty($yarn->meterage))
                                <span class="badge text-bg-light">{{ $yarn->meterage }} m</span>
                            @endif
                            @if(empty($yarn->weight) && empty($yarn->ply) && empty($yarn->unit_weight) && empty($yarn->meterage))
                                <span class="text-muted">—</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-head-font text-uppercase small text-muted mb-2">Progetti in cui l'ho usato</div>

                        @forelse ($yarn->projectYarns as $usage)
                            @php
                                $usedProject = $usage->project;
                                $projectLabel = $usedProject?->name ?? $usedProject?->pattern_name ?? 'Progetto';
                                $projectRouteParam = $usedProject?->slug ?? $usedProject?->id;
                            @endphp

                            <div class="d-flex flex-wrap align-items-center gap-2 py-2 {{ !$loop->last ? 'border-bottom' : '' }}">
                                @if($usedProject)
                                    <a class="text-decoration-none" href="{{ route('projects.show', $projectRouteParam) }}">
                                        <strong>{{ $projectLabel }}</strong>
                                    </a>
                                @else
                                    <strong>{{ $projectLabel }}</strong>
                                @endif

                                @if(!empty($usage->quantity))
                                    <span class="badge text-bg-light">Quantità: {{ (int) $usage->quantity }}</span>
                                @endif
                                @if(!empty($usage->weight))
                                    <span class="badge text-bg-light">{{ $usage->weight }} g</span>
                                @endif
                                @if(!empty($usage->meterage))
                                    <span class="badge text-bg-light">{{ $usage->meterage }} m</span>
                                @endif
                            </div>
                        @empty
                            <div class="text-muted">Non è ancora stato usato in nessun progetto.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<section class="notebook-sheet">
    <div class="notebook-sheet-header d-flex justify-content-between align-items-center gap-3">
        <h2 class="h5 mb-0 table-head-font text-uppercase">Note</h2>
    </div>

    <div class="notebook-sheet-body precise-font">
        @php
            $notes = $yarn->notes ?? null;
        @endphp

        @if(!empty($notes))
            <p class="mb-0">{!! nl2br(e($notes)) !!}</p>
        @else
            <p class="mb-0 text-muted">Nessuna nota ancora.</p>
        @endif
    </div>
</section>

<div class="d-flex justify-content-start mt-4 precise-font">
    <a href="{{ route('yarns.index') }}" class="go-back-button">
        Torna ai filati
    </a>
</div>
@endsection