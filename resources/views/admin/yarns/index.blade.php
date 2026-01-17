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

          <x-admin.delete-modal
            :id="'deleteYarnModal-'.$yarn->id"
            :action="route('yarns.destroy', $yarn)"
            message="Sei sicuro di voler eliminare questo filato? L'azione è irreversibile."
            triggerText="Elimina"
            triggerClass="btn btn-danger btn-sm"
          />
        </div>
      </td>
    </tr>
    @endforeach

</x-slot>

</x-admin.resource-table>

@endsection