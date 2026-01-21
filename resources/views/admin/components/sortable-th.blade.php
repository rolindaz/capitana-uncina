@props([
    'field',
    'label',
])

@php
    $currentSort = request()->query('sort');
    $currentDirection = request()->query('direction', 'asc');
    $currentDirection = $currentDirection === 'desc' ? 'desc' : 'asc';

    $isActive = $currentSort === $field;

    $nextDirection = ($isActive && $currentDirection === 'asc') ? 'desc' : 'asc';

    $url = request()->fullUrlWithQuery([
        ...request()->except(['sort', 'direction', 'page']),
        'sort' => $field,
        'direction' => $nextDirection,
    ]);

    $indicator = '';
    if ($isActive) {
        $indicator = $currentDirection === 'asc' ? '↑' : '↓';
    }
@endphp

<th scope="col">
    <a class="text-decoration-none text-black" href="{{ $url }}">
        {{ $label }}
        @if($indicator)
            <span class="ms-1">{{ $indicator }}</span>
        @endif
    </a>
</th>
