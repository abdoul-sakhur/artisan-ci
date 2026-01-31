<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Publiques
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('welcome');
})->name('home');

/*
|--------------------------------------------------------------------------
| Routes Authentifiées (require auth)
|--------------------------------------------------------------------------
| Ces routes nécessitent une authentification mais pas de rôle spécifique
*/

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard principal - redirige selon le rôle
    Route::get('/dashboard', function () {
        $user = auth()->user();
        
        // Redirection basée sur le rôle de l'utilisateur
        if ($user->hasRole('admin')) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->hasRole('artisan')) {
            return redirect()->route('artisan.dashboard');
        } elseif ($user->hasRole('client')) {
            return redirect()->route('client.dashboard');
        }
        
        // Si aucun rôle n'est trouvé, rediriger vers une page d'erreur
        abort(403, 'Aucun rôle assigné à votre compte. Contactez l\'administrateur.');
        
    })->name('dashboard');

    // Profile routes (accessible à tous les utilisateurs authentifiés)
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
});

/*
|--------------------------------------------------------------------------
| Routes Admin (role: admin)
|--------------------------------------------------------------------------
| Accès réservé aux administrateurs uniquement
*/

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin (Livewire)
    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('dashboard');
    
    // Validation des Artisans (Livewire)
    Route::get('/artisans/approval', function () {
        return view('admin.artisans.approval');
    })->name('artisans.approval');
    
    // Modération des Produits (Livewire)
    Route::get('/products/moderation', function () {
        return view('admin.products.moderation');
    })->name('products.moderation');
    
    // Gestion des utilisateurs
    Route::get('/users', function () {
        return view('admin.users.index');
    })->name('users.index');
    
    // Gestion des rôles et permissions
    Route::get('/roles', function () {
        return view('admin.roles.index');
    })->name('roles.index');
    
    // Gestion des artisans (ancienne page)
    Route::get('/artisans', function () {
        return view('admin.artisans.index');
    })->name('artisans.index');
    
    // Gestion des catégories
    Route::get('/categories', function () {
        return view('admin.categories.index');
    })->name('categories.index');
    
    // Gestion des commandes
    Route::get('/orders', function () {
        return view('admin.orders.index');
    })->name('orders.index');
    
    // Paramètres
    Route::get('/settings', function () {
        return view('admin.settings');
    })->name('settings');
    
    // Statistiques globales
    Route::get('/statistics', function () {
        return view('admin.statistics');
    })->name('statistics');
});

/*
|--------------------------------------------------------------------------
| Routes Artisan (role: artisan)
|--------------------------------------------------------------------------
| Accès réservé aux artisans vendeurs
*/

// Route publique pour la configuration initiale de la boutique (artisans sans profil)
Route::middleware(['auth', 'verified', 'role:artisan'])->group(function () {
    Route::get('/artisan/setup', function () {
        return view('artisan.shop-setup');
    })->name('artisan.shop.setup');
});

Route::middleware(['auth', 'verified', 'role:artisan'])->prefix('artisan')->name('artisan.')->group(function () {
    
    // Dashboard Artisan (Livewire)
    Route::get('/dashboard', function () {
        return view('artisan.dashboard');
    })->name('dashboard');
    
    // Gestion des produits (Livewire)
    Route::get('/products', function () {
        return view('artisan.products.index');
    })->name('products.index');
    
    Route::get('/products/create', function () {
        return view('artisan.products.create');
    })->name('products.create');
    
    Route::get('/products/{id}/edit', function ($id) {
        return view('artisan.products.edit', ['productId' => $id]);
    })->name('products.edit');
    
    // Gestion des commandes (Livewire)
    Route::get('/orders', function () {
        return view('artisan.orders.index');
    })->name('orders.index');
    
    // Paramètres de la boutique (Livewire)
    Route::get('/shop/settings', function () {
        return view('artisan.shop-settings');
    })->name('shop.settings');
});

/*
|--------------------------------------------------------------------------
| Routes Client (role: client)
|--------------------------------------------------------------------------
| Accès réservé aux clients acheteurs
*/

Route::middleware(['auth', 'verified', 'role:client'])->prefix('client')->name('client.')->group(function () {
    
    // Dashboard Client
    Route::get('/dashboard', function () {
        return view('client.dashboard');
    })->name('dashboard');
    
    // Mes commandes
    Route::get('/orders', function () {
        return view('client.orders.index');
    })->name('orders.index');
    
    Route::get('/orders/{order}', function ($order) {
        return view('client.orders.show', compact('order'));
    })->name('orders.show');
    
    // Panier
    Route::get('/cart', function () {
        return view('client.cart');
    })->name('cart');
    
    // Favoris
    Route::get('/favorites', function () {
        return view('client.favorites');
    })->name('favorites');
});

/*
|--------------------------------------------------------------------------
| Routes Shop (accessible à tous, même non authentifiés)
|--------------------------------------------------------------------------
| Catalogue de produits public
*/

Route::prefix('shop')->name('shop.')->group(function () {
    
    // Catalogue des produits
    Route::get('/', function () {
        return view('shop.index');
    })->name('index');
    
    // Détail d'un produit
    Route::get('/product/{id}', function ($id) {
        return view('shop.product', compact('id'));
    })->name('product');
    
    // Boutique d'un artisan (route principale)
    Route::get('/artisan/{id}', function ($id) {
        return view('shop.artisan', compact('id'));
    })->name('artisan');
    
    // Alias pour la route 'shop.show' (utilisée dans artisan-layout)
    Route::get('/{id}', function ($id) {
        return view('shop.artisan', compact('id'));
    })->name('show');
    
    // Catégories
    Route::get('/category/{slug}', function ($slug) {
        return view('shop.category', compact('slug'));
    })->name('category');
});

// Inclusion des routes Breeze (login, register, etc.) si le fichier existe
if (file_exists(__DIR__.'/auth.php')) {
    require __DIR__.'/auth.php';
}

