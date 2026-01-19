@extends('layouts.app')

@section('content')
<div class="auth-modal-shell w-100 d-flex justify-content-center">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content precise-font">
            <div class="modal-header login-header mb-3 py-2 rounded-3 ps-2">
                <h5 class="modal-title">Accedi</h5>
            </div>

            <div class="modal-body login-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Indirizzo Email</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                        @error('password')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <label class="form-check-label" for="remember">Ricordami</label>
                    </div>
                    <div class="modal-footer">
                        <a href="{{ url('/') }}" class="btn btn-secondary me-3">Chiudi</a>
                        <button type="submit" class="btn login-btn">Accedi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
