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
    </tr>
  </thead>
  <tbody>
    @foreach ($yarns as $yarn)
    <tr>
      <td>
        <a class="text-decoration-none text-black" href="{{ route('yarns.show', $yarn->slug) }}">
          <div class="thumbnail">
            <img src="{{ asset('storage/' . $yarn->image_path) }}" alt="{{ $yarn->name . ' Thumbnail'}}">
          </div>
        </a>
      </td>
      <td>
        <a class="text-decoration-none text-black" href="{{ route('yarns.show', $yarn->slug) }}">
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
    </tr>
    @endforeach
  </tbody>
</table>
@endsection