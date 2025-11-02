/**
 * Order Email Handler - Gestion sécurisée de l'envoi d'emails via EmailJS
 * 
 * Ce module charge dynamiquement la configuration EmailJS depuis le backend
 * et gère l'envoi double (client + admin) ainsi que la redirection WhatsApp
 */

// Configuration EmailJS (chargée dynamiquement)
let EMAILJS_CONFIG = {
    publicKey: '',
    serviceId: '',
    templateId: '',
    templateAdminId: '',
    adminEmail: '',
    adminName: '',
    whatsappNumber: ''
};

let isEmailJSReady = false;

/**
 * Charge la configuration EmailJS depuis l'API Laravel
 */
async function loadEmailJSConfig() {
    try {
        const res = await fetch('/api/email-config', {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            credentials: 'same-origin'
        });
        
        if (!res.ok) {
            throw new Error('Échec du chargement de la config EmailJS');
        }
        
        const cfg = await res.json();
        EMAILJS_CONFIG = {
            publicKey: cfg.publicKey,
            serviceId: cfg.serviceId,
            templateId: cfg.templateId,
            templateAdminId: cfg.templateAdminId,
            adminEmail: cfg.adminEmail,
            adminName: cfg.adminName,
            whatsappNumber: cfg.whatsappNumber
        };
        
        // Initialiser EmailJS avec la clé publique
        if (typeof emailjs !== 'undefined' && EMAILJS_CONFIG.publicKey) {
            emailjs.init(EMAILJS_CONFIG.publicKey);
            isEmailJSReady = true;
        } else {
            console.warn('EmailJS library not found or public key missing');
        }
    } catch (e) {
        console.error('Erreur chargement EmailJS:', e);
        isEmailJSReady = false;
    }
}

/**
 * Envoie un email au client via EmailJS
 */
async function sendEmailClient(data) {
    if (!isEmailJSReady) {
        throw new Error('EmailJS non initialisé');
    }
    return emailjs.send(EMAILJS_CONFIG.serviceId, EMAILJS_CONFIG.templateId, data);
}

/**
 * Envoie un email à l'admin via EmailJS
 */
async function sendEmailAdmin(data) {
    if (!isEmailJSReady) {
        throw new Error('EmailJS non initialisé');
    }
    if (!EMAILJS_CONFIG.templateAdminId) {
        console.warn('Template admin non configuré, email admin non envoyé');
        return Promise.resolve(null);
    }
    return emailjs.send(EMAILJS_CONFIG.serviceId, EMAILJS_CONFIG.templateAdminId, data);
}

/**
 * Prépare les données pour l'email client
 */
function buildClientEmailData(formData, serverData) {
    return {
        to_email: formData.get('customer_email'),
        to_name: formData.get('customer_name'),
        product_name: serverData.product_name,
        product_price: serverData.product_price,
        customer_phone: formData.get('customer_phone'),
        message: formData.get('message')
    };
}

/**
 * Prépare les données pour l'email admin
 */
function buildAdminEmailData(formData, serverData) {
    const customerName = formData.get('customer_name');
    const productName = serverData.product_name;
    
    return {
        to_email: EMAILJS_CONFIG.adminEmail,
        to_name: EMAILJS_CONFIG.adminName,
        customer_name: customerName,
        customer_email: formData.get('customer_email'),
        customer_phone: formData.get('customer_phone'),
        product_name: productName,
        product_price: serverData.product_price,
        message: formData.get('message'),
        order_date: new Date().toLocaleDateString('fr-FR', { 
            year: 'numeric', 
            month: 'long', 
            day: 'numeric', 
            hour: '2-digit', 
            minute: '2-digit' 
        }),
        // Versions URL-encodées pour les liens mailto: (compatibilité mobile)
        product_name_encoded: encodeURIComponent(productName),
        customer_name_encoded: encodeURIComponent(customerName)
    };
}

/**
 * Envoie les deux emails (client + admin) en séquence
 */
async function sendDualEmails(form, serverData) {
    const formData = new FormData(form);
    const clientData = buildClientEmailData(formData, serverData);
    const adminData = buildAdminEmailData(formData, serverData);
    
    try {
        const clientRes = await sendEmailClient(clientData);
        
        // Pause courte entre les envois pour éviter le rate limiting
        await new Promise(resolve => setTimeout(resolve, 1000));
        
        let adminRes = null;
        if (EMAILJS_CONFIG.templateAdminId) {
            adminRes = await sendEmailAdmin(adminData);
        }
        
        return { clientRes, adminRes, success: true };
    } catch (err) {
        console.error('Erreur envoi emails:', err);
        throw err;
    }
}

/**
 * Génère et ouvre l'URL WhatsApp avec le message pré-rempli
 */
function openWhatsAppWithMessage(messageText) {
    const phoneNumber = EMAILJS_CONFIG.whatsappNumber || '2250769465904';
    const encodedMessage = encodeURIComponent(messageText);
    // Utiliser wa.me (URL universelle qui s'adapte à l'environnement : mobile app, desktop app, ou web)
    const url = `https://wa.me/${phoneNumber}?text=${encodedMessage}`;
    
    // Copier le message dans le presse-papier
    if (navigator.clipboard && messageText) {
        navigator.clipboard.writeText(messageText).catch(() => {
            console.warn('Impossible de copier le message dans le presse-papier');
        });
    }
    
    return url;
}

/**
 * Gestionnaire principal pour le formulaire de commande
 */
async function handleOrderSubmit(form, productData, options = {}) {
    const {
        sendEmail = true,
        redirectToWhatsApp = false,
        showSuccessMessage = true,
        onSuccess = null,
        onError = null
    } = options;
    
    try {
        // Si envoi d'email demandé
        if (sendEmail && isEmailJSReady) {
            await sendDualEmails(form, productData);
        }
        
        // Si redirection WhatsApp demandée
        if (redirectToWhatsApp) {
            const formData = new FormData(form);
            const message = formData.get('message');
            const whatsappUrl = openWhatsAppWithMessage(message);
            
            if (showSuccessMessage && typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'info',
                    title: 'Redirection vers WhatsApp',
                    html: `
                        <p><strong>Commande enregistrée avec succès !</strong></p>
                        <p style="margin-top: 1rem; font-size: 0.9em; color: #666;">
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
                        window.open(whatsappUrl, '_blank');
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        // Recopier le message
                        if (message) {
                            navigator.clipboard.writeText(message).then(() => {
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
                window.open(whatsappUrl, '_blank');
            }
        }
        
        // Callback de succès
        if (onSuccess && typeof onSuccess === 'function') {
            onSuccess();
        }
        
        return { success: true };
    } catch (error) {
        console.error('Erreur lors de la soumission:', error);
        
        // Callback d'erreur
        if (onError && typeof onError === 'function') {
            onError(error);
        } else if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Erreur !',
                text: 'Une erreur est survenue. Veuillez réessayer.',
                confirmButtonText: 'OK',
                confirmButtonColor: '#e74a3b'
            });
        }
        
        return { success: false, error };
    }
}

// Charger la configuration au chargement de la page
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', loadEmailJSConfig);
} else {
    loadEmailJSConfig();
}

// Exporter les fonctions pour utilisation externe
window.OrderEmailHandler = {
    loadConfig: loadEmailJSConfig,
    sendDualEmails,
    handleOrderSubmit,
    openWhatsAppWithMessage,
    getConfig: () => EMAILJS_CONFIG,
    isReady: () => isEmailJSReady
};

