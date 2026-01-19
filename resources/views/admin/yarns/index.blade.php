@extends('layouts.admin')

@section('title', 'Dashboard')

{{-- @dd($yarns); --}}

@section('content')

<x-admin.resource-table
title="Filati"
:createRoute="route('yarns.create')"
action="+ Nuovo Filato"
>

<x-slot name="head">

  <th scope="col">
        Image
      </th>

      <x-admin.sortable-th field="name" label="Name" />
      <x-admin.sortable-th field="brand" label="Brand" />
      <x-admin.sortable-th field="created_at" label="Added" />
      <x-admin.sortable-th field="updated_at" label="Last updated" />

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
        {{ $yarn->created_at->diffForHumans() }}
      </td>
      <td>
        {{ $yarn->updated_at->diffForHumans() }}
      </td>
      <td>
        <div class="d-inline-flex gap-2">
          <x-admin.edit-button route="yarns.edit" :model="$yarn" />

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