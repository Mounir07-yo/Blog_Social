@extends('layouts.app')

@section('title', 'Profil de ' . $user->name)
@section('header', $user->name)
@section('subtitle', $user->bio ?? 'Membre de la communauté')

@section('content')
<div class="row">
    <div class="col-lg-4">
        <!-- Profil utilisateur -->
        <div class="card shadow-sm">
            <div class="card-body text-center">
                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=007bff&color=fff&size=200' }}" 
                     class="rounded-circle mb-3" width="120" height="120" alt="{{ $user->name }}">
                
                <h4>{{ $user->name }}</h4>
                
                @if($user->bio)
                    <p class="text-muted">{{ $user->bio }}</p>
                @endif

                <div class="row text-center mb-4">
                    <div class="col-4">
                        <strong>{{ $user->postsCount() }}</strong><br>
                        <small class="text-muted">Articles</small>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('users.followers', $user) }}" class="text-decoration-none text-dark">
                            <strong class="followers-count">{{ $user->followersCount() }}</strong><br>
                            <small class="text-muted">Abonnés</small>
                        </a>
                    </div>
                    <div class="col-4">
                        <a href="{{ route('users.following', $user) }}" class="text-decoration-none text-dark">
                            <strong>{{ $user->followingCount() }}</strong><br>
                            <small class="text-muted">Abonnements</small>
                        </a>
                    </div>
                </div>

                @if($user->location)
                    <p class="text-muted small">
                        <i class="bi bi-geo-alt"></i> {{ $user->location }}
                    </p>
                @endif

                @if($user->website)
                    <p class="text-muted small">
                        <i class="bi bi-link-45deg"></i> 
                        <a href="{{ $user->website }}" target="_blank" class="text-decoration-none">Site web</a>
                    </p>
                @endif

                <p class="text-muted small">
                    <i class="bi bi-calendar"></i> Membre depuis {{ $user->created_at->format('M Y') }}
                </p>

                @auth
                    @if(Auth::id() !== $user->id)
                        <button class="btn btn-primary follow-btn" data-user-id="{{ $user->id }}">
                            {{ Auth::user()->isFollowing($user) ? 'Ne plus suivre' : 'Suivre' }}
                        </button>
                    @else
                        <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                            Modifier le profil
                        </a>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Suivre {{ $user->name }}
                    </a>
                @endauth
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h5>Articles de {{ $user->name }}</h5>
        </div>

        @if($posts->count() > 0)
            @foreach($posts as $post)
                <article class="card shadow-sm mb-4">
                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" class="card-img-top" style="max-height: 250px; object-fit: cover;" alt="{{ $post->title }}">
                    @endif
                    
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('posts.show', $post) }}" class="text-decoration-none text-dark">
                                {{ $post->title }}
                            </a>
                        </h5>
                        
                        <div class="post-meta mb-3">
                            <small class="text-muted">
                                <i class="bi bi-calendar"></i> {{ $post->published_at->diffForHumans() }}
                            </small>
                        </div>
                        
                        @if($post->excerpt)
                            <p class="card-text">{{ $post->excerpt }}</p>
                        @else
                            <p class="card-text">{{ Str::limit(strip_tags($post->content), 200) }}</p>
                        @endif
                        
                        <div class="d-flex justify-content-between align-items-center">
                            <a href="{{ route('posts.show', $post) }}" class="btn btn-primary btn-sm">
                                Lire la suite
                            </a>
                            
                            <div class="text-muted small">
                                <i class="bi bi-heart"></i> {{ $post->likesCount() }}
                                <i class="bi bi-chat ms-2"></i> {{ $post->commentsCount() }}
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-file-text text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">Aucun article publié</h4>
                <p class="text-muted">{{ $user->name }} n'a pas encore publié d'articles.</p>
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
                    document.querySelector('.followers-count').textContent = data.followersCount;
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});
</script>
@endpush
@endsection