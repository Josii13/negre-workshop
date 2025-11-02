{{-- Formulaire pour éditer les textes des modales --}}

{{-- Modal de Détails --}}
<h5 class="text-primary">Modal de Détails (Produits/Activités)</h5>
<div class="form-group">
    <label for="detail_characteristics_title">Titre de la Section Caractéristiques</label>
    <input type="text" class="form-control" id="detail_characteristics_title" name="detail_characteristics_title" value="{{ $content->detail_characteristics_title ?? '' }}">
    <small class="form-text text-muted">Exemple : "Caractéristiques", "Détails", "Informations"</small>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="detail_button_order">Bouton Commander</label>
        <input type="text" class="form-control" id="detail_button_order" name="detail_button_order" value="{{ $content->detail_button_order ?? '' }}">
        <small class="form-text text-muted">Pour produits</small>
    </div>
    <div class="form-group col-md-6">
        <label for="detail_button_reserve">Bouton WhatsApp</label>
        <input type="text" class="form-control" id="detail_button_reserve" name="detail_button_reserve" value="{{ $content->detail_button_reserve ?? '' }}">
        <small class="form-text text-muted">Pour activités</small>
    </div>
</div>

<hr class="my-4">

{{-- Modal de Commande --}}
<h5 class="text-primary">Modal de Commande</h5>
<div class="form-group">
    <label for="order_title">Titre du Modal</label>
    <input type="text" class="form-control" id="order_title" name="order_title" value="{{ $content->order_title ?? '' }}">
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="order_label_name">Label Champ Nom</label>
        <input type="text" class="form-control" id="order_label_name" name="order_label_name" value="{{ $content->order_label_name ?? '' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="order_label_email">Label Champ Email</label>
        <input type="text" class="form-control" id="order_label_email" name="order_label_email" value="{{ $content->order_label_email ?? '' }}">
    </div>
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="order_label_phone">Label Champ Téléphone</label>
        <input type="text" class="form-control" id="order_label_phone" name="order_label_phone" value="{{ $content->order_label_phone ?? '' }}">
    </div>
    <div class="form-group col-md-6">
        <label for="order_label_message">Label Champ Message</label>
        <input type="text" class="form-control" id="order_label_message" name="order_label_message" value="{{ $content->order_label_message ?? '' }}">
    </div>
</div>

<div class="form-group">
    <label for="order_button_submit">Texte du Bouton Envoyer</label>
    <input type="text" class="form-control" id="order_button_submit" name="order_button_submit" value="{{ $content->order_button_submit ?? '' }}">
</div>

<hr class="my-4">

{{-- Messages de Succès/Chargement --}}
<h5 class="text-primary">Messages de Feedback</h5>
<div class="form-group">
    <label for="success_message">Message de Succès</label>
    <textarea class="form-control" id="success_message" name="success_message" rows="2">{{ $content->success_message ?? '' }}</textarea>
</div>

<div class="form-group">
    <label for="success_submessage">Sous-message de Succès</label>
    <textarea class="form-control" id="success_submessage" name="success_submessage" rows="2">{{ $content->success_submessage ?? '' }}</textarea>
</div>

<div class="form-group">
    <label for="loading_title">Titre du Chargement</label>
    <input type="text" class="form-control" id="loading_title" name="loading_title" value="{{ $content->loading_title ?? '' }}">
</div>

<div class="form-group">
    <label for="loading_message">Message de Chargement</label>
    <textarea class="form-control" id="loading_message" name="loading_message" rows="2">{{ $content->loading_message ?? '' }}</textarea>
</div>

