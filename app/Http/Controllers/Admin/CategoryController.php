<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::withCount('products')->latest()->paginate(15);
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if (!$request->slug) {
            $validated['slug'] = Str::slug($request->name);
        }

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        Category::create($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie créée avec succès !');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if (!$request->slug) {
            $validated['slug'] = Str::slug($request->name);
        }

        // Gérer la suppression de l'image si demandée
        if ($request->has('remove_image') && $request->remove_image == '1') {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
                $validated['image'] = null;
            }
        }
        // Gérer l'upload de la nouvelle image
        elseif ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            
            // Stocker la nouvelle image dans storage/app/public/categories
            $validated['image'] = $request->file('image')->store('categories', 'public');
        }

        $category->update($validated);

        return redirect()->route('admin.categories.index')->with('success', 'Catégorie mise à jour avec succès !');
    }

    public function destroy(Request $request, Category $category)
    {
        $productsCount = $category->products()->count();

        // Si la catégorie a des produits, vérifier le mot de passe
        if ($productsCount > 0) {
            // Valider que le mot de passe a été fourni
            $request->validate([
                'password' => 'required',
            ], [
                'password.required' => 'Le mot de passe est requis pour cette opération.',
            ]);

            // Vérifier le mot de passe de l'utilisateur connecté
            if (!Hash::check($request->password, Auth::user()->password)) {
                return redirect()->route('admin.categories.index')
                    ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
            }

            // Récupérer et supprimer les images des produits avant de les supprimer
            $products = $category->products;
            foreach ($products as $product) {
                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }
            }

            // Supprimer tous les produits de cette catégorie
            $category->products()->delete();
        }

        // Supprimer l'image de la catégorie si elle existe
        if ($category->image) {
            Storage::disk('public')->delete($category->image);
        }

        // Supprimer la catégorie
        $category->delete();

        if ($productsCount > 0) {
            return redirect()->route('admin.categories.index')
                ->with('success', "Catégorie et ses {$productsCount} produit(s) supprimé(s) avec succès !");
        }

        return redirect()->route('admin.categories.index')
            ->with('success', 'Catégorie supprimée avec succès !');
    }
}

