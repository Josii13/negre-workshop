<!-- Footer Styles -->
<style>
    footer {
        background: linear-gradient(135deg, #1a1a1a 0%, #000000 100%);
        color: #FFFFFF;
        padding: 0;
        margin-top: 6rem;
    }

    .footer-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 4rem 2rem 2rem;
    }

    .footer-main {
        display: grid;
        grid-template-columns: 2fr 1fr 1fr 1fr;
        gap: 4rem;
        margin-bottom: 3rem;
        padding-bottom: 3rem;
        border-bottom: 1px solid rgba(255, 255, 255, 0.1);
    }

    .footer-brand {
        max-width: 400px;
    }

    .footer-brand h3 {
        font-size: 1.75rem;
        font-weight: 400;
        margin-bottom: 1.25rem;
        letter-spacing: -0.02em;
    }

    .footer-brand p {
        font-size: 0.95rem;
        line-height: 1.7;
        color: rgba(255, 255, 255, 0.7);
        margin-bottom: 1.5rem;
        font-weight: 300;
    }

    .footer-social {
        display: flex;
        gap: 1rem;
        margin-top: 1.5rem;
    }

    .social-link {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(10px);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #FFFFFF;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .social-link:hover {
        background: #FFFFFF;
        color: #000000;
        transform: translateY(-4px);
        box-shadow: 0 6px 20px rgba(255, 255, 255, 0.2);
    }

    .social-link svg {
        width: 20px;
        height: 20px;
    }

    .footer-column h4 {
        font-size: 1rem;
        font-weight: 500;
        margin-bottom: 1.5rem;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #FFFFFF;
    }

    .footer-links {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .footer-links li {
        margin-bottom: 0.85rem;
    }

    .footer-links a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        font-size: 0.95rem;
        transition: all 0.3s ease;
        display: inline-block;
        font-weight: 300;
    }

    .footer-links a:hover {
        color: #FFFFFF;
        transform: translateX(4px);
    }

    .footer-contact-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        margin-bottom: 1rem;
        color: rgba(255, 255, 255, 0.7);
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .footer-contact-item svg {
        width: 18px;
        height: 18px;
        margin-top: 0.2rem;
        flex-shrink: 0;
        opacity: 0.7;
    }

    .footer-contact-item a {
        color: rgba(255, 255, 255, 0.7);
        text-decoration: none;
        transition: color 0.3s ease;
    }

    .footer-contact-item a:hover {
        color: #FFFFFF;
    }

    .footer-bottom {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 1.5rem 0;
        font-size: 0.9rem;
        color: rgba(255, 255, 255, 0.5);
    }

    .footer-bottom-links {
        display: flex;
        gap: 2rem;
    }

    .footer-bottom-links a {
        color: rgba(255, 255, 255, 0.5);
        text-decoration: none;
        transition: color 0.3s ease;
        font-size: 0.9rem;
        cursor: pointer;
    }

    .footer-bottom-links a:hover {
        color: #FFFFFF;
    }

    .footer-heart {
        color: #FF6B6B !important;
        animation: heartbeat 1.5s ease infinite;
    }

    @keyframes heartbeat {

        0%,
        100% {
            transform: scale(1);
        }

        10%,
        30% {
            transform: scale(1.1);
        }

        20%,
        40% {
            transform: scale(1);
        }
    }

    /* Newsletter Section (optionnel) */
    .footer-newsletter {
        background: rgba(255, 255, 255, 0.05);
        padding: 1.5rem;
        border-radius: 8px;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .newsletter-form {
        display: flex;
        gap: 0.75rem;
        margin-top: 1rem;
    }

    .newsletter-input {
        flex: 1;
        padding: 0.85rem 1.25rem;
        background: rgba(255, 255, 255, 0.1);
        border: 1px solid rgba(255, 255, 255, 0.2);
        border-radius: 50px;
        color: #FFFFFF;
        font-size: 0.95rem;
        font-family: 'Inter', sans-serif;
        outline: none;
        transition: all 0.3s ease;
    }

    .newsletter-input::placeholder {
        color: rgba(255, 255, 255, 0.5);
    }

    .newsletter-input:focus {
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.4);
    }

    .newsletter-btn {
        padding: 0.85rem 2rem;
        background: #FFFFFF;
        color: #000000;
        border: none;
        border-radius: 50px;
        font-size: 0.95rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        white-space: nowrap;
    }

    .newsletter-btn:hover {
        background: #F0F0F0;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 255, 255, 0.3);
    }

    /* Modal Styles */
    .modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.85);
        z-index: 1000;
        overflow-y: auto;
        backdrop-filter: blur(10px);
        animation: modalBackdropFadeIn 0.3s ease-out;
    }

    @keyframes modalBackdropFadeIn {
        from {
            opacity: 0;
        }
        to {
            opacity: 1;
        }
    }

    .modal-content {
        position: relative;
        background: linear-gradient(145deg, #1f1f1f 0%, #0a0a0a 100%);
        margin: 3% auto;
        padding: 0;
        width: 85%;
        max-width: 850px;
        border-radius: 20px;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.8),
                    0 0 0 1px rgba(255, 255, 255, 0.05);
        color: #FFFFFF;
        animation: modalFadeIn 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        overflow: hidden;
    }

    @keyframes modalFadeIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 2rem 2.5rem;
        background: white;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
        position: relative;
    }

    .modal-header::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 2px;
        background: linear-gradient(90deg,
            transparent 0%,
            rgba(255, 255, 255, 0.3) 50%,
            transparent 100%);
    }

    .modal-header h2 {
        margin: 0;
        font-size: 1.75rem;
        font-weight: 500;
        letter-spacing: -0.02em;
        background: black;
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
        background-clip: text;
    }

    .close-modal {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid rgba(255, 255, 255, 0.1);
        color: black;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 42px;
        height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        font-weight: 300;
    }

    .close-modal:hover {
        color: black;
        background: rgba(255, 255, 255, 0.15);
        border-color: rgba(255, 255, 255, 0.2);
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 2.5rem;
        max-height: 65vh;
        overflow-y: auto;
        scrollbar-width: thin;
        scrollbar-color: rgba(255, 255, 255, 0.2) transparent;
    }

    .modal-body::-webkit-scrollbar {
        width: 8px;
    }

    .modal-body::-webkit-scrollbar-track {
        background: transparent;
    }

    .modal-body::-webkit-scrollbar-thumb {
        background: rgba(255, 255, 255, 0.2);
        border-radius: 10px;
    }

    .modal-body::-webkit-scrollbar-thumb:hover {
        background: rgba(255, 255, 255, 0.3);
    }

    .modal-body h3 {
        font-size: 1.35rem;
        margin-top: 2rem;
        margin-bottom: 1rem;
        color: #FFFFFF;
        font-weight: 500;
        letter-spacing: -0.01em;
        position: relative;
        padding-left: 1rem;
    }

    .modal-body h3::before {
        content: '';
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        width: 4px;
        height: 60%;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.8) 0%, rgba(255, 255, 255, 0.3) 100%);
        border-radius: 2px;
    }

    .modal-body h3:first-child {
        margin-top: 0;
    }

    .modal-body p {
        line-height: 1.7;
        margin-bottom: 1.25rem;
        color: rgba(255, 255, 255, 0.75);
        font-size: 0.98rem;
    }

    .modal-body p strong {
        color: rgba(255, 255, 255, 0.95);
        font-weight: 500;
    }

    .modal-body ul {
        margin-left: 1.5rem;
        margin-bottom: 1.75rem;
        list-style: none;
        padding-left: 0;
    }

    .modal-body li {
        margin-bottom: 0.75rem;
        color: rgba(255, 255, 255, 0.75);
        line-height: 1.6;
        position: relative;
        padding-left: 1.75rem;
    }

    .modal-body li::before {
        content: '→';
        position: absolute;
        left: 0;
        color: rgba(255, 255, 255, 0.5);
        font-weight: 300;
    }

    /* Responsive */
    @media (max-width: 1024px) {
        .footer-main {
            grid-template-columns: 2fr 1fr 1fr;
            gap: 3rem;
        }

        .footer-column:last-child {
            grid-column: 1 / -1;
            max-width: 400px;
        }
    }

    @media (max-width: 768px) {
        footer {
            margin-top: 4rem;
        }

        .footer-content {
            padding: 3rem 1.5rem 1.5rem;
        }

        .footer-main {
            grid-template-columns: 1fr;
            gap: 2.5rem;
            margin-bottom: 2rem;
            padding-bottom: 2rem;
        }

        .footer-brand {
            max-width: 100%;
        }

        .footer-column:last-child {
            grid-column: auto;
            max-width: 100%;
        }

        .footer-bottom {
            flex-direction: column;
            gap: 1rem;
            text-align: center;
        }

        .footer-bottom-links {
            flex-direction: column;
            gap: 0.75rem;
        }

        .newsletter-form {
            flex-direction: column;
        }

        .newsletter-btn {
            width: 100%;
        }

        .modal-content {
            width: 90%;
            margin: 10% auto;
        }

        .modal-header {
            padding: 1rem 1.5rem;
        }

        .modal-body {
            padding: 1.5rem;
        }
    }

    @media (max-width: 480px) {
        .footer-content {
            padding: 2.5rem 1rem 1rem;
        }

        .footer-social {
            flex-wrap: wrap;
        }
    }

    /* Accessibility */
    .footer-links a:focus-visible,
    .social-link:focus-visible,
    .newsletter-input:focus-visible,
    .newsletter-btn:focus-visible {
        outline: 2px solid rgba(255, 255, 255, 0.6);
        outline-offset: 3px;
    }

    .close-modal:focus-visible {
        outline: 2px solid rgba(255, 255, 255, 0.6);
        outline-offset: 2px;
    }
</style>

<!-- Footer -->
<footer>
    <div class="footer-content">
        <div class="footer-main">
            <!-- Brand Section -->
            <div class="footer-brand">
                <h3>Nègre Studio 72</h3>
                <p>Artiste peintre et designer passionné, explorant l'intersection entre l'art contemporain, le design
                    et la culture africaine à travers des créations uniques et engagées.</p>

                <div class="footer-social">
                    <a href="https://facebook.com" class="social-link" aria-label="Facebook" target="_blank"
                        rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                        </svg>
                    </a>
                    <a href="https://instagram.com" class="social-link" aria-label="Instagram" target="_blank"
                        rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z" />
                        </svg>
                    </a>
                    <a href="https://twitter.com" class="social-link" aria-label="Twitter / X" target="_blank"
                        rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z" />
                        </svg>
                    </a>
                    <a href="https://linkedin.com" class="social-link" aria-label="LinkedIn" target="_blank"
                        rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z" />
                        </svg>
                    </a>
                    <a href="https://wa.me/2250769465904" class="social-link" aria-label="WhatsApp" target="_blank"
                        rel="noopener noreferrer">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                            <path
                                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z" />
                        </svg>
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="footer-column">
                <h4>Navigation</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Accueil</a></li>
                    <li><a href="{{ route('peinture') }}">Peinture</a></li>
                    <li><a href="{{ route('design') }}">Design</a></li>
                    <li><a href="{{ route('marques') }}">Marques</a></li>
                    <li><a href="{{ route('gallery') }}">Gallery</a></li>
                </ul>
            </div>

            <!-- Quick Links -->
            <div class="footer-column">
                <h4>À Propos</h4>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}#about">L'Artiste</a></li>
                    <li><a href="{{ route('gallery') }}">NÈGRE Workshop</a></li>
                    {{-- <li><a href="#">Expositions</a></li>
                    <li><a href="#">Publications</a></li>
                    <li><a href="#">Blog</a></li> --}}
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-column">
                <h4>Contact</h4>
                <div class="footer-contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>Abidjan, Côte d'Ivoire</span>
                </div>
                <div class="footer-contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <a href="mailto:contact@fredericnda.com"> fredericnda.ci@gmail.com</a>
                </div>
                <div class="footer-contact-item">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <a href="tel:+2250769465904">+225 07 69 46 59 04</a>
                </div>

                <!-- Newsletter (optionnel) -->
                <div class="footer-newsletter" style="margin-top: 1.5rem;">
                    <p style="font-size: 0.9rem; margin-bottom: 0.5rem; color: rgba(255, 255, 255, 0.9);">Restez informé
                    </p>
                    <form class="newsletter-form" onsubmit="event.preventDefault();">
                        <input type="email" class="newsletter-input" placeholder="Votre email" required>
                        <button type="submit" class="newsletter-btn">S'inscrire</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>© 2025 Frederic N'DA. Tous droits réservés. Développé par <span class="footer-heart"><a href="">DevCaleb</a></span></p>
            <div class="footer-bottom-links">
                <a href="#" onclick="openModal('mentions-legales')">Mentions légales</a>
                <a href="#" onclick="openModal('politique-confidentialite')">Politique de confidentialité</a>
                <a href="#" onclick="openModal('conditions-utilisation')">Conditions d'utilisation</a>
            </div>
        </div>
    </div>
</footer>

<!-- Modals -->
<div id="mentions-legales" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Mentions Légales</h2>
            <button class="close-modal" onclick="closeModal('mentions-legales')">&times;</button>
        </div>
        <div class="modal-body">
            <h3>Éditeur du site</h3>
            <p>Le site www.fredericnda.com est édité par :</p>
            <p><strong>Frederic N'DA</strong><br>
            Artiste peintre et designer<br>
            Abidjan, Côte d'Ivoire</p>

            <h3>Contact</h3>
            <p>Email : fredericnda.ci@gmail.com<br>
            Téléphone : +225 07 69 46 59 04</p>

            <h3>Hébergement</h3>
            <p>Le site est hébergé par :<br>
            [Nom de l'hébergeur]<br>
            [Adresse de l'hébergeur]<br>
            [Téléphone de l'hébergeur]</p>

            <h3>Propriété intellectuelle</h3>
            <p>L'ensemble de ce site relève de la législation française et internationale sur le droit d'auteur et la propriété intellectuelle. Tous les droits de reproduction sont réservés, y compris pour les documents téléchargeables et les représentations iconographiques et photographiques.</p>

            <h3>Données personnelles</h3>
            <p>Les informations recueillies font l'objet d'un traitement informatique destiné à [finalité du traitement]. Conformément à la loi « informatique et libertés » du 6 janvier 1978 modifiée, vous bénéficiez d'un droit d'accès et de rectification aux informations qui vous concernent.</p>
        </div>
    </div>
</div>

<div id="politique-confidentialite" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Politique de Confidentialité</h2>
            <button class="close-modal" onclick="closeModal('politique-confidentialite')">&times;</button>
        </div>
        <div class="modal-body">
            <h3>Introduction</h3>
            <p>La présente politique de confidentialité a pour but d'informer les utilisateurs du site sur la manière dont sont collectées et utilisées leurs données personnelles.</p>

            <h3>Données collectées</h3>
            <p>Nous pouvons collecter les données personnelles suivantes :</p>
            <ul>
                <li>Nom et prénom</li>
                <li>Adresse email</li>
                <li>Numéro de téléphone</li>
                <li>Données de navigation (cookies)</li>
            </ul>

            <h3>Utilisation des données</h3>
            <p>Les données personnelles collectées sont utilisées pour :</p>
            <ul>
                <li>Répondre à vos demandes d'information</li>
                <li>Vous envoyer des newsletters (avec votre consentement)</li>
                <li>Améliorer notre site et nos services</li>
                <li>Respecter nos obligations légales</li>
            </ul>

            <h3>Partage des données</h3>
            <p>Vos données personnelles ne sont pas vendues, échangées ou transférées à des tiers sans votre consentement, sauf pour répondre à une obligation légale.</p>

            <h3>Vos droits</h3>
            <p>Conformément au RGPD, vous disposez des droits suivants :</p>
            <ul>
                <li>Droit d'accès à vos données</li>
                <li>Droit de rectification</li>
                <li>Droit à l'effacement</li>
                <li>Droit à la limitation du traitement</li>
                <li>Droit à la portabilité des données</li>
                <li>Droit d'opposition</li>
            </ul>
            <p>Pour exercer ces droits, contactez-nous à fredericnda.ci@gmail.com</p>
        </div>
    </div>
</div>

<div id="conditions-utilisation" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2>Conditions d'Utilisation</h2>
            <button class="close-modal" onclick="closeModal('conditions-utilisation')">&times;</button>
        </div>
        <div class="modal-body">
            <h3>Acceptation des conditions</h3>
            <p>L'utilisation du site www.fredericnda.com implique l'acceptation pleine et entière des conditions générales d'utilisation décrites ci-après.</p>

            <h3>Accès au site</h3>
            <p>L'accès au site est gratuit, sauf coûts de connexion et d'utilisation du réseau internet qui sont à la charge de l'utilisateur.</p>

            <h3>Propriété intellectuelle</h3>
            <p>Tous les éléments du site, notamment les textes, présentations, illustrations, photographies, arborescences et mise en forme sont la propriété exclusive de Frederic N'DA, à l'exception des éléments provenant de partenaires.</p>

            <h3>Limitation de responsabilité</h3>
            <p>Frederic N'DA ne pourra être tenu responsable des dommages directs et indirects causés au matériel de l'utilisateur, lors de l'accès au site, et résultant soit de l'utilisation d'un matériel ne répondant pas aux spécifications indiquées, soit de l'apparition d'un bug ou d'une incompatibilité.</p>

            <h3>Liens hypertextes</h3>
            <p>Le site peut contenir des liens hypertextes vers d'autres sites. Frederic N'DA n'exerce aucun contrôle sur ces sites et décline toute responsabilité quant à leur contenu.</p>

            <h3>Modification des conditions</h3>
            <p>Frederic N'DA se réserve le droit de modifier, à tout moment et sans préavis, le contenu du site et/ou les présentes conditions d'utilisation.</p>

            <h3>Droit applicable</h3>
            <p>Les présentes conditions d'utilisation sont régies par le droit ivoirien. Tout litige relatif à l'utilisation du site sera soumis à la compétence des tribunaux d'Abidjan.</p>
        </div>
    </div>
</div>

<!-- Scripts -->
<script>
    // Fonction pour ouvrir un modal
    function openModal(modalId) {
        document.getElementById(modalId).style.display = 'block';
        document.body.style.overflow = 'hidden'; // Empêche le défilement de la page
    }

    // Fonction pour fermer un modal
    function closeModal(modalId) {
        document.getElementById(modalId).style.display = 'none';
        document.body.style.overflow = 'auto'; // Rétablit le défilement
    }

    // Fermer le modal en cliquant en dehors
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
            document.body.style.overflow = 'auto';
        }
    }

    // Fermer avec la touche Échap
    document.addEventListener('keydown', function(event) {
        if (event.key === 'Escape') {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                modal.style.display = 'none';
            });
            document.body.style.overflow = 'auto';
        }
    });

    // Newsletter Form Script (optionnel)
    document.querySelector('.newsletter-form')?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('.newsletter-input').value;

        // Ici, vous pouvez ajouter votre logique d'inscription à la newsletter
        // Par exemple, une requête AJAX vers votre backend

        alert('Merci pour votre inscription ! Vous recevrez bientôt nos actualités.');
        this.reset();
    });
</script>
