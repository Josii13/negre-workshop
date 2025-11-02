{{-- Banner Section --}}
<h5 class="text-primary">Section Bannière</h5>
<div class="form-group">
    <label for="banner_default_description">Description par Défaut</label>
    <textarea class="form-control" id="banner_default_description" name="banner_default_description" rows="3">{{ $content->banner_default_description ?? '' }}</textarea>
    <small class="form-text text-muted">Utilisée quand aucune catégorie n'est sélectionnée</small>
</div>
<div class="form-group">
    <label for="banner_background_file">Image de fond de la bannière</label>
    
    @if(isset($content->banner_background) && $content->banner_background)
        <div class="mb-3">
            <img id="current_banner_preview" src="{{ asset('images/' . $content->banner_background) }}" alt="Banner Background actuel" style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
        </div>
    @endif
    
    <input type="file" class="form-control" id="banner_background_file" name="banner_background_file" accept="image/*" onchange="previewBannerImage(event)">
    <input type="hidden" name="banner_background_current" value="{{ $content->banner_background ?? '' }}">
    
    <div id="banner_preview_container" class="mt-3" style="display: none;">
        <p class="text-muted">Aperçu de la nouvelle image :</p>
        <img id="banner_preview" src="" alt="Aperçu" style="max-width: 300px; max-height: 200px; border: 1px solid #ddd; border-radius: 4px;">
    </div>
    
    <small class="form-text text-muted">Formats acceptés : JPG, PNG, GIF, WEBP (max 2MB)</small>
</div>

<script>
function previewBannerImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('banner_preview').src = e.target.result;
            document.getElementById('banner_preview_container').style.display = 'block';
        }
        reader.readAsDataURL(file);
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
    <label for="product_button_whatsapp">Texte du bouton WhatsApp</label>
    <input type="text" class="form-control" id="product_button_whatsapp" name="product_button_whatsapp" value="{{ $content->product_button_whatsapp ?? 'Commander sur WhatsApp' }}">
    <small class="form-text text-muted">Texte affiché sur le bouton WhatsApp des cartes produits</small>
</div>

<hr class="my-4">

{{-- Detail Modal Section --}}
<h5 class="text-primary">Modal de Détails du Produit</h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="detail_button_whatsapp">Texte du bouton WhatsApp</label>
        <input type="text" class="form-control" id="detail_button_whatsapp" name="detail_button_whatsapp" value="{{ $content->detail_button_whatsapp ?? 'Commander sur WhatsApp' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="detail_characteristics_title">Titre de la section caractéristiques</label>
        <input type="text" class="form-control" id="detail_characteristics_title" name="detail_characteristics_title" value="{{ $content->detail_characteristics_title ?? 'Caractéristiques' }}">
    </div>
</div>

<h6 class="text-secondary mt-3">Labels des Caractéristiques</h6>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="detail_label_material">Label "Matière"</label>
        <input type="text" class="form-control" id="detail_label_material" name="detail_label_material" value="{{ $content->detail_label_material ?? 'Matière' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="detail_label_color">Label "Tailles/Couleurs"</label>
        <input type="text" class="form-control" id="detail_label_color" name="detail_label_color" value="{{ $content->detail_label_color ?? 'Tailles disponibles' }}">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="detail_label_brand">Label "Style/Marque"</label>
        <input type="text" class="form-control" id="detail_label_brand" name="detail_label_brand" value="{{ $content->detail_label_brand ?? 'Style' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="detail_label_availability">Label "Collection/Disponibilité"</label>
        <input type="text" class="form-control" id="detail_label_availability" name="detail_label_availability" value="{{ $content->detail_label_availability ?? 'Collection' }}">
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
        <label for="order_button_whatsapp">Texte bouton "Continuer sur WhatsApp"</label>
        <input type="text" class="form-control" id="order_button_whatsapp" name="order_button_whatsapp" value="{{ $content->order_button_whatsapp ?? 'Continuer sur WhatsApp' }}">
    </div>
</div>

<hr class="my-4">

{{-- WhatsApp --}}
<h5 class="text-primary">Configuration WhatsApp</h5>
<div class="form-group">
    <label for="whatsapp_message_template">Template de Message WhatsApp</label>
    <textarea class="form-control" id="whatsapp_message_template" name="whatsapp_message_template" rows="3">{{ $content->whatsapp_message_template ?? '' }}</textarea>
    <small class="form-text text-muted">
        Variables disponibles : {product_name}, {product_price}<br>
        Exemple : "Bonjour, je souhaite commander {product_name} au prix de {product_price}"
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

