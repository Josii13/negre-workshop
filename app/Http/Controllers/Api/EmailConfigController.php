<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class EmailConfigController extends Controller
{
    /**
     * Retourne la configuration publique EmailJS
     * Cette route ne nécessite pas d'authentification car elle ne contient que des clés publiques
     */
    public function show()
    {
        return response()->json([
            'publicKey' => env('EMAILJS_PUBLIC_KEY', ''),
            'serviceId' => env('EMAILJS_SERVICE_ID', ''),
            'templateId' => env('EMAILJS_TEMPLATE_ID', ''),
            'templateAdminId' => env('EMAILJS_TEMPLATE_ADMIN_ID', ''),
            'adminEmail' => env('ADMIN_EMAIL', 'admin@example.com'),
            'adminName' => env('ADMIN_NAME', 'Administrateur'),
            'whatsappNumber' => env('WHATSAPP_NUMBER', '2250769465904'),
        ]);
    }
}

