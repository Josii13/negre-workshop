@extends('layouts.app')

@section('title', $pageContent->meta_title ?? 'NÈGRE Workshop Gallery - Frederic N\'DA')

@section('styles')
<style>
    /* Page Banner */
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
        line-height: 1.2;
    }

    .banner-content .subtitle {
        font-size: 1.5rem;
        font-weight: 300;
        color: #666;
        margin-bottom: 2rem;
        letter-spacing: 0.05em;
    }

    .banner-content p {
        font-size: 1.15rem;
        line-height: 1.8;
        color: #555;
        font-weight: 300;
    }

    .workshop-description {
        max-width: 800px;
        margin: 3rem auto 0;
        text-align: left;
        font-style: italic;
        color: #666;
        border-left: 3px solid #000;
        padding-left: 2rem;
        line-height: 1.7;
    }

    /* Search Section */
    .search-section {
        padding: 2rem 2rem 0;
        background: #FFFFFF;
    }

    .search-container {
        max-width: 1200px;
        margin: 0 auto;
        position: relative;
    }

    .search-wrapper {
        position: relative;
        max-width: 600px;
        margin: 0 auto;
    }

    .search-input-container {
        position: relative;
        display: flex;
        align-items: center;
        background: #FAFAFA;
        border: 2px solid #E8E8E8;
        border-radius: 50px;
        padding: 0.75rem 1.5rem;
        transition: all 0.3s ease;
    }

    .search-input-container:focus-within {
        background: #FFFFFF;
        border-color: #000;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
    }

    .search-icon {
        width: 20px;
        height: 20px;
        margin-right: 0.75rem;
        color: #999;
        transition: color 0.3s ease;
    }

    .search-input-container:focus-within .search-icon {
        color: #000;
    }

    .search-input {
        flex: 1;
        border: none;
        background: transparent;
        font-size: 1rem;
        font-family: 'Inter', sans-serif;
        color: #000;
        outline: none;
    }

    .search-input::placeholder {
        color: #999;
    }

    .search-clear {
        width: 24px;
        height: 24px;
        border: none;
        background: #E8E8E8;
        border-radius: 50%;
        cursor: pointer;
        display: none;
        align-items: center;
        justify-content: center;
        transition: all 0.3s ease;
        color: #666;
        font-size: 0.9rem;
    }

    .search-clear.active {
        display: flex;
    }

    .search-clear:hover {
        background: #000;
        color: #FFF;
    }

    .autocomplete-dropdown {
        position: absolute;
        top: calc(100% + 0.5rem);
        left: 0;
        right: 0;
        background: #FFFFFF;
        border: 1px solid #E8E8E8;
        border-radius: 12px;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
        max-height: 400px;
        overflow-y: auto;
        z-index: 1000;
        display: none;
    }

    .autocomplete-dropdown.active {
        display: block;
        animation: slideDown 0.3s ease;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .autocomplete-item {
        padding: 1rem 1.5rem;
        cursor: pointer;
        transition: all 0.2s ease;
        border-bottom: 1px solid #F5F5F5;
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .autocomplete-item:last-child {
        border-bottom: none;
    }

    .autocomplete-item:hover,
    .autocomplete-item.selected {
        background: #FAFAFA;
    }

    .autocomplete-item-image {
        width: 50px;
        height: 50px;
        border-radius: 6px;
        object-fit: cover;
        background: #F0F0F0;
    }

    .autocomplete-item-info {
        flex: 1;
    }

    .autocomplete-item-title {
        font-weight: 500;
        color: #000;
        margin-bottom: 0.25rem;
        font-size: 0.95rem;
    }

    .autocomplete-item-meta {
        font-size: 0.85rem;
        color: #666;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .autocomplete-item-badge {
        background: #F0F0F0;
        padding: 0.2rem 0.6rem;
        border-radius: 12px;
        font-size: 0.75rem;
        color: #666;
    }

    .autocomplete-no-results {
        padding: 2rem;
        text-align: center;
        color: #999;
    }

    .autocomplete-no-results svg {
        width: 48px;
        height: 48px;
        margin-bottom: 0.75rem;
        opacity: 0.3;
    }

    .search-results-count {
        text-align: center;
        margin: 1.5rem 0 0;
        color: #666;
        font-size: 0.95rem;
    }

    .search-results-count strong {
        color: #000;
        font-weight: 600;
    }

    /* Tabs Section */
    .tabs-section {
        padding: 2rem 2rem 4rem;
        min-height: 60vh;
    }

    .tabs-container {
        max-width: 1200px;
        margin: 0 auto;
    }

    .tabs-header {
        display: flex;
        justify-content: center;
        margin-bottom: 3rem;
        border-bottom: 2px solid #F0F0F0;
        flex-wrap: wrap;
        gap: 0.5rem;
        position: sticky;
        top: 80px;
        background: #FFFFFF;
        z-index: 100;
        padding: 1rem 0;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }

    .tab-btn {
        padding: 1rem 2rem;
        background: none;
        border: none;
        font-family: 'Inter', sans-serif;
        font-size: 1rem;
        font-weight: 400;
        color: #666;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        border-bottom: 3px solid transparent;
        white-space: nowrap;
    }

    .tab-btn:hover {
        color: #000;
        background: rgba(0, 0, 0, 0.02);
    }

    .tab-btn.active {
        color: #000;
        font-weight: 500;
        border-bottom-color: #000;
    }

    .tab-content {
        display: none;
        animation: fadeIn 0.4s ease;
    }

    .tab-content.active {
        display: block;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(15px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* Activities Grid */
    .activities-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
        gap: 2rem;
        margin-bottom: 2rem;
    }

    .activity-card {
        background: #FFFFFF;
        border: 1px solid #E8E8E8;
        border-radius: 8px;
        overflow: hidden;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        cursor: pointer;
        height: 100%;
        display: flex;
        flex-direction: column;
    }

    .activity-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        border-color: #000;
    }

    .activity-image {
        height: 240px;
        background: linear-gradient(135deg, #FAFAFA 0%, #F5F5F5 100%);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        border-bottom: 1px solid #F0F0F0;
        position: relative;
        overflow: hidden;
    }

    .activity-image img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .activity-card:hover .activity-image img {
        transform: scale(1.08);
    }

    .activity-icon {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%) scale(0.8);
        width: 64px;
        height: 64px;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
    }

    .activity-card:hover .activity-icon {
        opacity: 1;
        transform: translate(-50%, -50%) scale(1);
    }

    .activity-icon svg {
        width: 28px;
        height: 28px;
        stroke: #000;
        stroke-width: 2;
    }

    .activity-info {
        padding: 1.75rem;
        flex: 1;
        display: flex;
        flex-direction: column;
    }

    .activity-info h3 {
        font-size: 1.35rem;
        font-weight: 500;
        margin-bottom: 0.75rem;
        letter-spacing: -0.01em;
        line-height: 1.3;
        color: #000;
    }

    .activity-info p {
        color: #666;
        font-size: 0.95rem;
        line-height: 1.6;
        margin-bottom: auto;
        flex: 1;
    }

    .activity-meta {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-size: 0.85rem;
        color: #999;
        margin-top: 1rem;
        padding-top: 1rem;
        border-top: 1px solid #F0F0F0;
    }

    .activity-type {
        background: linear-gradient(135deg, #F5F5F5 0%, #FAFAFA 100%);
        padding: 0.4rem 1rem;
        border-radius: 20px;
        font-size: 0.8rem;
        font-weight: 500;
        color: #333;
        border: 1px solid #E8E8E8;
    }

    /* Modal */
    .detail-modal {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.88);
        backdrop-filter: blur(4px);
        z-index: 2000;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        overflow-y: auto;
    }

    .detail-modal.active {
        display: flex;
    }

    .detail-modal-content {
        background-color: #FFFFFF;
        max-width: 950px;
        width: 100%;
        max-height: 92vh;
        overflow: hidden;
        position: relative;
        animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        border-radius: 12px;
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 0;
        box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
    }

    @keyframes slideUp {
        from {
            opacity: 0;
            transform: translateY(40px) scale(0.95);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    .detail-image-container {
        background-color: #F7F7F7;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 2.5rem;
        overflow: hidden;
    }

    .detail-image-container img {
        max-width: 100%;
        max-height: 450px;
        object-fit: contain;
        border-radius: 4px;
    }

    .detail-info-container {
        padding: 3rem;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        overflow-y: auto;
        max-height: 92vh;
    }

    .detail-info-container::-webkit-scrollbar {
        width: 6px;
    }

    .detail-info-container::-webkit-scrollbar-track {
        background: #F5F5F5;
    }

    .detail-info-container::-webkit-scrollbar-thumb {
        background: #CCC;
        border-radius: 3px;
    }

    .detail-info-container::-webkit-scrollbar-thumb:hover {
        background: #999;
    }

    .detail-close {
        position: absolute;
        top: 1.25rem;
        right: 1.25rem;
        background: rgba(255, 255, 255, 0.95);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(0, 0, 0, 0.08);
        font-size: 1.5rem;
        cursor: pointer;
        color: #000;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        width: 44px;
        height: 44px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        z-index: 10;
        font-weight: 300;
    }

    .detail-close:hover {
        background: #000000;
        color: #FFFFFF;
        transform: rotate(90deg);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    }

    .detail-title {
        font-size: 2rem;
        font-weight: 500;
        margin-bottom: 1.25rem;
        letter-spacing: -0.02em;
        line-height: 1.3;
        color: #000;
    }

    .detail-price {
        font-size: 1.5rem;
        font-weight: 600;
        color: #000;
        margin-bottom: 1.75rem;
        padding: 0.85rem 1.5rem;
        background: linear-gradient(135deg, #F5F5F5 0%, #FAFAFA 100%);
        border-left: 4px solid #000;
        display: inline-block;
        border-radius: 4px;
    }

    .detail-description {
        margin-bottom: 2rem;
        padding: 1.75rem;
        background-color: #FAFAFA;
        border-left: 4px solid #000000;
        border-radius: 4px;
    }

    .detail-description p {
        font-size: 0.98rem;
        line-height: 1.75;
        color: #333;
    }

    .detail-characteristics {
        margin-bottom: 2rem;
    }

    .detail-characteristics h4 {
        font-size: 0.9rem;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.1em;
        color: #666;
        margin-bottom: 1.25rem;
    }

    .characteristic-item {
        display: flex;
        justify-content: space-between;
        padding: 0.85rem 0;
        border-bottom: 1px solid #F0F0F0;
        align-items: center;
    }

    .characteristic-item:last-child {
        border-bottom: none;
    }

    .characteristic-label {
        color: #666;
        font-size: 0.95rem;
    }

    .characteristic-value {
        font-weight: 500;
        font-size: 0.95rem;
        color: #000;
    }

    .whatsapp-btn {
        width: 100%;
        padding: 1.15rem;
        background-color: #25D366;
        color: #FFFFFF;
        border: none;
        font-size: 1.05rem;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        font-family: 'Inter', sans-serif;
        letter-spacing: 0.02em;
        border-radius: 6px;
        text-decoration: none;
        text-align: center;
        display: block;
        box-shadow: 0 4px 12px rgba(37, 211, 102, 0.3);
    }

    .whatsapp-btn:hover {
        background-color: #128C7E;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(37, 211, 102, 0.4);
    }

    .whatsapp-btn:active {
        transform: translateY(0);
    }

    /* Loading State */
    .activity-card.loading .activity-image {
        background: linear-gradient(90deg, #F0F0F0 25%, #E8E8E8 50%, #F0F0F0 75%);
        background-size: 200% 100%;
        animation: shimmer 1.5s infinite;
    }

    @keyframes shimmer {
        0% { background-position: -200% 0; }
        100% { background-position: 200% 0; }
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        grid-column: 1/-1;
        padding: 4rem 2rem;
        color: #999;
    }

    .empty-state svg {
        width: 64px;
        height: 64px;
        margin-bottom: 1rem;
        opacity: 0.3;
    }

    .empty-state p {
        font-size: 1.1rem;
        margin-bottom: 0.5rem;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .banner-content h1 {
            font-size: 2.25rem;
        }

        .banner-content .subtitle {
            font-size: 1.15rem;
        }

        .workshop-description {
            padding-left: 1rem;
            margin-top: 2rem;
            font-size: 0.95rem;
        }

        .search-section {
            padding: 1.5rem 1rem 0;
        }

        .search-wrapper {
            max-width: 100%;
        }

        .search-input-container {
            padding: 0.65rem 1.25rem;
        }

        .tabs-header {
            gap: 0;
            top: 60px;
            padding: 0.5rem 0;
        }

        .tab-btn {
            padding: 0.85rem 1.25rem;
            font-size: 0.9rem;
        }

        .activities-grid {
            grid-template-columns: 1fr;
            gap: 1.5rem;
        }

        .detail-modal {
            padding: 1rem;
        }

        .detail-modal-content {
            grid-template-columns: 1fr;
            max-height: 90vh;
            border-radius: 8px;
        }

        .detail-image-container {
            padding: 2rem;
            max-height: 300px;
        }

        .detail-info-container {
            padding: 2rem;
        }

        .detail-title {
            font-size: 1.65rem;
        }

        .detail-price {
            font-size: 1.3rem;
            padding: 0.75rem 1.25rem;
        }
    }

    @media (max-width: 480px) {
        .page-banner {
            padding: 4rem 1.5rem 2.5rem;
        }

        .banner-content h1 {
            font-size: 1.85rem;
        }

        .tabs-section {
            padding: 3rem 1rem;
        }

        .activity-card {
            border-radius: 6px;
        }

        .activity-info {
            padding: 1.5rem;
        }

        .activity-info h3 {
            font-size: 1.2rem;
        }
    }

    /* Focus States for Accessibility */
    .tab-btn:focus-visible,
    .activity-card:focus-visible,
    .detail-close:focus-visible,
    .whatsapp-btn:focus-visible {
        outline: 3px solid #000;
        outline-offset: 3px;
    }

    /* Smooth Scrolling */
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection

@section('content')
    <!-- Page Banner -->
    <section class="page-banner" @if($pageContent && $pageContent->banner_background) style="background-image: linear-gradient(135deg, rgba(250, 250, 250, 0.95) 0%, rgba(255, 255, 255, 0.9) 100%), url('{{ asset('images/' . $pageContent->banner_background) }}'); background-size: cover; background-position: center;" @endif>
        <div class="banner-content">
            <h1>{{ $pageContent->banner_title ?? 'NÈGRE Workshop Gallery' }}</h1>
            <div class="subtitle">{{ $pageContent->banner_subtitle ?? 'LE NÈGRE | workshop - gallery' }}</div>
            <p>{{ $pageContent->banner_description ?? 'Un espace inspirant dédié à la création artistique, aux événements et aux échanges culturels.' }}</p>
            @if($pageContent && $pageContent->banner_quote)
            <div class="workshop-description">
                <p>"{{ $pageContent->banner_quote }}"</p>
            </div>
            @else
            <div class="workshop-description">
                <p>"Est un atelier artistique fondé par l'artiste peintre Frederic N'DA aka 'le nègre', cet espace inspirant destiné à sa pratique artistique, à la créativité, aux petits événements artistiques et aux podcasts où d'autres créateurs et artistes pourront raconter leurs histoires et leurs approches artistiques."</p>
            </div>
            @endif
        </div>
    </section>

    <!-- Search Section -->
    <section class="search-section">
        <div class="search-container">
            <div class="search-wrapper">
                <div class="search-input-container">
                    <svg class="search-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input
                        type="text"
                        id="searchInput"
                        class="search-input"
                        placeholder="Rechercher une activité, événement, podcast..."
                        autocomplete="off"
                    >
                    <button class="search-clear" id="searchClear" aria-label="Effacer">✕</button>
                </div>
                <div class="autocomplete-dropdown" id="autocompleteDropdown"></div>
            </div>
            <div class="search-results-count" id="searchResultsCount" style="display: none;"></div>
        </div>
    </section>

    <!-- Tabs Section -->
    <section class="tabs-section">
        <div class="tabs-container">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="atelier" aria-selected="true">{{ $pageContent->tab_atelier ?? 'L\'Atelier' }}</button>
                <button class="tab-btn" data-tab="activites" aria-selected="false">{{ $pageContent->tab_activites ?? 'Activités' }}</button>
                <button class="tab-btn" data-tab="evenements" aria-selected="false">{{ $pageContent->tab_evenements ?? 'Événements' }}</button>
                <button class="tab-btn" data-tab="podcasts" aria-selected="false">{{ $pageContent->tab_podcasts ?? 'Podcasts' }}</button>
            </div>

            <!-- Tab 1: L'Atelier -->
            <div class="tab-content active" id="atelier" role="tabpanel">
                <div class="activities-grid">
                    @foreach($atelierActivities as $activity)
                    <div class="activity-card" onclick="openActivityModal({{ $loop->index }}, 'atelier')" role="button" tabindex="0" onkeypress="if(event.key==='Enter') openActivityModal({{ $loop->index }}, 'atelier')">
                        <div class="activity-image">
                            <img src="{{ asset($activity->image ? 'storage/' . $activity->image : 'images/img1.jpg') }}" alt="{{ $activity->title }}" loading="lazy">
                            <div class="activity-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="activity-info">
                            <h3>{{ $activity->title }}</h3>
                            <p>{{ Str::limit($activity->description, 100) }}</p>
                            <div class="activity-meta">
                                <span class="activity-type">{{ $activity->type }}</span>
                                <span>{{ $activity->capacity }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tab 2: Activités -->
            <div class="tab-content" id="activites" role="tabpanel">
                <div class="activities-grid">
                    @foreach($activities as $activity)
                    <div class="activity-card" onclick="openActivityModal({{ $loop->index }}, 'activites')" role="button" tabindex="0" onkeypress="if(event.key==='Enter') openActivityModal({{ $loop->index }}, 'activites')">
                        <div class="activity-image">
                            <img src="{{ asset($activity->image ? 'storage/' . $activity->image : 'images/img1.jpg') }}" alt="{{ $activity->title }}" loading="lazy">
                            <div class="activity-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="activity-info">
                            <h3>{{ $activity->title }}</h3>
                            <p>{{ Str::limit($activity->description, 100) }}</p>
                            <div class="activity-meta">
                                <span class="activity-type">{{ $activity->type }}</span>
                                <span>{{ $activity->frequency }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Tab 3: Événements -->
            <div class="tab-content" id="evenements" role="tabpanel">
                <div class="activities-grid">
                    @forelse($evenements as $activity)
                    <div class="activity-card" onclick="openActivityModal({{ $loop->index }}, 'evenements')" role="button" tabindex="0" onkeypress="if(event.key==='Enter') openActivityModal({{ $loop->index }}, 'evenements')">
                        <div class="activity-image">
                            <img src="{{ asset($activity->image ? 'storage/' . $activity->image : 'images/img1.jpg') }}" alt="{{ $activity->title }}" loading="lazy">
                            <div class="activity-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="activity-info">
                            <h3>{{ $activity->title }}</h3>
                            <p>{{ Str::limit($activity->description, 100) }}</p>
                            <div class="activity-meta">
                                <span class="activity-type">{{ $activity->type }}</span>
                                <span>{{ $activity->frequency }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5" />
                        </svg>
                        <p>Aucun événement disponible pour le moment.</p>
                        <p style="font-size: 0.9rem; margin-top: 0.5rem;">Revenez bientôt pour découvrir nos prochains événements.</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab 4: Podcasts -->
            <div class="tab-content" id="podcasts" role="tabpanel">
                <div class="activities-grid">
                    @forelse($podcasts as $activity)
                    <div class="activity-card" onclick="openActivityModal({{ $loop->index }}, 'podcasts')" role="button" tabindex="0" onkeypress="if(event.key==='Enter') openActivityModal({{ $loop->index }}, 'podcasts')">
                        <div class="activity-image">
                            <img src="{{ asset($activity->image ? 'storage/' . $activity->image : 'images/img1.jpg') }}" alt="{{ $activity->title }}" loading="lazy">
                            <div class="activity-icon" aria-hidden="true">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="activity-info">
                            <h3>{{ $activity->title }}</h3>
                            <p>{{ Str::limit($activity->description, 100) }}</p>
                            <div class="activity-meta">
                                <span class="activity-type">{{ $activity->type }}</span>
                                <span>{{ $activity->frequency }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M19 11a7 7 0 01-7 7m0 0a7 7 0 01-7-7m7 7v4m0 0H8m4 0h4m-4-8a3 3 0 01-3-3V5a3 3 0 116 0v6a3 3 0 01-3 3z" />
                        </svg>
                        <p>Aucun podcast disponible pour le moment.</p>
                        <p style="font-size: 0.9rem; margin-top: 0.5rem;">Restez à l'écoute pour nos futurs épisodes.</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div id="activityModal" class="detail-modal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
        <div class="detail-modal-content">
            <button class="detail-close" onclick="closeActivityModal()" aria-label="Fermer">✕</button>
            <div class="detail-image-container">
                <img id="modalImage" src="" alt="">
            </div>
            <div class="detail-info-container">
                <div>
                    <h2 class="detail-title" id="modalTitle"></h2>
                    <div class="detail-price" id="modalPrice" style="display: none;"></div>
                    <div class="detail-description">
                        <p id="modalDescription"></p>
                    </div>
                    <div class="detail-characteristics">
                        <h4>{{ $pageContent->modal_details_title ?? 'Détails' }}</h4>
                        <div class="characteristic-item">
                            <span class="characteristic-label">{{ $pageContent->modal_label_type ?? 'Type' }}</span>
                            <span class="characteristic-value" id="modalType"></span>
                        </div>
                        <div class="characteristic-item">
                            <span class="characteristic-label">{{ $pageContent->modal_label_frequency ?? 'Fréquence' }}</span>
                            <span class="characteristic-value" id="modalFrequency"></span>
                        </div>
                        <div class="characteristic-item">
                            <span class="characteristic-label">{{ $pageContent->modal_label_capacity ?? 'Capacité' }}</span>
                            <span class="characteristic-value" id="modalCapacity"></span>
                        </div>
                        <div class="characteristic-item">
                            <span class="characteristic-label">{{ $pageContent->modal_label_audience ?? 'Public' }}</span>
                            <span class="characteristic-value" id="modalAudience"></span>
                        </div>
                    </div>
                </div>
                <a href="#" class="whatsapp-btn" id="modalWhatsapp">{{ $pageContent->modal_button_whatsapp ?? 'Réserver sur WhatsApp' }}</a>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    const allActivities = {
        atelier: @json($atelierActivities),
        activites: @json($activities),
        evenements: @json($evenements),
        podcasts: @json($podcasts)
    };
    const whatsappNumber = "{{ $whatsappNumber ?? '2250769465904' }}";
    const whatsappMessageTemplate = @json($pageContent->whatsapp_message_template ?? 'Bonjour, je souhaite réserver : {activity_title}');
    let currentActivity = null;
    let selectedAutocompleteIndex = -1;
    let filteredActivities = [];

    // Créer un tableau plat de toutes les activités avec leur catégorie
    const allActivitiesFlat = [];
    Object.keys(allActivities).forEach(category => {
        allActivities[category].forEach(activity => {
            allActivitiesFlat.push({
                ...activity,
                category: category,
                categoryLabel: getCategoryLabel(category)
            });
        });
    });

    function getCategoryLabel(category) {
        const labels = {
            'atelier': 'L\'Atelier',
            'activites': 'Activités',
            'evenements': 'Événements',
            'podcasts': 'Podcasts'
        };
        return labels[category] || category;
    }

    // Fonction de recherche
    function searchActivities(query) {
        if (!query || query.trim().length === 0) {
            return [];
        }

        const searchTerm = query.toLowerCase().trim();

        return allActivitiesFlat.filter(activity => {
            return activity.title.toLowerCase().includes(searchTerm) ||
                   activity.description.toLowerCase().includes(searchTerm) ||
                   activity.type.toLowerCase().includes(searchTerm) ||
                   activity.categoryLabel.toLowerCase().includes(searchTerm);
        });
    }

    // Gestion du champ de recherche
    const searchInput = document.getElementById('searchInput');
    const searchClear = document.getElementById('searchClear');
    const autocompleteDropdown = document.getElementById('autocompleteDropdown');
    const searchResultsCount = document.getElementById('searchResultsCount');

    searchInput.addEventListener('input', function(e) {
        const query = e.target.value;

        // Afficher/masquer le bouton clear
        if (query.length > 0) {
            searchClear.classList.add('active');
        } else {
            searchClear.classList.remove('active');
            autocompleteDropdown.classList.remove('active');
            clearSearchResults();
            return;
        }

        // Rechercher et afficher les résultats
        filteredActivities = searchActivities(query);
        displayAutocomplete(filteredActivities);
    });

    // Bouton clear
    searchClear.addEventListener('click', function() {
        searchInput.value = '';
        searchClear.classList.remove('active');
        autocompleteDropdown.classList.remove('active');
        clearSearchResults();
        searchInput.focus();
    });

    // Afficher l'autocomplétion
    function displayAutocomplete(results) {
        selectedAutocompleteIndex = -1;

        if (results.length === 0) {
            autocompleteDropdown.innerHTML = `
                <div class="autocomplete-no-results">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <p>Aucun résultat trouvé</p>
                </div>
            `;
            autocompleteDropdown.classList.add('active');
            return;
        }

        const html = results.map((activity, index) => {
            const imagePath = activity.image ? '/storage/' + activity.image : '/images/img1.jpg';
            return `
                <div class="autocomplete-item" data-index="${index}" onclick="selectActivity(${index})">
                    <img src="${imagePath}" alt="${activity.title}" class="autocomplete-item-image">
                    <div class="autocomplete-item-info">
                        <div class="autocomplete-item-title">${activity.title}</div>
                        <div class="autocomplete-item-meta">
                            <span class="autocomplete-item-badge">${activity.categoryLabel}</span>
                            <span>${activity.type}</span>
                        </div>
                    </div>
                </div>
            `;
        }).join('');

        autocompleteDropdown.innerHTML = html;
        autocompleteDropdown.classList.add('active');
    }

    // Sélectionner une activité depuis l'autocomplétion
    function selectActivity(index) {
        const activity = filteredActivities[index];
        searchInput.value = activity.title;
        autocompleteDropdown.classList.remove('active');

        // Afficher les résultats de recherche
        displaySearchResults([activity]);

        // Ouvrir le modal directement
        const activityIndex = allActivities[activity.category].findIndex(a => a.title === activity.title);
        if (activityIndex !== -1) {
            openActivityModal(activityIndex, activity.category);
        }
    }

    // Navigation clavier dans l'autocomplétion
    searchInput.addEventListener('keydown', function(e) {
        const items = autocompleteDropdown.querySelectorAll('.autocomplete-item');

        if (e.key === 'ArrowDown') {
            e.preventDefault();
            selectedAutocompleteIndex = Math.min(selectedAutocompleteIndex + 1, items.length - 1);
            updateAutocompleteSelection(items);
        } else if (e.key === 'ArrowUp') {
            e.preventDefault();
            selectedAutocompleteIndex = Math.max(selectedAutocompleteIndex - 1, -1);
            updateAutocompleteSelection(items);
        } else if (e.key === 'Enter' && selectedAutocompleteIndex >= 0) {
            e.preventDefault();
            selectActivity(selectedAutocompleteIndex);
        } else if (e.key === 'Escape') {
            autocompleteDropdown.classList.remove('active');
            selectedAutocompleteIndex = -1;
        }
    });

    function updateAutocompleteSelection(items) {
        items.forEach((item, index) => {
            if (index === selectedAutocompleteIndex) {
                item.classList.add('selected');
                item.scrollIntoView({ block: 'nearest' });
            } else {
                item.classList.remove('selected');
            }
        });
    }

    // Afficher les résultats de recherche dans la grille
    function displaySearchResults(results) {
        searchResultsCount.innerHTML = `<strong>${results.length}</strong> résultat${results.length > 1 ? 's' : ''} trouvé${results.length > 1 ? 's' : ''}`;
        searchResultsCount.style.display = 'block';

        // Masquer tous les onglets et cartes
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = 'none';
        });

        // Créer un onglet de résultats de recherche temporaire
        let searchResultsTab = document.getElementById('search-results-tab');
        if (!searchResultsTab) {
            searchResultsTab = document.createElement('div');
            searchResultsTab.id = 'search-results-tab';
            searchResultsTab.className = 'tab-content active';
            document.querySelector('.tabs-container').appendChild(searchResultsTab);
        }

        // Afficher les résultats
        const html = `
            <div class="activities-grid">
                ${results.map(activity => {
                    const imagePath = activity.image ? '/storage/' + activity.image : '/images/img1.jpg';
                    const activityIndex = allActivities[activity.category].findIndex(a => a.title === activity.title);
                    return `
                        <div class="activity-card" onclick="openActivityModal(${activityIndex}, '${activity.category}')" role="button" tabindex="0">
                            <div class="activity-image">
                                <img src="${imagePath}" alt="${activity.title}" loading="lazy">
                                <div class="activity-icon" aria-hidden="true">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="activity-info">
                                <h3>${activity.title}</h3>
                                <p>${activity.description.substring(0, 100)}${activity.description.length > 100 ? '...' : ''}</p>
                                <div class="activity-meta">
                                    <span class="activity-type">${activity.categoryLabel}</span>
                                    <span>${activity.type}</span>
                                </div>
                            </div>
                        </div>
                    `;
                }).join('')}
            </div>
        `;

        searchResultsTab.innerHTML = html;
        searchResultsTab.style.display = 'block';

        // Désactiver tous les onglets
        document.querySelectorAll('.tab-btn').forEach(btn => {
            btn.classList.remove('active');
            btn.setAttribute('aria-selected', 'false');
        });
    }

    // Effacer les résultats de recherche
    function clearSearchResults() {
        searchResultsCount.style.display = 'none';
        const searchResultsTab = document.getElementById('search-results-tab');
        if (searchResultsTab) {
            searchResultsTab.remove();
        }

        // Réafficher le premier onglet
        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.style.display = '';
        });
        document.querySelector('.tab-btn').click();
    }

    // Fermer l'autocomplétion en cliquant à l'extérieur
    document.addEventListener('click', function(e) {
        if (!searchInput.contains(e.target) && !autocompleteDropdown.contains(e.target)) {
            autocompleteDropdown.classList.remove('active');
        }
    });

    // Gestion des tabs avec accessibilité
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            switchTab(this);
        });

        // Support clavier
        btn.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                switchTab(this);
            }
        });
    });

    function switchTab(button) {
        // Désactiver tous les tabs
        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('active');
            b.setAttribute('aria-selected', 'false');
        });
        document.querySelectorAll('.tab-content').forEach(c => {
            c.classList.remove('active');
        });

        // Activer le tab sélectionné
        button.classList.add('active');
        button.setAttribute('aria-selected', 'true');
        const tabId = button.getAttribute('data-tab');
        document.getElementById(tabId).classList.add('active');

        // Smooth scroll vers le contenu sur mobile
        if (window.innerWidth <= 768) {
            setTimeout(() => {
                document.getElementById(tabId).scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }, 100);
        }
    }

    // Ouvrir le modal d'activité
    function openActivityModal(index, tab) {
        currentActivity = allActivities[tab][index];
        const imagePath = currentActivity.image ? '/storage/' + currentActivity.image : '/images/img1.jpg';

        const modalImage = document.getElementById('modalImage');
        modalImage.src = imagePath;
        modalImage.alt = currentActivity.title;

        document.getElementById('modalTitle').textContent = currentActivity.title;

        const priceElement = document.getElementById('modalPrice');
        if (currentActivity.price) {
            priceElement.textContent = currentActivity.price;
            priceElement.style.display = 'inline-block';
        } else {
            priceElement.style.display = 'none';
        }

        document.getElementById('modalDescription').textContent = currentActivity.description;
        document.getElementById('modalType').textContent = currentActivity.type;
        document.getElementById('modalFrequency').textContent = currentActivity.frequency || 'N/A';
        document.getElementById('modalCapacity').textContent = currentActivity.capacity || 'N/A';
        document.getElementById('modalAudience').textContent = currentActivity.audience || 'N/A';

        // Utiliser le template WhatsApp dynamique
        const message = whatsappMessageTemplate.replace('{activity_title}', currentActivity.title);
        const encodedMessage = encodeURIComponent(message);
        document.getElementById('modalWhatsapp').href = `https://wa.me/${whatsappNumber}?text=${encodedMessage}`;

        const modal = document.getElementById('activityModal');
        modal.classList.add('active');
        document.body.style.overflow = 'hidden';

        // Focus sur le bouton de fermeture pour l'accessibilité
        setTimeout(() => {
            document.querySelector('.detail-close').focus();
        }, 100);
    }

    function closeActivityModal() {
        const modal = document.getElementById('activityModal');
        modal.classList.remove('active');
        document.body.style.overflow = 'auto';
        currentActivity = null;
    }

    // Fermeture du modal en cliquant à l'extérieur
    document.getElementById('activityModal').addEventListener('click', function(e) {
        if (e.target === this) closeActivityModal();
    });

    // Fermeture du modal avec Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('activityModal');
            if (modal.classList.contains('active')) {
                closeActivityModal();
            }
        }
    });

    // Lazy loading images optimization
    if ('IntersectionObserver' in window) {
        const imageObserver = new IntersectionObserver((entries, observer) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    if (img.dataset.src) {
                        img.src = img.dataset.src;
                        img.removeAttribute('data-src');
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
</script>
@endsection
