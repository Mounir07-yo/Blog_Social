@extends('layouts.app')

@section('title', 'Modifier l\'article')
@section('header', 'Modifier l\'article')
@section('subtitle', $post->title)

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="{{ route('posts.update', $post) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label for="title" class="form-label">Titre de l'article *</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title', $post->title) }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Résumé (optionnel)</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror" 
                                  id="excerpt" 
                                  name="excerpt" 
                                  rows="2" 
                                  placeholder="Un court résumé de votre article...">{{ old('excerpt', $post->excerpt) }}</textarea>
                        <div class="form-text">Ce résumé apparaîtra sur la page d'accueil.</div>
                        @error('excerpt')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="featured_image" class="form-label">Image de couverture (optionnel)</label>
                        <input type="url" 
                               class="form-control @error('featured_image') is-invalid @enderror" 
                               id="featured_image" 
                               name="featured_image" 
                               value="{{ old('featured_image', $post->featured_image) }}" 
                               placeholder="https://exemple.com/image.jpg">
                        <div class="form-text">URL d'une image pour illustrer votre article.</div>
                        @error('featured_image')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label">Contenu de l'article *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="15" 
                                  placeholder="Écrivez votre article ici..." 
                                  required>{{ old('content', $post->content) }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1" 
                                   {{ old('is_published', $post->is_published) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_published">
                                Article publié
                            </label>
                        </div>
                        <div class="form-text">
                            @if($post->published_at)
                                Publié le {{ $post->published_at->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}
                            @else
                                Si vous cochez cette case, l'article sera publié maintenant.
                            @endif
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-outline-secondary">
                                Annuler
                            </a>
                        </div>
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-check-circle"></i> Mettre à jour
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Aperçu</h5>
            </div>
            <div class="card-body">
                <h6 id="preview-title">{{ $post->title }}</h6>
                <p id="preview-excerpt" class="small text-muted">
                    {{ $post->excerpt ?: 'Aucun résumé' }}
                </p>
                <small class="text-muted">
                    <i class="bi bi-person"></i> {{ $post->user->name }}<br>
                    <i class="bi bi-calendar"></i> {{ $post->updated_at->setTimezone('Europe/Paris')->format('d/m/Y') }}
                </small>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-warning">
                <h6 class="mb-0">
                    <i class="fas fa-chart-bar me-2"></i>Statistiques
                </h6>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>Créé : {{ $post->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</li>
                    <li>Modifié : {{ $post->updated_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</li>
                    <li>Statut : {{ $post->is_published ? 'Publié' : 'Brouillon' }}</li>
                    <li>Slug : <code>{{ $post->slug }}</code></li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Aperçu en temps réel
    document.addEventListener('DOMContentLoaded', function() {
        const titleInput = document.getElementById('title');
        const excerptInput = document.getElementById('excerpt');
        const previewTitle = document.getElementById('preview-title');
        const previewExcerpt = document.getElementById('preview-excerpt');

        titleInput.addEventListener('input', function() {
            previewTitle.textContent = this.value || 'Titre de votre article';
        });

        excerptInput.addEventListener('input', function() {
            previewExcerpt.textContent = this.value || 'Aucun résumé';
        });

        // Auto-resize textarea
        const textarea = document.getElementById('content');
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    });
</script>
@endpush