@extends('layouts.app')

@section('title', 'Connexion')
@section('header', 'Connexion à AREX')
@section('subtitle', 'Accédez à votre compte')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus>
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="remember" name="remember">
                        <label class="form-check-label" for="remember">
                            Se souvenir de moi
                        </label>
                        <div class="form-text">
                            Cochez cette case pour rester connecté même après avoir fermé votre navigateur (2 semaines maximum).
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <div></div>
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-muted small">
                            Mot de passe oublié ?
                        </a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                    </button>
                </form>

                <hr>

                <p class="text-center mb-0">
                    Pas encore de compte ? 
                    <a href="{{ route('register') }}" class="text-decoration-none">
                        Inscrivez-vous ici
                    </a>
                </p>
            </div>
        </div>
    </div>
</div>
@endsection