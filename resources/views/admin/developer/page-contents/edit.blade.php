@extends('admin.layouts.app')

@section('title', 'Éditer ' . ucfirst($page))

@section('content')
<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Éditer la Page : {{ ucfirst($page) }}</h1>
    <a href="{{ route('admin.developer.page-contents.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Retour
    </a>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fas fa-check-circle"></i> {{ session('success') }}
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif

<!-- Form Card -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Contenu de la Page</h6>
    </div>
    <div class="card-body">
        <form id="pageContentForm" action="{{ route('admin.developer.page-contents.update', $page) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            @include('admin.developer.page-contents.forms.' . $page)

            <hr>

            <div class="form-group row">
                <div class="col-sm-12">
                    <button type="button" id="submitBtn" class="btn btn-primary btn-lg">
                        <i class="fas fa-save"></i> Enregistrer les modifications
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Modal de Confirmation --}}
<div class="modal fade" id="confirmationModal" tabindex="-1" role="dialog" aria-labelledby="confirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header bg-warning text-white">
                <h5 class="modal-title" id="confirmationModalLabel">
                    <i class="fas fa-exclamation-triangle"></i> Confirmer les Modifications
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="alert alert-info">
                    <i class="fas fa-info-circle"></i> Vous êtes sur le point de modifier <strong id="changesCount">0</strong> champ(s).
                </div>
                
                <h6 class="text-primary mb-3"><i class="fas fa-list"></i> Liste des modifications :</h6>
                <div id="changesList" class="border rounded p-3 bg-light" style="max-height: 400px; overflow-y: auto;">
                    <!-- La liste des changements sera insérée ici -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Annuler
                </button>
                <button type="button" id="confirmSubmitBtn" class="btn btn-success">
                    <i class="fas fa-check"></i> Confirmer et Enregistrer
                </button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('pageContentForm');
    const submitBtn = document.getElementById('submitBtn');
    const confirmSubmitBtn = document.getElementById('confirmSubmitBtn');
    
    if (!form || !submitBtn || !confirmSubmitBtn) {
        console.error('Erreur: éléments du formulaire introuvables');
        return;
    }
    
    // Stocker les valeurs initiales
    const initialValues = new Map();
    
    // Capturer les valeurs initiales de tous les champs
    function captureInitialValues() {
        const formElements = form.querySelectorAll('input, textarea, select');
        formElements.forEach(element => {
            if (element.type === 'file') {
                initialValues.set(element.id || element.name, '');
            } else if (element.type === 'checkbox' || element.type === 'radio') {
                initialValues.set(element.id || element.name, element.checked);
            } else {
                initialValues.set(element.id || element.name, element.value || '');
            }
        });
    }
    
    // Détecter les changements
    function detectChanges() {
        const changes = [];
        const formElements = form.querySelectorAll('input, textarea, select');
        
        formElements.forEach(element => {
            const key = element.id || element.name;
            const label = getLabelForField(element);
            
            if (element.type === 'file') {
                if (element.files && element.files.length > 0) {
                    changes.push({
                        label: label,
                        oldValue: 'Aucun fichier',
                        newValue: element.files[0].name,
                        type: 'file'
                    });
                }
            } else if (element.type === 'checkbox' || element.type === 'radio') {
                const initialValue = initialValues.get(key);
                if (element.checked !== initialValue) {
                    changes.push({
                        label: label,
                        oldValue: initialValue ? 'Activé' : 'Désactivé',
                        newValue: element.checked ? 'Activé' : 'Désactivé',
                        type: 'checkbox'
                    });
                }
            } else {
                const initialValue = initialValues.get(key) || '';
                const currentValue = element.value || '';
                
                if (currentValue !== initialValue && key !== '_token' && key !== '_method') {
                    changes.push({
                        label: label,
                        oldValue: truncateText(initialValue, 100),
                        newValue: truncateText(currentValue, 100),
                        type: 'text'
                    });
                }
            }
        });
        
        return changes;
    }
    
    // Trouver le label associé à un champ
    function getLabelForField(element) {
        const id = element.id;
        if (id) {
            const label = document.querySelector(`label[for="${id}"]`);
            if (label) {
                return label.textContent.trim();
            }
        }
        return element.name || element.id || 'Champ inconnu';
    }
    
    // Tronquer le texte
    function truncateText(text, maxLength) {
        if (!text) return '(vide)';
        text = text.toString();
        if (text.length <= maxLength) return text;
        return text.substring(0, maxLength) + '...';
    }
    
    // Afficher les changements dans la modale
    function displayChanges(changes) {
        const changesList = document.getElementById('changesList');
        const changesCount = document.getElementById('changesCount');
        
        changesCount.textContent = changes.length;
        
        if (changes.length === 0) {
            changesList.innerHTML = '<p class="text-muted mb-0"><i class="fas fa-info-circle"></i> Aucune modification détectée.</p>';
            return;
        }
        
        let html = '<div class="list-group">';
        changes.forEach((change, index) => {
            html += `
                <div class="list-group-item">
                    <div class="d-flex w-100 justify-content-between">
                        <h6 class="mb-1 text-primary">
                            <i class="fas fa-edit"></i> ${change.label}
                        </h6>
                        <small class="text-muted">#${index + 1}</small>
                    </div>
                    <div class="row mt-2">
                        <div class="col-md-6">
                            <small class="text-muted">Avant :</small>
                            <p class="mb-0 font-weight-normal text-danger">${escapeHtml(change.oldValue)}</p>
                        </div>
                        <div class="col-md-6">
                            <small class="text-muted">Après :</small>
                            <p class="mb-0 font-weight-bold text-success">${escapeHtml(change.newValue)}</p>
                        </div>
                    </div>
                </div>
            `;
        });
        html += '</div>';
        
        changesList.innerHTML = html;
    }
    
    // Échapper le HTML
    function escapeHtml(text) {
        const div = document.createElement('div');
        div.textContent = text;
        return div.innerHTML;
    }
    
    // Gérer le clic sur "Enregistrer"
    submitBtn.addEventListener('click', function(e) {
        e.preventDefault();
        
        const changes = detectChanges();
        displayChanges(changes);
        
        if (changes.length === 0) {
            alert('Aucune modification détectée. Rien à enregistrer.');
            return;
        }
        
        $('#confirmationModal').modal('show');
    });
    
    // Gérer la confirmation
    confirmSubmitBtn.addEventListener('click', function() {
        $('#confirmationModal').modal('hide');
        form.submit();
    });
    
    // Capturer les valeurs initiales au chargement
    captureInitialValues();
});
</script>
@endsection

