@extends('layouts.app')

@section('title', 'Détail du signalement')
@section('header', 'Détail du signalement')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-flag me-2"></i>Signalement #{{ $report->id }}
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Signaleur:</strong></div>
                        <div class="col-sm-9">
                            <a href="{{ route('users.show', $report->user) }}">{{ $report->user->name }}</a>
                            ({{ $report->user->email }})
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Date:</strong></div>
                        <div class="col-sm-9">{{ $report->created_at->setTimezone('Europe/Paris')->format('d/m/Y à H:i') }}</div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Raison:</strong></div>
                        <div class="col-sm-9">
                            <span class="badge bg-warning">{{ $report->reason }}</span>
                        </div>
                    </div>

                    @if($report->description)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Description:</strong></div>
                        <div class="col-sm-9">{{ $report->description }}</div>
                    </div>
                    @endif

                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Statut:</strong></div>
                        <div class="col-sm-9">
                            @switch($report->status)
                                @case('pending')
                                    <span class="badge bg-warning">En attente</span>
                                    @break
                                @case('reviewed')
                                    <span class="badge bg-info">Examiné</span>
                                    @break
                                @case('resolved')
                                    <span class="badge bg-success">Résolu</span>
                                    @break
                                @case('dismissed')
                                    <span class="badge bg-secondary">Rejeté</span>
                                    @break
                            @endswitch
                        </div>
                    </div>

                    @if($report->admin_notes)
                    <div class="row mb-3">
                        <div class="col-sm-3"><strong>Notes admin:</strong></div>
                        <div class="col-sm-9">{{ $report->admin_notes }}</div>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Contenu signalé -->
            <div class="card mt-4">
                <div class="card-header bg-warning">
                    <h6 class="mb-0">
                        <i class="fas fa-exclamation-triangle me-2"></i>Contenu signalé
                    </h6>
                </div>
                <div class="card-body">
                    @if($report->reportable_type === 'App\Models\Post')
                        <h6>Article: {{ $report->reportable->title }}</h6>
                        <p><strong>Auteur:</strong> 
                            <a href="{{ route('users.show', $report->reportable->user) }}">
                                {{ $report->reportable->user->name }}
                            </a>
                        </p>
                        <div class="border p-3 bg-light">
                            {!! nl2br(e(Str::limit($report->reportable->content, 500))) !!}
                        </div>
                        <a href="{{ route('posts.show', $report->reportable) }}" class="btn btn-primary btn-sm mt-2" target="_blank">
                            Voir l'article complet
                        </a>
                    @else
                        <h6>Commentaire</h6>
                        <p><strong>Auteur:</strong> 
                            <a href="{{ route('users.show', $report->reportable->user) }}">
                                {{ $report->reportable->user->name }}
                            </a>
                        </p>
                        <div class="border p-3 bg-light">
                            {{ $report->reportable->content }}
                        </div>
                        <a href="{{ route('posts.show', $report->reportable->post) }}#comment-{{ $report->reportable->id }}" 
                           class="btn btn-primary btn-sm mt-2" target="_blank">
                            Voir dans l'article
                        </a>
                    @endif
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="col-md-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0">Actions</h6>
                </div>
                <div class="card-body">
                    @if($report->status === 'pending')
                        <!-- Supprimer l'utilisateur -->
                        <form method="POST" action="{{ route('admin.reports.delete-user', $report) }}" 
                              onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ? Cette action est irréversible.')" 
                              class="mb-3">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-user-times me-2"></i>Supprimer l'utilisateur
                            </button>
                        </form>

                        <!-- Mettre à jour le statut -->
                        <form method="POST" action="{{ route('admin.reports.update', $report) }}">
                            @csrf
                            @method('PATCH')
                            <div class="mb-3">
                                <label for="status" class="form-label">Statut</label>
                                <select class="form-select" name="status" required>
                                    <option value="reviewed">Examiné</option>
                                    <option value="resolved">Résolu</option>
                                    <option value="dismissed">Rejeté</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="admin_notes" class="form-label">Notes</label>
                                <textarea class="form-control" name="admin_notes" rows="3" placeholder="Notes sur la décision..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100">
                                <i class="fas fa-check me-2"></i>Mettre à jour
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('admin.reports.index') }}" class="btn btn-secondary w-100 mt-2">
                        <i class="fas fa-arrow-left me-2"></i>Retour à la liste
                    </a>
                </div>
            </div>

            <!-- Informations de l'utilisateur signalé -->
            <div class="card mt-3">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">Utilisateur signalé</h6>
                </div>
                <div class="card-body">
                    <p><strong>Nom:</strong> {{ $report->reportable->user->name }}</p>
                    <p><strong>Email:</strong> {{ $report->reportable->user->email }}</p>
                    <p><strong>Inscription:</strong> {{ $report->reportable->user->created_at->setTimezone('Europe/Paris')->format('d/m/Y') }}</p>
                    <p><strong>Articles:</strong> {{ $report->reportable->user->posts()->count() }}</p>
                    <p><strong>Commentaires:</strong> {{ $report->reportable->user->comments()->count() }}</p>
                    
                    <a href="{{ route('users.show', $report->reportable->user) }}" class="btn btn-info btn-sm w-100" target="_blank">
                        Voir le profil
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection