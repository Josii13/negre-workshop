@extends('admin.layouts.app')

@section('title', 'Modifier Catégorie')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Modifier Catégorie</h1>
    <a href="{{ route('admin.categories.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour
    </a>
</div>

<!-- Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informations de la Catégorie</h6>
    </div>
    <div class="card-body">
        <form id="editCategoryForm" action="{{ route('admin.categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="name">Nom de la catégorie <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $category->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="slug">Slug (URL)</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $category->slug) }}" 
                               placeholder="Laisser vide pour génération automatique">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Laisser vide pour générer automatiquement depuis le nom</small>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea class="form-control @error('description') is-invalid @enderror" 
                          id="description" name="description" rows="4">{{ old('description', $category->description) }}</textarea>
                @error('description')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <hr>

            {{-- Image de la catégorie --}}
            <h5 class="text-primary mb-3">Image de la Catégorie</h5>
            
            <div class="form-group">
                <label for="image_file">Image de la catégorie</label>
                
                {{-- Prévisualisation de l'image actuelle --}}
                @if($category->image)
                <div class="mb-3">
                    <img id="category_image_preview" 
                         src="{{ asset('storage/' . $category->image) }}" 
                         alt="Category Image" 
                         class="img-thumbnail" 
                         style="max-height: 200px; object-fit: cover;">
                </div>
                @else
                <div class="mb-3">
                    <div id="category_image_preview_placeholder" class="alert alert-info">
                        <i class="fas fa-image"></i> Aucune image définie pour cette catégorie
                    </div>
                </div>
                @endif
                
                {{-- Champ d'upload --}}
                <div class="custom-file">
                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror" 
                           id="image_file" name="image" accept="image/*" onchange="previewCategoryImage(event)">
                    <label class="custom-file-label" for="image_file">Choisir une image...</label>
                    @error('image')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>
                <small class="form-text text-muted">Format accepté : JPG, PNG, GIF, WEBP (max 2MB). Cette image sera affichée sur la page d'accueil.</small>
                
                {{-- Option pour supprimer l'image --}}
                @if($category->image)
                <div class="form-check mt-2">
                    <input type="checkbox" class="form-check-input" id="remove_image" name="remove_image" value="1">
                    <label class="form-check-label text-danger" for="remove_image">
                        <i class="fas fa-trash"></i> Supprimer l'image actuelle
                    </label>
                </div>
                @endif
            </div>

            <hr>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Mettre à jour
                </button>
                <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Annuler
                </a>
            </div>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
// Fonction de prévisualisation de l'image
function previewCategoryImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Vérifier si l'élément preview existe
            let previewImg = document.getElementById('category_image_preview');
            const placeholder = document.getElementById('category_image_preview_placeholder');
            
            if (!previewImg) {
                // Créer l'élément img si il n'existe pas
                if (placeholder) {
                    placeholder.parentElement.innerHTML = '<img id="category_image_preview" src="" alt="Category Image" class="img-thumbnail" style="max-height: 200px; object-fit: cover;">';
                    previewImg = document.getElementById('category_image_preview');
                }
            }
            
            if (previewImg) {
                previewImg.src = e.target.result;
            }
        }
        reader.readAsDataURL(file);
        
        // Mettre à jour le label avec le nom du fichier
        const fileName = file.name;
        const label = event.target.nextElementSibling;
        label.textContent = fileName;
    }
}

$(document).ready(function() {
    // Modale de chargement lors de la soumission du formulaire
    $('#editCategoryForm').on('submit', function(e) {
        Swal.fire({
            title: 'Mise à jour en cours...',
            html: 'Veuillez patienter pendant que nous mettons à jour la catégorie.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

    // Afficher les messages flash de succès
    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Succès !',
            text: '{{ session('success') }}',
            confirmButtonText: 'OK',
            confirmButtonColor: '#4e73df'
        });
    @endif

    // Afficher les messages flash d'erreur
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
            html: '<div class="text-left"><ul style="list-style-position: inside;">' +
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

