@extends('admin.layouts.app')

@section('title', 'Nouveau Slide')

@section('content')
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Nouveau Slide</h1>
    <a href="{{ route('admin.developer.carousel.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informations du Slide</h6>
    </div>
    <div class="card-body">
        <form id="createSlideForm" action="{{ route('admin.developer.carousel.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.developer.carousel.form')
            
            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Créer le Slide
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
        $('#createSlideForm').on('submit', function() {
            Swal.fire({
                title: 'Création en cours...',
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

