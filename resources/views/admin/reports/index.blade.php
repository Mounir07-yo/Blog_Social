@extends('layouts.app')

@section('title', 'Gestion des signalements')
@section('header', 'Panneau d\'administration')
@section('subtitle', 'Gestion des signalements')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-danger text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-flag me-2"></i>Signalements
                    </h5>
                </div>
                <div class="card-body">
                    <!-- Filtres -->
                    <div class="mb-3">
                        <a href="{{ route('admin.reports.index', ['status' => 'pending']) }}" 
                           class="btn btn-{{ $status === 'pending' ? 'primary' : 'outline-primary' }} btn-sm">
                            En attente
                        </a>
                        <a href="{{ route('admin.reports.index', ['status' => 'reviewed']) }}" 
                           class="btn btn-{{ $status === 'reviewed' ? 'info' : 'outline-info' }} btn-sm">
                            Examinés
                        </a>
                        <a href="{{ route('admin.reports.index', ['status' => 'resolved']) }}" 
                           class="btn btn-{{ $status === 'resolved' ? 'success' : 'outline-success' }} btn-sm">
                            Résolus
                        </a>
                        <a href="{{ route('admin.reports.index', ['status' => 'all']) }}" 
                           class="btn btn-{{ $status === 'all' ? 'secondary' : 'outline-secondary' }} btn-sm">
                            Tous
                        </a>
                    </div>

                    @if($reports->count() > 0)
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Signaleur</th>
                                        <th>Contenu signalé</th>
                                        <th>Raison</th>
                                        <th>Statut</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($reports as $report)
                                    <tr>
                                        <td>{{ $report->created_at->setTimezone('Europe/Paris')->format('d/m/Y H:i') }}</td>
                                        <td>
                                            <a href="{{ route('users.show', $report->user) }}">{{ $report->user->name }}</a>
                                        </td>
                                        <td>
                                            @if($report->reportable_type === 'App\Models\Post')
                                                <strong>Article:</strong> {{ Str::limit($report->reportable->title, 30) }}<br>
                                                <small>par {{ $report->reportable->user->name }}</small>
                                            @else
                                                <strong>Commentaire:</strong> {{ Str::limit($report->reportable->content, 30) }}<br>
                                                <small>par {{ $report->reportable->user->name }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge bg-warning">{{ $report->reason }}</span>
                                            @if($report->description)
                                                <br><small class="text-muted">{{ Str::limit($report->description, 50) }}</small>
                                            @endif
                                        </td>
                                        <td>
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
                                        </td>
                                        <td>
                                            <div class="btn-group-vertical btn-group-sm">
                                                <a href="{{ route('admin.reports.show', $report) }}" class="btn btn-info btn-sm">
                                                    <i class="fas fa-eye"></i> Voir
                                                </a>
                                                @if($report->status === 'pending')
                                                    <form method="POST" action="{{ route('admin.reports.delete-user', $report) }}" 
                                                          onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm w-100">
                                                            <i class="fas fa-user-times"></i> Supprimer utilisateur
                                                        </button>
                                                    </form>
                                                @endif
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $reports->links() }}
                    @else
                        <div class="text-center py-4">
                            <i class="fas fa-flag fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Aucun signalement trouvé.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection