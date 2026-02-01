<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventArtisanShopping
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Si l'utilisateur est authentifié et a le rôle artisan
        if (auth()->check() && auth()->user()->hasRole('artisan')) {
            return redirect()->route('artisan.dashboard')
                ->with('error', 'En tant qu\'artisan, vous ne pouvez pas passer de commandes. Vous pouvez uniquement vendre vos produits.');
        }

        return $next($request);
    }
}
