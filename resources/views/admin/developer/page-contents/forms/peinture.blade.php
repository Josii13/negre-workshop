{{-- Banner Section --}}
<h5 class="text-primary">Section Bannière</h5>
<div class="form-group">
    <label for="banner_title">Titre de la Bannière</label>
    <input type="text" class="form-control" id="banner_title" name="banner_title" value="{{ $content->banner_title ?? '' }}" required>
</div>
<div class="form-group">
    <label for="banner_description">Description</label>
    <textarea class="form-control" id="banner_description" name="banner_description" rows="3">{{ $content->banner_description ?? '' }}</textarea>
</div>
<div class="form-group">
    <label for="banner_background_file">Image de fond de la Bannière</label>
    
    {{-- Prévisualisation de l'image actuelle --}}
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
        <div id="banner_background_preview_placeholder" class="alert alert-info">
            <i class="fas fa-image"></i> Aucune image de fond définie
        </div>
    </div>
    @endif
    
    {{-- Champ d'upload --}}
    <div class="custom-file">
        <input type="file" class="custom-file-input" id="banner_background_file" name="banner_background_file" accept="image/*" onchange="previewBannerBackground(event)">
        <label class="custom-file-label" for="banner_background_file">Choisir une image de fond...</label>
    </div>
    <small class="form-text text-muted">Format accepté : JPG, PNG, GIF, WEBP (max 2MB). Cette image sera utilisée en arrière-plan de la bannière.</small>
    
    {{-- Champ caché pour conserver l'ancienne valeur --}}
    <input type="hidden" name="banner_background_current" value="{{ $content->banner_background ?? '' }}">
</div>

<script>
function previewBannerBackground(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            // Vérifier si l'élément preview existe
            let previewImg = document.getElementById('banner_background_preview');
            const placeholder = document.getElementById('banner_background_preview_placeholder');
            
            if (!previewImg) {
                // Créer l'élément img si il n'existe pas
                if (placeholder) {
                    placeholder.parentElement.innerHTML = '<img id="banner_background_preview" src="" alt="Banner Background" class="img-thumbnail" style="max-height: 200px; object-fit: cover;">';
                    previewImg = document.getElementById('banner_background_preview');
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
</script>

<hr class="my-4">

{{-- Introduction --}}
<h5 class="text-primary">Section Introduction</h5>
<div class="form-group">
    <label for="intro_title">Titre</label>
    <input type="text" class="form-control" id="intro_title" name="intro_title" value="{{ $content->intro_title ?? '' }}">
</div>
<div class="form-group">
    <label for="intro_text">Texte Intro</label>
    <textarea class="form-control" id="intro_text" name="intro_text" rows="4">{{ $content->intro_text ?? '' }}</textarea>
</div>

<hr class="my-4">

{{-- Grid Section --}}
<h5 class="text-primary">Section Grille de Produits</h5>
<div class="form-group">
    <label for="grid_title">Titre de la Grille</label>
    <input type="text" class="form-control" id="grid_title" name="grid_title" value="{{ $content->grid_title ?? '' }}">
</div>
<div class="form-group">
    <label for="grid_subtitle">Sous-titre</label>
    <input type="text" class="form-control" id="grid_subtitle" name="grid_subtitle" value="{{ $content->grid_subtitle ?? '' }}">
</div>

<hr class="my-4">

{{-- Product Cards Section --}}
<h5 class="text-primary">Boutons & Labels des Cartes Produits</h5>
<div class="form-group">
    <label for="product_button_order">Texte du bouton "Commander"</label>
    <input type="text" class="form-control" id="product_button_order" name="product_button_order" value="{{ $content->product_button_order ?? 'Commander' }}">
    <small class="form-text text-muted">Texte affiché sur le bouton de commande des cartes produits</small>
</div>

<hr class="my-4">

{{-- Detail Modal Section --}}
<h5 class="text-primary">Modal de Détails du Produit</h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="detail_button_order">Texte du bouton de commande</label>
        <input type="text" class="form-control" id="detail_button_order" name="detail_button_order" value="{{ $content->detail_button_order ?? 'Commander cette œuvre' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="detail_characteristics_title">Titre de la section caractéristiques</label>
        <input type="text" class="form-control" id="detail_characteristics_title" name="detail_characteristics_title" value="{{ $content->detail_characteristics_title ?? 'Caractéristiques' }}">
    </div>
</div>

<h6 class="text-secondary mt-3">Labels des Caractéristiques</h6>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="detail_label_dimensions">Label "Dimensions"</label>
        <input type="text" class="form-control" id="detail_label_dimensions" name="detail_label_dimensions" value="{{ $content->detail_label_dimensions ?? 'Dimensions' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="detail_label_technique">Label "Technique"</label>
        <input type="text" class="form-control" id="detail_label_technique" name="detail_label_technique" value="{{ $content->detail_label_technique ?? 'Technique' }}">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="detail_label_support">Label "Support"</label>
        <input type="text" class="form-control" id="detail_label_support" name="detail_label_support" value="{{ $content->detail_label_support ?? 'Support' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="detail_label_year">Label "Année"</label>
        <input type="text" class="form-control" id="detail_label_year" name="detail_label_year" value="{{ $content->detail_label_year ?? 'Année' }}">
    </div>
</div>

<hr class="my-4">

{{-- Order Modal Section --}}
<h5 class="text-primary">Modal de Commande</h5>
<div class="form-group">
    <label for="order_title">Titre du modal</label>
    <input type="text" class="form-control" id="order_title" name="order_title" value="{{ $content->order_title ?? 'Commander' }}">
</div>

<h6 class="text-secondary mt-3">Labels des Champs du Formulaire</h6>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="order_label_name">Label "Nom"</label>
        <input type="text" class="form-control" id="order_label_name" name="order_label_name" value="{{ $content->order_label_name ?? 'Nom' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="order_label_email">Label "Email"</label>
        <input type="text" class="form-control" id="order_label_email" name="order_label_email" value="{{ $content->order_label_email ?? 'Email' }}">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="order_label_phone">Label "Téléphone"</label>
        <input type="text" class="form-control" id="order_label_phone" name="order_label_phone" value="{{ $content->order_label_phone ?? 'Téléphone' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="order_label_message">Label "Message"</label>
        <input type="text" class="form-control" id="order_label_message" name="order_label_message" value="{{ $content->order_label_message ?? 'Message' }}">
    </div>
</div>

<h6 class="text-secondary mt-3">Boutons du Modal de Commande</h6>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="order_button_submit">Texte bouton "Commander via Email"</label>
        <input type="text" class="form-control" id="order_button_submit" name="order_button_submit" value="{{ $content->order_button_submit ?? 'Commander via Email' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="order_button_whatsapp">Texte bouton "WhatsApp"</label>
        <input type="text" class="form-control" id="order_button_whatsapp" name="order_button_whatsapp" value="{{ $content->order_button_whatsapp ?? 'Continuer sur WhatsApp' }}">
    </div>
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

