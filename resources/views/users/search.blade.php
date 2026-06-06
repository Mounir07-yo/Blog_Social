@extends('layouts.app')

@section('title', 'Découvrir des utilisateurs')
@section('header', 'Découvrir')
@section('subtitle', 'Trouvez et suivez d\'autres membres de la communauté')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <!-- Barre de recherche -->
        <div class="card shadow-sm mb-4">
            <div class="card-body">
                <form method="GET" action="{{ route('users.search') }}">
                    <div class="input-group">
                        <input type="text" class="form-control form-control-lg" name="q" 
                               value="{{ $query }}" placeholder="Rechercher des utilisateurs par nom ou email...">
                        <button class="btn btn-primary" type="submit">
                            <i class="bi bi-search"></i> Rechercher
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if($query)
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h5>Résultats pour "{{ $query }}"</h5>
                <span class="badge bg-secondary">{{ $users->count() }} résultat(s)</span>
            </div>
        @endif

        @if($users->count() > 0)
            <div class="row">
                @foreach($users as $user)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body text-center">
                                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=007bff&color=fff&size=80' }}" 
                                     class="rounded-circle mb-3" width="80" height="80" alt="{{ $user->name }}">
                                
                                <h6>
                                    <a href="{{ route('users.show', $user) }}" class="text-decoration-none text-dark">
                                        {{ $user->name }}
                                    </a>
                                </h6>
                                
                                @if($user->bio)
                                    <p class="text-muted small">{{ Str::limit($user->bio, 80) }}</p>
                                @endif

                                @if($user->location)
                                    <p class="text-muted small">
                                        <i class="bi bi-geo-alt"></i> {{ $user->location }}
                                    </p>
                                @endif

                                <div class="row text-center mb-3">
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

                                @auth
                                    @if(Auth::id() !== $user->id)
                                        <button class="btn btn-primary btn-sm follow-btn" data-user-id="{{ $user->id }}">
                                            {{ Auth::user()->isFollowing($user) ? 'Ne plus suivre' : 'Suivre' }}
                                        </button>
                                    @else
                                        <span class="badge bg-success">C'est vous !</span>
                                    @endif
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-primary btn-sm">
                                        Suivre
                                    </a>
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @elseif($query)
            <div class="text-center py-5">
                <i class="bi bi-search text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">Aucun résultat trouvé</h4>
                <p class="text-muted">Aucun utilisateur ne correspond à votre recherche "{{ $query }}".</p>
            </div>
        @else
            <!-- Suggestions d'utilisateurs -->
            <div class="text-center py-5">
                <i class="bi bi-people text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">Découvrez la communauté</h4>
                <p class="text-muted">Utilisez la barre de recherche ci-dessus pour trouver des utilisateurs.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion du suivi d'utilisateur
    document.querySelectorAll('.follow-btn').forEach(button => {
        button.addEventListener('click', function() {
            const userId = this.dataset.userId;
            
            fetch(`/users/${userId}/follow`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.textContent = data.isFollowing ? 'Ne plus suivre' : 'Suivre';
                    this.className = data.isFollowing ? 
                        'btn btn-outline-primary btn-sm follow-btn' : 
                        'btn btn-primary btn-sm follow-btn';
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});
</script>
@endpush
@endsection