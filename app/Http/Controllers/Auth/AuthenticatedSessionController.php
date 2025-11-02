<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     * Empêche l'accès direct - redirige vers l'accueil si pas d'URL intended
     */
    public function create(Request $request): View|RedirectResponse
    {
        // Si l'utilisateur est déjà connecté, rediriger vers le dashboard
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }

        // Vérifier si l'utilisateur vient d'une tentative d'accès à une page protégée
        // Laravel stocke l'URL intended dans la session
        $intended = $request->session()->get('url.intended');
        
        // Si pas d'URL intended, c'est un accès direct à /login
        // Rediriger vers la page d'accueil
        if (!$intended) {
            return redirect('/')->with('error', 'Accès restreint. Veuillez accéder au dashboard pour vous connecter.');
        }

        return view('admin.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('login')->with('status', 'Vous avez été déconnecté avec succès.');
    }
}
