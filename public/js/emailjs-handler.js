/**
 * ===================================
 * EMAILJS HANDLER - NEGRE SHOP
 * ===================================
 * 
 * Gestionnaire global pour l'envoi d'emails via EmailJS
 * et l'affichage des modales de confirmation
 */

// Configuration EmailJS (à configurer depuis le backend Laravel)
let EMAIL_CONFIG = {
    publicKey: '',      
    serviceId: '',      
    templateId: '',     
    templateAdminId: '' // Template pour notifications admin
};

// Configuration Admin (à configurer depuis le backend Laravel)
let ADMIN_CONFIG = {
    email: '',
    name: ''
};

// Fonction pour mettre à jour la configuration depuis le serveur
window.setEmailJSConfig = function(config) {
    if (config && config.publicKey && config.serviceId && config.templateId) {
        EMAIL_CONFIG = config;
        // Réinitialiser EmailJS avec la nouvelle clé
        if (typeof emailjs !== 'undefined') {
            emailjs.init(EMAIL_CONFIG.publicKey);
        }
    }
};

// Fonction pour mettre à jour la configuration admin
window.setAdminConfig = function(config) {
    if (config && config.email) {
        ADMIN_CONFIG = config;
    }
};

// Initialiser EmailJS au chargement de la page
(function initEmailJS() {
    if (typeof emailjs !== 'undefined') {
        emailjs.init(EMAIL_CONFIG.publicKey);
    } else {
        console.warn('EmailJS SDK non chargé');
    }
})();

/**
 * Afficher la modale de succès
 * @param {Object} options - Options de la modale
 * @param {string} options.title - Titre de la modale
 * @param {string} options.message - Message principal
 * @param {string} options.subMessage - Message secondaire
 * @param {boolean} options.showLoading - Afficher le spinner de chargement
 * @param {number} options.autoCloseDelay - Délai de fermeture auto (en ms, 0 = pas de fermeture auto)
 */
function showSuccessModal(options = {}) {
    const defaults = {
        title: 'Succès !',
        message: 'Votre demande a été prise en compte avec succès.',
        subMessage: 'Un email de confirmation vous sera envoyé sous peu.',
        showLoading: true,
        autoCloseDelay: 0
    };

    const config = { ...defaults, ...options };
    
    const modal = document.getElementById('globalSuccessModal');
    if (!modal) {
        console.error('Modale de succès introuvable');
        return;
    }

    // Mettre à jour le contenu
    const titleEl = modal.querySelector('.success-modal h2');
    const messageEl = modal.querySelector('.success-message');
    const subMessageEl = modal.querySelector('.success-sub-message');
    const loadingEl = modal.querySelector('.loading-container');

    if (titleEl) titleEl.textContent = config.title;
    if (messageEl) messageEl.textContent = config.message;
    if (subMessageEl) subMessageEl.textContent = config.subMessage;
    if (loadingEl) loadingEl.style.display = config.showLoading ? 'block' : 'none';

    // Afficher la modale
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';

    // Fermeture automatique si configuré
    if (config.autoCloseDelay > 0) {
        setTimeout(() => {
            closeSuccessModal();
        }, config.autoCloseDelay);
    }
}

/**
 * Fermer la modale de succès
 */
function closeSuccessModal() {
    const modal = document.getElementById('globalSuccessModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

/**
 * Afficher la modale d'erreur
 * @param {Object} options - Options de la modale
 */
function showErrorModal(options = {}) {
    const defaults = {
        title: 'Erreur',
        message: 'Une erreur est survenue.',
        subMessage: 'Veuillez réessayer ultérieurement.'
    };

    const config = { ...defaults, ...options };
    
    const modal = document.getElementById('globalErrorModal');
    if (!modal) {
        console.error('Modale d\'erreur introuvable');
        return;
    }

    // Mettre à jour le contenu
    const titleEl = modal.querySelector('.error-modal h2');
    const messageEl = modal.querySelector('.error-message');
    const subMessageEl = modal.querySelector('.error-sub-message');

    if (titleEl) titleEl.textContent = config.title;
    if (messageEl) messageEl.textContent = config.message;
    if (subMessageEl) subMessageEl.textContent = config.subMessage;

    // Afficher la modale
    modal.classList.add('active');
    document.body.style.overflow = 'hidden';
}

/**
 * Fermer la modale d'erreur
 */
function closeErrorModal() {
    const modal = document.getElementById('globalErrorModal');
    if (modal) {
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
    }
}

/**
 * Afficher une notification toast
 * @param {string} message - Message à afficher
 * @param {string} type - Type: 'success', 'error', 'warning', 'info'
 * @param {number} duration - Durée d'affichage en ms (défaut: 3000)
 */
function showToast(message, type = 'success', duration = 3000) {
    const toast = document.createElement('div');
    toast.className = `toast-notification ${type}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    setTimeout(() => {
        toast.classList.add('hiding');
        setTimeout(() => {
            document.body.removeChild(toast);
        }, 300);
    }, duration);
}

/**
 * Envoyer un email via EmailJS
 * @param {Object} emailData - Données de l'email
 * @param {Object} options - Options
 * @returns {Promise}
 */
async function sendEmail(emailData, options = {}) {
    const defaults = {
        showSuccessModal: true,
        showErrorModal: true,
        reloadOnSuccess: false,
        reloadDelay: 3000,
        onSuccess: null,
        onError: null
    };

    const config = { ...defaults, ...options };

    // Vérifier que EmailJS est chargé
    if (typeof emailjs === 'undefined') {
        console.error('EmailJS n\'est pas chargé');
        if (config.showErrorModal) {
            showErrorModal({
                title: 'Erreur technique',
                message: 'Le service d\'envoi d\'email n\'est pas disponible.',
                subMessage: 'Veuillez réessayer plus tard.'
            });
        }
        return Promise.reject('EmailJS non disponible');
    }

    try {
        // Envoyer l'email
        const response = await emailjs.send(
            EMAIL_CONFIG.serviceId,
            EMAIL_CONFIG.templateId,
            emailData
        );

        // Mettre à jour le texte de chargement
        const loadingText = document.getElementById('loadingText');
        if (loadingText) {
            loadingText.textContent = 'Email envoyé !';
        }

        // Callback personnalisé
        if (config.onSuccess && typeof config.onSuccess === 'function') {
            config.onSuccess(response);
        }

        // Recharger la page si configuré
        if (config.reloadOnSuccess) {
            setTimeout(() => {
                window.location.reload();
            }, config.reloadDelay);
        }

        return response;

    } catch (error) {
        console.error('Erreur lors de l\'envoi de l\'email:', error);

        // Mettre à jour le texte de chargement
        const loadingText = document.getElementById('loadingText');
        if (loadingText) {
            loadingText.textContent = 'Email en cours d\'envoi...';
        }

        // Callback personnalisé
        if (config.onError && typeof config.onError === 'function') {
            config.onError(error);
        }

        // Afficher la modale d'erreur si configuré
        if (config.showErrorModal) {
            showErrorModal({
                title: 'Erreur d\'envoi',
                message: 'L\'email de confirmation n\'a pas pu être envoyé.',
                subMessage: 'Votre commande a bien été enregistrée. Nous vous contacterons bientôt.'
            });
        }

        // Recharger quand même si configuré
        if (config.reloadOnSuccess) {
            setTimeout(() => {
                window.location.reload();
            }, config.reloadDelay);
        }

        throw error;
    }
}

/**
 * Envoyer des emails multiples (client + admin)
 * @param {Object} customerData - Données de l'email client
 * @param {Object} adminData - Données de l'email admin
 * @param {Object} options - Options
 * @returns {Promise}
 */
async function sendDualEmails(customerData, adminData, options = {}) {
    const defaults = {
        showSuccessModal: true,
        showErrorModal: true,
        reloadOnSuccess: false,
        reloadDelay: 3000,
        onSuccess: null,
        onError: null
    };

    const config = { ...defaults, ...options };

    // Vérifier que EmailJS est chargé
    if (typeof emailjs === 'undefined') {
        console.error('EmailJS n\'est pas chargé');
        if (config.showErrorModal) {
            showErrorModal({
                title: 'Erreur technique',
                message: 'Le service d\'envoi d\'email n\'est pas disponible.',
                subMessage: 'Veuillez réessayer plus tard.'
            });
        }
        return Promise.reject('EmailJS non disponible');
    }

    try {
        // Mettre à jour le texte de chargement
        const loadingText = document.getElementById('loadingText');
        let customerResponse = null;
        let adminResponse = null;

        // ============================================
        // ÉTAPE 1 : Envoyer l'email au CLIENT
        // ============================================
        if (loadingText) {
            loadingText.textContent = 'Envoi de l\'email au client...';
        }

        try {
            customerResponse = await emailjs.send(
                EMAIL_CONFIG.serviceId,
                EMAIL_CONFIG.templateId,
                customerData
            );
        } catch (customerError) {
            console.error('Erreur envoi email client:', customerError);
            throw customerError; // Stopper si email client échoue
        }

        // Petite pause de 1 seconde entre les deux envois
        await new Promise(resolve => setTimeout(resolve, 1000));

        // ============================================
        // ÉTAPE 2 : Envoyer l'email à l'ADMIN
        // ============================================
        if (EMAIL_CONFIG.templateAdminId && ADMIN_CONFIG.email) {
            if (loadingText) {
                loadingText.textContent = 'Envoi de la notification admin...';
            }

            try {
                adminResponse = await emailjs.send(
                    EMAIL_CONFIG.serviceId,
                    EMAIL_CONFIG.templateAdminId,
                    adminData
                );
            } catch (adminError) {
                console.error('Erreur envoi email admin:', adminError);
                console.warn('L\'email client a été envoyé, mais l\'email admin a échoué');
                // On ne throw pas l'erreur admin pour ne pas bloquer le processus
            }
        } else {
            console.warn('Template admin non configuré ou email admin manquant');
        }

        // Mettre à jour le texte de chargement
        if (loadingText) {
            if (adminResponse) {
                loadingText.textContent = 'Emails envoyés !';
            } else {
                loadingText.textContent = 'Email client envoyé !';
            }
        }

        // Callback personnalisé
        if (config.onSuccess && typeof config.onSuccess === 'function') {
            config.onSuccess({ customerResponse, adminResponse });
        }

        // Recharger la page si configuré
        if (config.reloadOnSuccess) {
            setTimeout(() => {
                window.location.reload();
            }, config.reloadDelay);
        }

        return { customerResponse, adminResponse };

    } catch (error) {
        console.error('Erreur lors de l\'envoi des emails:', error);

        // Mettre à jour le texte de chargement
        const loadingText = document.getElementById('loadingText');
        if (loadingText) {
            loadingText.textContent = 'Email en cours d\'envoi...';
        }

        // Callback personnalisé
        if (config.onError && typeof config.onError === 'function') {
            config.onError(error);
        }

        // Afficher la modale d'erreur si configuré
        if (config.showErrorModal) {
            showErrorModal({
                title: 'Erreur d\'envoi',
                message: 'L\'email de confirmation n\'a pas pu être envoyé.',
                subMessage: 'Votre commande a bien été enregistrée. Nous vous contacterons bientôt.'
            });
        }

        // Recharger quand même si configuré
        if (config.reloadOnSuccess) {
            setTimeout(() => {
                window.location.reload();
            }, config.reloadDelay);
        }

        throw error;
    }
}

/**
 * Traiter une soumission de formulaire avec EmailJS
 * @param {HTMLFormElement} form - Le formulaire
 * @param {Function} prepareEmailData - Fonction pour préparer les données email
 * @param {Object} options - Options
 */
async function handleFormSubmit(form, prepareEmailData, options = {}) {
    const defaults = {
        showSuccessModal: true,
        sendEmail: true,
        reloadOnSuccess: true,
        reloadDelay: 3000,
        successMessage: 'Votre demande a été enregistrée avec succès.',
        successSubMessage: 'Un email de confirmation vous sera envoyé sous peu.'
    };

    const config = { ...defaults, ...options };

    // Désactiver le bouton de soumission
    const submitBtn = form.querySelector('[type="submit"]');
    if (submitBtn) {
        submitBtn.disabled = true;
        submitBtn.dataset.originalText = submitBtn.textContent;
        submitBtn.textContent = 'Envoi en cours...';
    }

    try {
        // Soumettre le formulaire au serveur Laravel
        const formData = new FormData(form);
        
        const response = await fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': formData.get('_token')
            }
        });

        const data = await response.json();

        if (data.success) {
            // Afficher la modale de succès
            if (config.showSuccessModal) {
                showSuccessModal({
                    title: 'Succès !',
                    message: config.successMessage,
                    subMessage: config.successSubMessage,
                    showLoading: config.sendEmail
                });
            }

            // Envoyer l'email (ou les emails) si configuré
            if (config.sendEmail && prepareEmailData) {
                // Si une fonction pour préparer l'email admin est fournie, envoyer 2 emails
                if (config.prepareAdminEmailData && typeof config.prepareAdminEmailData === 'function') {
                    const customerData = prepareEmailData(formData, data);
                    const adminData = config.prepareAdminEmailData(formData, data);
                    
                    await sendDualEmails(customerData, adminData, {
                        showSuccessModal: false,
                        showErrorModal: false,
                        reloadOnSuccess: config.reloadOnSuccess,
                        reloadDelay: config.reloadDelay
                    });
                } else {
                    // Envoi simple (client seulement)
                    const emailData = prepareEmailData(formData, data);
                    await sendEmail(emailData, {
                        showSuccessModal: false,
                        showErrorModal: false,
                        reloadOnSuccess: config.reloadOnSuccess,
                        reloadDelay: config.reloadDelay
                    });
                }
            } else if (config.reloadOnSuccess) {
                setTimeout(() => {
                    window.location.reload();
                }, config.reloadDelay);
            }

            // Réinitialiser le formulaire
            form.reset();

        } else {
            throw new Error(data.message || 'Erreur lors de l\'envoi');
        }

    } catch (error) {
        console.error('Erreur:', error);
        
        showErrorModal({
            title: 'Erreur',
            message: 'Une erreur est survenue lors de l\'envoi.',
            subMessage: 'Veuillez réessayer.'
        });

    } finally {
        // Réactiver le bouton
        if (submitBtn) {
            submitBtn.disabled = false;
            submitBtn.textContent = submitBtn.dataset.originalText || 'Envoyer';
        }
    }
}

// Exposer les fonctions globalement
window.showSuccessModal = showSuccessModal;
window.closeSuccessModal = closeSuccessModal;
window.showErrorModal = showErrorModal;
window.closeErrorModal = closeErrorModal;
window.showToast = showToast;
window.sendEmail = sendEmail;
window.sendDualEmails = sendDualEmails;
window.handleFormSubmit = handleFormSubmit;

