@extends('admin.layouts.app')

@section('title', 'Gestion des Utilisateurs')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion des Utilisateurs</h1>
    @if(auth()->user()->type === 'super_admin')
        <a href="{{ route('admin.users.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
            <i class="fas fa-plus fa-sm text-white-50"></i> Nouvel Administrateur
        </a>
    @else
        <button type="button" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm" disabled title="Seuls les super administrateurs peuvent créer des administrateurs">
            <i class="fas fa-lock fa-sm text-white-50"></i> Accès restreint
        </button>
    @endif
</div>

<!-- DataTales -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Utilisateurs</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Type</th>
                        <th>Commandes</th>
                        <th>Date création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td><strong>{{ $user->name }}</strong></td>
                            <td>{{ $user->email }}</td>
                            <td>
                                <span class="badge badge-{{
                                    $user->type === 'super_admin' ? 'danger' :
                                    ($user->type === 'admin' ? 'warning' : 'info')
                                }}">
                                    {{ $user->type === 'super_admin' ? 'Super Admin' : ($user->type === 'admin' ? 'Administrateur' : 'Client') }}
                                </span>
                            </td>
                            <td>
                                @if($user->orders_count > 0)
                                    <span class="badge badge-info">{{ $user->orders_count }}</span>
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>{{ $user->created_at->format('d/m/Y') }}</td>
                            <td>
                                @php
                                    $isCurrentUser = $user->id === auth()->id();
                                    $isSuperAdmin = $user->type === 'super_admin';
                                    $isAdminOrSuperAdmin = in_array($user->type, ['admin', 'super_admin']);
                                    $currentUserIsAdmin = auth()->user()->type === 'admin';
                                    $canEdit = !($currentUserIsAdmin && $isAdminOrSuperAdmin);
                                    $canDelete = !$isCurrentUser && (!$isSuperAdmin) && (!($currentUserIsAdmin && $isAdminOrSuperAdmin));
                                @endphp

                                @if($canEdit)
                                    <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @else
                                    <button type="button" class="btn btn-sm btn-secondary btn-access-denied" 
                                            data-action="modifier"
                                            data-user-name="{{ $user->name }}"
                                            data-user-type="{{ $user->type }}"
                                            title="Accès refusé">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                @endif

                                @if($canDelete)
                                    <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="delete-user-form" style="display: inline-block;" 
                                          data-user-id="{{ $user->id }}"
                                          data-user-name="{{ $user->name }}"
                                          data-user-type="{{ $user->type }}"
                                          data-orders-count="{{ $user->orders_count }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger btn-delete-user">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                @elseif($isSuperAdmin)
                                    <button type="button" class="btn btn-sm btn-secondary" disabled title="Les super administrateurs ne peuvent pas être supprimés">
                                        <i class="fas fa-shield-alt"></i>
                                    </button>
                                @else
                                    <button type="button" class="btn btn-sm btn-secondary btn-access-denied" 
                                            data-action="supprimer"
                                            data-user-name="{{ $user->name }}"
                                            data-user-type="{{ $user->type }}"
                                            title="Accès refusé">
                                        <i class="fas fa-lock"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucun utilisateur trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3">
            {{ $users->links() }}
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

    // Modale "Non accès" pour les administrateurs tentant d'accéder à d'autres admins
    $('.btn-access-denied').on('click', function() {
        const action = $(this).data('action');
        const userName = $(this).data('user-name');
        const userType = $(this).data('user-type');
        const userTypeLabel = userType === 'super_admin' ? 'super administrateur' : 'administrateur';

        Swal.fire({
            icon: 'error',
            title: '🚫 Accès Refusé',
            html: `
                <div style="text-align: left; padding: 20px;">
                    <p><strong>Vous n'avez pas les permissions nécessaires pour effectuer cette action.</strong></p>
                    <hr style="margin: 15px 0;">
                    <p><strong>Action demandée :</strong> ${action.charAt(0).toUpperCase() + action.slice(1)} "${userName}"</p>
                    <p><strong>Type d'utilisateur :</strong> ${userTypeLabel.charAt(0).toUpperCase() + userTypeLabel.slice(1)}</p>
                    <hr style="margin: 15px 0;">
                    <p style="color: #e74a3b; font-weight: bold;">
                        <i class="fas fa-exclamation-triangle"></i> 
                        Seuls les <strong>super administrateurs</strong> peuvent ${action} des administrateurs ou super administrateurs.
                    </p>
                    <p style="color: #666; font-size: 0.9em; margin-top: 15px;">
                        Si vous pensez avoir besoin de ces permissions, veuillez contacter un super administrateur.
                    </p>
                </div>
            `,
            confirmButtonText: 'J\'ai compris',
            confirmButtonColor: '#6c757d',
            width: '600px',
            customClass: {
                popup: 'access-denied-modal'
            }
        });
    });

    // Gestion de la suppression des utilisateurs
    $('.btn-delete-user').on('click', function() {
        const form = $(this).closest('.delete-user-form');
        const userId = form.data('user-id');
        const userName = form.data('user-name');
        const userType = form.data('user-type');
        const ordersCount = form.data('orders-count');

        // Déterminer si la suppression sécurisée est nécessaire
        const requiresSecureDelete = (userType === 'admin') || (userType === 'customer' && ordersCount > 0);

        if (requiresSecureDelete) {
            // Première modale : Avertissement
            showSecureDeleteWarning(form, userName, userType, ordersCount);
        } else {
            // Suppression simple pour les clients sans commandes
            showSimpleDeleteConfirmation(form, userName);
        }
    });

    // Fonction pour la suppression simple
    function showSimpleDeleteConfirmation(form, userName) {
        Swal.fire({
            title: 'Êtes-vous sûr ?',
            html: `Vous êtes sur le point de supprimer le client <strong>"${userName}"</strong>.<br>Cette action est irréversible.`,
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

    // Fonction pour l'avertissement de suppression sécurisée
    function showSecureDeleteWarning(form, userName, userType, ordersCount) {
        let warningMessage = '';
        
        if (userType === 'admin') {
            warningMessage = `
                <div style="text-align: left; margin-bottom: 20px;">
                    <p><strong>⚠️ ATTENTION - Suppression d'un administrateur</strong></p>
                    <p>Vous êtes sur le point de supprimer l'administrateur <strong>"${userName}"</strong>.</p>
                    <p style="color: #e74a3b;"><strong>Cette action est irréversible et peut affecter la gestion du système.</strong></p>
                </div>
            `;
        } else {
            warningMessage = `
                <div style="text-align: left; margin-bottom: 20px;">
                    <p><strong>⚠️ ATTENTION - Client avec commandes</strong></p>
                    <p>Le client <strong>"${userName}"</strong> a passé <strong>${ordersCount} commande(s)</strong>.</p>
                    <p style="color: #e74a3b;"><strong>La suppression du client supprimera également toutes ses commandes.</strong></p>
                </div>
            `;
        }

        Swal.fire({
            title: '⚠️ Confirmation requise',
            html: warningMessage,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#e74a3b',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Continuer',
            cancelButtonText: 'Annuler',
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                showSecureDeleteConfirmation(form, userName, userType);
            }
        });
    }

    // Fonction pour la confirmation sécurisée (taper "supprimer" + mot de passe)
    function showSecureDeleteConfirmation(form, userName, userType) {
        const entityType = userType === 'admin' ? "l'administrateur" : 'le client';
        
        Swal.fire({
            title: '🔒 Confirmation de sécurité',
            html: `
                <div style="text-align: left; margin-bottom: 20px;">
                    <p>Pour confirmer la suppression de ${entityType} <strong>"${userName}"</strong>, veuillez :</p>
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
                const confirmWordInput = document.getElementById('confirmWord');
                
                // Désactiver le copier-coller
                confirmWordInput.addEventListener('paste', (e) => {
                    e.preventDefault();
                    Swal.showValidationMessage('Le copier-coller est désactivé pour ce champ');
                    setTimeout(() => {
                        Swal.resetValidationMessage();
                    }, 2000);
                });
                
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

    // Fonction pour afficher la modale de chargement et soumettre le formulaire
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

