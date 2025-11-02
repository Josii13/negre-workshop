{{--
    Modal de commande réutilisable
    
    @param string $modalId - ID unique du modal (défaut: 'orderModal')
    @param string $formId - ID du formulaire (défaut: 'orderForm')
    @param string $formAction - Action du formulaire
--}}

<div id="{{ $modalId ?? 'orderModal' }}" class="order-modal">
    <div class="order-modal-content">
        <button class="detail-close" onclick="closeOrderModal()">✕</button>
        
        <h2>{{ $modalContent->order_title ?? 'Commander' }}</h2>
        
        <form id="{{ $formId ?? 'orderForm' }}" action="{{ $formAction ?? route('order.store') }}" method="POST">
            @csrf
            <input type="hidden" id="product_id" name="product_id">
            
            <div class="form-group">
                <label for="customer_name">{{ $modalContent->order_label_name ?? 'Nom' }}</label>
                <input type="text" id="customer_name" name="customer_name" required>
            </div>
            
            <div class="form-group">
                <label for="customer_email">{{ $modalContent->order_label_email ?? 'Email' }}</label>
                <input type="email" id="customer_email" name="customer_email" required>
            </div>
            
            <div class="form-group">
                <label for="customer_phone">{{ $modalContent->order_label_phone ?? 'Téléphone' }}</label>
                <input type="tel" id="customer_phone" name="customer_phone" required>
            </div>
            
            <div class="form-group">
                <label for="message">{{ $modalContent->order_label_message ?? 'Message' }}</label>
                <textarea id="message" name="message" readonly></textarea>
            </div>
            
            <input type="hidden" id="order_channel" name="order_channel" value="app">
            
            <div class="form-actions">
                <button type="submit" class="submit-btn" id="submitBtn">
                    <i class="fas fa-paper-plane"></i> {{ $modalContent->order_button_submit ?? 'Commander via Email' }}
                </button>
                <button type="button" class="submit-btn whatsapp-btn" id="submitWhatsAppBtn" onclick="submitOrderViaWhatsApp()">
                    <i class="fab fa-whatsapp"></i> Continuer sur WhatsApp
                </button>
            </div>
        </form>
    </div>
</div>

<style>
.order-modal {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.85);
    z-index: 3000;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}

.order-modal.active {
    display: flex !important;
}

.order-modal-content {
    background-color: #FFFFFF;
    max-width: 500px;
    width: 100%;
    padding: 3rem;
    border-radius: 8px;
    position: relative;
    animation: slideUp 0.4s ease;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(40px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.order-modal .detail-close {
    position: absolute;
    top: 1rem;
    right: 1rem;
    background: rgba(255, 255, 255, 0.9);
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
}

.order-modal .detail-close:hover {
    background: #000000;
    color: #FFFFFF;
    transform: rotate(90deg);
}

.order-modal h2 {
    font-size: 1.8rem;
    font-weight: 500;
    margin-bottom: 2rem;
    text-align: center;
    color: #000;
}

.order-modal .form-group {
    margin-bottom: 1.5rem;
}

.order-modal .form-group label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 500;
    color: #333;
}

.order-modal .form-group input,
.order-modal .form-group textarea {
    width: 100%;
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.order-modal .form-group textarea {
    min-height: 100px;
    resize: vertical;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1.5rem;
}

.form-actions .submit-btn {
    flex: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    font-size: 1rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
}

.form-actions .submit-btn:not(.whatsapp-btn) {
    background: #000000;
    color: #FFFFFF;
}

.form-actions .submit-btn:not(.whatsapp-btn):hover {
    background: #333333;
}

.form-actions .whatsapp-btn {
    background: #25D366;
    color: #FFFFFF;
}

.form-actions .whatsapp-btn:hover {
    background: #128C7E;
}

/* Responsive */
@media (max-width: 768px) {
    .order-modal {
        padding: 1rem;
    }
    
    .order-modal-content {
        padding: 2rem;
    }
    
    .form-actions {
        flex-direction: column;
    }
}
</style>
