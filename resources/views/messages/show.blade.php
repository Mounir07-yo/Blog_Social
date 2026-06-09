@extends('layouts.app')

@section('title', 'Conversation avec ' . $user->name)
@section('header', 'Conversation avec ' . $user->name)

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div class="d-flex align-items-center">
                            <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=007bff&color=fff' }}" 
                                 alt="{{ $user->name }}" 
                                 class="rounded-circle me-3" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                            <div>
                                <h6 class="mb-0">{{ $user->name }}</h6>
                                <small class="text-light">Conversation</small>
                            </div>
                        </div>
                        <div>
                            <a href="{{ route('messages.index') }}" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-arrow-left me-1"></i>Retour
                            </a>
                            <a href="{{ route('users.show', $user) }}" class="btn btn-sm btn-outline-light">
                                <i class="fas fa-user me-1"></i>Profil
                            </a>
                        </div>
                    </div>
                </div>
                
                <!-- Zone des messages -->
                <div class="card-body" style="height: 400px; overflow-y: auto;" id="messages-container">
                    @if($messages->count() > 0)
                        @foreach($messages as $message)
                            <div class="message-item mb-3 {{ $message->isFromUser(Auth::id()) ? 'text-end' : '' }}">
                                <div class="d-inline-block" style="max-width: 70%;">
                                    <div class="p-3 rounded {{ $message->isFromUser(Auth::id()) ? 'bg-primary text-white' : 'bg-light' }}">
                                        <p class="mb-1">{{ $message->content }}</p>
                                        <small class="{{ $message->isFromUser(Auth::id()) ? 'text-light' : 'text-muted' }}">
                                            {{ $message->created_at->setTimezone('Europe/Paris')->format('H:i') }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-comments fa-3x mb-3"></i>
                            <p>Aucun message dans cette conversation. Soyez le premier à écrire !</p>
                        </div>
                    @endif
                </div>
                
                <!-- Formulaire d'envoi -->
                <div class="card-footer">
                    <form id="message-form" method="POST" action="{{ route('messages.store', $user) }}">
                        @csrf
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   name="content" 
                                   id="message-input"
                                   placeholder="Tapez votre message..." 
                                   required 
                                   maxlength="1000">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const messagesContainer = document.getElementById('messages-container');
    const messageForm = document.getElementById('message-form');
    const messageInput = document.getElementById('message-input');
    
    // Scroll vers le bas au chargement
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
    
    // Envoyer message via AJAX
    messageForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const content = messageInput.value.trim();
        if (!content) return;
        
        // Désactiver le formulaire pendant l'envoi
        const submitButton = messageForm.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        messageInput.disabled = true;
        
        // Utiliser FormData pour un envoi plus simple
        const formData = new FormData();
        formData.append('content', content);
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);
        
        fetch(messageForm.action, {
            method: 'POST',
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: formData
        })
        .then(response => {
            console.log('Status:', response.status);
            console.log('Headers:', response.headers);
            if (!response.ok) {
                return response.text().then(text => {
                    console.error('Réponse erreur:', text);
                    throw new Error(`HTTP error! status: ${response.status}, body: ${text}`);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('Réponse reçue:', data);
            if (data.success) {
                // Ajouter le message à la conversation
                const messageHtml = `
                    <div class="message-item mb-3 text-end">
                        <div class="d-inline-block" style="max-width: 70%;">
                            <div class="p-3 rounded bg-primary text-white">
                                <p class="mb-1">${data.message.content}</p>
                                <small class="text-light">${data.message.created_at}</small>
                            </div>
                        </div>
                    </div>
                `;
                messagesContainer.insertAdjacentHTML('beforeend', messageHtml);
                
                // Scroll vers le bas
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
                
                // Vider le champ
                messageInput.value = '';
            } else {
                console.error('Erreur serveur:', data.message);
                alert(data.message || 'Erreur lors de l\'envoi du message');
            }
        })
        .catch(error => {
            console.error('Erreur fetch:', error);
            alert('Erreur lors de l\'envoi du message: ' + error.message);
        })
        .finally(() => {
            // Réactiver le formulaire
            submitButton.disabled = false;
            messageInput.disabled = false;
            messageInput.focus();
        });
    });
    
    // Focus sur le champ de message
    messageInput.focus();
});
</script>
@endpush
@endsection