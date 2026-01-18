@extends('layouts.admin')

@section('content')
<div class="container">
    <h2 style="font-family: 'Permanent Marker'; font-size: 60px; color: #031963;">
        {{ __('Dashboard') }}
    </h2>

    <!-- Logged in alert -->
    <div class="alert alert-success" role="alert">
        {{ __("Hai effettuato l'accesso!") }}
    </div>

    <!-- Logout button -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="mb-4">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>

    <!-- Report of last updates -->
    <div class="w-75">
        <h3 style="font-family: 'Permanent Marker'; font-size: 40px; color: #031963;">
            {{ __('Ultimi aggiornamenti') }}
        </h3>
        <ul class="list-group">
            @forelse ($recentUpdates as $update)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <span>{{ $update->description }}</span>
                    <small class="text-muted">{{ $update->created_at->diffForHumans() }}</small>
                </li>
            @empty
                <li class="list-group-item text-muted">{{ __('Nessun aggiornamento recente.') }}</li>
            @endforelse
        </ul>
    </div>
</div>
@endsection
