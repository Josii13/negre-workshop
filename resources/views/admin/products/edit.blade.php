@extends('admin.layouts.app')

@section('title', 'Modifier Produit')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Modifier Produit</h1>
    <a href="{{ route('admin.products.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour
    </a>
</div>

<!-- Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informations du Produit</h6>
    </div>
    <div class="card-body">
        <form id="editProductForm" action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            
            <div class="row">
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="name">Nom du produit <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" 
                               id="name" name="name" value="{{ old('name', $product->name) }}" required>
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="slug">Slug (URL)</label>
                        <input type="text" class="form-control @error('slug') is-invalid @enderror" 
                               id="slug" name="slug" value="{{ old('slug', $product->slug) }}" 
                               placeholder="Laisser vide pour génération automatique">
                        @error('slug')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Laisser vide pour générer automatiquement depuis le nom</small>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5">{{ old('description', $product->description) }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="form-group">
                        <label for="category_id">Catégorie <span class="text-danger">*</span></label>
                        <select class="form-control @error('category_id') is-invalid @enderror" 
                                id="category_id" name="category_id" required>
                            <option value="">Sélectionner une catégorie</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" 
                                        {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="price">Prix (FCFA) <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('price') is-invalid @enderror" 
                               id="price" name="price" value="{{ old('price', $product->price) }}" min="0" step="1" required>
                        @error('price')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label>Image actuelle</label>
                        @if($product->image)
                            <div class="mb-2">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" 
                                     style="max-width: 100%; height: auto; max-height: 200px; object-fit: cover;">
                            </div>
                        @else
                            <p class="text-muted">Aucune image</p>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="image">Nouvelle image (optionnel)</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Formats: JPEG, PNG, JPG, GIF, WEBP. Max: 2MB</small>
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-checkbox mb-2">
                            <input type="checkbox" class="custom-control-input" id="is_available" name="is_available" value="1"
                                   {{ old('is_available', $product->is_available) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_available">Disponible à la vente</label>
                        </div>
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" id="is_featured" name="is_featured" value="1"
                                   {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_featured">Produit en vedette</label>
                        </div>
                    </div>

                </div>
            </div>

            <hr>
            
            <h5 class="mb-3 text-primary">Caractéristiques spécifiques</h5>
            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="dimensions">Dimensions</label>
                        <div class="input-group">
                            <input type="number" min="0" class="form-control @error('dimensions') is-invalid @enderror"
                                id="dimension_length" placeholder="Longueur" style="max-width: 90px;">
                            <div class="input-group-prepend input-group-append">
                                <span class="input-group-text" style="font-weight:bold;">x</span>
                            </div>
                            <input type="number" min="0" class="form-control @error('dimensions') is-invalid @enderror"
                                id="dimension_width" placeholder="Largeur" style="max-width: 90px;">
                            <div class="input-group-append">
                                <select id="dimension_unit" class="form-control" style="max-width: 80px;">
                                    <option value="cm">cm</option>
                                    <option value="m">m</option>
                                </select>
                            </div>
                            <input type="hidden"
                                name="dimensions"
                                id="dimensions"
                                value="{{ old('dimensions', $product->dimensions) }}">
                        </div>
                        
                        @error('dimensions')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pour peintures et design</small>
                    </div>

                    <div class="form-group">
                        <label for="technique">Technique</label>
                        <input type="text" class="form-control @error('technique') is-invalid @enderror" 
                               id="technique" name="technique" value="{{ old('technique', $product->technique) }}"
                               placeholder="Ex: Acrylique, Huile">
                        @error('technique')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pour peintures</small>
                    </div>

                    <div class="form-group">
                        <label for="support">Support</label>
                        <input type="text" class="form-control @error('support') is-invalid @enderror" 
                               id="support" name="support" value="{{ old('support', $product->support) }}"
                               placeholder="Ex: Toile, Bois, Papier">
                        @error('support')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pour peintures</small>
                    </div>

                    <div class="form-group">
                        <label for="materials">Matériaux</label>
                        <input type="text" class="form-control @error('materials') is-invalid @enderror" 
                               id="materials" name="materials" value="{{ old('materials', $product->materials) }}"
                               placeholder="Ex: Coton, Polyester">
                        @error('materials')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pour design et marque</small>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="style">Style</label>
                        <input type="text" class="form-control @error('style') is-invalid @enderror" 
                               id="style" name="style" value="{{ old('style', $product->style) }}"
                               placeholder="Ex: Contemporain, Moderne">
                        @error('style')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="collection">Collection</label>
                        <input type="text" class="form-control @error('collection') is-invalid @enderror" 
                               id="collection" name="collection" value="{{ old('collection', $product->collection) }}"
                               placeholder="Ex: Collection Printemps 2025">
                        @error('collection')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pour marque</small>
                    </div>

                    <div class="form-group">
                        <label for="sizes">Tailles disponibles</label>
                        <input type="text" class="form-control @error('sizes') is-invalid @enderror" 
                               id="sizes" name="sizes" value="{{ old('sizes', $product->sizes) }}"
                               placeholder="Ex: S, M, L, XL">
                        @error('sizes')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Pour marque (vêtements)</small>
                    </div>

                    <div class="form-group">
                        <label for="year">Année</label>
                        <input type="text" class="form-control @error('year') is-invalid @enderror" 
                               id="year" name="year" value="{{ old('year', $product->year) }}"
                               placeholder="Ex: 2025">
                        @error('year')
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
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
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
    // Modale de chargement lors de la soumission du formulaire
    $('#editProductForm').on('submit', function(e) {
        Swal.fire({
            title: 'Mise à jour en cours...',
            html: 'Veuillez patienter pendant que nous mettons à jour le produit.',
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

<!-- Dimensions Script -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        function updateDimensionsField() {
            const length = document.getElementById('dimension_length').value;
            const width = document.getElementById('dimension_width').value;
            const unit = document.getElementById('dimension_unit').value;
            let dim = '';
            if (length && width) {
                dim = length + 'x' + width + ' ' + unit;
            }
            document.getElementById('dimensions').value = dim;
        }

        // Pré-remplissage si old('dimensions') ou $product->dimensions existe (format attendu: 100x80 cm)
        @if(old('dimensions') || $product->dimensions)
            (function () {
                let dimensionsValue = `{{ old('dimensions', $product->dimensions) }}`;
                let match = dimensionsValue.match(/^(\d+)\s*x\s*(\d+)\s*(cm|m)?$/i);
                if (match) {
                    document.getElementById('dimension_length').value = match[1];
                    document.getElementById('dimension_width').value = match[2];
                    if (match[3]) document.getElementById('dimension_unit').value = match[3];
                }
            })();
        @endif

        document.getElementById('dimension_length').addEventListener('input', updateDimensionsField);
        document.getElementById('dimension_width').addEventListener('input', updateDimensionsField);
        document.getElementById('dimension_unit').addEventListener('change', updateDimensionsField);
    });
</script>
@endsection

