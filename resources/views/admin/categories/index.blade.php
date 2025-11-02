@extends('admin.layouts.app')

@section('title', 'Gestion des Catégories')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion des Catégories</h1>
    <a href="{{ route('admin.categories.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nouvelle Catégorie
    </a>
</div>

<!-- DataTales -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Catégories</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Slug</th>
                        <th>Description</th>
                        <th>Nb Produits</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($categories as $category)
                        <tr>
                            <td><strong>{{ $category->name }}</strong></td>
                            <td><code>{{ $category->slug }}</code></td>
                            <td>{{ Str::limit($category->description, 50) }}</td>
                            <td>
                                <span class="badge badge-info">{{ $category->products_count }} produits</span>
                            </td>
                            <td>
                                <a href="{{ route('admin.categories.edit', $category) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="delete-category-form" style="display: inline-block;" 
                                      data-category-id="{{ $category->id }}"
                                      data-category-name="{{ $category->name }}"
                                      data-products-count="{{ $category->products_count }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete-category">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center">Aucune catégorie trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3">
            {{ $categories->links() }}
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

    // Suppression de catégorie avec logique sécurisée
    $('.btn-delete-category').on('click', function() {
        const form = $(this).closest('.delete-category-form');
        const categoryName = form.data('category-name');
        const productsCount = form.data('products-count');

        // Si la catégorie a des produits, afficher un avertissement spécial
        if (productsCount > 0) {
            Swal.fire({
                title: '⚠️ Attention !',
                html: `<div style="text-align: left;">
                    <p>La catégorie <strong>"${categoryName}"</strong> contient <strong>${productsCount} produit(s)</strong>.</p>
                    <p style="color: #e74a3b; font-weight: bold;">⚠️ En supprimant cette catégorie, TOUS les produits associés seront également supprimés définitivement !</p>
                    <p>Cette action est <strong>irréversible</strong>.</p>
                    <p>Êtes-vous absolument certain de vouloir continuer ?</p>
                </div>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, je comprends les risques',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Afficher la modale de double confirmation avec mot à taper + mot de passe
                    showSecureDeleteConfirmation(form, categoryName);
                }
            });
        } else {
            // Catégorie vide, confirmation simple
            Swal.fire({
                title: 'Êtes-vous sûr ?',
                html: `Vous êtes sur le point de supprimer la catégorie <strong>"${categoryName}"</strong>.`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#e74a3b',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    showLoadingAndSubmit(form);
                }
            });
        }
    });

    // Fonction de confirmation sécurisée (pour catégories avec produits)
    function showSecureDeleteConfirmation(form, categoryName) {
        Swal.fire({
            title: '🔒 Confirmation de sécurité',
            html: `
                <div style="text-align: left; margin-bottom: 20px;">
                    <p>Pour confirmer la suppression de <strong>"${categoryName}"</strong> et de ses produits, veuillez :</p>
                </div>
                <div class="form-group" style="text-align: left;">
                    <label for="confirmWord" style="font-weight: bold;">1. Tapez le mot "supprimer" :</label>
                    <input type="text" id="confirmWord" class="swal2-input" placeholder="supprimer" 
                           style="width: 100%; margin-top: 5px;" autocomplete="off">
                    <small style="color: #6c757d;">Le copier-coller est désactivé</small>
                </div>
                <div class="form-group" style="text-align: left; margin-top: 15px;">
                    <label for="confirmPassword" style="font-weight: bold;">2. Entrez votre mot de passe :</label>
                    <input type="password" id="confirmPassword" class="swal2-input" placeholder="Votre mot de passe" 
                           style="width: 100%; margin-top: 5px;" autocomplete="current-password">
                </div>
            `,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Confirmer la suppression',
            cancelButtonText: 'Annuler',
            reverseButtons: true,
            width: '600px',
            didOpen: () => {
                // Désactiver le copier-coller sur le champ "supprimer"
                const confirmWordInput = document.getElementById('confirmWord');
                confirmWordInput.addEventListener('paste', (e) => {
                    e.preventDefault();
                    Swal.showValidationMessage('Le copier-coller est désactivé pour ce champ');
                    setTimeout(() => {
                        Swal.resetValidationMessage();
                    }, 2000);
                });
                
                // Focus sur le premier champ
                confirmWordInput.focus();
            },
            preConfirm: () => {
                const confirmWord = document.getElementById('confirmWord').value;
                const password = document.getElementById('confirmPassword').value;

                if (confirmWord !== 'supprimer') {
                    Swal.showValidationMessage('Vous devez taper exactement "supprimer"');
                    return false;
                }

                if (!password) {
                    Swal.showValidationMessage('Veuillez entrer votre mot de passe');
                    return false;
                }

                return { password: password };
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // Ajouter le mot de passe au formulaire
                const passwordInput = document.createElement('input');
                passwordInput.type = 'hidden';
                passwordInput.name = 'password';
                passwordInput.value = result.value.password;
                form.append(passwordInput);

                // Soumettre le formulaire
                showLoadingAndSubmit(form);
            }
        });
    }

    // Afficher la modale de chargement et soumettre
    function showLoadingAndSubmit(form) {
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
        
        form.submit();
    }
});
</script>
@endsection

