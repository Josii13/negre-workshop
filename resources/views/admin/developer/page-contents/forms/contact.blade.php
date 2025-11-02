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
    <label for="banner_background">Image de fond (URL ou chemin)</label>
    <input type="text" class="form-control" id="banner_background" name="banner_background" value="{{ $content->banner_background ?? '' }}">
</div>

<hr class="my-4">

{{-- Contact Info --}}
<h5 class="text-primary">Informations de Contact</h5>
<div class="form-group">
    <label for="info_title">Titre de la Section</label>
    <input type="text" class="form-control" id="info_title" name="info_title" value="{{ $content->info_title ?? '' }}">
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="info_email">Email</label>
        <input type="email" class="form-control" id="info_email" name="info_email" value="{{ $content->info_email ?? '' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="info_phone">Téléphone</label>
        <input type="text" class="form-control" id="info_phone" name="info_phone" value="{{ $content->info_phone ?? '' }}">
    </div>
</div>
<div class="form-group">
    <label for="info_address">Adresse</label>
    <input type="text" class="form-control" id="info_address" name="info_address" value="{{ $content->info_address ?? '' }}">
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="info_city">Ville</label>
        <input type="text" class="form-control" id="info_city" name="info_city" value="{{ $content->info_city ?? '' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="info_country">Pays</label>
        <input type="text" class="form-control" id="info_country" name="info_country" value="{{ $content->info_country ?? '' }}">
    </div>
</div>

<hr class="my-4">

{{-- Social Media --}}
<h5 class="text-primary">Réseaux Sociaux</h5>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="social_facebook">Facebook (URL complète)</label>
        <input type="url" class="form-control" id="social_facebook" name="social_facebook" value="{{ $content->social_facebook ?? '' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="social_instagram">Instagram (URL complète)</label>
        <input type="url" class="form-control" id="social_instagram" name="social_instagram" value="{{ $content->social_instagram ?? '' }}">
    </div>
</div>
<div class="form-row">
    <div class="form-group col-md-6">
        <label for="social_twitter">Twitter (URL complète)</label>
        <input type="url" class="form-control" id="social_twitter" name="social_twitter" value="{{ $content->social_twitter ?? '' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="social_linkedin">LinkedIn (URL complète)</label>
        <input type="url" class="form-control" id="social_linkedin" name="social_linkedin" value="{{ $content->social_linkedin ?? '' }}">
    </div>
</div>

<hr class="my-4">

{{-- Form Section --}}
<h5 class="text-primary">Section Formulaire</h5>
<div class="form-group">
    <label for="form_title">Titre du Formulaire</label>
    <input type="text" class="form-control" id="form_title" name="form_title" value="{{ $content->form_title ?? '' }}">
</div>
<div class="form-group">
    <label for="form_description">Description</label>
    <textarea class="form-control" id="form_description" name="form_description" rows="2">{{ $content->form_description ?? '' }}</textarea>
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

