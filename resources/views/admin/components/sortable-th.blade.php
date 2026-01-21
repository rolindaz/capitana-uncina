{{-- Componente per le colonne ordinabili nella tabella della index --}}

@props([
    'field',
    'label',
    'currentSort' => null,
    'currentDirection' => null,
])

{{-- Definisco la logica per l'ordinamento dei progetti --}}
@php

    // parametro per l'ordinamento e direzione sono passati dal controller alla index a qui tramite i props oppure impostati su valori coerenti di fallback
    $currentSort = $currentSort ?? request()->query('sort');
    $currentDirection = $currentDirection ?? request()->query('direction', 'desc');
    $currentDirection = $currentDirection === 'asc' ? 'asc' : 'desc';

    // Definisco la colonna attiva, cioè che gestisce l'ordinamento
    $isActive = $currentSort === $field;

    $nextDirection = ($isActive && $currentDirection === 'asc') ? 'desc' : 'asc';

    // Mi salvo l'url completa tranne sort e direction - perché intendo sostituirle - e page perché al click su una colonna di ordinamento diversa la paginazione deve resettarsi e tornare a pagina 1
    $url = request()->fullUrlWithQuery([
        ...request()->except(['sort', 'direction', 'page']),
        'sort' => $field,
        'direction' => $nextDirection,
    ]);

    // Scelgo un indicatore per la colonna attiva - se non è attiva non dev'esserci niente - in base alla direzione di ordinamento
    $indicator = '';
    if ($isActive) {
        $indicator = $currentDirection === 'asc' ? '↑' : '↓';
    }
@endphp

<th scope="col" class="text-center">
    <a class="text-decoration-none text-black" href="{{ $url }}">
        {{ $label }}
        @if($indicator)
            <span class="ms-1">{{ $indicator }}</span>
        @endif
    </a>
</th>
