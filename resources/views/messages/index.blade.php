@extends('layouts.app')

@section('title', 'Messagerie')
@section('header', 'Messagerie')
@section('subtitle', 'Vos conversations')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-comments me-2"></i>Vos conversations
                        @if($unreadCount > 0)
                            <span class="badge bg-danger ms-2">{{ $unreadCount }}</span>
                        @endif
                    </h5>
                </div>
                <div class="card-body">
                    @if($conversations->count() > 0)
                        <div class="list-group list-group-flush">
                            @foreach($conversations as $conversation)
                                @php
                                    $otherUser = $conversation->sender_id === Auth::id() 
                                        ? $conversation->receiver 
                                        : $conversation->sender;
                                    $isUnread = !$conversation->is_read && $conversation->receiver_id === Auth::id();
                                @endphp
                                <a href="{{ route('messages.show', $otherUser) }}" 
                                   class="list-group-item list-group-item-action {{ $isUnread ? 'bg-light border-primary' : '' }}">
                                    <div class="d-flex w-100 justify-content-between">
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $otherUser->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($otherUser->name) . '&background=007bff&color=fff' }}" 
                                                 alt="{{ $otherUser->name }}" 
                                                 class="rounded-circle me-3" 
                                                 style="width: 50px; height: 50px; object-fit: cover;">
                                            <div>
                                                <h6 class="mb-1 {{ $isUnread ? 'fw-bold' : '' }}">{{ $otherUser->name }}</h6>
                                                <p class="mb-1 text-muted {{ $isUnread ? 'fw-bold text-dark' : '' }}">
                                                    {{ Str::limit($conversation->content, 60) }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <small class="text-muted">{{ $conversation->created_at->setTimezone('Europe/Paris')->diffForHumans() }}</small>
                                            @if($isUnread)
                                                <br><span class="badge bg-primary">Non lu</span>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">Aucune conversation</h5>
                            <p class="text-muted">Commencez une conversation en visitant le profil d'un utilisateur.</p>
                            <a href="{{ route('users.search') }}" class="btn btn-primary">
                                <i class="fas fa-search me-2"></i>Rechercher des utilisateurs
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection