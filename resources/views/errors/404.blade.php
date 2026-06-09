@extends('layouts.app')

@section('title', 'Page introuvable')
@section('header', '404 - Page introuvable')
@section('subtitle', 'Cette page semble être indisponible')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 text-center">
        <div class="card shadow-sm">
            <div class="card-body py-5">
                <div class="mb-4">
                    <i class="fas fa-exclamation-circle text-primary" style="font-size: 6rem;"></i>
                </div>
                <h2 class="h3 mb-3">Page introuvable</h2>
                <p class="text-muted mb-4">
                    La ressource demandée n'existe pas ou a été déplacée.
                    Utilisez les liens ci-dessous pour continuer votre navigation.
                </p>
                
                <div class="d-flex justify-content-center gap-3 flex-wrap">
                    <a href="{{ route('welcome') }}" class="btn btn-primary">
                        <i class="fas fa-home me-2"></i>Accueil
                    </a>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-newspaper me-2"></i>Tous les articles
                    </a>
                    @auth
                        <a href="{{ route('posts.create') }}" class="btn btn-success">
                            <i class="fas fa-plus me-2"></i>Nouveau contenu
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-sign-in-alt me-2"></i>Se connecter
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
                        <div class="mb-3">
                            <i class="fas fa-book-open text-info" style="font-size: 2rem;"></i>
                        </div>
                        <h6>Explorer le contenu</h6>
                        <p class="small text-muted">Découvrez notre bibliothèque de contenus</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 bg-light">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-edit text-success" style="font-size: 2rem;"></i>
                        </div>
                        <h6>Créer du contenu</h6>
                        <p class="small text-muted">Partagez vos connaissances professionnelles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 border-0 bg-light">
                    <div class="card-body text-center">
                        <div class="mb-3">
                            <i class="fas fa-users text-warning" style="font-size: 2rem;"></i>
                        </div>
                        <h6>Rejoindre la communauté</h6>
                        <p class="small text-muted">Connectez-vous avec d'autres professionnels</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection