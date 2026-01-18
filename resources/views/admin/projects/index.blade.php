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
        Image
    </th>

    <x-admin.sortable-th field="name" label="Title" />
    <x-admin.sortable-th field="category" label="Category" />
    <x-admin.sortable-th field="created_at" label="Added" />
    <x-admin.sortable-th field="updated_at" label="Last updated" />

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
          {{ $project->category->name }}
      </td>
      <td>
        {{ $project->created_at->diffForHumans() }}
      </td>
      <td>
        {{ $project->updated_at->diffForHumans() }}
      </td>
      <td class="text-end">
        <div class="d-inline-flex gap-2">
          <x-admin.edit-button label="Edit" :route="'project.edit'"/>

          <x-admin.delete-modal
            :id="'deleteProjectModal-'.$project->id"
            :action="route('projects.destroy', $project)"
            message="Sei sicuro di voler eliminare questo progetto? L'azione è irreversibile."
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