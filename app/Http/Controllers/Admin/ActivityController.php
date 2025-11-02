<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Activity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ActivityController extends Controller
{
    public function index()
    {
        $activities = Activity::latest()->paginate(15);
        return view('admin.activities.index', compact('activities'));
    }

    public function create()
    {
        return view('admin.activities.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'audience' => 'nullable|string|max:255',
            'tab' => 'required|in:atelier,activites,evenements,podcasts',
            'order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
        ]);

        // Gérer le statut actif/inactif
        $validated['is_active'] = $request->has('is_active');

        // Gérer l'ordre par défaut
        if (!isset($validated['order'])) {
            $validated['order'] = 0;
        }

        // Gérer l'upload de l'image
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('activities', 'public');
        }

        Activity::create($validated);

        return redirect()->route('admin.activities.index')->with('success', 'Activité créée avec succès !');
    }

    public function edit(Activity $activity)
    {
        return view('admin.activities.edit', compact('activity'));
    }

    public function update(Request $request, Activity $activity)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'type' => 'required|string|max:255',
            'price' => 'nullable|string|max:255',
            'frequency' => 'nullable|string|max:255',
            'capacity' => 'nullable|string|max:255',
            'audience' => 'nullable|string|max:255',
            'tab' => 'required|in:atelier,activites,evenements,podcasts',
            'order' => 'nullable|integer|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:5000',
        ]);

        // Gérer le statut actif/inactif
        $validated['is_active'] = $request->has('is_active');

        // Gérer l'upload de la nouvelle image
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($activity->image) {
                Storage::disk('public')->delete($activity->image);
            }
            $validated['image'] = $request->file('image')->store('activities', 'public');
        }

        $activity->update($validated);

        return redirect()->route('admin.activities.index')->with('success', 'Activité mise à jour avec succès !');
    }

    public function destroy(Activity $activity)
    {
        // Supprimer l'image si elle existe
        if ($activity->image) {
            Storage::disk('public')->delete($activity->image);
        }

        $activity->delete();

        return redirect()->route('admin.activities.index')->with('success', 'Activité supprimée avec succès !');
    }
}
