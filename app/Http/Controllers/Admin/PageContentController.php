<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PageContentController extends Controller
{
    /**
     * Display a listing of the pages.
     */
    public function index()
    {
        $pages = [
            'home' => 'Page d\'Accueil',
            'peinture' => 'Page Peinture',
            'design' => 'Page Design',
            'gallery' => 'Page Gallery',
            'contact' => 'Page Contact',
            'marques' => 'Page Marques',
            'modals' => 'Modales (Textes Communs)',
        ];

        return view('admin.developer.page-contents.index', compact('pages'));
    }

    /**
     * Show the form for editing the specified page.
     */
    public function edit($page)
    {
        $validPages = ['home', 'peinture', 'design', 'gallery', 'contact', 'marques', 'modals'];

        if (!in_array($page, $validPages)) {
            abort(404, 'Page introuvable');
        }

        // Cas spécial pour les modales
        if ($page === 'modals') {
            $content = DB::table('modal_contents')->first();
        } else {
            // Récupérer le contenu de la page
            $content = DB::table('page_' . $page . '_contents')->first();
        }

        // Si aucun contenu n'existe, retourner un objet vide
        if (!$content) {
            $content = (object)[];
        }

        return view('admin.developer.page-contents.edit', compact('page', 'content'));
    }

    /**
     * Update the specified page content in storage.
     */
    public function update(Request $request, $page)
    {
        $validPages = ['home', 'peinture', 'design', 'gallery', 'contact', 'marques', 'modals'];

        if (!in_array($page, $validPages)) {
            abort(404, 'Page introuvable');
        }

        // Cas spécial pour les modales
        if ($page === 'modals') {
            $tableName = 'modal_contents';
        } else {
            $tableName = 'page_' . $page . '_contents';
        }

        // Récupérer toutes les données sauf _token, _method et les fichiers
        $data = $request->except(['_token', '_method', 'hero_image_file', 'hero_image_current', 'banner_background_file', 'banner_background_current', 'gallery_image_file', 'gallery_image_current']);
        
        // Gérer l'upload de l'image hero (spécifique à la page home)
        if ($page === 'home' && $request->hasFile('hero_image_file')) {
            $image = $request->file('hero_image_file');
            
            // Valider l'image
            $request->validate([
                'hero_image_file' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);
            
            // Générer un nom unique pour l'image
            $imageName = time() . '_hero_' . $image->getClientOriginalName();
            
            // Déplacer l'image dans public/images
            $image->move(public_path('images'), $imageName);
            
            // Supprimer l'ancienne image si elle existe et n'est pas une image par défaut
            $oldImage = $request->input('hero_image_current');
            if ($oldImage && !in_array($oldImage, ['img1.jpg', 'img2.jpg', 'logo.jpg'])) {
                $oldImagePath = public_path('images/' . basename($oldImage));
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
            
            // Stocker le nom du fichier (sans le chemin images/)
            $data['hero_image'] = $imageName;
        } elseif ($page === 'home' && !$request->hasFile('hero_image_file')) {
            // Si pas de nouveau fichier, garder l'ancienne valeur
            $data['hero_image'] = $request->input('hero_image_current');
        }
        
        // Gérer l'upload de l'image banner background (pages peinture, design, gallery et marques)
        if (in_array($page, ['peinture', 'design', 'gallery', 'marques']) && $request->hasFile('banner_background_file')) {
            $image = $request->file('banner_background_file');
            
            // Valider l'image
            $request->validate([
                'banner_background_file' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);
            
            // Générer un nom unique pour l'image
            $imageName = time() . '_banner_' . $image->getClientOriginalName();
            
            // Déplacer l'image dans public/images
            $image->move(public_path('images'), $imageName);
            
            // Supprimer l'ancienne image si elle existe et n'est pas une image par défaut
            $oldImage = $request->input('banner_background_current');
            if ($oldImage && !in_array($oldImage, ['img1.jpg', 'img2.jpg', 'logo.jpg'])) {
                $oldImagePath = public_path('images/' . basename($oldImage));
                if (file_exists($oldImagePath)) {
                    @unlink($oldImagePath);
                }
            }
            
            // Stocker le nom du fichier (sans le chemin images/)
            $data['banner_background'] = $imageName;
        } elseif (in_array($page, ['peinture', 'design', 'gallery', 'marques']) && !$request->hasFile('banner_background_file')) {
            // Si pas de nouveau fichier, garder l'ancienne valeur
            $data['banner_background'] = $request->input('banner_background_current');
        }
        
        // Gérer l'upload de l'image de la carte Gallery (page gallery uniquement)
        if ($page === 'gallery' && $request->hasFile('gallery_image_file')) {
            $image = $request->file('gallery_image_file');
            
            // Valider l'image
            $request->validate([
                'gallery_image_file' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048'
            ]);
            
            // Stocker dans storage/app/public/gallery
            $imagePath = $image->store('gallery', 'public');
            
            // Supprimer l'ancienne image si elle existe et n'est pas une image par défaut
            $oldImage = $request->input('gallery_image_current');
            if ($oldImage) {
                Storage::disk('public')->delete($oldImage);
            }
            
            // Stocker le chemin complet
            $data['gallery_image'] = $imagePath;
        } elseif ($page === 'gallery' && !$request->hasFile('gallery_image_file')) {
            // Si pas de nouveau fichier, garder l'ancienne valeur
            $data['gallery_image'] = $request->input('gallery_image_current');
        }
        
        $data['updated_at'] = now();

        // Vérifier si un enregistrement existe déjà
        $exists = DB::table($tableName)->count() > 0;

        if ($exists) {
            // Mise à jour
            DB::table($tableName)->update($data);
        } else {
            // Création
            $data['created_at'] = now();
            DB::table($tableName)->insert($data);
        }

        return redirect()
            ->route('admin.developer.page-contents.edit', $page)
            ->with('success', 'Contenu mis à jour avec succès !');
    }
}

