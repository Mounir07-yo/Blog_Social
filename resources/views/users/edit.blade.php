@extends('layouts.app')

@section('title', 'Modifier mon profil')
@section('header', 'Modifier mon profil')
@section('subtitle', 'Personnalisez votre présence sur la plateforme')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow">
            <div class="card-body">
                <form method="POST" action="{{ route('profile.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row mb-4">
                        <div class="col-md-4 text-center">
                            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=007bff&color=fff&size=150' }}" 
                                 class="rounded-circle mb-3" width="150" height="150" alt="{{ $user->name }}" id="avatar-preview">
                            <h5>{{ $user->name }}</h5>
                        </div>
                        <div class="col-md-8">
                            <div class="mb-3">
                                <label for="name" class="form-label">Nom complet *</label>
                                <input type="text" 
                                       class="form-control @error('name') is-invalid @enderror" 
                                       id="name" 
                                       name="name" 
                                       value="{{ old('name', $user->name) }}" 
                                       required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email *</label>
                                <input type="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       id="email" 
                                       name="email" 
                                       value="{{ old('email', $user->email) }}" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="avatar" class="form-label">URL de l'avatar</label>
                                <input type="url" 
                                       class="form-control @error('avatar') is-invalid @enderror" 
                                       id="avatar" 
                                       name="avatar" 
                                       value="{{ old('avatar', $user->avatar) }}" 
                                       placeholder="https://exemple.com/mon-avatar.jpg">
                                <div class="form-text">Laissez vide pour utiliser l'avatar automatique</div>
                                @error('avatar')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="bio" class="form-label">Biographie</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" 
                                  name="bio" 
                                  rows="4" 
                                  placeholder="Parlez-nous de vous...">{{ old('bio', $user->bio) }}</textarea>
                        <div class="form-text">Maximum 500 caractères</div>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="location" class="form-label">Localisation</label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location', $user->location) }}" 
                                       placeholder="Paris, France">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="website" class="form-label">Site web</label>
                                <input type="url" 
                                       class="form-control @error('website') is-invalid @enderror" 
                                       id="website" 
                                       name="website" 
                                       value="{{ old('website', $user->website) }}" 
                                       placeholder="https://monsite.com">
                                @error('website')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input" 
                                   type="checkbox" 
                                   id="is_private" 
                                   name="is_private" 
                                   value="1" 
                                   {{ old('is_private', $user->is_private) ? 'checked' : '' }}>
                            <label class="form-check-label" for="is_private">
                                Profil privé
                            </label>
                        </div>
                        <div class="form-text">
                            Si activé, seuls vos abonnés pourront voir vos articles.
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('users.show', $user) }}" class="btn btn-outline-secondary">
                            Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-check-circle"></i> Sauvegarder les modifications
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Statistiques -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-info text-white">
                <h5 class="mb-0">Vos statistiques</h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-4">
                        <strong>{{ $user->postsCount() }}</strong><br>
                        <small class="text-muted">Articles</small>
                    </div>
                    <div class="col-4">
                        <strong>{{ $user->followersCount() }}</strong><br>
                        <small class="text-muted">Abonnés</small>
                    </div>
                    <div class="col-4">
                        <strong>{{ $user->followingCount() }}</strong><br>
                        <small class="text-muted">Abonnements</small>
                    </div>
                </div>
            </div>
        </div>

        <div class="card shadow-sm mt-4">
            <div class="card-header bg-warning">
                <h5 class="mb-0">
                    <i class="fas fa-lightbulb me-2"></i>Conseils
                </h5>
            </div>
            <div class="card-body">
                <ul class="small mb-0">
                    <li>Une bio professionnelle renforce votre crédibilité</li>
                    <li>Ajoutez votre localisation pour le networking professionnel</li>
                    <li>Un avatar de qualité améliore votre image de marque</li>
                    <li>Partagez votre site web ou portfolio professionnel</li>
                </ul>
            </div>
        </div>

        <!-- Zone dangereuse -->
        <div class="card shadow-sm mt-4 border-danger">
            <div class="card-header bg-danger text-white">
                <h5 class="mb-0">
                    <i class="fas fa-exclamation-triangle me-2"></i>Zone dangereuse
                </h5>
            </div>
            <div class="card-body">
                <h6>Supprimer mon compte</h6>
                <p class="text-muted small mb-3">
                    Cette action est irréversible. Toutes vos données, articles et commentaires seront définitivement supprimés.
                </p>
                <button type="button" class="btn btn-danger" onclick="confirmDeleteAccount()">
                    <i class="fas fa-trash me-2"></i>Supprimer définitivement mon compte
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.delete') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Attention !</strong> Cette action est irréversible.
                    </div>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="delete_password" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirmation" class="form-label">Tapez "DELETE" pour confirmer</label>
                        <input type="text" class="form-control" id="confirmation" name="confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Prévisualisation de l'avatar
    const avatarInput = document.getElementById('avatar');
    const avatarPreview = document.getElementById('avatar-preview');
    const nameInput = document.getElementById('name');
    
    function updateAvatarPreview() {
        const avatarUrl = avatarInput.value;
        const userName = nameInput.value || '{{ $user->name }}';
        
        if (avatarUrl) {
            avatarPreview.src = avatarUrl;
        } else {
            avatarPreview.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(userName)}&background=007bff&color=fff&size=150`;
        }
    }
    
    avatarInput.addEventListener('input', updateAvatarPreview);
    nameInput.addEventListener('input', updateAvatarPreview);
    
    // Compteur de caractères pour la bio
    const bioTextarea = document.getElementById('bio');
    const maxLength = 500;
    
    function updateCharCount() {
        const currentLength = bioTextarea.value.length;
        const remaining = maxLength - currentLength;
        
        let countText = bioTextarea.parentElement.querySelector('.char-count');
        if (!countText) {
            countText = document.createElement('div');
            countText.className = 'char-count form-text';
            bioTextarea.parentElement.appendChild(countText);
        }
        
        countText.textContent = `${currentLength}/${maxLength} caractères`;
        countText.className = remaining < 50 ? 'char-count form-text text-warning' : 'char-count form-text';
        
        if (remaining < 0) {
            countText.className = 'char-count form-text text-danger';
        }
    }
    
    bioTextarea.addEventListener('input', updateCharCount);
    updateCharCount(); // Initial call
});
</script>
@endpush

<!-- Modal de confirmation de suppression -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Confirmer la suppression</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="{{ route('profile.delete') }}">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <div class="alert alert-danger">
                        <strong>Attention !</strong> Cette action est irréversible.
                    </div>
                    
                    <div class="mb-3">
                        <label for="delete_password" class="form-label">Mot de passe actuel</label>
                        <input type="password" class="form-control" id="delete_password" name="password" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirmation" class="form-label">Tapez "DELETE" pour confirmer</label>
                        <input type="text" class="form-control" id="confirmation" name="confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                    <button type="submit" class="btn btn-danger">Supprimer définitivement</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmDeleteAccount() {
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteAccountModal'));
    deleteModal.show();
}
</script>
@endpush
@endsection