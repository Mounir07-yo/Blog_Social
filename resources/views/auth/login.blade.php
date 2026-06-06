@extends('layouts.app')

@section('title', 'Connexion')
@section('header', 'Connexion')
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
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        Se connecter
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

        <!-- Compte de test -->
        <div class="card mt-4 border-info">
            <div class="card-header bg-info text-white">
                <h6 class="mb-0">🧪 Compte de test</h6>
            </div>
            <div class="card-body">
                <p class="small mb-2">Utilisez ces identifiants pour tester :</p>
                <ul class="small mb-0">
                    <li><strong>Email :</strong> admin@blog.com</li>
                    <li><strong>Mot de passe :</strong> password</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection