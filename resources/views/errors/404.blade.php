@extends('layouts.app')

@section('title', 'Page introuvable')
@section('header', '404 - Page introuvable')
@section('subtitle', 'Oups ! Cette page semble avoir disparu...')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <div class="card shadow-sm">
            <div class="card-body py-5">
                <div class="display-1 text-primary mb-4">🤔</div>
                <h2 class="h3 mb-3">Page introuvable</h2>
                <p class="text-muted mb-4">
                    La page que vous cherchez n'existe pas ou a été déplacée.
                    Pas de panique, voici quelques liens utiles !
                </p>
                
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('welcome') }}" class="btn btn-primary">
                        🏠 Accueil
                    </a>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                        📚 Tous les articles
                    </a>
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn btn-success">
                            ✏️ Écrire un article
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                            🔐 Se connecter
                        </a>
                    @endauth
                </div>
            </div>
        </div>

        <!-- Suggestions -->
        <div class="row mt-4 g-3">
            <div class="col-md-4">
                <div class="card h-100 border-0 bg-light">
                    <div class="card-body text-center">
                        <div class="h4 text-info">📖</div>
                        <h6>Lire le blog</h6>
                        <p class="small text-muted">Découvrez nos derniers articles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 bg-light">
                    <div class="card-body text-center">
                        <div class="h4 text-success">✍️</div>
                        <h6>Écrire</h6>
                        <p class="small text-muted">Partagez vos idées avec nous</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 bg-light">
                    <div class="card-body text-center">
                        <div class="h4 text-warning">🤝</div>
                        <h6>Rejoindre</h6>
                        <p class="small text-muted">Devenez membre de notre communauté</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Redirection automatique après 10 secondes (optionnel)
let countdown = 10;
const redirectBtn = document.createElement('div');
redirectBtn.className = 'alert alert-info mt-4';
redirectBtn.innerHTML = '<small>Redirection automatique vers l\'accueil dans <span id="countdown">10</span> secondes...</small>';

// Décommenter pour activer la redirection automatique
/*
document.querySelector('.col-md-8').appendChild(redirectBtn);
const interval = setInterval(() => {
    countdown--;
    document.getElementById('countdown').textContent = countdown;
    if (countdown === 0) {
        window.location.href = "{{ route('welcome') }}";
    }
}, 1000);
*/
</script>
@endpush