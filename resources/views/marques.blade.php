@extends('layouts.app')

@section('title', 'Marque - Frederic N\'DA')

@section('styles')
<style>
    /* Styles spécifiques à la page Marques */

    /* Cards de produits améliorées */
    .product-card {
        background: #FFFFFF;
        border-radius: 12px;
        overflow: hidden;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        position: relative;
    }

    .product-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.15);
    }

    .product-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #25D366, #1DA851);
        transform: scaleX(0);
        transition: transform 0.4s ease;
    }

    .product-card:hover::before {
        transform: scaleX(1);
    }

    .product-image {
        position: relative;
        overflow: hidden;
        background: #F8F8F8;
        aspect-ratio: 1;
    }

    .product-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image img {
        transform: scale(1.08);
    }

    .product-image::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.02) 100%);
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .product-card:hover .product-image::after {
        opacity: 1;
    }

    .view-eye {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0);
        width: 56px;
        height: 56px;
        background-color: rgba(255, 255, 255, 0.98);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.2);
        z-index: 5;
        backdrop-filter: blur(8px);
    }

    .product-card:hover .view-eye {
        transform: translate(-50%, -50%) scale(1);
    }

    .view-eye:hover {
        background-color: #25D366;
        transform: translate(-50%, -50%) scale(1.1);
        box-shadow: 0 12px 32px rgba(37, 211, 102, 0.3);
    }

    .view-eye svg {
        width: 26px;
        height: 26px;
        stroke: #000000;
        transition: stroke 0.3s ease;
    }

    .view-eye:hover svg {
        stroke: #FFFFFF;
    }

    .product-info {
        padding: 1.5rem;
    }

    .product-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        margin-bottom: 1.25rem;
        gap: 1rem;
    }

    .product-header h3 {
        font-size: 1.1rem;
        font-weight: 500;
        color: #1a1a1a;
        line-height: 1.4;
        letter-spacing: -0.01em;
        margin: 0;
    }

    .product-price {
        font-size: 1.05rem;
        font-weight: 700;
        color: #000000;
        white-space: nowrap;
        padding: 0.4rem 0.8rem;
        background: #F8F8F8;
        border-radius: 6px;
        letter-spacing: -0.02em;
    }

    .product-btn {
        width: 100%;
        padding: 0.85rem 1.5rem;
        background: #25D366;
        color: #FFFFFF;
        border: 2px solid #25D366;
        border-radius: 8px;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
        letter-spacing: 0.02em;
    }

    .product-btn:hover {
        background: #1DA851;
        border-color: #1DA851;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }

    .product-btn:active {
        transform: translateY(0);
    }

    .whatsapp-btn {
        background-color: #25D366;
        border-color: #25D366;
    }

    .whatsapp-btn:hover {
        background-color: #1DA851;
        border-color: #1DA851;
    }

    .brand-description {
        margin-top: 2rem;
        padding: 2rem;
        background-color: #FAFAFA;
        border-left: 3px solid #25D366;
        border-radius: 4px;
    }

    .brand-description p {
        font-size: 1rem;
        line-height: 1.8;
        color: black;
        font-weight: 300;
        margin: 0;
    }

    /* Barre de recherche */
    .search-container {
        max-width: 600px;
        margin: 0 auto 3rem;
        position: relative;
    }

    .search-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-input {
        width: 100%;
        padding: 1rem 3rem 1rem 1.5rem;
        border: 2px solid #E5E5E5;
        border-radius: 50px;
        font-size: 1rem;
        transition: all 0.3s ease;
        outline: none;
    }

    .search-input:focus {
        border-color: #25D366;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.15);
    }

    .search-icon {
        position: absolute;
        right: 1.5rem;
        color: black;
        pointer-events: none;
    }

    .clear-search {
        position: absolute;
        right: 3.5rem;
        background: none;
        border: none;
        color: #999;
        cursor: pointer;
        font-size: 1.2rem;
        display: none;
        padding: 0.5rem;
        transition: color 0.3s ease;
    }

    .clear-search.active {
        display: block;
    }

    .clear-search:hover {
        color: #25D366;
    }

    .autocomplete-results {
        position: absolute;
        top: calc(100% + 0.5rem);
        left: 0;
        right: 0;
        background: white;
        border: 1px solid #E5E5E5;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.12);
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .autocomplete-results.active {
        display: block;
    }

    .autocomplete-item {
        padding: 1rem 1.5rem;
        cursor: pointer;
        transition: background-color 0.2s ease;
        border-bottom: 1px solid #F5F5F5;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .autocomplete-item:last-child {
        border-bottom: none;
    }

    .autocomplete-item:hover {
        background-color: #F9F9F9;
    }

    .autocomplete-item-image {
        width: 50px;
        height: 50px;
        object-fit: cover;
        border-radius: 6px;
        flex-shrink: 0;
    }

    .autocomplete-item-info {
        flex: 1;
    }

    .autocomplete-item-name {
        font-weight: 500;
        color: #000;
        margin-bottom: 0.25rem;
    }

    .autocomplete-item-price {
        font-size: 0.9rem;
        color: black;
    }

    .no-results {
        padding: 2rem;
        text-align: center;
        color: #999;
    }

    /* Modal de détails */
    .detail-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.85);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .detail-modal.active {
        display: flex;
    }

    .detail-modal-content {
        background-color: #FFFFFF;
        max-width: 1000px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        animation: slideUp 0.4s ease;
        border-radius: 8px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .detail-image-container {
        background-color: #F7F7F7;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        min-height: 400px;
    }

    .detail-image-container img {
        max-width: 100%;
        max-height: 600px;
        object-fit: contain;
    }

    .detail-info-container {
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .detail-close {
        position: absolute;
        top: 1rem;
        right: 1rem;
        background: rgba(255, 255, 255, 0.95);
        border: none;
        font-size: 1.5rem;
        cursor: pointer;
        color: #000;
        transition: all 0.3s ease;
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        z-index: 10;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
    }

    .detail-close:hover {
        background: #25D366;
        color: #FFFFFF;
        transform: rotate(90deg);
    }

    .detail-title {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 1rem;
        letter-spacing: -0.02em;
        color: #000;
    }

    .detail-price {
        font-size: 1.8rem;
        font-weight: 600;
        color: #000000;
        margin-bottom: 1.5rem;
        padding-bottom: 1.5rem;
        border-bottom: 2px solid #F0F0F0;
    }

    .detail-description {
        margin-bottom: 2rem;
        padding: 1.5rem;
        background-color: #FAFAFA;
        border-left: 3px solid #25D366;
        border-radius: 4px;
    }

    .detail-description p {
        font-size: 0.95rem;
        line-height: 1.7;
        color: #333;
        margin: 0;
    }

    .detail-characteristics {
        margin-bottom: 2rem;
    }

    .detail-characteristics h4 {
        font-size: 0.85rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.08em;
        color: black;
        margin-bottom: 1rem;
    }

    .characteristic-item {
        display: flex;
        justify-content: space-between;
        padding: 0.75rem 0;
        border-bottom: 1px solid #F0F0F0;
        gap: 1rem;
    }

    .characteristic-item:last-child {
        border-bottom: none;
    }

    .characteristic-label {
        color: black;
        font-size: 0.95rem;
        font-weight: 500;
    }

    .characteristic-value {
        font-weight: 400;
        font-size: 0.95rem;
        text-align: right;
        color: #000;
    }

    /* Modal de commande */
    .order-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.75);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 1rem;
    }

    .order-modal.active {
        display: flex;
    }

    .order-modal-content {
        background-color: #FFFFFF;
        max-width: 550px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        padding: 2.5rem;
        position: relative;
        animation: slideUp 0.4s ease;
        border-radius: 8px;
    }

    .order-modal h2 {
        font-size: 1.8rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        letter-spacing: -0.02em;
    }

    /* Responsive */
    @media (max-width: 992px) {
        .detail-modal-content {
            grid-template-columns: 1fr;
            max-height: 90vh;
        }

        .detail-image-container {
            min-height: 300px;
            padding: 1.5rem;
        }

        .detail-info-container {
            padding: 2rem;
        }

        .detail-title {
            font-size: 1.6rem;
        }

        .detail-price {
            font-size: 1.5rem;
        }
    }

    @media (max-width: 768px) {
        .products-grid {
            grid-template-columns: 1fr;
        }

        .search-container {
            padding: 0 1rem;
            margin-bottom: 2rem;
        }

        .search-input {
            padding: 0.9rem 3rem 0.9rem 1.2rem;
            font-size: 0.95rem;
        }

        .order-modal-content {
            padding: 2rem 1.5rem;
            max-height: 85vh;
        }

        .order-modal h2 {
            font-size: 1.5rem;
            margin-bottom: 1.25rem;
        }

        .detail-info-container {
            padding: 1.5rem;
        }

        .detail-title {
            font-size: 1.4rem;
        }

        .detail-price {
            font-size: 1.3rem;
        }

        .detail-description {
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .product-info {
            padding: 1.25rem;
        }

        .product-header h3 {
            font-size: 1rem;
        }

        .product-price {
            font-size: 0.95rem;
            padding: 0.35rem 0.7rem;
        }

        .product-btn {
            padding: 0.75rem 1.25rem;
            font-size: 0.9rem;
        }

        .view-eye {
            width: 50px;
            height: 50px;
        }

        .view-eye svg {
            width: 24px;
            height: 24px;
        }

        .brand-description {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .detail-modal {
            padding: 0.5rem;
        }

        .order-modal-content {
            padding: 1.5rem 1rem;
        }

        .detail-info-container {
            padding: 1.25rem;
        }

        .detail-close {
            width: 36px;
            height: 36px;
            font-size: 1.3rem;
        }

        .autocomplete-item {
            padding: 0.75rem 1rem;
        }

        .autocomplete-item-image {
            width: 40px;
            height: 40px;
        }

        .brand-description {
            padding: 1rem;
            margin-top: 1.5rem;
        }
    }

    /* Amélioration de la scrollbar pour les modals */
    .detail-modal-content::-webkit-scrollbar,
    .order-modal-content::-webkit-scrollbar,
    .autocomplete-results::-webkit-scrollbar {
        width: 8px;
    }

    .detail-modal-content::-webkit-scrollbar-track,
    .order-modal-content::-webkit-scrollbar-track,
    .autocomplete-results::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .detail-modal-content::-webkit-scrollbar-thumb,
    .order-modal-content::-webkit-scrollbar-thumb,
    .autocomplete-results::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 4px;
    }

    .detail-modal-content::-webkit-scrollbar-thumb:hover,
    .order-modal-content::-webkit-scrollbar-thumb:hover,
    .autocomplete-results::-webkit-scrollbar-thumb:hover {
        background: black;
    }
</style>
@endsection

@section('content')
    <!-- Page Banner -->
    <section class="page-banner" @if($pageContent && $pageContent->banner_background) style="background-image: linear-gradient(135deg, rgba(250, 250, 250, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%), url('{{ asset('images/' . $pageContent->banner_background) }}'); background-size: cover; background-position: center;" @endif>
        <div class="banner-content">
            <h1>{{ $category->banner_title ?? $category->name }}</h1>
            <p>{{ $category->banner_description ?? $category->description }}</p>
            @if($category->description)
            <div class="brand-description">
                <p>{{ $category->description }}</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Search Bar -->
    <section class="products-section" style="padding-top: 2rem;">
        <div class="search-container">
            <div class="search-wrapper">
                <input type="text"
                       id="searchInput"
                       class="search-input"
                       placeholder="Rechercher un produit par nom..."
                       autocomplete="off">
                <button class="clear-search" id="clearSearch" aria-label="Effacer la recherche">
                    <i class="fas fa-times"></i>
                </button>
                <span class="search-icon">
                    <i class="fas fa-search"></i>
                </span>
            </div>
            <div class="autocomplete-results" id="autocompleteResults"></div>
        </div>

        <!-- Products Grid -->
        <div class="products-grid" id="productsGrid">
            @forelse($products as $product)
            <div class="product-card" data-product-id="{{ $product->id }}" data-product-name="{{ strtolower($product->name) }}">
                <div class="product-image">
                    <img src="{{ asset($product->image ? 'storage/' . $product->image : 'images/img1.jpg') }}" alt="{{ $product->name }}" loading="lazy">
                    <div class="view-eye" onclick="openDetailModal({{ $loop->index }})">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-header">
                        <h3>{{ $product->name }}</h3>
                        <span class="product-price">{{ $product->formatted_price ?? ($product->price . ' FCFA') }}</span>
                    </div>
                    <button class="product-btn whatsapp-btn" onclick="orderOnWhatsApp({{ $loop->index }})">
                        <i class="fab fa-whatsapp"></i> {{ $pageContent->product_button_whatsapp ?? 'Commander sur WhatsApp' }}
                    </button>
                </div>
            </div>
            @empty
            <p style="text-align: center; grid-column: 1/-1; padding: 3rem; color: black;">Aucun produit disponible pour le moment.</p>
            @endforelse
        </div>
    </section>

    <!-- Modales -->
    @include('partials.modals.detail-modal', [
        'modalId' => 'detailModal',
        'imageId' => 'detailImage',
        'titleId' => 'detailTitle',
        'priceId' => 'detailPrice',
        'descriptionId' => 'detailDescription',
        'characteristics' => [
            ['label' => $pageContent->detail_label_material ?? 'Matière', 'id' => 'detailMaterial'],
            ['label' => $pageContent->detail_label_color ?? 'Tailles disponibles', 'id' => 'detailSizes'],
            ['label' => $pageContent->detail_label_brand ?? 'Style', 'id' => 'detailStyle'],
            ['label' => $pageContent->detail_label_availability ?? 'Collection', 'id' => 'detailCollection']
        ],
        'buttonAction' => 'orderFromDetail()'
    ])

    @include('partials.modals.order-modal', ['modalId' => 'orderModal', 'formId' => 'orderForm'])
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const products = @json($products);
    const whatsappNumber = "{{ $whatsappNumber ?? '2250769465904' }}";
    let currentProductMarque = null;

    // ===== FONCTIONNALITÉ DE RECHERCHE AVEC AUTOCOMPLÉTION =====
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const autocompleteResults = document.getElementById('autocompleteResults');
    const productsGrid = document.getElementById('productsGrid');
    const productCards = document.querySelectorAll('.product-card');

    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase().trim();

        if (searchTerm) {
            clearSearch.classList.add('active');
        } else {
            clearSearch.classList.remove('active');
            autocompleteResults.classList.remove('active');
            productCards.forEach(card => card.style.display = 'block');
            return;
        }

        const matches = products.filter(product =>
            product.name.toLowerCase().includes(searchTerm)
        );

        if (matches.length > 0) {
            autocompleteResults.innerHTML = matches.map((product, index) => {
                const imagePath = product.image ? '/storage/' + product.image : '/images/img1.jpg';
                const price = product.formatted_price || (product.price + ' FCFA');

                return `
                    <div class="autocomplete-item" data-index="${products.indexOf(product)}">
                        <img src="${imagePath}" alt="${product.name}" class="autocomplete-item-image">
                        <div class="autocomplete-item-info">
                            <div class="autocomplete-item-name">${product.name}</div>
                            <div class="autocomplete-item-price">${price}</div>
                        </div>
                    </div>
                `;
            }).join('');
            autocompleteResults.classList.add('active');

            document.querySelectorAll('.autocomplete-item').forEach(item => {
                item.addEventListener('click', function() {
                    const index = parseInt(this.dataset.index);
                    openDetailModal(index);
                    autocompleteResults.classList.remove('active');
                    searchInput.value = '';
                    clearSearch.classList.remove('active');
                });
            });
        } else {
            autocompleteResults.innerHTML = '<div class="no-results"><i class="fas fa-search"></i><br>Aucun résultat trouvé</div>';
            autocompleteResults.classList.add('active');
        }

        productCards.forEach(card => {
            const productName = card.dataset.productName;
            if (productName.includes(searchTerm)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    clearSearch.addEventListener('click', function() {
        searchInput.value = '';
        this.classList.remove('active');
        autocompleteResults.classList.remove('active');
        productCards.forEach(card => card.style.display = 'block');
        searchInput.focus();
    });

    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteResults.contains(e.target)) {
            autocompleteResults.classList.remove('active');
        }
    });

    // ===== MODALS =====

    window.openDetailModal = function(index) {
        currentProductMarque = products[index];
        const detailModal = document.getElementById('detailModal');
        const detailImage = document.getElementById('detailImage');
        const detailTitle = document.getElementById('detailTitle');
        const detailPrice = document.getElementById('detailPrice');
        const detailDescription = document.getElementById('detailDescription');
        const detailMaterial = document.getElementById('detailMaterial');
        const detailSizes = document.getElementById('detailSizes');
        const detailStyle = document.getElementById('detailStyle');
        const detailCollection = document.getElementById('detailCollection');

        if (!detailModal) {
            console.error('Modal de détails introuvable');
            return;
        }

        const imagePath = currentProductMarque.image ? '/storage/' + currentProductMarque.image : '/images/img1.jpg';

        detailImage.src = imagePath;
        detailTitle.textContent = currentProductMarque.name;
        detailPrice.textContent = currentProductMarque.formatted_price || (currentProductMarque.price + ' FCFA');
        detailDescription.textContent = currentProductMarque.description || 'Aucune description disponible.';
        detailMaterial.textContent = currentProductMarque.materials || 'N/A';
        detailSizes.textContent = currentProductMarque.sizes || 'N/A';
        detailStyle.textContent = currentProductMarque.style || 'N/A';
        detailCollection.textContent = currentProductMarque.collection || 'N/A';

        detailModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    window.closeDetailModal = function() {
        const detailModal = document.getElementById('detailModal');
        if (detailModal) {
            detailModal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    window.orderFromDetail = function() {
        closeDetailModal();
        openOrderModal(currentProductMarque);
    }

    window.orderOnWhatsApp = function(index) {
        openOrderModal(products[index]);
    }

    function openOrderModal(product) {
        const orderModal = document.getElementById('orderModal');
        const productIdField = document.getElementById('product_id');
        const messageField = document.getElementById('message');

        if (!orderModal || !productIdField || !messageField) {
            console.error('Éléments du formulaire introuvables');
            return;
        }

        const price = product.formatted_price || (product.price + ' FCFA');
        const message = `Bonjour, je souhaite commander le produit suivant :\n\n*${product.name}*\nPrix : ${price}\n\nMerci de me recontacter pour finaliser la commande.`;

        productIdField.value = product.id;
        messageField.value = message;

        orderModal.classList.add('active');
        document.body.style.overflow = 'hidden';
    }

    window.closeOrderModal = function() {
        const orderModal = document.getElementById('orderModal');
        if (orderModal) {
            orderModal.classList.remove('active');
            document.body.style.overflow = 'auto';
        }
    }

    // Fonction pour WhatsApp
    window.submitOrderViaWhatsApp = function() {
        const form = document.getElementById('orderForm');

        if (!form.checkValidity()) {
            form.reportValidity();
            return;
        }

        document.getElementById('order_channel').value = 'whatsapp';
        form.dispatchEvent(new Event('submit', { cancelable: true, bubbles: true }));
    }

    // Gestion de la soumission du formulaire
    const orderForm = document.getElementById('orderForm');
    if (orderForm) {
        orderForm.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);
            const orderChannel = formData.get('order_channel');
            const submitBtn = document.getElementById('submitBtn');
            const whatsappBtn = document.getElementById('submitWhatsAppBtn');

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Envoi...';
            }
            if (whatsappBtn) {
                whatsappBtn.disabled = true;
            }

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'X-Requested-With': 'XMLHttpRequest',
                    'Accept': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    closeOrderModal();

                    if (data.redirect_to_whatsapp && data.whatsapp_url) {
                        if (data.message_text && navigator.clipboard) {
                            navigator.clipboard.writeText(data.message_text).catch(() => {});
                        }

                        Swal.fire({
                            icon: 'info',
                            title: 'Redirection vers WhatsApp',
                            html: `
                                <p><strong>Commande enregistrée avec succès !</strong></p>
                                <p style="margin-top: 1rem; font-size: 0.9em; color: black;">
                                    <i class="fas fa-info-circle"></i> Le message a été copié automatiquement.<br>
                                    Si le texte n'apparaît pas dans WhatsApp, <strong>collez-le manuellement</strong> (Ctrl+V).
                                </p>
                            `,
                            confirmButtonText: 'Ouvrir WhatsApp',
                            confirmButtonColor: '#25D366',
                            showCancelButton: true,
                            cancelButtonText: 'Copier le message',
                            cancelButtonColor: '#6c757d'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.open(data.whatsapp_url, '_blank');
                            } else if (result.dismiss === Swal.DismissReason.cancel) {
                                if (data.message_text) {
                                    navigator.clipboard.writeText(data.message_text).then(() => {
                                        Swal.fire({
                                            icon: 'success',
                                            title: 'Message copié !',
                                            text: 'Collez-le dans WhatsApp (Ctrl+V)',
                                            timer: 2000,
                                            showConfirmButton: false
                                        });
                                    });
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'success',
                            title: 'Commande envoyée !',
                            text: data.message || 'Votre commande a été prise en compte avec succès.',
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#25D366'
                        });
                    }

                    orderForm.reset();
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur !',
                    text: 'Une erreur est survenue lors de l\'envoi de la commande.',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#e74a3b'
                });
            })
            .finally(() => {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.innerHTML = '<i class="fas fa-paper-plane"></i> Commander via Email';
                }
                if (whatsappBtn) {
                    whatsappBtn.disabled = false;
                }
            });
        });
    }

    // Fermer les modals en cliquant à l'extérieur
    const detailModal = document.getElementById('detailModal');
    const orderModal = document.getElementById('orderModal');

    if (detailModal) {
        detailModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDetailModal();
            }
        });
    }

    if (orderModal) {
        orderModal.addEventListener('click', function(e) {
            if (e.target === this) {
                closeOrderModal();
            }
        });
    }

    // Fermer les modals avec la touche Échap
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            if (detailModal && detailModal.classList.contains('active')) {
                closeDetailModal();
            }
            if (orderModal && orderModal.classList.contains('active')) {
                closeOrderModal();
            }
            if (autocompleteResults && autocompleteResults.classList.contains('active')) {
                autocompleteResults.classList.remove('active');
            }
        }
    });
});
</script>
@endsection
