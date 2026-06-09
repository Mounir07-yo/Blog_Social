@extends('layouts.app')

@section('title', 'Mot de passe oublié')
@section('header', 'Mot de passe oublié')
@section('subtitle', 'Récupérez l\'accès à votre compte')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-6 col-lg-4">
        <div class="card shadow">
            <div class="card-body">
                @if(session('status'))
                    <div class="alert alert-success">
                        <i class="fas fa-check-circle me-2"></i>{{ session('status') }}
                    </div>
                @endif

                @if(session('dev_message') && session('dev_link'))
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle me-2"></i>{{ session('dev_message') }}
                        <br><br>
                        <div class="d-grid">
                            <a href="{{ session('dev_link') }}" class="btn btn-info btn-sm">
                                <i class="fas fa-link me-1"></i>Utiliser le lien de réinitialisation
                            </a>
                        </div>
                        <br>
                        <small class="text-muted">
                            Ou copiez ce lien : <br>
                            <code style="word-break: break-all;">{{ session('dev_link') }}</code>
                        </small>
                    </div>
                @endif

                <div class="text-center mb-4">
                    <i class="fas fa-key text-primary" style="font-size: 3rem;"></i>
                    <p class="text-muted mt-3">
                        Saisissez votre adresse email pour recevoir un lien de réinitialisation sécurisé.
                    </p>
                </div>

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse email</label>
                        <input type="email" 
                               class="form-control @error('email') is-invalid @enderror" 
                               id="email" 
                               name="email" 
                               value="{{ old('email') }}" 
                               required 
                               autofocus
                               placeholder="votre.email@exemple.com">
                        @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="fas fa-paper-plane me-2"></i>Envoyer le lien par email
                    </button>
                </form>

                <hr>

                <div class="text-center">
                    <p class="mb-2">
                        <a href="{{ route('login') }}" class="text-decoration-none">
                            <i class="fas fa-arrow-left me-1"></i>Retour à la connexion
                        </a>
                    </p>
                    <p class="mb-0">
                        Pas encore de compte ? 
                        <a href="{{ route('register') }}" class="text-decoration-none">
                            Inscrivez-vous ici
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Informations de sécurité -->
        <div class="card mt-3">
            <div class="card-body">
                <h6 class="card-title">
                    <i class="fas fa-shield-alt text-success me-2"></i>Sécurité
                </h6>
                <ul class="small mb-0">
                    <li>Le lien de réinitialisation sera valide pendant 1 heure seulement</li>
                    <li>Il ne pourra être utilisé qu'une seule fois</li>
                    <li>Vérifiez votre boîte de réception et vos spams</li>
                    <li>N'partagez jamais ce lien avec personne</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection