@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-center" style="width: 420px;">
    <div class="modal-dialog modal-dialog-centered w-100">
        <div class="modal-content precise-font">
            <div class="modal-header register-header mb-3 py-2 rounded-3 ps-2">
                <h5 class="modal-title">Registrati</h5>
            </div>

            <div class="modal-body register-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                        @error('name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Indirizzo Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password-confirm" class="form-label">Conferma Password</label>
                        <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
                    </div>
                    <div class="modal-footer">
                        <a href="{{ url('/') }}" class="btn btn-secondary me-3">Chiudi</a>
                        <button type="submit" class="btn register-btn">Registrati</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
