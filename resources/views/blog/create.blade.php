@extends('layouts.app')

@section('title', 'Créer un article')
@section('header', 'Créer un nouvel article')
@section('subtitle', 'Partagez vos idées avec le monde')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="{{ route('posts.store') }}" id="post-form">
                    @csrf

                    <!-- Type de publication -->
                    <div class="mb-4">
                        <label class="form-label">Type de publication</label>
                        <div class="btn-group w-100" role="group">
                            <input type="radio" class="btn-check" name="post_type" id="article" value="article" checked>
                            <label class="btn btn-outline-primary" for="article">
                                <i class="bi bi-file-text"></i> Article
                            </label>

                            <input type="radio" class="btn-check" name="post_type" id="photo" value="photo">
                            <label class="btn btn-outline-primary" for="photo">
                                <i class="bi bi-image"></i> Photo
                            </label>

                            <input type="radio" class="btn-check" name="post_type" id="status" value="status">
                            <label class="btn btn-outline-primary" for="status">
                                <i class="bi bi-chat-quote"></i> Statut
                            </label>
                        </div>
                    </div>

                    <div class="mb-3" id="title-field">
                        <label for="title" class="form-label">Titre *</label>
                        <input type="text" 
                               class="form-control @error('title') is-invalid @enderror" 
                               id="title" 
                               name="title" 
                               value="{{ old('title') }}" 
                               required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Zone d'upload d'images -->
                    <div class="mb-3">
                        <label class="form-label">Images</label>
                        <div class="card border-dashed" style="border: 2px dashed #dee2e6;">
                            <div class="card-body text-center" id="upload-zone">
                                <i class="bi bi-cloud-upload text-muted" style="font-size: 3rem;"></i>
                                <p class="text-muted mt-2">Cliquez ou faites glisser vos images ici</p>
                                <input type="file" id="image-input" multiple accept="image/*" style="display: none;">
                                <button type="button" class="btn btn-outline-primary" id="select-images-btn">
                                    Sélectionner des images
                                </button>
                            </div>
                        </div>
                        
                        <!-- Aperçu des images -->
                        <div id="images-preview" class="row mt-3" style="display: none;"></div>
                        
                        <!-- Images cachées pour le formulaire -->
                        <div id="hidden-images"></div>
                    </div>

                    <div class="mb-4">
                        <label for="content" class="form-label">Contenu *</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" 
                                  id="content" 
                                  name="content" 
                                  rows="8" 
                                  placeholder="Écrivez ici..." 
                                  required>{{ old('content') }}</textarea>
                        @error('content')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_published" 
                                   name="is_published" 
                                   value="1" 
                                   checked>
                            <label class="form-check-label" for="is_published">
                                Publier immédiatement
                            </label>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('posts.index') }}" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Publier
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('image-input');
    const selectBtn = document.getElementById('select-images-btn');
    const uploadZone = document.getElementById('upload-zone');
    const previewContainer = document.getElementById('images-preview');
    const hiddenImagesContainer = document.getElementById('hidden-images');
    let uploadedImages = [];

    selectBtn.addEventListener('click', () => imageInput.click());
    
    uploadZone.addEventListener('dragover', function(e) {
        e.preventDefault();
        this.classList.add('border-primary');
    });

    uploadZone.addEventListener('drop', function(e) {
        e.preventDefault();
        this.classList.remove('border-primary');
        const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
        if (files.length > 0) handleImageUpload(files);
    });

    imageInput.addEventListener('change', function() {
        const files = Array.from(this.files);
        if (files.length > 0) handleImageUpload(files);
    });

    function handleImageUpload(files) {
        const formData = new FormData();
        files.forEach(file => formData.append('images[]', file));

        fetch('/upload/images', {
            method: 'POST',
            headers: { 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                uploadedImages.push(...data.images);
                updateImagePreview();
                updateHiddenImages();
            }
        });
    }

    function updateImagePreview() {
        if (uploadedImages.length === 0) return;
        
        previewContainer.style.display = 'block';
        previewContainer.innerHTML = uploadedImages.map((image, index) => `
            <div class="col-md-4 mb-3">
                <div class="card">
                    <img src="${image.url}" class="card-img-top" style="height: 150px; object-fit: cover;">
                    <div class="card-body p-2">
                        <button type="button" class="btn btn-danger btn-sm w-100" onclick="removeImage(${index})">
                            Supprimer
                        </button>
                    </div>
                </div>
            </div>
        `).join('');
    }

    function updateHiddenImages() {
        hiddenImagesContainer.innerHTML = uploadedImages.map(image => 
            `<input type="hidden" name="images[]" value="${image.url}">`
        ).join('');
    }

    window.removeImage = function(index) {
        uploadedImages.splice(index, 1);
        updateImagePreview();
        updateHiddenImages();
    };
});
</script>
@endpush
@endsection