@extends('layouts.admin')

@section('title', 'I miei filati')

{{-- @dd($yarns); --}}

@section('content')

{{-- Tabella risorse con i parametri relativi ai filati --}}
<x-admin.resource-table
title="Filati"
:createRoute="route('yarns.create')"
action="+ Nuovo Filato"
>

{{-- Slot per la prima barra di paginazione --}}
<x-slot name="paginationTop">
  @if ($yarns->hasPages())
    {{ $yarns->onEachSide(1)->links('admin.pagination.index') }}
  @endif
</x-slot>

{{-- Slot dell'intestazione della tabella con le colonne ordinabili --}}
<x-slot name="head">

      <th scope="col" class="text-center">
        Foto
      </th>

      <x-admin.sortable-th field="name" label="Nome" :currentSort="$sort" :currentDirection="$direction" />
      <x-admin.sortable-th field="brand" label="Marca" :currentSort="$sort" :currentDirection="$direction" />
      <x-admin.sortable-th field="created_at" label="Aggiunto" :currentSort="$sort" :currentDirection="$direction" />
      <x-admin.sortable-th field="updated_at" label="Aggiornato" :currentSort="$sort" :currentDirection="$direction" />

      <th scope="col" class="text-center">
        Azioni
      </th>

</x-slot>

{{-- Slot del corpo con le informazioni dei filati --}}
<x-slot name="body">

@foreach ($yarns as $yarn)
    <tr>
      {{-- Immagine --}}
      <td>
        <a class="text-decoration-none text-black" href="{{ route('yarns.show', $yarn->slug ?? $yarn->id) }}">
          <div class="thumbnail">
            @if($yarn->image_path)
              <img src="{{ asset('storage/' . $yarn->image_path) }}" alt="{{ $yarn->name . ' Thumbnail'}}">
            @endif
          </div>
        </a>
      </td>
      {{-- Nome filato --}}
      <td class="text-center">
        <a class="text-decoration-none text-black" href="{{ route('yarns.show', $yarn->slug ?? $yarn->id) }}">
          {{ $yarn->name }}
        </a>
      </td>
      {{-- marca filato --}}
      <td class="text-center">
          {{ $yarn->brand }}
      </td>
      {{-- Data di creazione --}}
      <td class="text-center">
        {{ $yarn->created_at->diffForHumans() }}
      </td>
      {{-- Ultimo aggiornamento --}}
      <td class="text-center">
        {{ $yarn->updated_at->diffForHumans() }}
      </td>
      {{-- Azioni --}}
      <td>
        <div class="d-flex gap-2 justify-content-evenly">

          {{-- Pulsante di modifica --}}
          <x-admin.edit-button route="yarns.edit" :model="$yarn" />

          {{-- Pulsante di eliminazione che triggera la modale --}}
          <x-admin.delete-modal
            :id="'deleteYarnModal-'.$yarn->id"
            :action="route('yarns.destroy', $yarn)"
            message="Sei sicuro di voler eliminare questo filato? L'azione è irreversibile."
            triggerText="Elimina"
            triggerClass="action-button action-button--delete"
          />
        </div>
      </td>
    </tr>
@endforeach

</x-slot>

{{-- Slot per la seconda barra di paginazione --}}
<x-slot name="paginationBottom">
  @if ($yarns->hasPages())
    {{ $yarns->onEachSide(1)->links('admin.pagination.index') }}
  @endif
</x-slot>

</x-admin.resource-table>

@endsection