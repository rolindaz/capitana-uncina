@extends('layouts.admin')

@section('title', 'Dashboard')

{{-- @dd($projects); --}}

@section('actions')

<div class="m-4">
    <a href="{{ route('projects.create') }}">
            <button class="btn btn-success">
                + New Project
            </button>
    </a>  
</div>

@endsection

@section('content')


<table class="table">
  <thead>
    <tr>
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
    </tr>
  </thead>
  <tbody>
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
    </tr>
    @endforeach
  </tbody>
</table>
@endsection