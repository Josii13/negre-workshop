<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Models\User;
use App\Models\SiteSetting;
use App\Models\PageContactContent;
use App\Http\Requests\StoreContactRequest;

class ContactController extends Controller
{
    /**
     * Afficher la page contact
     */
    public function index()
    {
        // Récupérer le contenu dynamique de la page
        $pageContent = PageContactContent::first();

        // Fallback vers les anciens paramètres si pas de contenu dynamique
        $contactInfo = [
            'address' => $pageContent->info_address ?? SiteSetting::get('contact_address', 'Cocody, Riviera Abatta<br>Abidjan, Côte d\'Ivoire'),
            'email' => $pageContent->info_email ?? SiteSetting::get('contact_email', 'fredericnda.ci@gmail.com'),
            'phone' => $pageContent->info_phone ?? SiteSetting::get('contact_phone', '+225 07 68 29 89 65'),
            'hours' => SiteSetting::get('contact_hours', 'Lundi - Vendredi: 9h - 18h<br>Sur rendez-vous uniquement'),
        ];

        return view('contact', compact('contactInfo', 'pageContent'));
    }

    /**
     * Traiter le formulaire de contact
     */
    public function store(StoreContactRequest $request)
    {
        $validated = $request->validated();
        Contact::create($validated);

        // Créer ou mettre à jour l'utilisateur
        User::updateOrCreate(
            ['email' => $validated['email']],
            [
                'name' => $validated['name'],
                'phone' => $validated['phone'],
                'type' => 'customer',
            ]
        );

        $successMessage = 'Merci pour votre message ! Nous vous contacterons bientôt.';

        // Retourner une réponse JSON pour les requêtes AJAX
        if ($request->wantsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => $successMessage,
                'contact_name' => $validated['name'],
            ]);
        }

        return back()->with('success', $successMessage);
    }
}

