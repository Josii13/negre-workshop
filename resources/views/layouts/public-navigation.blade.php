<!-- Navigation Styles -->
<style>
    nav {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(20px);
        box-shadow: 0 2px 20px rgba(0, 0, 0, 0.05);
        z-index: 1000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    nav.scrolled {
        background: rgba(255, 255, 255, 0.98);
        box-shadow: 0 4px 30px rgba(0, 0, 0, 0.1);
    }

    .nav-content {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0rem 1.25rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        position: relative;
    }

    /* Logo Section */
    .logo {
        display: flex;
        align-items: left;
        gap: 1rem;
        text-decoration: none;
        transition: all 0.3s ease;
    }

    .logo-image {
        width: 48px;
        height: 48px;
        object-fit: cover;
        /* border-radius: 50%; */
        border: 2px solid rgba(0, 0, 0, 0.1);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .logo:hover .logo-image {
        transform: rotate(360deg) scale(1.1);
        border-color: #000;
    }

    .logo span {
        font-size: 1.5rem;
        font-weight: 400;
        letter-spacing: 0.05em;
        color: #000;
        transition: all 0.3s ease;
    }

    .logo:hover span {
        letter-spacing: 0.08em;
    }

    /* Navigation Links */
    .nav-links {
        display: flex;
        list-style: none;
        gap: 0.5rem;
        margin: 0;
        padding: 0;
        align-items: center;
    }

    .nav-links li {
        position: relative;
    }

    .nav-links a {
        display: block;
        padding: 0.75rem 1.25rem;
        color: #333;
        text-decoration: none;
        font-size: 0.95rem;
        font-weight: 400;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 50px;
        position: relative;
        letter-spacing: 0.02em;
    }

    /* .nav-links a::before {
        content: '';
        position: absolute;
        bottom: 8px;
        left: 50%;
        transform: translateX(-50%) scaleX(0);
        width: 24px;
        height: 2px;
        background: #000;
        transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    } */

    .nav-links a:hover {
        color: #000;
        background: rgba(0, 0, 0, 0.05);
    }

    .nav-links a:hover::before {
        transform: translateX(-50%) scaleX(1);
    }

    .nav-links a.active {
        color: #000;
        font-weight: 500;
        background: rgba(0, 0, 0, 0.08);
    }

    .nav-links a.active::before {
        transform: translateX(-50%) scaleX(1);
    }

    /* Dashboard Button Special Style */
    .dashboard-btn {
        background: linear-gradient(135deg, #000 0%, #333 100%);
        color: #fff;
        padding: 0.75rem 1.5rem;
        border-radius: 50px;
        font-weight: 500;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .dashboard-btn::before {
        display: none;
    }

    .dashboard-btn:hover {
        background: linear-gradient(135deg, #333 0%, #000 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
    }

    /* Mobile Menu Button */
    .mobile-menu-btn {
        display: none;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 44px;
        height: 44px;
        background: none;
        border: none;
        cursor: pointer;
        padding: 0;
        z-index: 1001;
        position: relative;
    }

    .menu-icon {
        position: relative;
        width: 26px;
        height: 2px;
        background: #000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .menu-icon::before,
    .menu-icon::after {
        content: '';
        position: absolute;
        width: 26px;
        height: 2px;
        background: #000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .menu-icon::before {
        top: -8px;
    }

    .menu-icon::after {
        bottom: -8px;
    }

    .mobile-menu-btn.active .menu-icon {
        background: transparent;
    }

    .mobile-menu-btn.active .menu-icon::before {
        transform: rotate(45deg);
        top: 0;
    }

    .mobile-menu-btn.active .menu-icon::after {
        transform: rotate(-45deg);
        bottom: 0;
    }

    /* Search & Actions Container */
    .nav-actions {
        display: flex;
        align-items: center;
        gap: 1rem;
        margin-left: 2rem;
    }

    .search-btn {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: rgba(0, 0, 0, 0.05);
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .search-btn:hover {
        background: rgba(0, 0, 0, 0.1);
        transform: scale(1.1);
    }

    .search-btn svg {
        width: 20px;
        height: 20px;
        stroke: #000;
    }

    /* Language Switcher */
    .lang-switcher {
        position: relative;
    }

    .lang-btn {
        padding: 0.5rem 1rem;
        background: rgba(0, 0, 0, 0.05);
        border: none;
        border-radius: 20px;
        cursor: pointer;
        font-size: 0.9rem;
        font-weight: 500;
        color: #000;
        transition: all 0.3s ease;
    }

    .lang-btn:hover {
        background: rgba(0, 0, 0, 0.1);
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .nav-content {
            padding: 1rem 1.5rem;
        }

        .nav-links {
            gap: 0.25rem;
        }

        .nav-links a {
            padding: 0.65rem 1rem;
            font-size: 0.9rem;
        }

        .nav-actions {
            margin-left: 1rem;
        }
    }

    @media (max-width: 768px) {
        .mobile-menu-btn {
            display: flex;
        }

        .nav-content {
            padding: 1rem;
        }

        .logo span {
            font-size: 1.25rem;
        }

        .nav-links {
            position: fixed;
            top: 20px;
            left: 0;
            right: 0;
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(20px);
            flex-direction: column;
            padding: 1.5rem;
            gap: 0.5rem;
            box-shadow: 0 8px 30px rgba(0, 0, 0, 0.15);
            transform: translateY(-100%);
            opacity: 0;
            visibility: hidden;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            max-height: calc(100vh - 70px);
            overflow-y: auto;
        }

        .nav-links.active {
            transform: translateY(0);
            opacity: 1;
            visibility: visible;
        }

        .nav-links li {
            width: 100%;
        }

        .nav-links a {
            width: 100%;
            padding: 1rem 1.25rem;
            border-radius: 8px;
            font-size: 1rem;
            text-align: center;
        }

        .dashboard-btn {
            width: 100%;
            text-align: center;
        }

        .nav-actions {
            display: none;
        }

        /* Mobile Search */
        .nav-links::after {
            content: '';
            display: block;
            padding: 1rem 0;
        }
    }

    @media (max-width: 480px) {
        .logo span {
            font-size: 1.1rem;
            letter-spacing: 0.03em;
        }

        .logo-image {
            width: 40px;
            height: 40px;
        }

        .nav-content {
            padding: 0.85rem 1rem;
        }
    }

    /* Scroll Progress Bar */
    .scroll-progress {
        position: absolute;
        bottom: 0;
        left: 0;
        height: 3px;
        background: linear-gradient(90deg, #000 0%, #333 100%);
        width: 0;
        transition: width 0.1s ease;
        z-index: 1002;
    }

    /* Accessibility */
    .nav-links a:focus-visible,
    .mobile-menu-btn:focus-visible,
    .search-btn:focus-visible,
    .lang-btn:focus-visible {
        outline: 2px solid #000;
        outline-offset: 3px;
    }

    /* Animation d'entrée */
    @keyframes slideDown {
        from {
            transform: translateY(-100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    nav {
        animation: slideDown 0.5s ease-out;
    }

    /* High contrast mode support */
    @media (prefers-contrast: high) {
        .nav-links a {
            border: 1px solid transparent;
        }

        .nav-links a:focus {
            border-color: #000;
        }
    }

    /* Reduced motion support */
    @media (prefers-reduced-motion: reduce) {
        * {
            animation-duration: 0.01ms !important;
            animation-iteration-count: 1 !important;
            transition-duration: 0.01ms !important;
        }

        .logo:hover .logo-image {
            transform: none;
        }
    }
</style>

<!-- Navigation -->
<nav id="mainNav" aria-label="Navigation principale">
    <div class="scroll-progress" id="scrollProgress" aria-hidden="true"></div>
    <div class="nav-content">
        <a href="{{ route('home') }}" class="logo" aria-label="Accueil - Frédéric N'DA">
            @if(file_exists(public_path('images/logo.jpg')))
                <img src="{{ asset('images/logo.jpg') }}" alt="Logo Frédéric N'DA" class="logo-image" width="48" height="48">
            @else
                <div class="logo-image" style="background: #f0f0f0; display: flex; align-items: center; justify-content: center; font-size: 12px; color: #666;">
                    FN
                </div>
            @endif
            <span>Nègre Studio 72</span>
        </a>

        <button class="mobile-menu-btn" id="menuBtn" aria-label="Menu" aria-expanded="false" aria-controls="navLinks">
            <span class="menu-icon" aria-hidden="true"></span>
        </button>

        <ul class="nav-links" id="navLinks" role="menubar">
            <li role="none"><a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'active' : '' }}" role="menuitem">Accueil</a></li>
            <li role="none"><a href="{{ route('peinture') }}" class="{{ request()->routeIs('peinture') ? 'active' : '' }}" role="menuitem">Peinture</a></li>
            <li role="none"><a href="{{ route('design') }}" class="{{ request()->routeIs('design') ? 'active' : '' }}" role="menuitem">Design</a></li>
            <li role="none"><a href="{{ route('marques') }}" class="{{ request()->routeIs('marques') ? 'active' : '' }}" role="menuitem">Marques</a></li>
            <li role="none"><a href="{{ route('gallery') }}" class="{{ request()->routeIs('gallery') ? 'active' : '' }}" role="menuitem">Gallery</a></li>
            <li role="none"><a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'active' : '' }}" role="menuitem">Contact</a></li>
            @auth
                @if(in_array(Auth::user()->type, ['admin', 'super_admin']))
                    <li role="none"><a href="{{ route('dashboard') }}" class="dashboard-btn" role="menuitem">
                        <svg style="width: 18px; height: 18px; display: inline; vertical-align: middle; margin-right: 6px;" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                        </svg>
                        Dashboard
                    </a></li>
                @endif
            @endauth
        </ul>

        <!-- Actions Section -->
        <div class="nav-actions">
            <button class="search-btn" aria-label="Rechercher" onclick="toggleSearch()">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
            </button>

            <!-- Language Switcher -->
            <div class="lang-switcher">
                <button class="lang-btn" onclick="toggleLanguage()" aria-label="Changer la langue">FR</button>
            </div>
        </div>
    </div>
</nav>

<!-- Navigation Scripts -->
<script>
    // Mobile Menu Toggle
    const menuBtn = document.getElementById('menuBtn');
    const navLinks = document.getElementById('navLinks');

    function toggleMobileMenu() {
        const isExpanded = menuBtn.classList.toggle('active');
        navLinks.classList.toggle('active');

        menuBtn.setAttribute('aria-expanded', isExpanded);
        document.body.style.overflow = isExpanded ? 'hidden' : 'auto';

        // Trap focus in mobile menu when open
        if (isExpanded) {
            trapFocus(navLinks);
        }
    }

    menuBtn.addEventListener('click', toggleMobileMenu);

    // Close mobile menu when clicking on a link
    const navLinksItems = navLinks.querySelectorAll('a');
    navLinksItems.forEach(link => {
        link.addEventListener('click', () => {
            if (window.innerWidth <= 768) {
                closeMobileMenu();
            }
        });
    });

    // Close menu when clicking outside
    document.addEventListener('click', (e) => {
        if (window.innerWidth <= 768 &&
            !menuBtn.contains(e.target) &&
            !navLinks.contains(e.target) &&
            navLinks.classList.contains('active')) {
            closeMobileMenu();
        }
    });

    function closeMobileMenu() {
        menuBtn.classList.remove('active');
        navLinks.classList.remove('active');
        menuBtn.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = 'auto';
    }

    // Scroll Effects
    const nav = document.getElementById('mainNav');
    const scrollProgress = document.getElementById('scrollProgress');
    let lastScroll = 0;
    let scrollTimeout;

    function handleScroll() {
        const currentScroll = window.pageYOffset;

        // Add/remove scrolled class
        if (currentScroll > 50) {
            nav.classList.add('scrolled');
        } else {
            nav.classList.remove('scrolled');
        }

        // Update scroll progress bar
        const docHeight = document.documentElement.scrollHeight - document.documentElement.clientHeight;
        const scrollPercent = docHeight > 0 ? (currentScroll / docHeight) * 100 : 0;
        scrollProgress.style.width = Math.min(scrollPercent, 100) + '%';

        lastScroll = currentScroll;
    }

    // Throttled scroll event
    window.addEventListener('scroll', () => {
        if (!scrollTimeout) {
            scrollTimeout = setTimeout(() => {
                scrollTimeout = null;
                handleScroll();
            }, 10);
        }
    });

    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                const target = document.querySelector(href);
                const navHeight = nav.offsetHeight;
                const targetPosition = target.offsetTop - navHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // Search Toggle Function
    function toggleSearch() {
        // Implémentez votre logique de recherche ici
        console.log('Fonctionnalité de recherche à implémenter');
    }

    // Language Toggle Function
    function toggleLanguage() {
        const langBtn = document.querySelector('.lang-btn');
        const currentLang = langBtn.textContent;
        const newLang = currentLang === 'FR' ? 'EN' : 'FR';
        langBtn.textContent = newLang;
        langBtn.setAttribute('aria-label', `Changer la langue, actuellement ${newLang}`);

        // Implémentez votre logique de changement de langue ici
        console.log('Changement de langue vers ' + newLang);
    }

    // Focus trap for mobile menu
    function trapFocus(element) {
        const focusableElements = element.querySelectorAll('a, button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];

        element.addEventListener('keydown', function(e) {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        });
    }

    // Keyboard Navigation
    document.addEventListener('keydown', (e) => {
        // ESC to close mobile menu
        if (e.key === 'Escape' && navLinks.classList.contains('active')) {
            closeMobileMenu();
            menuBtn.focus();
        }
    });

    // Handle window resize
    let resizeTimer;
    window.addEventListener('resize', () => {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(() => {
            if (window.innerWidth > 768 && navLinks.classList.contains('active')) {
                closeMobileMenu();
            }
        }, 250);
    });

    // Initialize navigation
    document.addEventListener('DOMContentLoaded', () => {
        // Set initial scroll state
        handleScroll();

        // Add loading class for any initial transitions
        nav.classList.add('loaded');
    });
</script>
