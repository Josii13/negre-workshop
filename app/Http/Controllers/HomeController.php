<?php

namespace App\Http\Controllers;

use App\Models\CarouselSlide;
use App\Models\Category;
use App\Models\Product;
use App\Models\PageHomeContent;
use App\Models\PageGalleryContent;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Afficher la page d'accueil
     */
    public function index()
    {
        // Récupérer les slides du carousel
        $slides = CarouselSlide::active()->ordered()->get();

        // Récupérer les catégories pour les cartes
        $categories = Category::active()->ordered()->get();

        // Récupérer les produits en vedette
        $featuredProducts = Product::featured()->available()->take(4)->get();

        // Récupérer le contenu dynamique de la page
        $pageContent = PageHomeContent::first();
        
        // Récupérer le contenu de la carte Gallery
        $galleryContent = PageGalleryContent::first();

        return view('home', compact('slides', 'categories', 'featuredProducts', 'pageContent', 'galleryContent'));
    }
}

