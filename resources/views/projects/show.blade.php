@extends('layouts.admin')

{{-- @dd($project) --}}

@section('title', $project->name)

{{-- <x-projects.go-back-button/> --}}

@section('actions')
<div class="d-flex gap-3 my-4">
    <a href="{{ route('projects.edit', $project->slug) }}">
        <button class="btn btn-success">
            Modifica
        </button>
    </a>  
    
    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
        Elimina
    </button>
</div>


<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="exampleModalLabel">
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
        <form action="{{ route('projects.destroy', $project->slug) }}" method="POST">
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

@endsection

@section('content')
<ul>
    @if($project->image_path)
        <img class="img-fluid w-50" src="{{ asset('storage/' . $project->image_path) }}" alt="copertina">
    @endif
    <li>
        Categoria: {{ $project->category->name }}
    </li>
    <li>
        Tecniche: {{ $project->craft }}
    </li>
    <li>
        Filati: 
        @foreach ($project->projectYarns as $used_yarn)
            {{ $used_yarn->yarn->name }}, {{ $used_yarn->yarn->brand }} - 
            Quantità: {{ (int)$used_yarn->quantity }} gomitoli, {{ $used_yarn->weight }} g per {{ $used_yarn->meterage }} metri
        @endforeach
    </li>
   {{-- <li class="d-flex gap-2 mt-3">
        @foreach ($project->tags as $tag)
            <div style="
            background-color: {{ $tag->color }};"
            class="rounded-2 px-3">
                {{ $tag->name }}
            </div>
        @endforeach
    </li> --}}
</ul>
@endsection