<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category');
        
        // Filtrage par catégorie
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        // Filtrage par statut
        if ($request->filled('status')) {
            if ($request->status === 'available') {
                $query->where('is_available', true);
            } elseif ($request->status === 'unavailable') {
                $query->where('is_available', false);
            } elseif ($request->status === 'featured') {
                $query->where('is_featured', true);
            }
        }
        
        // Tri
        $sortBy = $request->get('sort', 'latest');
        switch ($sortBy) {
            case 'name':
                $query->orderBy('name');
                break;
            case 'price_asc':
                $query->orderBy('price');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            default:
                $query->latest();
        }
        
        $products = $query->paginate(15)->appends($request->query());
        $categories = Category::all();
        
        return view('admin.products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
            'dimensions' => 'nullable|string|max:255',
            'technique' => 'nullable|string|max:255',
            'support' => 'nullable|string|max:255',
            'materials' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'collection' => 'nullable|string|max:255',
            'sizes' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:255',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        if (!$request->slug) {
            $validated['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        Product::create($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit créé avec succès !');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|unique:products,slug,' . $product->id,
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
            'dimensions' => 'nullable|string|max:255',
            'technique' => 'nullable|string|max:255',
            'support' => 'nullable|string|max:255',
            'materials' => 'nullable|string|max:255',
            'style' => 'nullable|string|max:255',
            'collection' => 'nullable|string|max:255',
            'sizes' => 'nullable|string|max:255',
            'year' => 'nullable|string|max:255',
            'is_available' => 'nullable|boolean',
            'is_featured' => 'nullable|boolean',
        ]);

        if (!$request->slug) {
            $validated['slug'] = Str::slug($request->name);
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $validated['is_available'] = $request->has('is_available');
        $validated['is_featured'] = $request->has('is_featured');

        $product->update($validated);

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour avec succès !');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Produit supprimé avec succès !');
    }
}

