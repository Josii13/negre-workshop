<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CarouselSlide;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    /**
     * Display a listing of carousel slides.
     */
    public function index()
    {
        $slides = CarouselSlide::orderBy('order')->get();
        return view('admin.developer.carousel.index', compact('slides'));
    }

    /**
     * Show the form for creating a new carousel slide.
     */
    public function create()
    {
        return view('admin.developer.carousel.create');
    }

    /**
     * Store a newly created carousel slide in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        $validated['is_active'] = $request->has('is_active');

        CarouselSlide::create($validated);

        return redirect()
            ->route('admin.developer.carousel.index')
            ->with('success', 'Slide créé avec succès !');
    }

    /**
     * Show the form for editing the specified carousel slide.
     */
    public function edit(CarouselSlide $carousel)
    {
        return view('admin.developer.carousel.edit', compact('carousel'));
    }

    /**
     * Update the specified carousel slide in storage.
     */
    public function update(Request $request, CarouselSlide $carousel)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'button_text' => 'nullable|string|max:100',
            'button_link' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'order' => 'required|integer|min:0',
            'is_active' => 'boolean',
        ]);

        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image
            if ($carousel->image && file_exists(public_path('images/' . $carousel->image))) {
                unlink(public_path('images/' . $carousel->image));
            }

            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->move(public_path('images'), $imageName);
            $validated['image'] = $imageName;
        }

        $validated['is_active'] = $request->has('is_active');

        $carousel->update($validated);

        return redirect()
            ->route('admin.developer.carousel.index')
            ->with('success', 'Slide mis à jour avec succès !');
    }

    /**
     * Remove the specified carousel slide from storage.
     */
    public function destroy(CarouselSlide $carousel)
    {
        // Supprimer l'image
        if ($carousel->image && file_exists(public_path('images/' . $carousel->image))) {
            unlink(public_path('images/' . $carousel->image));
        }

        $carousel->delete();

        return redirect()
            ->route('admin.developer.carousel.index')
            ->with('success', 'Slide supprimé avec succès !');
    }
}

