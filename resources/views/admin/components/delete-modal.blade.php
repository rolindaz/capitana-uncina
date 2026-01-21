@props([
    'id',
    'action',
    'title' => 'Conferma eliminazione',
    'message' => "Sei sicuro di voler eliminare questo elemento? Questa azione è irreversibile.",
    'triggerText' => 'Elimina',
    'triggerClass' => 'btn btn-danger precise-font',
    'confirmText' => 'Elimina definitivamente',
    'cancelText' => 'Annulla',
])

@php
    $labelId = $id.'Label';
@endphp

<button
    type="button"
    class="{{ $triggerClass }}"
    data-bs-toggle="modal"
    data-bs-target="#{{ $id }}"
>
    {{ $triggerText }}
</button>

<div
    class="modal fade"
    id="{{ $id }}"
    tabindex="-1"
    aria-labelledby="{{ $labelId }}"
    aria-hidden="true"
>
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $labelId }}">
                    {{ $title }}
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    {{ $cancelText }}
                </button>

                <form action="{{ $action }}" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        {{ $confirmText }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
