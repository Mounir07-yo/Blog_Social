@extends('layouts.app')

@section('title', 'Accueil')
@section('header', 'Bienvenue sur Mon Blog')
@section('subtitle', 'Découvrez nos derniers articles')

@section('content')
<div class="row">
    <div class="col-lg-8">
        @if($posts->count() > 0)
            @foreach($posts as $post)
                <article class="card post-card shadow-sm mb-4">
                    <!-- Header de l'article avec profil utilisateur -->
                    <div class="card-header border-0 bg-white">
                        <div class="d-flex align-items-center">
                            <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=007bff&color=fff' }}" 
                                 class="rounded-circle me-3" width="40" height="40" alt="{{ $post->user->name }}">
                            <div class="flex-grow-1">
                                <h6 class="mb-0">
                                    <a href="{{ route('users.show', $post->user) }}" class="text-decoration-none text-dark fw-bold">
                                        {{ $post->user->name }}
                                    </a>
                                </h6>
                                <small class="text-muted">{{ $post->published_at->setTimezone('Europe/Paris')->diffForHumans() }}</small>
                            </div>
                            @auth
                                @if(Auth::id() === $post->user_id)
                                    <div class="dropdown">
                                        <button class="btn btn-sm btn-outline-secondary" data-bs-toggle="dropdown">
                                            <i class="bi bi-three-dots"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li><a class="dropdown-item" href="{{ route('posts.edit', $post) }}">Modifier</a></li>
                                            <li>
                                                <form method="POST" action="{{ route('posts.destroy', $post) }}">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger" 
                                                            onclick="return confirm('Supprimer cet article ?')">
                                                        Supprimer
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>

                    @if($post->featured_image)
                        <img src="{{ $post->featured_image }}" class="card-img-top" style="max-height: 400px; object-fit: cover;" alt="{{ $post->title }}">
                    @elseif($post->images && count($post->images) > 0)
                        @if(count($post->images) == 1)
                            <img src="{{ $post->images[0] }}" class="card-img-top" style="max-height: 400px; object-fit: cover;" alt="{{ $post->title }}">
                        @else
                            <div id="carousel-list-{{ $post->id }}" class="carousel slide" data-bs-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach(array_slice($post->images, 0, 3) as $index => $image)
                                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                            <img src="{{ $image }}" class="d-block w-100" style="max-height: 400px; object-fit: cover;" alt="Image {{ $index + 1 }}">
                                            @if(count($post->images) > 3 && $index === 2)
                                                <div class="carousel-caption d-flex justify-content-center align-items-center" 
                                                     style="background: rgba(0,0,0,0.6); inset: 0; position: absolute;">
                                                    <span class="text-white h4">+{{ count($post->images) - 3 }} photos</span>
                                                </div>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                                @if(count($post->images) > 1)
                                    <button class="carousel-control-prev" type="button" data-bs-target="#carousel-list-{{ $post->id }}" data-bs-slide="prev">
                                        <span class="carousel-control-prev-icon"></span>
                                    </button>
                                    <button class="carousel-control-next" type="button" data-bs-target="#carousel-list-{{ $post->id }}" data-bs-slide="next">
                                        <span class="carousel-control-next-icon"></span>
                                    </button>
                                @endif
                            </div>
                        @endif
                    @endif
                    
                    <div class="card-body">
                        <h2 class="card-title h5">{{ $post->title }}</h2>
                        
                        @if($post->excerpt)
                            <p class="card-text">{{ $post->excerpt }}</p>
                        @else
                            <p class="card-text">{{ Str::limit(strip_tags($post->content), 200) }}</p>
                        @endif
                        
                        <a href="{{ route('posts.show', $post) }}" class="btn btn-link p-0 text-decoration-none">
                            Lire la suite...
                        </a>
                    </div>

                    <!-- Actions sociales -->
                    <div class="card-footer border-0 bg-white pt-0">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <div class="d-flex gap-3">
                                @auth
                                    <button class="btn btn-link p-0 like-btn" data-type="post" data-id="{{ $post->slug }}">
                                        <i class="bi bi-heart{{ $post->isLikedBy(Auth::user()) ? '-fill text-danger' : '' }}"></i>
                                        <span class="likes-count">{{ $post->likesCount() }}</span>
                                    </button>
                                    
                                    @if($post->user_id !== Auth::id())
                                    <button class="btn btn-link p-0 text-warning" onclick="reportContent('post', {{ $post->id }})" title="Signaler">
                                        <i class="bi bi-flag"></i>
                                    </button>
                                    @endif
                                @else
                                    <span class="text-muted">
                                        <i class="bi bi-heart"></i> {{ $post->likesCount() }}
                                    </span>
                                @endauth

                                <a href="{{ route('posts.show', $post) }}" class="btn btn-link p-0 text-decoration-none">
                                    <i class="bi bi-chat"></i> {{ $post->commentsCount() }}
                                </a>
                            </div>
                        </div>

                        @if($post->likesCount() > 0)
                            <small class="text-muted">
                                {{ $post->likesCount() }} {{ $post->likesCount() > 1 ? 'j\'aime' : 'j\'aime' }}
                            </small>
                        @endif
                    </div>
                </article>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $posts->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <h3 class="text-muted">Aucun article publié pour le moment</h3>
                <p class="text-muted">Revenez bientôt pour découvrir du nouveau contenu !</p>
                @auth
                    <a href="{{ route('posts.create') }}" class="btn btn-primary">
                        Écrire le premier article
                    </a>
                @endauth
            </div>
        @endif
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        @auth
            <!-- Profil rapide -->
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=007bff&color=fff' }}" 
                         class="rounded-circle mb-3" width="80" height="80" alt="{{ Auth::user()->name }}">
                    <h5>{{ Auth::user()->name }}</h5>
                    @if(Auth::user()->bio)
                        <p class="text-muted small">{{ Auth::user()->bio }}</p>
                    @endif
                    <div class="row text-center">
                        <div class="col-4">
                            <strong>{{ Auth::user()->postsCount() }}</strong><br>
                            <small class="text-muted">Articles</small>
                        </div>
                        <div class="col-4">
                            <strong>{{ Auth::user()->followersCount() }}</strong><br>
                            <small class="text-muted">Abonnés</small>
                        </div>
                        <div class="col-4">
                            <strong>{{ Auth::user()->followingCount() }}</strong><br>
                            <small class="text-muted">Abonnements</small>
                        </div>
                    </div>
                    <a href="{{ route('posts.create') }}" class="btn btn-primary btn-sm mt-3 w-100">
                        <i class="fas fa-plus me-2"></i>Nouveau contenu
                    </a>
                </div>
            </div>
        @endauth

        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">À propos</h5>
            </div>
            <div class="card-body">
                <p class="card-text">
                    Bienvenue sur notre blog social ! Partagez vos idées, likez les articles qui vous plaisent
                    et interagissez avec la communauté.
                </p>
                @guest
                    <a href="{{ route('register') }}" class="btn btn-primary btn-sm">
                        Rejoignez-nous
                    </a>
                @endauth
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Gestion des likes
    document.querySelectorAll('.like-btn').forEach(button => {
        button.addEventListener('click', function() {
            const type = this.dataset.type;
            const id = this.dataset.id;
            const icon = this.querySelector('i');
            const countSpan = this.querySelector('.likes-count');
            
            fetch(`/${type}s/${id}/like`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-Requested-With': 'XMLHttpRequest'
                },
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    if (data.isLiked) {
                        icon.className = 'bi bi-heart-fill text-danger';
                    } else {
                        icon.className = 'bi bi-heart';
                    }
                    countSpan.textContent = data.likesCount;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du traitement du like. Veuillez réessayer.');
            });
        });
    });
});
</script>
@endpush
@endsection