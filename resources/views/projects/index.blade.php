@extends('layouts.admin')

@section('title', 'Dashboard')

@section('actions')

{{-- <div class="m-4">
    <a href="{{ route('projects.create') }}">
            <button class="btn btn-success">
                + New Project
            </button>
    </a>  
</div> --}}

@endsection

@section('content')

{{-- @dd($projects); --}}
{{-- @dd($projects_it); --}}

<table class="table">
  <thead>
    <tr>
      <th scope="col">
        Thumbnail
    </th>
      <th scope="col">
        Title
    </th>
      <th scope="col">
        Craft
    </th>
      <th scope="col">
        Added
    </th>
    <th scope="col">
        Last Updated
    </th>
    </tr>
  </thead>
  <tbody>
    @foreach ($projects as $project)
    <tr>
      <td>
        <a class="text-decoration-none text-black" {{-- href="{{ route('projects.show', $project) }}" --}}>
          <div class="thumbnail">
            <img src="{{ asset('storage/' . $project->image_path) }}" alt="{{ $project->name . 'Thumbnail'}}">
          </div>
        </a>
      </td>
      @foreach ($projects_it as $project)
      <td>
        <a class="text-decoration-none text-black" {{-- href="{{ route('projects.show', $project) }}" --}}>
          {{ $project->name }}
        </a>
      </td>
      <td>
            {{ $project->craft }} 
      </td>
      @endforeach
      <td>
        {{ $project->started }}
      </td>
      <td>
        {{ $project->completed }}
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
@endsection