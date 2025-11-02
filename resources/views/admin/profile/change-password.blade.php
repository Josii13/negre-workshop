@extends('admin.layouts.app')

@section('title', 'Modifier le mot de passe')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-key text-primary"></i> Modifier mon mot de passe
    </h1>
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-sm">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<!-- Change Password Form -->
<div class="row justify-content-center">
    <div class="col-lg-6">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Nouveau mot de passe</h6>
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('admin.profile.update-password') }}" id="changePasswordForm">
                    @csrf
                    @method('PUT')

                    <!-- Current Password -->
                    <div class="form-group">
                        <label for="current_password">Mot de passe actuel <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control @error('current_password') is-invalid @enderror" 
                               id="current_password" 
                               name="current_password" 
                               required
                               autocomplete="current-password">
                        @error('current_password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control @error('password') is-invalid @enderror" 
                               id="password" 
                               name="password" 
                               required
                               autocomplete="new-password"
                               minlength="8">
                        <small class="form-text text-muted">
                            <i class="fas fa-info-circle"></i> Le mot de passe doit contenir au moins 8 caractères.
                        </small>
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group">
                        <label for="password_confirmation">Confirmer le nouveau mot de passe <span class="text-danger">*</span></label>
                        <input type="password" 
                               class="form-control" 
                               id="password_confirmation" 
                               name="password_confirmation" 
                               required
                               autocomplete="new-password"
                               minlength="8">
                    </div>

                    <hr>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-check"></i> Modifier le mot de passe
                        </button>
                    </div>
                </form>
            </div>
        </div>
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

        // Afficher les erreurs de validation avec SweetAlert2
        @if($errors->any())
            let errorHtml = '<ul style="text-align: left;">';
            @foreach($errors->all() as $error)
                errorHtml += '<li>{{ $error }}</li>';
            @endforeach
            errorHtml += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Erreurs de validation',
                html: errorHtml,
                confirmButtonColor: '#e74a3b'
            });
        @endif

        // Gestion de la soumission du formulaire
        $('#changePasswordForm').on('submit', function() {
            Swal.fire({
                title: 'Modification en cours...',
                html: 'Veuillez patienter',
                allowOutsideClick: false,
                allowEscapeKey: false,
                allowEnterKey: false,
                showConfirmButton: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });
        });
    });
</script>
@endsection

