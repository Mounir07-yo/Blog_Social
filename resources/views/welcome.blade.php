@extends('layouts.app')

@section('title', 'Accueil')
@section('header', '🚀 Bienvenue sur Mon Blog')
@section('subtitle', 'Votre plateforme de partage d\'idées et de connaissances')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h2 class="h4 text-primary mb-3">Découvrez notre blog</h2>
                <p class="lead">
                    Bienvenue sur notre plateforme de blog ! Ici, vous pouvez découvrir des articles 
                    passionnants, partager vos idées et rejoindre une communauté dynamique.
                </p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('posts.index') }}" class="btn btn-primary btn-lg">
                        📚 Voir les articles
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                            ✏️ Rejoignez-nous
                        </a>
                    @else
                        <a href="{{ route('posts.create') }}" class="btn btn-success btn-lg">
                            ✏️ Écrire un article
                        </a>
                    @endguest
                </div>
            </div>
        </div>

        <!-- Fonctionnalités -->
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3">📝</div>
                        <h5>Écrivez facilement</h5>
                        <p class="text-muted">
                            Interface simple et intuitive pour rédiger vos articles en quelques clics.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3">👥</div>
                        <h5>Communauté active</h5>
                        <p class="text-muted">
                            Rejoignez une communauté de passionnés et partagez vos connaissances.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3">🎨</div>
                        <h5>Design moderne</h5>
                        <p class="text-muted">
                            Interface élégante et responsive qui s'adapte à tous vos appareils.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="display-4 mb-3">⚡</div>
                        <h5>Rapide et sécurisé</h5>
                        <p class="text-muted">
                            Plateforme optimisée construite avec les dernières technologies web.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        @auth
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">👋 Bonjour {{ Auth::user()->name }} !</h5>
                </div>
                <div class="card-body">
                    <p>Prêt à partager vos idées ?</p>
                    <a href="{{ route('posts.create') }}" class="btn btn-success w-100">
                        Écrire un nouvel article
                    </a>
                </div>
            </div>
        @else
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">🚀 Commencez maintenant</h5>
                </div>
                <div class="card-body">
                    <p>Créez votre compte pour commencer à publier vos articles !</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            Créer un compte
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            Se connecter
                        </a>
                    </div>
                </div>
            </div>
        @endauth

        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">🧪 Test rapide</h5>
            </div>
            <div class="card-body">
                <p class="small">Pour tester immédiatement :</p>
                <ul class="small mb-2">
                    <li><strong>Email :</strong> admin@blog.com</li>
                    <li><strong>Mot de passe :</strong> password</li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-info btn-sm w-100">
                    Connexion test
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Animation simple pour les cartes de fonctionnalités
    const cards = document.querySelectorAll('.card');
    cards.forEach((card, index) => {
        setTimeout(() => {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
});
</script>
@endpush

<style>
.card {
    opacity: 0;
    transform: translateY(20px);
    transition: all 0.3s ease;
}
</style>
@endsection