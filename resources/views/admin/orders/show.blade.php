@extends('admin.layouts.app')

@section('title', 'Détails Commande #' . $order->id)

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Détails Commande #{{ $order->id }}</h1>
    <a href="{{ route('admin.orders.index') }}" class="d-none d-sm-inline-block btn btn-sm btn-secondary shadow-sm">
        <i class="fas fa-arrow-left fa-sm text-white-50"></i> Retour
    </a>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<div class="row">
    <!-- Informations Client -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Informations Client</h6>
            </div>
            <div class="card-body">
                <table class="table table-borderless">
                    <tr>
                        <th style="width: 40%;">Nom:</th>
                        <td>{{ $order->customer_name }}</td>
                    </tr>
                    <tr>
                        <th>Email:</th>
                        <td><a href="mailto:{{ $order->customer_email }}">{{ $order->customer_email }}</a></td>
                    </tr>
                    <tr>
                        <th>Téléphone:</th>
                        <td><a href="tel:{{ $order->customer_phone }}">{{ $order->customer_phone }}</a></td>
                    </tr>
                    <tr>
                        <th>Canal:</th>
                        <td>
                            @if($order->order_channel === 'whatsapp')
                                <span class="badge badge-success">
                                    <i class="fab fa-whatsapp"></i> WhatsApp
                                </span>
                            @else
                                <span class="badge badge-primary">
                                    <i class="fas fa-envelope"></i> Email
                                </span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Date commande:</th>
                        <td>{{ $order->created_at->format('d/m/Y à H:i') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>

    <!-- Informations Produit -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Produit Commandé</h6>
            </div>
            <div class="card-body">
                @if($order->product)
                    <div class="row">
                        <div class="col-md-4">
                            @if($order->product->image)
                                <img src="{{ asset('storage/' . $order->product->image) }}" alt="{{ $order->product->name }}" class="img-fluid rounded">
                            @else
                                <img src="{{ asset('images/img1.jpg') }}" alt="Default" class="img-fluid rounded">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h5>{{ $order->product->name }}</h5>
                            <p class="text-muted">{{ $order->product->category->name ?? 'N/A' }}</p>
                            <h4 class="text-success">{{ number_format($order->product->price, 0, ',', ' ') }} FCFA</h4>
                        </div>
                    </div>
                @else
                    <p class="text-muted">{{ $order->product_name ?? 'Produit supprimé' }}</p>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Message -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Message du Client</h6>
            </div>
            <div class="card-body">
                <p>{{ $order->message ?: 'Aucun message' }}</p>
            </div>
        </div>
    </div>
</div>

<!-- Statut -->
<div class="row">
    <div class="col-lg-12 mb-4">
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between align-items-center">
                <h6 class="m-0 font-weight-bold text-primary">Statut de la Commande</h6>
                <span class="badge badge-{{ 
                    $order->status === 'pending' ? 'warning' : 
                    ($order->status === 'confirmed' ? 'info' :
                    ($order->status === 'completed' ? 'success' : 'secondary')) 
                }} badge-lg">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update', $order) }}" method="POST" class="form-inline">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group mr-3">
                        <label for="status" class="mr-2">Changer le statut:</label>
                        <select name="status" id="status" class="form-control">
                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>En attente</option>
                            <option value="confirmed" {{ $order->status === 'confirmed' ? 'selected' : '' }}>Confirmée</option>
                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Terminée</option>
                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Annulée</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Mettre à jour
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

