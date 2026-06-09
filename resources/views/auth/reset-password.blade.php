@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')
@section('header', 'Nouveau mot de passe')
@section('subtitle', 'Choisissez votre nouveau mot de passe')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <div class="text-center mb-4">
                    <i class="fas fa-lock text-primary" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">
                        Saisissez votre nouveau mot de passe pour <strong>{{ request('email') ?? session('email') }}</strong>
                    </p>
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">
                    <input type="hidden" name="email" value="{{ request('email') ?? session('email') }}">

                    <div class="mb-3">
                        <label for="password" class="form-label">Nouveau mot de passe</label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required 
                               autofocus
                               minlength="8"
                               placeholder="Minimum 8 caractères">
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                        <div class="form-text">
                            Le mot de passe doit contenir au moins 8 caractères.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">Confirmer le mot de passe</label>
                        <input type="password" 
                               class="form-control @error('password_confirmation') is-invalid @enderror" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               minlength="8"
                               placeholder="Confirmez votre mot de passe">
                        @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    @error('token')
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>{{ $message }}
                        </div>
                    @enderror

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-save me-2"></i>Réinitialiser le mot de passe
                    </button>
                </form>

                <hr>

                <div class="text-center">
                    <p class="mb-0">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>Retour à la connexion
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="fas fa-info-circle text-info me-2"></i>Conseils de sécurité
                </h6>
                <ul class="small mb-0">
                    <li>Utilisez un mot de passe unique pour ce compte</li>
                    <li>Mélangez lettres, chiffres et caractères spéciaux</li>
                    <li>Évitez les informations personnelles facilement devinables</li>
                    <li>Considérez l'utilisation d'un gestionnaire de mots de passe</li>
                </ul>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirm = document.getElementById('password_confirmation');
    
    function validatePasswords() {
        if (password.value && passwordConfirm.value) {
            if (password.value === passwordConfirm.value) {
                passwordConfirm.setCustomValidity('');
                passwordConfirm.classList.remove('is-invalid');
                passwordConfirm.classList.add('is-valid');
            } else {
                passwordConfirm.setCustomValidity('Les mots de passe ne correspondent pas');
                passwordConfirm.classList.remove('is-valid');
                passwordConfirm.classList.add('is-invalid');
            }
        }
    }
    
    password.addEventListener('input', validatePasswords);
    passwordConfirm.addEventListener('input', validatePasswords);
});
</script>
@endpush
@endsection