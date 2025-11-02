<div class="form-group">
    <label for="title">Titre *</label>
    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title" name="title" value="{{ old('title', $carousel->title ?? '') }}" required>
    @error('title')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="subtitle">Sous-titre</label>
    <input type="text" class="form-control @error('subtitle') is-invalid @enderror" id="subtitle" name="subtitle" value="{{ old('subtitle', $carousel->subtitle ?? '') }}">
    @error('subtitle')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="description">Description</label>
    <textarea class="form-control @error('description') is-invalid @enderror" id="description" name="description" rows="3">{{ old('description', $carousel->description ?? '') }}</textarea>
    @error('description')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="form-group">
    <label for="image">Image{{ isset($carousel) ? '' : ' *' }}</label>
    @if(isset($carousel) && $carousel->image)
        <div class="mb-2">
            <img src="{{ asset('images/' . $carousel->image) }}" alt="{{ $carousel->title }}" style="max-width: 300px; height: auto;" class="img-thumbnail">
        </div>
    @endif
    <input type="file" class="form-control-file @error('image') is-invalid @enderror" id="image" name="image" accept="image/*" {{ isset($carousel) ? '' : 'required' }}>
    <small class="form-text text-muted">Format: JPEG, PNG, JPG, GIF, WEBP - Max: 2MB</small>
    @error('image')
        <div class="invalid-feedback d-block">{{ $message }}</div>
    @enderror
</div>

<div class="form-row">
    <div class="form-group col-md-6">
        <label for="order">Ordre d'affichage *</label>
        <input type="number" class="form-control @error('order') is-invalid @enderror" id="order" name="order" value="{{ old('order', $carousel->order ?? 0) }}" min="0" required>
        <small class="form-text text-muted">Les slides avec un ordre inférieur seront affichés en premier</small>
        @error('order')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="form-group col-md-6">
        <div class="custom-control custom-checkbox mt-4">
            <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" value="1" {{ old('is_active', $carousel->is_active ?? true) ? 'checked' : '' }}>
            <label class="custom-control-label" for="is_active">Slide actif</label>
        </div>
        <small class="form-text text-muted">Seuls les slides actifs seront affichés</small>
    </div>
</div>

