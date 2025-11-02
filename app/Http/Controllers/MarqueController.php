<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\PageMarquesContent;
use Illuminate\Http\Request;

class MarqueController extends Controller
{
    /**
     * Afficher la page marque
     */
    public function index()
    {
        // Récupérer la catégorie marque
        $category = Category::where('slug', 'marque')->firstOrFail();

        // Récupérer tous les produits de la marque
        $products = Product::byCategory('marque')
            ->available()
            ->ordered()
            ->get();

        // Récupérer le contenu dynamique de la page
        $pageContent = PageMarquesContent::first();

        // Numéro WhatsApp depuis le .env
        $whatsappNumber = env('WHATSAPP_NUMBER', '2250769465904');

        return view('marques', compact('category', 'products', 'pageContent', 'whatsappNumber'));
    }
}

