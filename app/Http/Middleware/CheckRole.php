<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        if (!$request->user()) {
            return redirect()->route('login');
        }

        foreach ($roles as $role) {
            if ($request->user()->hasRole($role)) {
                return $next($request);
            }
        }

        // Rediriger l'utilisateur vers son dashboard approprié s'il n'a pas le bon rôle
        if ($request->user()->hasRole('admin')) {
            return redirect()->route('admin.dashboard')->with('error', 'Accès non autorisé.');
        }

        if ($request->user()->hasRole('artisan')) {
            return redirect()->route('artisan.dashboard')->with('error', 'Accès non autorisé.');
        }

        if ($request->user()->hasRole('client')) {
            return redirect()->route('dashboard')->with('error', 'Accès non autorisé.');
        }

        // Si aucun rôle n'est assigné, déconnecter
        auth()->logout();
        return redirect()->route('login')->with('error', 'Votre compte n\'a pas de rôle assigné.');
    }
}
