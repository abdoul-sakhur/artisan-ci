<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ShopController;
use App\Http\Controllers\Front\ProductController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\OrderController;
use App\Http\Controllers\Front\ArtisanController;
use App\Http\Controllers\Front\ClientController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Routes Publiques Frontend
|--------------------------------------------------------------------------
*/

// Page d'accueil
Route::get('/', [HomeController::class, 'index'])->name('front.home');

// Boutique
Route::get('/shop', [ShopController::class, 'index'])->name('front.shop.index');
Route::get('/shop/products/{slug}', [ProductController::class, 'show'])->name('front.shop.product');

// Artisans publics
Route::get('/artisans', [ArtisanController::class, 'index'])->name('front.artisans.index');
Route::get('/artisans/{slug}', [ArtisanController::class, 'show'])->name('front.artisans.show');

// Panier (accessible uniquement aux non-artisans)
Route::middleware(['prevent.artisan.shopping'])->group(function () {
    Route::post('/cart/add', [CartController::class, 'add'])->name('front.cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('front.cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('front.cart.remove');
    Route::post('/cart/clear', [CartController::class, 'clear'])->name('front.cart.clear');
    Route::get('/cart/count', [CartController::class, 'count'])->name('front.cart.count');
    Route::get('/cart', [CartController::class, 'index'])->name('front.cart.index');
});

/*
|--------------------------------------------------------------------------
| Routes Frontend Authentifiées
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'prevent.artisan.shopping'])->group(function () {
    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('front.checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'store'])->name('front.checkout.store');
    
    // Commandes
    Route::get('/orders/{orderNumber}/confirmation', [OrderController::class, 'confirmation'])->name('front.orders.confirmation');
    Route::get('/orders', [OrderController::class, 'index'])->name('front.orders.index');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('front.orders.show');
    
    // Espace client
    Route::get('/my-account', [ClientController::class, 'account'])->name('front.client.account');
    Route::post('/my-account/profile', [ClientController::class, 'updateProfile'])->name('front.client.profile.update');
    Route::post('/my-account/password', [ClientController::class, 'updatePassword'])->name('front.client.password.update');
    Route::get('/my-account/orders', [ClientController::class, 'orders'])->name('front.client.orders');
});

/*
|--------------------------------------------------------------------------
| Routes Anciennes (pour compatibilité)
|--------------------------------------------------------------------------
*/

// Page d'accueil (ancienne route)
Route::get('/old-home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Catalogue produits (anciennes routes)
Route::get('/old-shop', [App\Http\Controllers\ShopController::class, 'index'])->name('shop.index');
Route::get('/old-shop/{slug}', [App\Http\Controllers\ShopController::class, 'show'])->name('shop.show');

// Démo des composants UI (accessible à tous les utilisateurs authentifiés)
Route::middleware(['auth'])->group(function () {
    Route::get('/components-demo', function () {
        return view('components-demo');
    })->name('components.demo');
});

/*
|--------------------------------------------------------------------------
| Routes Client (authentifié)
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:client'])->group(function () {
    // Redirection du tableau de bord client vers l'espace compte (page orange)
    Route::get('/dashboard', function () {
        return redirect()->route('front.client.account');
    })->name('dashboard');
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Routes Artisan
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:artisan'])->prefix('artisan')->name('artisan.')->group(function () {
    // Dashboard Artisan
    Route::get('/dashboard', [App\Http\Controllers\Artisan\DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/pending', [App\Http\Controllers\Artisan\DashboardController::class, 'pending'])->name('dashboard.pending');
    
    // Gestion des Produits
    Route::resource('products', App\Http\Controllers\Artisan\ProductController::class);
    
    // Gestion des Commandes
    Route::get('/orders', [App\Http\Controllers\Artisan\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [App\Http\Controllers\Artisan\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/update-status', [App\Http\Controllers\Artisan\OrderController::class, 'updateStatus'])->name('orders.update-status');
    
    // Profil Boutique
    Route::get('/profile/create', [App\Http\Controllers\Artisan\ProfileController::class, 'create'])->name('profile.create');
    Route::post('/profile', [App\Http\Controllers\Artisan\ProfileController::class, 'store'])->name('profile.store');
    Route::get('/profile', [App\Http\Controllers\Artisan\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [App\Http\Controllers\Artisan\ProfileController::class, 'update'])->name('profile.update');
});

/*
|--------------------------------------------------------------------------
| Routes Admin
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard Admin
    Route::get('/dashboard', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');
    
    // Gestion des Artisans
    Route::get('/artisans', [App\Http\Controllers\Admin\ArtisanController::class, 'index'])->name('artisans.index');
    Route::get('/artisans/{artisan}', [App\Http\Controllers\Admin\ArtisanController::class, 'show'])->name('artisans.show');
    Route::post('/artisans/{artisan}/approve', [App\Http\Controllers\Admin\ArtisanController::class, 'approve'])->name('artisans.approve');
    Route::post('/artisans/{artisan}/reject', [App\Http\Controllers\Admin\ArtisanController::class, 'reject'])->name('artisans.reject');
    Route::delete('/artisans/{artisan}', [App\Http\Controllers\Admin\ArtisanController::class, 'destroy'])->name('artisans.destroy');
    
    // Gestion des Catégories
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);
    Route::post('/categories/{category}/toggle-status', [App\Http\Controllers\Admin\CategoryController::class, 'toggleStatus'])->name('categories.toggle-status');
});

/*
|--------------------------------------------------------------------------
| Routes d'authentification
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';

