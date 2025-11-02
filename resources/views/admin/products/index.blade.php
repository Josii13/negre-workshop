@extends('admin.layouts.app')

@section('title', 'Gestion des Produits')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion des Produits</h1>
    <a href="{{ route('admin.products.create') }}" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
        <i class="fas fa-plus fa-sm text-white-50"></i> Nouveau Produit
    </a>
</div>

<!-- Filtres et Tri -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Filtres et Tri</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="{{ route('admin.products.index') }}" class="row align-items-end">
            <div class="col-md-3">
                <label for="category" class="form-label">Catégorie</label>
                <select name="category" id="category" class="form-control">
                    <option value="">Toutes les catégories</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="status" class="form-label">Statut</label>
                <select name="status" id="status" class="form-control">
                    <option value="">Tous les statuts</option>
                    <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Disponibles</option>
                    <option value="unavailable" {{ request('status') === 'unavailable' ? 'selected' : '' }}>Indisponibles</option>
                    <option value="featured" {{ request('status') === 'featured' ? 'selected' : '' }}>En vedette</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <label for="sort" class="form-label">Trier par</label>
                <select name="sort" id="sort" class="form-control">
                    <option value="latest" {{ request('sort') === 'latest' ? 'selected' : '' }}>Plus récents</option>
                    <option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nom (A-Z)</option>
                    <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Prix (croissant)</option>
                    <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Prix (décroissant)</option>
                </select>
            </div>
            
            <div class="col-md-3">
                <a href="{{ route('admin.products.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times"></i> Réinitialiser
                </a>
            </div>
        </form>
    </div>
</div>

<!-- DataTales -->
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Produits</h6>
        <div class="text-muted small">
            @if(request()->hasAny(['category', 'status', 'sort']))
                <span class="badge badge-info">
                    {{ $products->total() }} produit(s) trouvé(s)
                </span>
            @else
                <span class="badge badge-secondary">
                    {{ $products->total() }} produit(s) au total
                </span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <!-- Boutons de tri rapide par catégorie -->
        <div class="mb-3">
            <div class="d-flex flex-wrap gap-2 align-items-center">
                <span class="text-muted small">Tri rapide :</span>
                <a href="{{ route('admin.products.index') }}" 
                   class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-outline-primary' }}">
                    Tous
                </a>
                @foreach($categories as $category)
                    <a href="{{ route('admin.products.index', ['category' => $category->id]) }}" 
                       class="btn btn-sm {{ request('category') == $category->id ? 'btn-primary' : 'btn-outline-primary' }}">
                        {{ $category->name }}
                    </a>
                @endforeach
            </div>
        </div>
        
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Nom</th>
                        <th>Catégorie</th>
                        <th>Prix</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td>
                                @if($product->image)
                                    <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" style="width: 50px; height: 50px; object-fit: cover;">
                                @else
                                    <img src="{{ asset('images/img1.jpg') }}" alt="Default" style="width: 50px; height: 50px; object-fit: cover;">
                                @endif
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>
                                <span class="badge badge-info">{{ $product->category->name ?? 'N/A' }}</span>
                            </td>
                            <td>{{ number_format($product->price, 0, ',', ' ') }} FCFA</td>
                            <td>
                                @if($product->is_featured)
                                    <span class="badge badge-warning mb-1">
                                        <i class="fas fa-star"></i> Vedette
                                    </span><br>
                                @endif
                                @if($product->is_available)
                                    <span class="badge badge-success">Disponible</span>
                                @else
                                    <span class="badge badge-secondary">Indisponible</span>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning" title="Modifier">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="delete-form" style="display: inline-block;" data-product-name="{{ $product->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">Aucun produit trouvé</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3">
            {{ $products->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    // Filtrage automatique lors du changement des sélecteurs
    $('#category, #status, #sort').on('change', function() {
        $(this).closest('form').submit();
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

    // Confirmation de suppression avec SweetAlert2
    $('.btn-delete').on('click', function() {
        const form = $(this).closest('.delete-form');
        const productName = form.data('product-name');

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            html: `Vous êtes sur le point de supprimer le produit <strong>"${productName}"</strong>.<br>Cette action est irréversible.`,
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
                    html: 'Veuillez patienter.',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
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

