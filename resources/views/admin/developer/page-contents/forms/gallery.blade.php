{{-- Informations de Gallery Section --}}
<div class="card mb-4 border-info">
    <div class="card-header bg-info text-white d-flex justify-content-between align-items-center">
        <h5 class="mb-0"><i class="fas fa-info-circle"></i> Informations de Gallery (Page d'accueil)</h5>
    </div>
    <div class="card-body">
        <p class="text-muted">Ces informations sont affichées sur la page d'accueil dans la carte Gallery</p>
        
        <div class="form-group">
            <label for="gallery_name">Nom de la section</label>
            <input type="text" class="form-control" id="gallery_name" name="gallery_name" value="{{ $content->gallery_name ?? 'Gallery' }}">
            <small class="form-text text-muted">Le nom affiché sur la carte de la page d'accueil</small>
        </div>

        <div class="form-group">
            <label for="gallery_description">Description courte</label>
            <textarea class="form-control" id="gallery_description" name="gallery_description" rows="2">{{ $content->gallery_description ?? 'NÈGRE Workshop - Espace créatif' }}</textarea>
            <small class="form-text text-muted">La description affichée sur la carte de la page d'accueil</small>
        </div>

        <div class="form-group">
            <label for="gallery_image_file">Image de la carte (Page d'accueil)</label>
            @if(isset($content->gallery_image) && $content->gallery_image)
            <div class="mb-3">
                <img id="gallery_image_preview" 
                     src="{{ asset('storage/' . $content->gallery_image) }}" 
                     alt="Gallery Card Image" 
                     class="img-thumbnail" 
                     style="max-height: 200px; object-fit: cover;">
            </div>
            @else
            <div class="mb-3">
                <img id="gallery_image_preview" 
                     src="{{ asset('images/img1.jpg') }}" 
                     alt="Gallery Card Image" 
                     class="img-thumbnail" 
                     style="max-height: 200px; object-fit: cover;">
            </div>
            @endif
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="gallery_image_file" name="gallery_image_file" accept="image/*" onchange="previewGalleryImage(event)">
                <label class="custom-file-label" for="gallery_image_file">Choisir une nouvelle image...</label>
            </div>
            <small class="form-text text-muted">Format accepté : JPG, PNG, GIF, WEBP (max 2MB). Cette image sera affichée sur la carte Gallery de la page d'accueil.</small>
            <input type="hidden" name="gallery_image_current" value="{{ $content->gallery_image ?? '' }}">
        </div>
    </div>
</div>

<script>
function previewGalleryImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('gallery_image_preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
        const fileName = file.name;
        const label = event.target.nextElementSibling;
        label.textContent = fileName;
    }
}
</script>

<hr class="my-4">

{{-- Banner Section --}}
<h5 class="text-primary">Section Bannière</h5>
<div class="form-group">
    <label for="banner_title">Titre Principal</label>
    <input type="text" class="form-control" id="banner_title" name="banner_title" value="{{ $content->banner_title ?? '' }}" required>
</div>
<div class="form-group">
    <label for="banner_subtitle">Sous-titre</label>
    <input type="text" class="form-control" id="banner_subtitle" name="banner_subtitle" value="{{ $content->banner_subtitle ?? '' }}">
</div>
<div class="form-group">
    <label for="banner_description">Description</label>
    <textarea class="form-control" id="banner_description" name="banner_description" rows="3">{{ $content->banner_description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="banner_quote">Citation/Quote</label>
    <textarea class="form-control" id="banner_quote" name="banner_quote" rows="4">{{ $content->banner_quote ?? '' }}</textarea>
    <small class="form-text text-muted">Texte descriptif de l'atelier</small>
</div>
<div class="form-group">
    <label for="banner_background_file">Image de fond de la bannière</label>
    @if(isset($content->banner_background) && $content->banner_background)
    <div class="mb-3">
        <img id="banner_background_preview" 
             src="{{ asset('images/' . $content->banner_background) }}" 
             alt="Banner Background" 
             class="img-thumbnail" 
             style="max-height: 200px; object-fit: cover;">
    </div>
    @else
    <div class="mb-3">
        <img id="banner_background_preview" 
             src="{{ asset('images/img1.jpg') }}" 
             alt="Banner Background" 
             class="img-thumbnail" 
             style="max-height: 200px; object-fit: cover;">
    </div>
    @endif
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="banner_background_file" name="banner_background_file" accept="image/*" onchange="previewBannerBackground(event)">
        <label class="custom-file-label" for="banner_background_file">Choisir une nouvelle image...</label>
    </div>
    <small class="form-text text-muted">Format accepté : JPG, PNG, GIF, WEBP (max 2MB). Cette image sera affichée en arrière-plan de la bannière.</small>
    <input type="hidden" name="banner_background_current" value="{{ $content->banner_background ?? '' }}">
</div>

<script>
function previewBannerBackground(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('banner_background_preview').src = e.target.result;
        }
        reader.readAsDataURL(file);
        const fileName = file.name;
        const label = event.target.nextElementSibling;
        label.textContent = fileName;
    }
}
</script>

<hr class="my-4">

{{-- Tabs Section --}}
<h5 class="text-primary">Onglets de Navigation</h5>
<div class="form-row">
    <div class="form-group col-md-3">
        <label for="tab_atelier">Onglet 1</label>
        <input type="text" class="form-control" id="tab_atelier" name="tab_atelier" value="{{ $content->tab_atelier ?? '' }}">
    </div>
    <div class="form-group col-md-3">
        <label for="tab_activites">Onglet 2</label>
        <input type="text" class="form-control" id="tab_activites" name="tab_activites" value="{{ $content->tab_activites ?? '' }}">
    </div>
    <div class="form-group col-md-3">
        <label for="tab_evenements">Onglet 3</label>
        <input type="text" class="form-control" id="tab_evenements" name="tab_evenements" value="{{ $content->tab_evenements ?? '' }}">
    </div>
    <div class="form-group col-md-3">
        <label for="tab_podcasts">Onglet 4</label>
        <input type="text" class="form-control" id="tab_podcasts" name="tab_podcasts" value="{{ $content->tab_podcasts ?? '' }}">
    </div>
</div>

<hr class="my-4">

{{-- Activity Modal Section --}}
<h5 class="text-primary">Modal de Détails d'Activité</h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="modal_details_title">Titre de la section</label>
        <input type="text" class="form-control" id="modal_details_title" name="modal_details_title" value="{{ $content->modal_details_title ?? 'Détails' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="modal_button_whatsapp">Texte du bouton WhatsApp</label>
        <input type="text" class="form-control" id="modal_button_whatsapp" name="modal_button_whatsapp" value="{{ $content->modal_button_whatsapp ?? 'Réserver sur WhatsApp' }}">
    </div>
</div>

<h6 class="text-secondary mt-3">Labels des Caractéristiques d'Activité</h6>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="modal_label_type">Label "Type"</label>
        <input type="text" class="form-control" id="modal_label_type" name="modal_label_type" value="{{ $content->modal_label_type ?? 'Type' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="modal_label_frequency">Label "Fréquence"</label>
        <input type="text" class="form-control" id="modal_label_frequency" name="modal_label_frequency" value="{{ $content->modal_label_frequency ?? 'Fréquence' }}">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="modal_label_capacity">Label "Capacité"</label>
        <input type="text" class="form-control" id="modal_label_capacity" name="modal_label_capacity" value="{{ $content->modal_label_capacity ?? 'Capacité' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="modal_label_audience">Label "Public"</label>
        <input type="text" class="form-control" id="modal_label_audience" name="modal_label_audience" value="{{ $content->modal_label_audience ?? 'Public' }}">
    </div>
</div>

<hr class="my-4">

{{-- WhatsApp Configuration --}}
<h5 class="text-primary">Configuration WhatsApp</h5>
<div class="form-group">
    <label for="whatsapp_message_template">Template de Message WhatsApp</label>
    <textarea class="form-control" id="whatsapp_message_template" name="whatsapp_message_template" rows="3">{{ $content->whatsapp_message_template ?? 'Bonjour, je souhaite réserver : {activity_title}' }}</textarea>
    <small class="form-text text-muted">
        Variables disponibles : {activity_title}<br>
        Exemple : "Bonjour, je souhaite réserver : {activity_title}"
    </small>
</div>

<hr class="my-4">

{{-- SEO Section --}}
<h5 class="text-primary">SEO Meta Tags</h5>
<div class="form-group">
    <label for="meta_title">Meta Title</label>
    <input type="text" class="form-control" id="meta_title" name="meta_title" value="{{ $content->meta_title ?? '' }}">
</div>
<div class="form-group">
    <label for="meta_description">Meta Description</label>
    <textarea class="form-control" id="meta_description" name="meta_description" rows="2">{{ $content->meta_description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="meta_keywords">Meta Keywords</label>
    <input type="text" class="form-control" id="meta_keywords" name="meta_keywords" value="{{ $content->meta_keywords ?? '' }}">
</div>

