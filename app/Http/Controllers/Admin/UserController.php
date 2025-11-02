<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Vérifier que l'utilisateur est admin ou super_admin
     */
    protected function checkAdminAccess()
    {
        if (!in_array(Auth::user()->type, ['admin', 'super_admin'])) {
            abort(403, 'Accès refusé. Seuls les administrateurs peuvent gérer les utilisateurs.');
        }
    }

    public function index()
    {
        $this->checkAdminAccess();
        
        $users = User::withCount('orders')->latest()->paginate(20);
        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        $this->checkAdminAccess();
        
        // Les admins ne peuvent pas créer d'autres admins
        if (Auth::user()->type === 'admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Accès refusé. Seuls les super administrateurs peuvent créer des administrateurs.');
        }
        
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $this->checkAdminAccess();
        
        // Les admins ne peuvent pas créer d'autres admins
        if (Auth::user()->type === 'admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Accès refusé. Seuls les super administrateurs peuvent créer des administrateurs.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'required|string|min:8',
            'type' => 'required|in:super_admin,admin',
        ], [
            'type.in' => 'Seuls les administrateurs et super administrateurs peuvent être créés manuellement.',
            'password.required' => 'Le mot de passe est requis pour créer un administrateur.',
        ]);

        $validated['password'] = Hash::make($request->password);

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'Administrateur créé avec succès !');
    }

    public function edit(User $user)
    {
        $this->checkAdminAccess();
        
        // Les admins ne peuvent pas éditer d'autres admins ou super_admins
        if (Auth::user()->type === 'admin' && in_array($user->type, ['admin', 'super_admin'])) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Accès refusé. Vous ne pouvez pas modifier un administrateur ou super administrateur.');
        }
        
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $this->checkAdminAccess();
        
        // Les admins ne peuvent pas modifier d'autres admins ou super_admins
        if (Auth::user()->type === 'admin' && in_array($user->type, ['admin', 'super_admin'])) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Accès refusé. Vous ne pouvez pas modifier un administrateur ou super administrateur.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8',
            'type' => 'required|in:super_admin,admin,customer',
        ]);

        if ($request->password) {
            $validated['password'] = Hash::make($request->password);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'Utilisateur mis à jour avec succès !');
    }

    public function destroy(Request $request, User $user)
    {
        $this->checkAdminAccess();
        
        // Empêcher la suppression du propre compte
        if ($user->id === Auth::user()->id) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Vous ne pouvez pas supprimer votre propre compte.');
        }

        // Les admins ne peuvent pas supprimer d'autres admins ou super_admins
        if (Auth::user()->type === 'admin' && in_array($user->type, ['admin', 'super_admin'])) {
            return redirect()->route('admin.users.index')
                ->with('error', 'Accès refusé. Vous ne pouvez pas supprimer un administrateur ou super administrateur.');
        }


        // Interdire la suppression des super_admin
        if ($user->type === 'super_admin') {
            return redirect()->route('admin.users.index')
                ->with('error', 'Les super administrateurs ne peuvent pas être supprimés.');
        }

        // Compter les commandes de l'utilisateur
        $ordersCount = $user->orders()->count();

        // Si c'est un admin OU un client avec des commandes, exiger la confirmation sécurisée
        if ($user->type === 'admin' || ($user->type === 'customer' && $ordersCount > 0)) {
            // Valider le mot de passe
            $request->validate([
                'password' => 'required',
            ], [
                'password.required' => 'Le mot de passe est requis pour cette opération.',
            ]);

            // Vérifier le mot de passe
            if (!Hash::check($request->password, Auth::user()->password)) {
                return redirect()->route('admin.users.index')
                    ->with('error', 'Mot de passe incorrect. La suppression a été annulée.');
            }

            // Message de succès détaillé
            if ($user->type === 'admin') {
                $user->delete();
                return redirect()->route('admin.users.index')
                    ->with('success', "L'administrateur \"{$user->name}\" a été supprimé avec succès !");
            } else {
                $user->delete();
                return redirect()->route('admin.users.index')
                    ->with('success', "Le client \"{$user->name}\" et ses {$ordersCount} commande(s) ont été supprimés avec succès !");
            }
        }

        // Suppression simple pour les clients sans commandes
        $user->delete();
        return redirect()->route('admin.users.index')
            ->with('success', 'Utilisateur supprimé avec succès !');
    }
}

