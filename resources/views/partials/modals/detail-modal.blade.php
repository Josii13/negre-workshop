{{--
    Modal de détails de produit/activité réutilisable
    
    @param string $modalId - ID unique du modal (défaut: 'detailModal')
    @param string $imageId - ID de l'image (défaut: 'detailImage')
    @param string $titleId - ID du titre (défaut: 'detailTitle')
    @param string $priceId - ID du prix (défaut: 'detailPrice')
    @param string $descriptionId - ID de la description (défaut: 'detailDescription')
    @param array $characteristics - Caractéristiques à afficher
    @param string $buttonAction - Action du bouton (défaut: 'orderFromDetail()')
--}}

<div id="{{ $modalId ?? 'detailModal' }}" class="detail-modal">
    <div class="detail-modal-content">
        <button class="detail-close" onclick="closeDetailModal()">✕</button>
        
        <div class="detail-image-container">
            <img id="{{ $imageId ?? 'detailImage' }}" src="" alt="">
        </div>
        
        <div class="detail-info-container">
            <div>
                <h2 class="detail-title" id="{{ $titleId ?? 'detailTitle' }}"></h2>
                <div class="detail-price" id="{{ $priceId ?? 'detailPrice' }}"></div>
                
                <div class="detail-description">
                    <p id="{{ $descriptionId ?? 'detailDescription' }}"></p>
                </div>
                
                @if(!empty($characteristics))
                <div class="detail-characteristics">
                    <h4>{{ $modalContent->detail_characteristics_title ?? 'Caractéristiques' }}</h4>
                    @foreach($characteristics as $char)
                    <div class="characteristic-item">
                        <span class="characteristic-label">{{ $char['label'] }}</span>
                        <span class="characteristic-value" id="{{ $char['id'] }}"></span>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
            
            <button class="product-btn" onclick="{{ $buttonAction ?? 'orderFromDetail()' }}">
                {{ $modalContent->detail_button_order ?? 'Commander cette œuvre' }}
            </button>
        </div>
    </div>
</div>
