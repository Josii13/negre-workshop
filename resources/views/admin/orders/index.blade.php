@extends('admin.layouts.app')

@section('title', 'Gestion des Commandes')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Gestion des Commandes</h1>
</div>

<!-- DataTales -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des Commandes</h6>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>N°</th>
                        <th>Date</th>
                        <th>Client</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Canal</th>
                        <th>Produit</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ $order->customer_name }}</td>
                            <td>{{ $order->customer_email }}</td>
                            <td>{{ $order->customer_phone }}</td>
                            <td class="text-center">
                                @if($order->order_channel === 'whatsapp')
                                    <span class="badge badge-success" title="Commande via WhatsApp">
                                        <i class="fab fa-whatsapp"></i> WhatsApp
                                    </span>
                                @else
                                    <span class="badge badge-primary" title="Commande via Email">
                                        <i class="fas fa-envelope"></i> Email
                                    </span>
                                @endif
                            </td>
                            <td>
                                @if($order->product)
                                    <strong>{{ $order->product->name }}</strong><br>
                                    <small class="text-muted">{{ number_format($order->product->price, 0, ',', ' ') }} FCFA</small>
                                @else
                                    <span class="text-muted">{{ $order->product_name ?? 'Produit supprimé' }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge badge-{{ 
                                    $order->status === 'pending' ? 'warning' : 
                                    ($order->status === 'confirmed' ? 'info' :
                                    ($order->status === 'completed' ? 'success' : 'secondary')) 
                                }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.orders.destroy', $order) }}" method="POST" class="delete-form" style="display: inline-block;" data-order-id="{{ $order->id }}" data-customer-name="{{ $order->customer_name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger btn-delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">Aucune commande trouvée</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="mt-3">
            {{ $orders->links() }}
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

    // Confirmation de suppression avec SweetAlert2
    $('.btn-delete').on('click', function() {
        const form = $(this).closest('.delete-form');
        const orderId = form.data('order-id');
        const customerName = form.data('customer-name');

        Swal.fire({
            title: 'Êtes-vous sûr ?',
            html: `Vous êtes sur le point de supprimer la commande <strong>#${orderId}</strong> de <strong>${customerName}</strong>.<br>Cette action est irréversible.`,
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


