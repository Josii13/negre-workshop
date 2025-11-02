@extends('admin.layouts.app')

@section('title', 'Gestion du Carrousel')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion du Carrousel</h1>
    <a href="{{ route('admin.developer.carousel.create') }}" class="btn btn-primary">
        <i class="fas fa-plus"></i> Nouveau Slide
    </a>
</div>

<!-- DataTales -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Slides</h6>
    </div>
    <div class="card-body">
        @if($slides->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered" width="100%">
                <thead>
                    <tr>
                        <th>Ordre</th>
                        <th>Image</th>
                        <th>Titre</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($slides as $slide)
                    <tr>
                        <td>{{ $slide->order }}</td>
                        <td>
                            @if($slide->image)
                            <img src="{{ asset('images/' . $slide->image) }}" alt="{{ $slide->title }}" style="max-width: 100px; height: auto;">
                            @else
                            <span class="text-muted">Aucune image</span>
                            @endif
                        </td>
                        <td>
                            <strong>{{ $slide->title }}</strong><br>
                            <small class="text-muted">{{ $slide->subtitle }}</small>
                        </td>
                        <td>
                            @if($slide->is_active)
                            <span class="badge badge-success">Actif</span>
                            @else
                            <span class="badge badge-secondary">Inactif</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('admin.developer.carousel.edit', $slide) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.developer.carousel.destroy', $slide) }}" method="POST" class="delete-form" style="display: inline-block;" data-slide-title="{{ $slide->title }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-images fa-3x text-gray-300 mb-3"></i>
            <p class="text-muted">Aucun slide pour le moment.</p>
            <a href="{{ route('admin.developer.carousel.create') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Créer le premier slide
            </a>
        </div>
        @endif
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Afficher la modale de succès si présente
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Succès !',
                text: '{{ session('success') }}',
                confirmButtonColor: '#4e73df',
                timer: 3000,
                timerProgressBar: true
            });
        @endif

        // Afficher la modale d'erreur si présente
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Erreur !',
                text: '{{ session('error') }}',
                confirmButtonColor: '#e74a3b'
            });
        @endif

        // Gestion de la suppression avec confirmation
        $('.btn-delete').on('click', function() {
            const form = $(this).closest('.delete-form');
            const slideTitle = form.data('slide-title');

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                html: `Vous êtes sur le point de supprimer le slide <strong>"${slideTitle}"</strong>.<br>Cette action est irréversible.`,
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
                        html: 'Veuillez patienter',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false,
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

