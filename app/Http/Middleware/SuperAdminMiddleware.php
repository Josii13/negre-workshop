<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est authentifié et est un super_admin
        if (!auth()->check() || auth()->user()->type !== 'super_admin') {
            abort(403, 'Accès refusé. Vous devez être super administrateur pour accéder à cette page.');
        }

        return $next($request);
    }
}

