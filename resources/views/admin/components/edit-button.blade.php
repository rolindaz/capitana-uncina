{{-- Pulsante di modifica della risorsa - Va alla edit --}}

@props([
    'href' => null,
    'route' => null,
    'model' => null,
    'label' => 'Modifica',
    'class' => 'edit-btn',
])

@php
    // Se non c'è il link, passo la rotta con Laravel route()
    $resolvedHref = $href;
    if (empty($resolvedHref) && !empty($route) && !empty($model)) {
        $resolvedHref = route($route, $model);
    }
@endphp

<a href="{{ $resolvedHref ?? '#' }}" class="{{ $class }}">
    {{ $label }}
</a>