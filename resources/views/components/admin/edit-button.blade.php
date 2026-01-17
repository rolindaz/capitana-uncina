@props([
    'href' => null,
    'route' => null,
    'model' => null,
    'label' => 'Modifica',
    'class' => 'edit-btn',
])

@php
    $resolvedHref = $href;
    if (empty($resolvedHref) && !empty($route) && !empty($model)) {
        $resolvedHref = route($route, $model);
    }
@endphp

<a href="{{ $resolvedHref ?? '#' }}" class="{{ $class }}">
    {{ $label }}
</a>