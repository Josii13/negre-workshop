<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Http\Requests\StoreOrderRequest;
use App\Models\User;
    
class OrderController extends Controller
{
    /**
     * Traiter une commande
     */
    public function store(StoreOrderRequest $request)
    {
        $validated = $request->validated();

        // Récupérer le produit pour sauvegarder ses informations
        $product = Product::findOrFail($validated['product_id']);

        // Créer la commande
        $order = Order::create([
            'product_id' => $validated['product_id'],
            'customer_name' => $validated['customer_name'],
            'customer_email' => $validated['customer_email'],
            'customer_phone' => $validated['customer_phone'],
            'message' => $validated['message'] ?? null,
            'product_name' => $product->name,
            'product_price' => $product->price,
            'status' => 'pending',
            'order_channel' => $validated['order_channel'] ?? 'app',
        ]);

        // Créer ou mettre à jour l'utilisateur
        User::updateOrCreate(
            ['email' => $validated['customer_email']],
            [
                'name' => $validated['customer_name'],
                'phone' => $validated['customer_phone'],
                'type' => 'customer',
            ]
        );

        // Retourner une réponse JSON pour les requêtes AJAX
        if ($request->wantsJson() || $request->ajax()) {
            $response = [
                'success' => true,
                'message' => 'Merci pour votre commande ! Nous vous contacterons bientôt.',
                'product_name' => $product->name,
                'product_price' => $product->formatted_price ?? $product->price . ' FCFA',
            ];
            
            // Si la commande est via WhatsApp, générer l'URL de redirection
            if ($order->order_channel === 'whatsapp') {
                $whatsappNumber = config('services.whatsapp.number', '2250769465904');
                $message = "Bonjour, je souhaite commander le produit suivant :\n\n*{$product->name}*\nPrix : " . ($product->formatted_price ?? $product->price . ' FCFA') . "\n\nNom: {$order->customer_name}\nEmail: {$order->customer_email}\nTéléphone: {$order->customer_phone}\n\nMerci de me recontacter pour finaliser la commande.";
                $encodedMessage = urlencode($message);
            // Utiliser wa.me (URL universelle qui s'adapte à l'environnement : mobile app, desktop app, ou web)
            $response['whatsapp_url'] = "https://wa.me/{$whatsappNumber}?text={$encodedMessage}";
                $response['redirect_to_whatsapp'] = true;
                $response['message_text'] = $message; // Pour copie manuelle si besoin
            }
            
            return response()->json($response);
        }

        return back()->with('success', 'Merci pour votre commande ! Nous vous contacterons bientôt.');
    }

    /**
     * Afficher les détails d'une commande
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}

