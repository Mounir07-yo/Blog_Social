@extends('layouts.app')

@section('title', 'Notifications')
@section('header', 'Notifications')
@section('subtitle', 'Restez au courant de l\'activité sur votre profil')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4>Vos notifications</h4>
            @if(Auth::user()->unreadNotifications->count() > 0)
                <button class="btn btn-outline-primary btn-sm" id="mark-all-read">
                    Tout marquer comme lu
                </button>
            @endif
        </div>

        @if($notifications->count() > 0)
            @foreach($notifications as $notification)
                <div class="card shadow-sm mb-3 notification-item {{ $notification->read_at ? '' : 'border-primary' }}" 
                     data-notification-id="{{ $notification->id }}">
                    <div class="card-body">
                        <div class="d-flex align-items-start">
                            <img src="{{ $notification->data['user_avatar'] ?? 'https://ui-avatars.com/api/?name=' . urlencode($notification->data['user_name'] ?? 'User') . '&background=007bff&color=fff' }}" 
                                 class="rounded-circle me-3" width="50" height="50" alt="Avatar">
                            
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between align-items-start">
                                    <div>
                                        <p class="mb-1">
                                            {{ $notification->data['message'] }}
                                        </p>
                                        <small class="text-muted">
                                            {{ $notification->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                    
                                    @if(!$notification->read_at)
                                        <span class="badge bg-primary">Nouveau</span>
                                    @endif
                                </div>
                                
                                @if(isset($notification->data['url']))
                                    <a href="{{ $notification->data['url'] }}" class="btn btn-sm btn-outline-primary mt-2 notification-link"
                                       data-notification-id="{{ $notification->id }}">
                                        Voir
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center">
                {{ $notifications->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="bi bi-bell text-muted" style="font-size: 4rem;"></i>
                <h4 class="text-muted mt-3">Aucune notification</h4>
                <p class="text-muted">Vous n'avez pas encore de notifications.</p>
            </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Marquer toutes les notifications comme lues
    document.getElementById('mark-all-read')?.addEventListener('click', function() {
        fetch('/notifications/read-all', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        })
        .catch(error => console.error('Erreur:', error));
    });

    // Marquer une notification comme lue lors du clic sur le lien
    document.querySelectorAll('.notification-link').forEach(link => {
        link.addEventListener('click', function() {
            const notificationId = this.dataset.notificationId;
            
            fetch(`/notifications/${notificationId}/read`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                },
            })
            .catch(error => console.error('Erreur:', error));
        });
    });
});
</script>
@endpush
@endsection