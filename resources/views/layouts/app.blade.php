<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">

        <!-- Public CSS - Charger le CSS original (backup) qui fonctionne -->
        <link rel="stylesheet" href="{{ asset('css/style-backup.css') }}">
        
        <!-- SweetAlert2 -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
        
        <style>
            /* Admin Navigation Override (si connecté) */
            @auth
                body {
                    padding-top: 0 !important;
                }
            @endauth

            /* Page Banner Styles */
            .page-banner {
                margin-top: 80px;
                padding: 5rem 2rem 3rem;
                background: linear-gradient(135deg, #FAFAFA 0%, #FFFFFF 100%);
                text-align: center;
                border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            }

            .banner-content {
                max-width: 800px;
                margin: 0 auto;
            }

            .banner-content h1 {
                font-size: 3.5rem;
                font-weight: 300;
                letter-spacing: -0.03em;
                margin-bottom: 1.5rem;
            }

            .banner-content p {
                font-size: 1.15rem;
                line-height: 1.8;
                color: #555;
                font-weight: 300;
            }

            /* Responsive */
            @media (max-width: 768px) {
                .page-banner {
                    margin-top: 70px;
                    padding: 3rem 1.5rem 2rem;
                }

                .banner-content h1 {
                    font-size: 2.5rem;
                }

                .banner-content p {
                    font-size: 1.05rem;
                }
            }
        </style>

        @yield('styles')
    </head>
    <body class="public-site">
        <div id="public-wrapper">
            {{-- Toujours utiliser la navigation publique sur les pages publiques --}}
            @include('layouts.public-navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                @yield('content')
            </main>

            @guest
                @include('layouts.footer')
            @endguest
        </div>

        <!-- Mobile menu toggle script -->
        <script>
            const menuBtn = document.getElementById('menuBtn');
            const navLinks = document.getElementById('navLinks');

            if (menuBtn && navLinks) {
                menuBtn.addEventListener('click', () => {
                    navLinks.classList.toggle('active');
                });
            }
        </script>

        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

        <!-- EmailJS SDK -->
        <script src="https://cdn.jsdelivr.net/npm/@emailjs/browser@3/dist/email.min.js"></script>

        <!-- Public JS -->
        <script src="{{ asset('js/emailjs-handler.js') }}"></script>
        <script src="{{ asset('js/order-email-handler.js') }}"></script>
        
        <!-- Configuration EmailJS et Admin depuis .env -->
        <script>
            // Configurer EmailJS avec les valeurs du .env Laravel
            if (typeof setEmailJSConfig === 'function') {
                setEmailJSConfig(@json($emailjsConfig));
            }
            
            // Configurer les informations admin
            if (typeof setAdminConfig === 'function') {
                setAdminConfig({
                    email: '{{ $adminEmail }}',
                    name: '{{ $adminName }}'
                });
            }
        </script>
        
        <!-- Global Form Handler with Modals -->
        <script>
            // Afficher les messages flash de Laravel avec SweetAlert2
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Succès !',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#000000',
                    timer: 4000,
                    timerProgressBar: true
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Erreur !',
                    text: '{{ session('error') }}',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#e74a3b'
                });
            @endif

            @if($errors->any())
                Swal.fire({
                    icon: 'error',
                    title: 'Erreurs de validation',
                    html: '<div style="text-align: left;"><ul style="list-style-position: inside;">' +
                        @foreach($errors->all() as $error)
                            '<li>{{ $error }}</li>' +
                        @endforeach
                        '</ul></div>',
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#e74a3b',
                    width: '600px'
                });
            @endif

            /**
             * Gestionnaire global pour les formulaires avec modales
             * @param {HTMLFormElement} form - Le formulaire à soumettre
             * @param {Function} prepareEmailData - Fonction pour préparer les données email (optionnel)
             * @param {Object} options - Options de configuration
             */
            function handleFormSubmit(form, prepareEmailData = null, options = {}) {
                const defaults = {
                    showLoadingModal: true,
                    showSuccessModal: true,
                    sendEmail: false,
                    reloadOnSuccess: false,
                    reloadDelay: 2000,
                    successTitle: 'Succès !',
                    successMessage: 'Votre demande a été envoyée avec succès.',
                    successSubMessage: null,
                    loadingTitle: 'Envoi en cours...',
                    loadingMessage: 'Veuillez patienter.'
                };

                const config = { ...defaults, ...options };
                const formData = new FormData(form);
                const submitBtn = form.querySelector('button[type="submit"]');
                
                // Afficher la modale de chargement
                if (config.showLoadingModal) {
                    Swal.fire({
                        title: config.loadingTitle,
                        html: config.loadingMessage,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        allowEnterKey: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                }

                // Désactiver le bouton de soumission
                if (submitBtn) {
                    submitBtn.disabled = true;
                }

                // Soumettre le formulaire via AJAX
                return fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            throw data;
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    // Succès
                    if (config.showSuccessModal) {
                        let htmlContent = config.successMessage;
                        if (config.successSubMessage) {
                            htmlContent += '<br><small style="color: #666; margin-top: 1rem; display: block;">' + config.successSubMessage + '</small>';
                        }

                        Swal.fire({
                            icon: 'success',
                            title: config.successTitle,
                            html: htmlContent,
                            confirmButtonText: 'OK',
                            confirmButtonColor: '#000000',
                            timer: config.reloadOnSuccess ? config.reloadDelay : null,
                            timerProgressBar: config.reloadOnSuccess
                        }).then(() => {
                            if (config.reloadOnSuccess) {
                                window.location.reload();
                            }
                        });
                    }

                    // Envoyer l'email si configuré
                    if (config.sendEmail && prepareEmailData && typeof emailjs !== 'undefined') {
                        const emailData = prepareEmailData(formData, data);
                        const serviceId = '{{ env('EMAILJS_SERVICE_ID', 'service_atkfepu') }}';
                        const templateId = '{{ env('EMAILJS_TEMPLATE_ID', 'template_nrtko5u') }}';
                        
                        emailjs.send(serviceId, templateId, emailData)
                            .then(() => {
                                // Email envoyé avec succès
                            })
                            .catch(err => {
                                console.error('Erreur lors de l\'envoi de l\'email:', err);
                                // Ne pas bloquer le succès de l'opération principale
                            });
                    }

                    // Réinitialiser le formulaire
                    form.reset();
                    
                    return data;
                })
                .catch(error => {
                    console.error('Erreur:', error);
                    
                    let errorMessage = 'Une erreur est survenue lors de l\'envoi.';
                    if (error.message) {
                        errorMessage = error.message;
                    } else if (error.errors) {
                        errorMessage = '<ul style="list-style-position: inside; text-align: left;">';
                        Object.values(error.errors).forEach(msgs => {
                            msgs.forEach(msg => {
                                errorMessage += '<li>' + msg + '</li>';
                            });
                        });
                        errorMessage += '</ul>';
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Erreur',
                        html: errorMessage,
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#e74a3b'
                    });

                    throw error;
                })
                .finally(() => {
                    // Réactiver le bouton
                    if (submitBtn) {
                        submitBtn.disabled = false;
                    }
                });
            }
        </script>

        @yield('scripts')
    </body>
</html>
