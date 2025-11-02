@extends('admin.layouts.app')

@section('title', 'Messages de Contact')

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">
        <i class="fas fa-envelope text-primary"></i> Messages de Contact
    </h1>
    <div>
        <span class="badge badge-primary" style="font-size: 1rem; padding: 0.5rem 1rem;">
            <i class="fas fa-inbox"></i> {{ $contacts->total() }} message(s)
        </span>
    </div>
</div>

<!-- DataTales -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Liste des messages</h6>
    </div>
    <div class="card-body">
        @if($contacts->count() > 0)
        <div class="table-responsive">
            <table class="table table-bordered" width="100%">
                <thead>
                    <tr>
                        <th width="10%">Date</th>
                        <th width="15%">Nom</th>
                        <th width="15%">Email</th>
                        <th width="12%">Téléphone</th>
                        <th width="38%">Message</th>
                        <th width="10%">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($contacts as $contact)
                    <tr>
                        <td>
                            <small class="text-muted">
                                <i class="fas fa-calendar"></i> 
                                {{ $contact->created_at->format('d/m/Y') }}<br>
                                <i class="fas fa-clock"></i> 
                                {{ $contact->created_at->format('H:i') }}
                            </small>
                        </td>
                        <td>
                            <strong>{{ $contact->name }}</strong>
                        </td>
                        <td>
                            <a href="mailto:{{ $contact->email }}" class="text-primary">
                                <i class="fas fa-envelope"></i> {{ $contact->email }}
                            </a>
                        </td>
                        <td>
                            @if($contact->phone)
                                <i class="fas fa-phone"></i> {{ $contact->phone }}
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </td>
                        <td>
                            <div style="max-height: 60px; overflow: hidden;">
                                {{ Str::limit($contact->message, 100) }}
                            </div>
                        </td>
                        <td>
                            <button type="button" class="btn btn-sm btn-info btn-view" 
                                    data-id="{{ $contact->id }}"
                                    data-name="{{ $contact->name }}"
                                    data-email="{{ $contact->email }}"
                                    data-phone="{{ $contact->phone ?? 'N/A' }}"
                                    data-message="{{ addslashes($contact->message) }}"
                                    data-date="{{ $contact->created_at->format('d/m/Y à H:i') }}"
                                    title="Voir le message">
                                <i class="fas fa-eye"></i>
                            </button>
                            <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="delete-form" style="display: inline-block;" data-contact-name="{{ $contact->name }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-sm btn-danger btn-delete">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $contacts->links() }}
        </div>
        @else
        <div class="text-center py-5">
            <i class="fas fa-inbox fa-3x text-gray-300 mb-3"></i>
            <p class="text-muted">Aucun message pour le moment.</p>
        </div>
        @endif
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

        // Bouton "Voir le message"
        $('.btn-view').on('click', function() {
            const id = $(this).data('id');
            const name = $(this).data('name');
            const email = $(this).data('email');
            const phone = $(this).data('phone');
            const message = $(this).data('message');
            const date = $(this).data('date');
            
            showContactModal(id, name, email, phone, message, date);
        });

        // Gestion de la suppression avec confirmation
        $('.btn-delete').on('click', function() {
            const form = $(this).closest('.delete-form');
            const contactName = form.data('contact-name');

            Swal.fire({
                title: 'Êtes-vous sûr ?',
                html: `Vous êtes sur le point de supprimer le message de <strong>"${contactName}"</strong>.<br>Cette action est irréversible.`,
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
                        html: 'Veuillez patienter',
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        showConfirmButton: false,
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

