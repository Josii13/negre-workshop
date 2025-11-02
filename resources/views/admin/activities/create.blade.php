@extends('admin.layouts.app')

@section('title', 'Nouvelle Activité')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Nouvelle Activité</h1>
    <a href="{{ route('admin.activities.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour
    </a>
</div>

<!-- Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Informations de l'Activité</h6>
    </div>
    <div class="card-body">
        <form id="createActivityForm" action="{{ route('admin.activities.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="row">
                {{-- Colonne gauche --}}
                <div class="col-md-8">
                    <div class="form-group">
                        <label for="title">Titre <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" 
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5">{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="price_number">Prix</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('price') is-invalid @enderror" 
                                           id="price_number" name="price_number" 
                                           value="{{ old('price_number') }}" 
                                           placeholder="Ex: 450 000">
                                    <div class="input-group-append">
                                        <span class="input-group-text">FCFA</span>
                                    </div>
                                </div>
                                <input type="hidden" id="price" name="price" value="{{ old('price') }}">
                                <small class="form-text text-muted">Saisissez uniquement le montant (ex: 450 000)</small>
                                @error('price')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="frequency">Fréquence</label>
                                <input type="text" class="form-control @error('frequency') is-invalid @enderror" 
                                       id="frequency" name="frequency" value="{{ old('frequency') }}" 
                                       placeholder="Ex: Tous les week-ends">
                                @error('frequency')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="capacity_number">Capacité</label>
                                <div class="input-group">
                                    <input type="text" class="form-control @error('capacity') is-invalid @enderror" 
                                           id="capacity_number" name="capacity_number" 
                                           value="{{ old('capacity_number') }}" 
                                           placeholder="Ex: 30">
                                    <div class="input-group-append">
                                        <span class="input-group-text">personnes</span>
                                    </div>
                                </div>
                                <input type="hidden" id="capacity" name="capacity" value="{{ old('capacity') }}">
                                <small class="form-text text-muted">Saisissez uniquement le nombre (ex: 30)</small>
                                @error('capacity')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="audience">Public Cible</label>
                                <input type="text" class="form-control @error('audience') is-invalid @enderror" 
                                       id="audience" name="audience" value="{{ old('audience') }}" 
                                       placeholder="Ex: Tous niveaux, adultes">
                                @error('audience')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Colonne droite --}}
                <div class="col-md-4">
                    <div class="form-group">
                        <label for="type">Type d'activité <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('type') is-invalid @enderror" 
                               id="type" name="type" value="{{ old('type') }}" 
                               placeholder="Ex: Atelier de création" required>
                        <small class="form-text text-muted">Description du type (ex: Atelier loisir créatif, Production audio)</small>
                        @error('type')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="tab">Onglet d'affichage <span class="text-danger">*</span></label>
                        <select class="form-control @error('tab') is-invalid @enderror" 
                                id="tab" name="tab" required>
                            <option value="">Sélectionner un onglet</option>
                            <option value="atelier" {{ old('tab') === 'atelier' ? 'selected' : '' }}>L'Atelier</option>
                            <option value="activites" {{ old('tab') === 'activites' ? 'selected' : '' }}>Activités</option>
                            <option value="evenements" {{ old('tab') === 'evenements' ? 'selected' : '' }}>Événements</option>
                            <option value="podcasts" {{ old('tab') === 'podcasts' ? 'selected' : '' }}>Podcasts</option>
                        </select>
                        <small class="form-text text-muted">Détermine dans quel onglet l'activité sera affichée</small>
                        @error('tab')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="order">Ordre d'affichage</label>
                        <input type="number" class="form-control @error('order') is-invalid @enderror" 
                               id="order" name="order" value="{{ old('order', 0) }}" min="0">
                        <small class="form-text text-muted">Plus le nombre est petit, plus l'activité sera affichée en premier</small>
                        @error('order')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="form-group">
                        <div class="custom-control custom-switch">
                            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" 
                                   {{ old('is_active', true) ? 'checked' : '' }}>
                            <label class="custom-control-label" for="is_active">Activité active (visible sur le site)</label>
                        </div>
                    </div>

                    <hr>

                    <div class="form-group">
                        <label for="image">Image</label>
                        <input type="file" class="form-control-file @error('image') is-invalid @enderror" 
                               id="image" name="image" accept="image/*">
                        @error('image')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="form-text text-muted">Formats: JPEG, PNG, JPG, GIF, WEBP. Max: 5MB</small>
                    </div>
                </div>
            </div>

            <hr>

            <div class="form-group mb-0">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Enregistrer
                </button>
                <a href="{{ route('admin.activities.index') }}" class="btn btn-secondary">
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
    // Ajouter les unités avant la soumission du formulaire
    $('#createActivityForm').on('submit', function(e) {
        const priceNumber = $('#price_number').val().trim();
        const capacityNumber = $('#capacity_number').val().trim();
        
        // Ajouter "FCFA" au prix si un montant est saisi
        if (priceNumber) {
            $('#price').val(priceNumber + ' FCFA');
        } else {
            $('#price').val('');
        }
        
        // Ajouter "personnes" à la capacité si un nombre est saisi
        if (capacityNumber) {
            $('#capacity').val(capacityNumber + ' personnes');
        } else {
            $('#capacity').val('');
        }
        
        // Modale de chargement
        Swal.fire({
            title: 'Création en cours...',
            html: 'Veuillez patienter pendant que nous créons l\'activité.',
            allowOutsideClick: false,
            allowEscapeKey: false,
            allowEnterKey: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
    });

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
