<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Mon Blog') - {{ config('app.name') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    
    <!-- Custom CSS -->
    @vite(['resources/css/app.css'])
    
    <style>
        body {
            font-family: 'Figtree', sans-serif;
        }
        .blog-header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }
        .post-card {
            transition: transform 0.2s;
        }
        .post-card:hover {
            transform: translateY(-5px);
        }
        .post-meta {
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand fw-bold" href="{{ route('welcome') }}">
                🚀 Mon Blog
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('posts.index') }}">Accueil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('users.search') }}">Découvrir</a>
                    </li>
                </ul>
                
                <!-- Barre de recherche -->
                <form class="d-flex me-3" action="{{ route('users.search') }}" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Rechercher des utilisateurs..." 
                           value="{{ request('q') }}" style="width: 250px;">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                
                <ul class="navbar-nav">
                    @auth
                        <!-- Notifications -->
                        <li class="nav-item dropdown me-3">
                            <a class="nav-link position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-bell" style="font-size: 1.2rem;"></i>
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger notification-count" 
                                      style="font-size: 0.7rem; display: none;">
                                    0
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" style="width: 350px; max-height: 400px; overflow-y: auto;">
                                <li><h6 class="dropdown-header">Notifications récentes</h6></li>
                                <div id="notifications-list">
                                    <li><span class="dropdown-item-text text-muted">Chargement...</span></li>
                                </div>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-center" href="{{ route('notifications.index') }}">Voir toutes les notifications</a></li>
                            </ul>
                        </li>
                        
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('posts.create') }}">Écrire un article</a>
                        </li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="{{ route('users.show', Auth::user()) }}">Mon profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Modifier profil</a></li>
                                <li><a class="dropdown-item" href="{{ route('notifications.index') }}">Notifications</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                        @csrf
                                        <button type="submit" class="dropdown-item">Déconnexion</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Connexion</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('register') }}">Inscription</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Header -->
    <header class="blog-header py-5">
        <div class="container text-center">
            <h1 class="display-4 fw-bold mb-3">@yield('header', 'Bienvenue sur Mon Blog')</h1>
            <p class="lead">@yield('subtitle', 'Découvrez des articles passionnants et partagez vos idées')</p>
        </div>
    </header>

    <!-- Main Content -->
    <main class="container my-5">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-dark text-light py-4 mt-5">
        <div class="container text-center">
            <p class="mb-0">&copy; {{ date('Y') }} Mon Blog. Créé avec ❤️ et Laravel.</p>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @vite(['resources/js/app.js'])
    
    @auth
    <script>
    // Gestion des notifications en temps réel
    document.addEventListener('DOMContentLoaded', function() {
        updateNotificationCount();
        
        // Mettre à jour le compteur toutes les 30 secondes
        setInterval(updateNotificationCount, 30000);
        
        // Charger les notifications lors de l'ouverture du dropdown
        document.getElementById('notificationsDropdown')?.addEventListener('click', function() {
            loadRecentNotifications();
        });
    });

    function updateNotificationCount() {
        fetch('/api/notifications/count')
            .then(response => response.json())
            .then(data => {
                const badge = document.querySelector('.notification-count');
                if (data.count > 0) {
                    badge.textContent = data.count > 99 ? '99+' : data.count;
                    badge.style.display = 'inline';
                } else {
                    badge.style.display = 'none';
                }
            })
            .catch(error => console.error('Erreur:', error));
    }

    function loadRecentNotifications() {
        fetch('/api/notifications/latest')
            .then(response => response.json())
            .then(notifications => {
                const container = document.getElementById('notifications-list');
                
                if (notifications.length === 0) {
                    container.innerHTML = '<li><span class="dropdown-item-text text-muted">Aucune nouvelle notification</span></li>';
                    return;
                }
                
                container.innerHTML = notifications.map(notification => {
                    const data = JSON.parse(notification.data);
                    return `
                        <li>
                            <a class="dropdown-item py-2" href="${data.url || '#'}" 
                               onclick="markNotificationAsRead('${notification.id}')">
                                <div class="d-flex align-items-start">
                                    <img src="${data.user_avatar || 'https://ui-avatars.com/api/?name=' + encodeURIComponent(data.user_name || 'User') + '&background=007bff&color=fff'}" 
                                         class="rounded-circle me-2" width="32" height="32" alt="Avatar">
                                    <div class="flex-grow-1">
                                        <div class="small">${data.message}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">
                                            ${timeAgo(new Date(notification.created_at))}
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </li>
                    `;
                }).join('');
            })
            .catch(error => console.error('Erreur:', error));
    }

    function markNotificationAsRead(notificationId) {
        fetch(`/notifications/${notificationId}/read`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(() => updateNotificationCount())
        .catch(error => console.error('Erreur:', error));
    }

    function timeAgo(date) {
        const seconds = Math.floor((new Date() - date) / 1000);
        
        if (seconds < 60) return 'À l\'instant';
        
        const intervals = {
            année: 31536000,
            mois: 2592000,
            jour: 86400,
            heure: 3600,
            minute: 60
        };
        
        for (let [unit, value] of Object.entries(intervals)) {
            const interval = Math.floor(seconds / value);
            if (interval >= 1) {
                return `Il y a ${interval} ${unit}${interval > 1 ? (unit === 'mois' ? '' : 's') : ''}`;
            }
        }
    }
    </script>
    @endauth
    
    @stack('scripts')
</body>
</html>