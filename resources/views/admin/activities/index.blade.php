@extends('admin.layouts.app')

@section('title', 'Gestion des Activités')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion des Activités</h1>
    <a href="{{ route('admin.activities.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nouvelle Activité
    </a>
</div>

<!-- DataTales -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Activités</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Type</th>
                        <th>Onglet</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($activities as $activity)
                        <tr>
                            <td>
                                @if($activity->image)
                                    <img src="{{ asset('storage/' . $activity->image) }}" alt="{{ $activity->title }}" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/img1.jpg') }}" alt="Default" style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td><strong>{{ $activity->title }}</strong></td>
                            <td>
                                <span class="badge badge-info">{{ $activity->type }}</span>
                            </td>
                            <td>
                                @php
                                    $tabLabels = [
                                        'atelier' => 'L\'Atelier',
                                        'activites' => 'Activités',
                                        'evenements' => 'Événements',
                                        'podcasts' => 'Podcasts'
                                    ];
                                    $tabColors = [
                                        'atelier' => 'primary',
                                        'activites' => 'success',
                                        'evenements' => 'warning',
                                        'podcasts' => 'secondary'
                                    ];
                                @endphp
                                <span class="badge badge-{{ $tabColors[$activity->tab] ?? 'secondary' }}">
                                    {{ $tabLabels[$activity->tab] ?? $activity->tab }}
                                </span>
                            </td>
                            <td>
                                @if($activity->is_active)
                                    <span class="badge badge-success">
                                        <i class="fas fa-check-circle"></i> Actif
                                    </span>
                                @else
                                    <span class="badge badge-danger">
                                        <i class="fas fa-times-circle"></i> Inactif
                                    </span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.activities.edit', $activity) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.activities.destroy', $activity) }}" method="POST" class="delete-form" style="display: inline-block;" data-activity-title="{{ $activity->title }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucune activité trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3">
            {{ $activities->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Afficher les messages de succès
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès !',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4e73df',
            timer: 3000,
            timerProgressBar: true
        });
    @endif

    // Afficher les messages d'erreur
    @if(session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Erreur !',
            text: '{{ session('error') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#e74a3b'
        });
    @endif

    // Confirmation de suppression avec SweetAlert2
    $('.btn-delete').on('click', function() {
        const form = $(this).closest('.delete-form');
        const activityTitle = form.data('activity-title');

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            html: `Vous êtes sur le point de supprimer l'activité <strong>"${activityTitle}"</strong>.<br>Cette action est irréversible.`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Oui, supprimer',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                // Afficher la modale de chargement
                Swal.fire({
                    title: 'Suppression en cours...',
                    html: 'Veuillez patienter.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });
                
                // Soumettre le formulaire
                form.submit();
            }
        });
    });
});
</script>
@endsection

