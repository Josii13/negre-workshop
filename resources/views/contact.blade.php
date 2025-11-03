@extends('layouts.app')

@section('title', $pageContent->meta_title ?? 'Contact - Frederic N\'DA')

@section('content')
    <!-- Page Banner -->
    <section class="page-banner">
        <div class="banner-content">
            <h1>{{ $pageContent->banner_title ?? 'Contact' }}</h1>
            <p>{{ $pageContent->banner_description ?? 'Vous avez un projet, une question ou simplement envie d\'échanger ? N\'hésitez pas à me contacter. Je serais ravi de discuter avec vous de vos idées et de voir comment nous pourrions collaborer.' }}</p>
        </div>
    </section>

    <!-- Contact Section -->
    <section class="contact-section">
        <div class="contact-container">
            <div class="contact-form">
                <h2>{{ $pageContent->form_title ?? 'Envoyez-moi un message' }}</h2>
                @if($pageContent && $pageContent->form_description)
                <p style="margin-bottom: 1.5rem; color: black;">{{ $pageContent->form_description }}</p>
                @endif

                <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nom</label>
                        <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Téléphone</label>
                        <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" required>{{ old('message') }}</textarea>
                    </div>
                    <button type="submit" class="submit-btn">Envoyer</button>
                </form>
            </div>
            <div class="contact-info">
                <h2>{{ $pageContent->info_title ?? 'Informations' }}</h2>
                <div class="info-item">
                    <h3>Adresse</h3>
                    <p>{!! $contactInfo['address'] ?? 'Cocody, Riviera Abatta<br>Abidjan, Côte d\'Ivoire' !!}</p>
                </div>
                <div class="info-item">
                    <h3>Email</h3>
                    <p>{{ $contactInfo['email'] ?? 'fredericnda.ci@gmail.com' }}</p>
                </div>
                <div class="info-item">
                    <h3>Téléphone</h3>
                    <p>{{ $contactInfo['phone'] ?? '+225 07 68 29 89 65' }}</p>
                </div>
                <div class="info-item">
                    <h3>Horaires d'ouverture</h3>
                    <p>{!! $contactInfo['hours'] ?? 'Lundi - Vendredi: 9h - 18h<br>Sur rendez-vous uniquement' !!}</p>
                </div>
            </div>
        </div>
        <div class="map-container">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3972.4031824891945!2d-3.9878584!3d5.364494!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0xfc1ebba8afc00fb%3A0x4f8a53df72b5b9ab!2sRiviera%20Abatta%2C%20Abidjan%2C%20C%C3%B4te%20d'Ivoire!5e0!3m2!1sfr!2sfr!4v1234567890" allowfullscreen loading="lazy"></iframe>
        </div>
    </section>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const contactForm = document.getElementById('contactForm');

    if (contactForm) {
        contactForm.addEventListener('submit', function(e) {
            e.preventDefault();

            // Fonction pour préparer les données email
            const prepareEmailData = (formData, serverData) => ({
                to_email: '{{ env('CONTACT_EMAIL', 'fredericnda.ci@gmail.com') }}',
                to_name: 'Frederic N\'DA',
                from_name: formData.get('name'),
                from_email: formData.get('email'),
                from_phone: formData.get('phone'),
                message: formData.get('message')
            });

            // Utiliser le gestionnaire global
            handleFormSubmit(contactForm, prepareEmailData, {
                showLoadingModal: true,
                showSuccessModal: true,
                sendEmail: true,
                reloadOnSuccess: false,
                successTitle: 'Message envoyé !',
                successMessage: 'Merci pour votre message !',
                successSubMessage: 'Nous vous contacterons bientôt.',
                loadingTitle: 'Envoi en cours...',
                loadingMessage: 'Veuillez patienter pendant que nous traitons votre message.'
            });
        });
    }
});
</script>
@endsection


