@extends('layouts.app')

@section('title', $pageContent->meta_title ?? 'Frederic N\'DA - Artiste Peintre & Designer')

@section('styles')
<style>
    /* Carousel Section - Optimisé */
    .carousel-section {
        width: 100%;
        max-width: 1400px;
        margin: 100px auto 60px;
        padding: 0 2rem;
    }

    .carousel-container {
        position: relative;
        width: 100%;
        height: 650px;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
    }

    .carousel-slides {
        width: 100%;
        height: 100%;
        position: relative;
    }

    .carousel-slide {
        position: absolute;
        width: 100%;
        height: 100%;
        opacity: 0;
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        transform: scale(1.05);
    }

    .carousel-slide.active {
        opacity: 1;
        transform: scale(1);
        transition: opacity 0.8s cubic-bezier(0.4, 0, 0.2, 1),
                    transform 8s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .carousel-slide img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .carousel-caption {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.85) 0%, rgba(0, 0, 0, 0.4) 70%, transparent 100%);
        color: white;
        padding: 4rem 3rem 2.5rem;
        backdrop-filter: blur(2px);
    }

    .carousel-caption h3 {
        font-size: 2.5rem;
        margin-bottom: 0.75rem;
        font-weight: 400;
        letter-spacing: -0.02em;
        line-height: 1.2;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
    }

    .carousel-caption p {
        font-size: 1.15rem;
        opacity: 0.95;
        font-weight: 300;
        max-width: 600px;
        line-height: 1.6;
        text-shadow: 0 1px 4px rgba(0, 0, 0, 0.3);
    }

    .carousel-btn {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.05);
        color: #000000;
        font-size: 2rem;
        width: 56px;
        height: 56px;
        border-radius: 50%;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 10;
        font-weight: 300;
    }

    .carousel-btn:hover {
        background: #000000;
        color: #FFFFFF;
        transform: translateY(-50%) scale(1.15);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
    }

    .carousel-btn:active {
        transform: translateY(-50%) scale(1.05);
    }

    .carousel-btn.prev {
        left: 24px;
    }

    .carousel-btn.next {
        right: 24px;
    }

    .carousel-dots {
        position: absolute;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%);
        display: flex;
        gap: 12px;
        z-index: 10;
        background: rgba(0, 0, 0, 0.3);
        backdrop-filter: blur(10px);
        padding: 8px 16px;
        border-radius: 24px;
    }

    .dot {
        width: 10px;
        height: 10px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.5);
        cursor: pointer;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1px solid transparent;
    }

    .dot:hover {
        background: rgba(255, 255, 255, 0.8);
        transform: scale(1.2);
    }

    .dot.active {
        background: white;
        width: 32px;
        border-radius: 5px;
        box-shadow: 0 2px 8px rgba(255, 255, 255, 0.3);
    }

    /* Progress bar pour le slide actif */
    .carousel-progress {
        position: absolute;
        top: 0;
        left: 0;
        height: 4px;
        background: linear-gradient(90deg, #FFFFFF 0%, rgba(255, 255, 255, 0.5) 100%);
        width: 0;
        transition: width 5s linear;
        z-index: 11;
        opacity: 0.7;
    }

    .carousel-slide.active .carousel-progress {
        width: 100%;
    }

    /* Hero Section - Amélioré */
    .hero {
        max-width: 1400px;
        margin: 0 auto;
        padding: 0 2rem 5rem;
    }

    .hero-content {
        display: grid;
        grid-template-columns: 1fr 1.5fr;
        gap: 5rem;
        margin-bottom: 5rem;
        align-items: center;
    }

    .hero-image {
        width: 100%;
        height: 550px;
        overflow: hidden;
        border-radius: 12px;
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.15);
        background-color: #F7F7F7;
        position: relative;
    }

    .hero-image::before {
        content: '';
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.1) 0%, transparent 50%);
        z-index: 1;
        opacity: 0;
        transition: opacity 0.4s ease;
    }

    .hero-image:hover::before {
        opacity: 1;
    }

    .hero-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .hero-image:hover img {
        transform: scale(1.08);
    }

    .hero-text h1 {
        font-size: 3.5rem;
        font-weight: 300;
        letter-spacing: -0.03em;
        margin-bottom: 2rem;
        line-height: 1.1;
    }

    .hero-text p {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #555;
        margin-bottom: 1.5rem;
        font-weight: 300;
    }

    .hero-text p:last-of-type {
        margin-bottom: 0;
    }

    /* Category Cards - Redesigné */
    .category-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(320px, 1fr 1fr));
        gap: 2rem;
    }

    .category-card {
        position: relative;
        height: 400px;
        overflow: hidden;
        border-radius: 12px;
        cursor: pointer;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 16px 50px rgba(0, 0, 0, 0.2);
    }

    .category-card img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.6s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-card:hover img {
        transform: scale(1.1);
    }

    .category-overlay {
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        background: linear-gradient(to top, rgba(0, 0, 0, 0.9) 0%, rgba(0, 0, 0, 0.6) 60%, transparent 100%);
        color: white;
        padding: 2.5rem 2rem;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-card:hover .category-overlay {
        background: linear-gradient(to top, rgba(0, 0, 0, 0.95) 0%, rgba(0, 0, 0, 0.7) 70%, transparent 100%);
        padding: 3rem 2rem 2.5rem;
    }

    .category-overlay h2 {
        font-size: 2rem;
        margin-bottom: 0.75rem;
        font-weight: 400;
        letter-spacing: -0.02em;
        text-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
    }

    .category-card:hover .category-overlay h2 {
        transform: translateY(-4px);
    }

    .category-desc {
        font-size: 1rem;
        opacity: 0;
        transform: translateY(10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        line-height: 1.6;
        font-weight: 300;
    }

    .category-card:hover .category-desc {
        opacity: 0.95;
        transform: translateY(0);
    }

    /* Indicateur visuel "Voir plus" */
    .category-overlay::after {
        content: '→';
        position: absolute;
        bottom: 2rem;
        right: 2rem;
        width: 40px;
        height: 40px;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        opacity: 0;
        transform: translateX(-10px);
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .category-card:hover .category-overlay::after {
        opacity: 1;
        transform: translateX(0);
    }

    /* Section divider */
    .section-divider {
        max-width: 1400px;
        margin: 4rem auto;
        padding: 0 2rem;
    }

    .divider-line {
        height: 1px;
        background: linear-gradient(90deg, transparent 0%, rgba(0, 0, 0, 0.1) 50%, transparent 100%);
    }

    /* Loading animation pour les images */
    .loading-placeholder {
        background: linear-gradient(90deg, #F0F0F0 25%, #E8E8E8 50%, #F0F0F0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Responsive Design */
    @media (max-width: 1024px) {
        .carousel-section {
            margin: 90px auto 50px;
        }

        .carousel-container {
            height: 500px;
        }

        .hero-content {
            gap: 3rem;
            margin-bottom: 4rem;
        }

        .category-cards {
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
        }

        .category-card {
            height: 350px;
        }
    }

    @media (max-width: 768px) {
        .carousel-section {
            margin: 80px auto 40px;
            padding: 0 1rem;
        }

        .carousel-container {
            height: 450px;
            border-radius: 8px;
        }

        .carousel-caption {
            padding: 3rem 1.5rem 2rem;
        }

        .carousel-caption h3 {
            font-size: 1.75rem;
        }

        .carousel-caption p {
            font-size: 1rem;
        }

        .carousel-btn {
            width: 44px;
            height: 44px;
            font-size: 1.5rem;
        }

        .carousel-btn.prev {
            left: 12px;
        }

        .carousel-btn.next {
            right: 12px;
        }

        .carousel-dots {
            gap: 8px;
            padding: 6px 12px;
        }

        .dot {
            width: 8px;
            height: 8px;
        }

        .dot.active {
            width: 24px;
        }

        .hero {
            padding: 0 1rem 3rem;
        }

        .hero-content {
            grid-template-columns: 1fr;
            gap: 2.5rem;
            margin-bottom: 3rem;
        }

        .hero-image {
            height: 400px;
        }

        .hero-text h1 {
            font-size: 2.5rem;
            margin-bottom: 1.5rem;
        }

        .hero-text p {
            font-size: 1.05rem;
        }

        .category-cards {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .category-card {
            height: 320px;
        }

        .category-overlay h2 {
            font-size: 1.75rem;
        }
    }

    @media (max-width: 480px) {
        .carousel-container {
            height: 350px;
        }

        .carousel-caption {
            padding: 2rem 1rem 1.5rem;
        }

        .carousel-caption h3 {
            font-size: 1.5rem;
        }

        .carousel-caption p {
            font-size: 0.9rem;
        }

        .hero-text h1 {
            font-size: 2rem;
        }

        .category-overlay {
            padding: 2rem 1.5rem;
        }

        .category-overlay h2 {
            font-size: 1.5rem;
        }
    }

    /* Smooth scrolling */
    html {
        scroll-behavior: smooth;
    }

    /* Focus states pour l'accessibilité */
    .carousel-btn:focus-visible,
    .dot:focus-visible,
    .category-card:focus-visible {
        outline: 3px solid #000;
        outline-offset: 3px;
    }

    /* Animations d'entrée */
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .hero-content,
    .category-card {
        animation: fadeInUp 0.6s ease-out backwards;
    }

    .category-card:nth-child(1) { animation-delay: 0.1s; }
    .category-card:nth-child(2) { animation-delay: 0.2s; }
    .category-card:nth-child(3) { animation-delay: 0.3s; }
    .category-card:nth-child(4) { animation-delay: 0.4s; }
</style>
@endsection

@section('content')
    <!-- Carousel Section -->
    <section class="carousel-section">
        <div class="carousel-container">
            <div class="carousel-slides" id="carouselSlides">
                @foreach($slides as $index => $slide)
                <div class="carousel-slide {{ $index === 0 ? 'active' : '' }}">
                    <div class="carousel-progress"></div>
                    <img src="{{ asset('images/' . $slide->image) }}" alt="{{ $slide->title }}" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                    <div class="carousel-caption">
                        <h3>{{ $slide->title }}</h3>
                        <p>{{ $slide->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            <button class="carousel-btn prev" id="prevBtn" aria-label="Slide précédent">‹</button>
            <button class="carousel-btn next" id="nextBtn" aria-label="Slide suivant">›</button>
            <div class="carousel-dots" id="carouselDots" role="tablist"></div>
        </div>
    </section>

    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <div class="hero-image">
                <img src="{{ asset('images/' . ($pageContent->hero_image ?? 'img2.jpg')) }}" alt="{{ $pageContent->hero_title ?? 'Frederic N\'DA' }}" loading="lazy">
            </div>
            <div class="hero-text">
                <h1>{{ $pageContent->hero_title ?? 'Frederic N\'DA' }}</h1>
                @if($pageContent && $pageContent->hero_paragraph_1)
                    <p>{{ $pageContent->hero_paragraph_1 }}</p>
                @endif
                @if($pageContent && $pageContent->hero_paragraph_2)
                    <p>{{ $pageContent->hero_paragraph_2 }}</p>
                @endif
                @if($pageContent && $pageContent->hero_paragraph_3)
                    <p>{{ $pageContent->hero_paragraph_3 }}</p>
                @endif
            </div>
        </div>

        <div class="category-cards">
            @foreach($categories->where('slug', '!=', 'gallery') as $category)
            @php
                $routeName = match($category->slug) {
                    'peinture' => 'peinture',
                    'design' => 'design',
                    'marque' => 'marques',
                    default => $category->slug
                };
            @endphp
            <a href="{{ route($routeName) }}" class="category-card" role="button" tabindex="0">
                <img src="{{ asset($category->image ? 'storage/' . $category->image : 'images/img1.jpg') }}" alt="{{ $category->name }}" loading="lazy">
                <div class="category-overlay">
                    <h2>{{ $category->name }}</h2>
                    <p class="category-desc">{{ $category->description }}</p>
                </div>
            </a>
            @endforeach

            {{-- Carte Gallery --}}
            <a href="{{ route('gallery') }}" class="category-card" role="button" tabindex="0">
                <img src="{{ asset($galleryContent && $galleryContent->gallery_image ? 'storage/' . $galleryContent->gallery_image : 'images/img1.jpg') }}" alt="{{ $galleryContent->gallery_name ?? 'Gallery' }}" loading="lazy">
                <div class="category-overlay">
                    <h2>{{ $galleryContent->gallery_name ?? 'Gallery' }}</h2>
                    <p class="category-desc">{{ $galleryContent->gallery_description ?? 'NÈGRE Workshop - Espace créatif' }}</p>
                </div>
            </a>
        </div>
    </section>
@endsection

@section('scripts')
<script>
    // Carousel functionality - Optimisé
    const slides = document.querySelectorAll('.carousel-slide');
    const dotsContainer = document.getElementById('carouselDots');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    let currentSlide = 0;
    let autoPlayInterval;
    let isTransitioning = false;

    // Create dots avec accessibilité
    slides.forEach((_, index) => {
        const dot = document.createElement('button');
        dot.classList.add('dot');
        dot.setAttribute('role', 'tab');
        dot.setAttribute('aria-label', `Slide ${index + 1}`);
        if (index === 0) {
            dot.classList.add('active');
            dot.setAttribute('aria-selected', 'true');
        } else {
            dot.setAttribute('aria-selected', 'false');
        }
        dot.addEventListener('click', () => goToSlide(index));
        dotsContainer.appendChild(dot);
    });

    const dots = document.querySelectorAll('.dot');

    function showSlide(n) {
        if (isTransitioning) return;
        isTransitioning = true;

        slides.forEach(slide => {
            slide.classList.remove('active');
        });
        dots.forEach(dot => {
            dot.classList.remove('active');
            dot.setAttribute('aria-selected', 'false');
        });

        currentSlide = (n + slides.length) % slides.length;
        slides[currentSlide].classList.add('active');
        dots[currentSlide].classList.add('active');
        dots[currentSlide].setAttribute('aria-selected', 'true');

        setTimeout(() => {
            isTransitioning = false;
        }, 800);
    }

    function nextSlide() {
        showSlide(currentSlide + 1);
    }

    function prevSlide() {
        showSlide(currentSlide - 1);
    }

    function goToSlide(n) {
        stopAutoPlay();
        showSlide(n);
        startAutoPlay();
    }

    function startAutoPlay() {
        autoPlayInterval = setInterval(nextSlide, 5000);
    }

    function stopAutoPlay() {
        clearInterval(autoPlayInterval);
    }

    // Event listeners
    prevBtn.addEventListener('click', () => {
        stopAutoPlay();
        prevSlide();
        startAutoPlay();
    });

    nextBtn.addEventListener('click', () => {
        stopAutoPlay();
        nextSlide();
        startAutoPlay();
    });

    // Support clavier
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowLeft') {
            stopAutoPlay();
            prevSlide();
            startAutoPlay();
        } else if (e.key === 'ArrowRight') {
            stopAutoPlay();
            nextSlide();
            startAutoPlay();
        }
    });

    // Pause au survol
    const carouselContainer = document.querySelector('.carousel-container');
    carouselContainer.addEventListener('mouseenter', stopAutoPlay);
    carouselContainer.addEventListener('mouseleave', startAutoPlay);

    // Pause lorsque la page n'est pas visible
    document.addEventListener('visibilitychange', () => {
        if (document.hidden) {
            stopAutoPlay();
        } else {
            startAutoPlay();
        }
    });

    // Démarrer l'auto-play
    startAutoPlay();

    // Lazy loading pour les images
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
                        img.classList.remove('loading-placeholder');
                    }
                    observer.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[loading="lazy"]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    // Smooth scroll pour les ancres
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            const href = this.getAttribute('href');
            if (href !== '#' && document.querySelector(href)) {
                e.preventDefault();
                document.querySelector(href).scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // Support clavier pour les category cards
    document.querySelectorAll('.category-card').forEach(card => {
        card.addEventListener('keydown', (e) => {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                card.click();
            }
        });
    });
</script>
@endsection
