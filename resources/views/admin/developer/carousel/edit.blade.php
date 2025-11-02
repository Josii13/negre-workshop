@extends('admin.layouts.app')

@section('title', 'Éditer Slide')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Éditer le Slide</h1>
    <a href="{{ route('admin.developer.carousel.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informations du Slide</h6>
    </div>
    <div class="card-body">
        <form id="editSlideForm" action="{{ route('admin.developer.carousel.update', $carousel) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.developer.carousel.form')
            
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </div>
            </div>
        </form>
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
            let errorList = '<ul style="text-align: left;">';
            @foreach($errors->all() as $error)
                errorList += '<li>{{ $error }}</li>';
            @endforeach
            errorList += '</ul>';

            Swal.fire({
                icon: 'error',
                title: 'Erreurs de validation',
                html: errorList,
                confirmButtonColor: '#e74a3b',
                width: '600px'
            });
        @endif

        // Modale de chargement lors de la soumission
        $('#editSlideForm').on('submit', function() {
            Swal.fire({
                title: 'Mise à jour en cours...',
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

