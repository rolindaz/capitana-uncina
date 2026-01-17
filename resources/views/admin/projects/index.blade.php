@extends('layouts.admin')

@section('title', 'Dashboard')

{{-- @dd($projects); --}}

@section('content')

<x-admin.resource-table
  title="Projects"
  :createRoute="route('projects.create')"
>

<x-slot name="head">

  <th scope="col">
        Immagine
    </th>
      <th scope="col">
        Nome
    </th>
      <th scope="col">
        Tecniche
    </th>
      <th scope="col">
        Aggiunto
    </th>
    <th scope="col">
        Ultima modifica
    </th>

</x-slot>

<x-slot name="body">

  @foreach ($projects as $project)
    <tr>
      <td>
        <a class="text-decoration-none text-black" href="{{ route('projects.show', $project->slug) }}">
          <div class="thumbnail">
            <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->name . ' Thumbnail'}}">
          </div>
        </a>
      </td>
      <td>
        <a class="text-decoration-none text-black" href="{{ route('projects.show', $project->slug) }}">
          {{ $project->name }}
        </a>
      </td>
      <td>
        @foreach ($project->crafts as $craft)
          {{ $craft->name }}
        @endforeach
      </td>
      <td>
        {{ $project->created_at->diffForHumans() }}
      </td>
      <td>
        {{ $project->updated_at->diffForHumans() }}
      </td>
      <td class="text-end">
        <div class="d-inline-flex gap-2">
          <a href="{{ route('projects.edit', $project) }}" class="btn btn-success btn-sm">
            Modifica
          </a>

          <button
            type="button"
            class="btn btn-danger btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#deleteProjectModal-{{ $project->id }}"
          >
            Elimina
          </button>
        </div>

        <div
          class="modal fade"
          id="deleteProjectModal-{{ $project->id }}"
          tabindex="-1"
          aria-labelledby="deleteProjectModalLabel-{{ $project->id }}"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteProjectModalLabel-{{ $project->id }}">
                  Conferma eliminazione
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Sei sicuro di voler eliminare questo progetto? L'azione è irreversibile.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Annulla
                </button>
                <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">
                    Elimina definitivamente
                  </button>
                </form>
              </div>
            </div>
          </div>
        </div>
      </td>
    </tr>
    @endforeach

</x-slot>

</x-admin.resource-table>

@endsection