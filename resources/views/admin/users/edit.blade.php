@extends('admin.layouts.app')

@section('title', 'Modifier Utilisateur')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Modifier Utilisateur</h1>
    <a href="{{ route('admin.users.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour
    </a>
</div>

<!-- Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informations de l'Utilisateur</h6>
    </div>
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST" id="editUserForm">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nom complet <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $user->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="email">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" name="email" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="password">Nouveau mot de passe (optionnel)</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" name="password">
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Laisser vide pour conserver le mot de passe actuel</small>
                    </div>

                    <div class="form-group">
                        <label for="type">Type d'utilisateur <span class="text-danger">*</span></label>
                        <select class="form-control @error('type') is-invalid @enderror" 
                                id="type" name="type" required>
                            <option value="customer" {{ old('type', $user->type) === 'customer' ? 'selected' : '' }}>Client</option>
                            <option value="admin" {{ old('type', $user->type) === 'admin' ? 'selected' : '' }}>Administrateur</option>
                            @if(auth()->user()->type === 'super_admin')
                                <option value="super_admin" {{ old('type', $user->type) === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            @endif
                        </select>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Modale de chargement lors de la soumission
    $('#editUserForm').on('submit', function(e) {
        Swal.fire({
            title: 'Mise à jour en cours...',
            html: 'Veuillez patienter pendant la mise à jour de l\'utilisateur.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

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

    // Afficher les erreurs de validation
    @if($errors->any())
        Swal.fire({
            icon: 'error',
            title: 'Erreurs de validation',
            html: '<div style="text-align: left;"><ul style="list-style-position: inside;">' +
                @foreach($errors->all() as $error)
                    '<li>{{ $error }}</li>' +
                @endforeach
                '</ul></div>',
            confirmButtonText: 'OK',
            confirmButtonColor: '#e74a3b',
            width: '600px'
        });
    @endif
});
</script>
@endsection

