@extends('layouts.app')

@section('title', 'Accueil')
@section('header', 'AREX - Réseau Social Professionnel')
@section('subtitle', 'Votre solution complète pour le partage de contenu et la collaboration')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h2 class="h4 text-primary mb-3">Découvrez notre plateforme</h2>
                <p class="lead">
                    Bienvenue sur AREX ! Un réseau social professionnel pour la création, 
                    le partage et la gestion de contenu avec des fonctionnalités 
                    collaboratives avancées.
                </p>
                <div class="d-flex justify-content-center gap-3 mt-4">
                    <a href="{{ route('posts.index') }}" class="btn btn-primary btn-lg">
                        <i class="fas fa-newspaper me-2"></i>Explorer les articles
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg">
                            <i class="fas fa-user-plus me-2"></i>Créer un compte
                        </a>
                    @else
                        <a href="{{ route('posts.create') }}" class="btn btn-success btn-lg">
                            <i class="fas fa-plus-circle me-2"></i>Nouveau contenu
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
                        <div class="mb-3">
                            <i class="fas fa-edit text-primary" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Édition Intuitive</h5>
                        <p class="text-muted">
                            Interface moderne et ergonomique pour créer du contenu professionnel rapidement.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-users text-success" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Collaboration Avancée</h5>
                        <p class="text-muted">
                            Outils de collaboration en temps réel avec système de notifications intégré.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-palette text-info" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Design Professionnel</h5>
                        <p class="text-muted">
                            Interface responsive et élégante adaptée à tous les appareils professionnels.
                        </p>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-shield-alt text-warning" style="font-size: 3rem;"></i>
                        </div>
                        <h5>Sécurité & Performance</h5>
                        <p class="text-muted">
                            Infrastructure sécurisée avec optimisations avancées et sauvegarde automatique.
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
                    <h5 class="mb-0">
                        <i class="fas fa-user-check me-2"></i>Bonjour {{ Auth::user()->name }}
                    </h5>
                </div>
                <div class="card-body">
                    <p>Prêt à créer du contenu professionnel ?</p>
                    <a href="{{ route('posts.create') }}" class="btn btn-success w-100">
                        <i class="fas fa-plus me-2"></i>Créer un nouveau contenu
                    </a>
                </div>
            </div>
        @else
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-rocket me-2"></i>Démarrer maintenant
                    </h5>
                </div>
                <div class="card-body">
                    <p>Rejoignez notre plateforme professionnelle dès aujourd'hui !</p>
                    <div class="d-grid gap-2">
                        <a href="{{ route('register') }}" class="btn btn-primary">
                            <i class="fas fa-user-plus me-2"></i>Créer un compte
                        </a>
                        <a href="{{ route('login') }}" class="btn btn-outline-primary">
                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
                        </a>
                    </div>
                </div>
            </div>
        @endauth

        <div class="card shadow-sm">
            <div class="card-header bg-dark text-white">
                <h5 class="mb-0">
                    <i class="fas fa-info-circle me-2"></i>À propos
                </h5>
            </div>
            <div class="card-body">
                <p class="small mb-2">AREX - Réseau Social Professionnel</p>
                <p class="small mb-0">Partagez vos idées, collaborez et développez votre réseau professionnel.</p>
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