@extends('layouts.admin')

@section('title', 'I miei progetti')

{{-- @dd($projects); --}}

@section('content')

{{-- Tabella risorse con i parametri relativi ai progetti --}}
<x-admin.resource-table
  title="Progetti"
  :createRoute="route('projects.create')"
  action="+ Nuovo Progetto"
>

{{-- Slot per la prima barra di paginazione --}}
<x-slot name="paginationTop">
  @if ($projects->hasPages())
    {{ $projects->onEachSide(1)->links('admin.pagination.index') }}
  @endif
</x-slot>

{{-- Slot dell'intestazione della tabella con le colonne ordinabili --}}
<x-slot name="head">

    <th scope="col" class="text-center">
      Foto
    </th>

    <x-admin.sortable-th field="name" label="Titolo" :currentSort="$sort" :currentDirection="$direction" />
    <x-admin.sortable-th field="category" label="Categoria" :currentSort="$sort" :currentDirection="$direction" />
    <x-admin.sortable-th field="created_at" label="Aggiunto" :currentSort="$sort" :currentDirection="$direction" />
    <x-admin.sortable-th field="updated_at" label="Aggiornato" :currentSort="$sort" :currentDirection="$direction" />

    <th scope="col" class="text-center">
      Azioni
    </th>

</x-slot>

{{-- Slot del corpo con le informazioni dei progetti --}}
<x-slot name="body">

  @foreach ($projects as $project)
    <tr>
      {{-- Immagine --}}
      <td>
        <a class="text-decoration-none text-black" href="{{ route('projects.show', $project->slug) }}">
          <div class="thumbnail">
            <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->name . ' Thumbnail'}}">
          </div>
        </a>
      </td>
      {{-- Nome progetto --}}
      <td class="text-center">
        <a class="text-decoration-none text-black" href="{{ route('projects.show', $project->slug) }}">
          {{ $project->name }}
        </a>
      </td>
      {{-- Categoria --}}
      <td class="text-center">
          {{ $project->category->name }}
      </td>
      {{-- Data di creazione --}}
      <td class="text-center">
        {{ $project->created_at->diffForHumans() }}
      </td>
      {{-- Ultimo aggiornamento --}}
      <td class="text-center">
        {{ $project->updated_at->diffForHumans() }}
      </td>
      {{-- Azioni --}}
      <td>
        <div class="d-flex gap-2 justify-content-evenly">

          {{-- Pulsante di modifica --}}
          <x-admin.edit-button label="Modifica" route="projects.edit" :model="$project" />

          {{-- Pulsante di eliminazione che triggera la modale --}}
          <x-admin.delete-modal
            :id="'deleteProjectModal-'.$project->id"
            :action="route('projects.destroy', $project)"
            message="Sei sicuro di voler eliminare questo progetto? L'azione è irreversibile."
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
  @if ($projects->hasPages())
    {{ $projects->onEachSide(1)->links('admin.pagination.index') }}
  @endif
</x-slot>

</x-admin.resource-table>

@endsection