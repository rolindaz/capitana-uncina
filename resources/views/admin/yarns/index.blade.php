@extends('layouts.admin')

@section('title', 'Dashboard')

{{-- @dd($yarns); --}}

@section('actions')

<div class="m-4">
    <a href="{{ route('yarns.create') }}">
            <button class="btn btn-success">
                + New Yarn
            </button>
    </a>  
</div>

@endsection

@section('content')

<x-admin.resource-table
title="Yarns"
:createRoute="route('yarns.create')"
>

<x-slot name="head">

  <th scope="col">
        Immagine
      </th>
      <th scope="col">
        Nome
      </th>
      <th scope="col">
        Marca
      </th>
      <th scope="col">
        Fibre
      </th>
      <th scope="col">
        Aggiunto
      </th>
      <th scope="col">
        Ultima modifica
      </th>

</x-slot>

<x-slot name="body">

@foreach ($yarns as $yarn)
    <tr>
      <td>
        <a class="text-decoration-none text-black" href="{{ route('yarns.show', $yarn->slug ?? $yarn->id) }}">
          <div class="thumbnail">
            @if($yarn->image_path)
              <img src="{{ asset('storage/' . $yarn->image_path) }}" alt="{{ $yarn->name . ' Thumbnail'}}">
            @endif
          </div>
        </a>
      </td>
      <td>
        <a class="text-decoration-none text-black" href="{{ route('yarns.show', $yarn->slug ?? $yarn->id) }}">
          {{ $yarn->name }}
        </a>
      </td>
      <td>
          {{ $yarn->brand }}
      </td>
      <td>
        {{-- @foreach ($yarns->fibers as $fiber)
        {{ $yarn->fiber }}
        @endforeach --}}
      </td>
      <td>
        {{ $yarn->created_at->diffForHumans() }}
      </td>
      <td>
        {{ $yarn->updated_at->diffForHumans() }}
      </td>
      <td class="text-end">
        <div class="d-inline-flex gap-2">
          <a href="{{ route('yarns.edit', $yarn) }}" class="btn btn-success btn-sm">
            Modifica
          </a>

          <button
            type="button"
            class="btn btn-danger btn-sm"
            data-bs-toggle="modal"
            data-bs-target="#deleteYarnModal-{{ $yarn->id }}"
          >
            Elimina
          </button>
        </div>

        <div
          class="modal fade"
          id="deleteYarnModal-{{ $yarn->id }}"
          tabindex="-1"
          aria-labelledby="deleteYarnModalLabel-{{ $yarn->id }}"
          aria-hidden="true"
        >
          <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h1 class="modal-title fs-5" id="deleteYarnModalLabel-{{ $yarn->id }}">
                  Conferma eliminazione
                </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                Sei sicuro di voler eliminare questo filato? L'azione è irreversibile.
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  Annulla
                </button>
                <form action="{{ route('yarns.destroy', $yarn) }}" method="POST" class="d-inline">
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