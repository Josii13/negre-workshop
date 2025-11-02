<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\PagePeintureContent;
use Illuminate\Http\Request;

class PeintureController extends Controller
{
    /**
     * Afficher la page peinture
     */
    public function index()
    {
        // Récupérer la catégorie peinture
        $category = Category::where('slug', 'peinture')->firstOrFail();

        // Récupérer tous les produits de peinture
        $products = Product::byCategory('peinture')
            ->available()
            ->ordered()
            ->get();

        // Récupérer le contenu dynamique de la page
        $pageContent = PagePeintureContent::first();

        return view('peinture', compact('category', 'products', 'pageContent'));
    }
}

