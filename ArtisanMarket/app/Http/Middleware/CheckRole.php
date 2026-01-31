<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    /**
     * Handle an incoming request.
     * 
     * Vérifie si l'utilisateur connecté possède au moins un des rôles requis.
     * Redirige vers la page d'accueil avec un message d'erreur si l'accès est refusé.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @param  string  ...$roles - Liste des rôles autorisés (ex: 'admin', 'artisan')
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Vérifier si l'utilisateur est authentifié
        if (!Auth::check()) {
            return redirect()->route('login')
                ->with('error', 'Vous devez être connecté pour accéder à cette page.');
        }

        $user = Auth::user();

        // Vérifier si l'utilisateur a au moins un rôle assigné
        if (!$user->roles()->exists()) {
            Auth::logout();
            return redirect()->route('login')
                ->with('error', 'Votre compte n\'a pas de rôle assigné. Contactez l\'administrateur.');
        }

        // Vérifier si l'utilisateur possède au moins un des rôles requis
        if (!$user->hasAnyRole($roles)) {
            return redirect()->route('dashboard')
                ->with('error', 'Accès refusé. Vous n\'avez pas les permissions nécessaires.');
        }

        return $next($request);
    }
}
