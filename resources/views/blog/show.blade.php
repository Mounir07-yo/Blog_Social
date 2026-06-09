@extends('layouts.app')

@section('title', $post->title)
@section('header', $post->title)
@section('subtitle', $post->excerpt ?? '')

@section('content')
<div class="row">
    <div class="col-lg-8">
        <article class="card shadow-sm">
            <!-- Header de l'article -->
            <div class="card-header border-0 bg-white">
                <div class="d-flex align-items-center">
                    <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=007bff&color=fff' }}" 
                         class="rounded-circle me-3" width="50" height="50" alt="{{ $post->user->name }}">
                    <div class="flex-grow-1">
                        <h6 class="mb-0">
                            <a href="{{ route('users.show', $post->user) }}" class="text-decoration-none text-dark fw-bold">
                                {{ $post->user->name }}
                            </a>
                        </h6>
                        <small class="text-muted">{{ $post->published_at ? $post->published_at->setTimezone('Europe/Paris')->format('d/m/Y à H:i') : 'Brouillon' }}</small>
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
                <img src="{{ $post->featured_image }}" class="card-img-top" style="max-height: 500px; object-fit: cover;" alt="{{ $post->title }}">
            @elseif($post->images && count($post->images) > 0)
                @if(count($post->images) == 1)
                    <img src="{{ $post->images[0] }}" class="card-img-top" style="max-height: 500px; object-fit: cover;" alt="{{ $post->title }}">
                @else
                    <div id="carousel-{{ $post->id }}" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($post->images as $index => $image)
                                <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                                    <img src="{{ $image }}" class="d-block w-100" style="max-height: 500px; object-fit: cover;" alt="Image {{ $index + 1 }}">
                                </div>
                            @endforeach
                        </div>
                        @if(count($post->images) > 1)
                            <button class="carousel-control-prev" type="button" data-bs-target="#carousel-{{ $post->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon"></span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#carousel-{{ $post->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon"></span>
                            </button>
                        @endif
                    </div>
                @endif
            @endif
            
            <div class="card-body">
                @if(!$post->is_published)
                    <div class="alert alert-warning">
                        <i class="bi bi-exclamation-triangle"></i>
                        Cet article est en brouillon et n'est visible que par vous.
                    </div>
                @endif

                <div class="post-content">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            <!-- Actions sociales -->
            <div class="card-footer border-0 bg-white">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div class="d-flex gap-4">
                        @auth
                            <button class="btn btn-link p-0 like-btn" data-type="post" data-id="{{ $post->slug }}">
                                <i class="bi bi-heart{{ $post->isLikedBy(Auth::user()) ? '-fill text-danger' : '' }}" style="font-size: 1.5rem;"></i>
                                <span class="likes-count">{{ $post->likesCount() }}</span>
                            </button>
                        @else
                            <span class="text-muted">
                                <i class="bi bi-heart" style="font-size: 1.5rem;"></i>
                                <span>{{ $post->likesCount() }}</span>
                            </span>
                        @endauth
                        <div>
                            <i class="bi bi-chat" style="font-size: 1.5rem;"></i>
                        </div>
                    </div>
                </div>

                @if($post->likesCount() > 0)
                    <div class="mb-2">
                        <strong><span class="likes-count">{{ $post->likesCount() }}</span> j'aime</strong>
                    </div>
                @endif
            </div>
        </article>

        <!-- Section des commentaires -->
        <div class="card shadow-sm mt-4">
            <div class="card-header">
                <h5 class="mb-0">Commentaires ({{ $post->commentsCount() }})</h5>
            </div>
            <div class="card-body">
                @auth
                    <!-- Formulaire d'ajout de commentaire -->
                    <form method="POST" action="{{ route('comments.store', $post) }}" class="mb-4">
                        @csrf
                        <div class="d-flex">
                            <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=007bff&color=fff' }}" 
                                 class="rounded-circle me-3" width="40" height="40" alt="{{ Auth::user()->name }}">
                            <div class="flex-grow-1">
                                <textarea class="form-control" name="content" rows="2" placeholder="Écrivez un commentaire..." required></textarea>
                                <button type="submit" class="btn btn-primary btn-sm mt-2">Publier</button>
                            </div>
                        </div>
                    </form>
                @else
                    <p class="text-muted">
                        <a href="{{ route('login') }}">Connectez-vous</a> pour laisser un commentaire.
                    </p>
                @endauth

                <!-- Liste des commentaires -->
                @foreach($post->comments as $comment)
                    <div class="comment mb-4" id="comment-{{ $comment->id }}">
                        <div class="d-flex">
                            <img src="{{ $comment->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($comment->user->name) . '&background=28a745&color=fff' }}" 
                                 class="rounded-circle me-3" width="40" height="40" alt="{{ $comment->user->name }}">
                            <div class="flex-grow-1">
                                <div class="bg-light rounded p-3">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <strong>
                                            <a href="{{ route('users.show', $comment->user) }}" class="text-decoration-none">
                                                {{ $comment->user->name }}
                                            </a>
                                        </strong>
                                        <small class="text-muted">{{ $comment->created_at->setTimezone('Europe/Paris')->diffForHumans() }}</small>
                                    </div>
                                    <p class="mb-0 mt-1">{{ $comment->content }}</p>
                                </div>
                                
                                <div class="d-flex align-items-center mt-2 gap-3">
                                    @auth
                                        <button class="btn btn-link btn-sm p-0 like-btn" data-type="comment" data-id="{{ $comment->id }}">
                                            <i class="bi bi-heart{{ $comment->isLikedBy(Auth::user()) ? '-fill text-danger' : '' }}"></i>
                                            <span class="likes-count">{{ $comment->likesCount() }}</span>
                                        </button>
                                        
                                        <button class="btn btn-link btn-sm p-0 text-muted reply-btn" 
                                                data-comment-id="{{ $comment->id }}">
                                            Répondre
                                        </button>
                                        
                                        @if(Auth::id() === $comment->user_id)
                                            <form method="POST" action="{{ route('comments.destroy', $comment) }}" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button type="submit" class="btn btn-link btn-sm p-0 text-danger"
                                                        onclick="return confirm('Supprimer ce commentaire ?')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        @endif
                                    @endauth
                                </div>

                                <!-- Formulaire de réponse (masqué par défaut) -->
                                @auth
                                    <div class="reply-form mt-2" id="reply-form-{{ $comment->id }}" style="display: none;">
                                        <form method="POST" action="{{ route('comments.store', $post) }}">
                                            @csrf
                                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                                            <div class="d-flex">
                                                <img src="{{ Auth::user()->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode(Auth::user()->name) . '&background=007bff&color=fff' }}" 
                                                     class="rounded-circle me-2" width="30" height="30" alt="{{ Auth::user()->name }}">
                                                <div class="flex-grow-1">
                                                    <textarea class="form-control form-control-sm" name="content" rows="2" 
                                                              placeholder="Répondre à {{ $comment->user->name }}..." required></textarea>
                                                    <div class="mt-2">
                                                        <button type="submit" class="btn btn-primary btn-sm">Répondre</button>
                                                        <button type="button" class="btn btn-secondary btn-sm cancel-reply">Annuler</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                @endauth

                                <!-- Réponses -->
                                @if($comment->replies->count() > 0)
                                    <div class="replies mt-3 ms-4">
                                        @foreach($comment->replies as $reply)
                                            <div class="reply mb-3" id="comment-{{ $reply->id }}">
                                                <div class="d-flex">
                                                    <img src="{{ $reply->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($reply->user->name) . '&background=6c757d&color=fff' }}" 
                                                         class="rounded-circle me-2" width="32" height="32" alt="{{ $reply->user->name }}">
                                                    <div class="flex-grow-1">
                                                        <div class="bg-light rounded p-2">
                                                            <div class="d-flex justify-content-between align-items-start">
                                                                <strong>
                                                                    <a href="{{ route('users.show', $reply->user) }}" class="text-decoration-none">
                                                                        {{ $reply->user->name }}
                                                                    </a>
                                                                </strong>
                                                                <small class="text-muted">{{ $reply->created_at->setTimezone('Europe/Paris')->diffForHumans() }}</small>
                                                            </div>
                                                            <p class="mb-0 mt-1">{{ $reply->content }}</p>
                                                        </div>
                                                        
                                                        <div class="d-flex align-items-center mt-1 gap-3">
                                                            @auth
                                                                <button class="btn btn-link btn-sm p-0 like-btn" data-type="comment" data-id="{{ $reply->id }}">
                                                                    <i class="bi bi-heart{{ $reply->isLikedBy(Auth::user()) ? '-fill text-danger' : '' }}"></i>
                                                                    <span class="likes-count">{{ $reply->likesCount() }}</span>
                                                                </button>
                                                                
                                                                @if(Auth::id() === $reply->user_id)
                                                                    <form method="POST" action="{{ route('comments.destroy', $reply) }}" class="d-inline">
                                                                        @csrf @method('DELETE')
                                                                        <button type="submit" class="btn btn-link btn-sm p-0 text-danger"
                                                                                onclick="return confirm('Supprimer ce commentaire ?')">
                                                                            Supprimer
                                                                        </button>
                                                                    </form>
                                                                @endif
                                                            @endauth
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Navigation -->
        <div class="mt-4">
            <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">
                ← Retour aux articles
            </a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">À propos de l'auteur</h5>
            </div>
            <div class="card-body text-center">
                <img src="{{ $post->user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($post->user->name) . '&background=007bff&color=fff' }}" 
                     class="rounded-circle mb-3" width="80" height="80" alt="{{ $post->user->name }}">
                <h6>{{ $post->user->name }}</h6>
                @if($post->user->bio)
                    <p class="text-muted small">{{ $post->user->bio }}</p>
                @endif
                <p class="text-muted small">Membre depuis {{ $post->user->created_at->setTimezone('Europe/Paris')->format('M Y') }}</p>
                
                <div class="row text-center mb-3">
                    <div class="col-4">
                        <strong>{{ $post->user->postsCount() }}</strong><br>
                        <small class="text-muted">Articles</small>
                    </div>
                    <div class="col-4">
                        <strong>{{ $post->user->followersCount() }}</strong><br>
                        <small class="text-muted">Abonnés</small>
                    </div>
                    <div class="col-4">
                        <strong>{{ $post->user->followingCount() }}</strong><br>
                        <small class="text-muted">Abonnements</small>
                    </div>
                </div>

                @auth
                    @if(Auth::id() !== $post->user_id)
                        <button class="btn btn-primary btn-sm follow-btn" data-user-id="{{ $post->user->id }}">
                            {{ Auth::user()->isFollowing($post->user) ? 'Ne plus suivre' : 'Suivre' }}
                        </button>
                    @else
                        <a href="{{ route('posts.create') }}" class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-2"></i>Nouveau contenu
                        </a>
                    @endif
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
                    if (countSpan) countSpan.textContent = data.likesCount;
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                alert('Erreur lors du traitement du like. Veuillez réessayer.');
            });
        });
    });

    // Gestion des réponses aux commentaires
    document.querySelectorAll('.reply-btn').forEach(button => {
        button.addEventListener('click', function() {
            const commentId = this.dataset.commentId;
            const replyForm = document.getElementById(`reply-form-${commentId}`);
            replyForm.style.display = replyForm.style.display === 'none' ? 'block' : 'none';
        });
    });

    // Annuler les réponses
    document.querySelectorAll('.cancel-reply').forEach(button => {
        button.addEventListener('click', function() {
            this.closest('.reply-form').style.display = 'none';
        });
    });

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
                }
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});
</script>
@endpush
@endsection