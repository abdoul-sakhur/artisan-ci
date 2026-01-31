<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Support\Facades\Session;

class CartService
{
    protected $sessionKey = 'cart';

    /**
     * Ajouter un produit au panier
     */
    public function add(Product $product, int $quantity = 1)
    {
        $cart = $this->getCart();

        $productId = $product->id;

        if (isset($cart[$productId])) {
            // Si le produit existe déjà, augmenter la quantité
            $cart[$productId]['quantity'] += $quantity;
        } else {
            // Nouveau produit
            $cart[$productId] = [
                'product_id' => $product->id,
                'quantity' => $quantity,
                'price' => $product->price,
                'product_data' => [
                    'id' => $product->id,
                    'name' => $product->name,
                    'slug' => $product->slug,
                    'price' => $product->price,
                    'formatted_price' => $product->formatted_price,
                    'image' => $product->images->first()?->image_url ?? null,
                    'stock_quantity' => $product->stock_quantity,
                ]
            ];
        }

        // Vérifier le stock
        if ($cart[$productId]['quantity'] > $product->stock_quantity) {
            $cart[$productId]['quantity'] = $product->stock_quantity;
        }

        Session::put($this->sessionKey, $cart);
    }

    /**
     * Mettre à jour la quantité d'un produit
     */
    public function update(int $productId, int $quantity)
    {
        $cart = $this->getCart();

        if (isset($cart[$productId])) {
            if ($quantity <= 0) {
                $this->remove($productId);
            } else {
                $cart[$productId]['quantity'] = $quantity;
                Session::put($this->sessionKey, $cart);
            }
        }
    }

    /**
     * Supprimer un produit du panier
     */
    public function remove(int $productId)
    {
        $cart = $this->getCart();
        unset($cart[$productId]);
        Session::put($this->sessionKey, $cart);
    }

    /**
     * Vider le panier
     */
    public function clear()
    {
        Session::forget($this->sessionKey);
    }

    /**
     * Obtenir tous les articles du panier
     */
    public function getItems()
    {
        $cart = $this->getCart();
        $items = [];

        foreach ($cart as $item) {
            $items[] = [
                'product' => (object) $item['product_data'],
                'quantity' => $item['quantity'],
                'subtotal' => $item['quantity'] * $item['price'],
                'formatted_subtotal' => $this->formatPrice($item['quantity'] * $item['price'])
            ];
        }

        return $items;
    }

    /**
     * Obtenir le nombre total d'articles
     */
    public function getCount(): int
    {
        $cart = $this->getCart();
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Obtenir le montant total (en centimes)
     */
    public function getTotal(): int
    {
        $cart = $this->getCart();
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['quantity'] * $item['price'];
        }

        return $total;
    }

    /**
     * Obtenir le montant total formaté
     */
    public function getFormattedTotal(): string
    {
        return $this->formatPrice($this->getTotal());
    }

    /**
     * Vérifier si le panier est vide
     */
    public function isEmpty(): bool
    {
        return $this->getCount() === 0;
    }

    /**
     * Obtenir les détails d'un produit dans le panier
     */
    public function getItem(int $productId)
    {
        $cart = $this->getCart();
        return $cart[$productId] ?? null;
    }

    /**
     * Vérifier si un produit est dans le panier
     */
    public function has(int $productId): bool
    {
        $cart = $this->getCart();
        return isset($cart[$productId]);
    }

    /**
     * Obtenir la quantité d'un produit spécifique
     */
    public function getQuantity(int $productId): int
    {
        $cart = $this->getCart();
        return $cart[$productId]['quantity'] ?? 0;
    }

    /**
     * Synchroniser le panier avec les produits de la base de données
     * (utile pour vérifier les prix et la disponibilité)
     */
    public function sync()
    {
        $cart = $this->getCart();
        
        if (empty($cart)) {
            return;
        }

        $productIds = array_keys($cart);
        $products = Product::whereIn('id', $productIds)
            ->where('is_published', true)
            ->with('images')
            ->get()
            ->keyBy('id');

        $updated = false;

        foreach ($cart as $productId => $item) {
            $product = $products->get($productId);

            if (!$product) {
                // Produit n'existe plus, le supprimer
                unset($cart[$productId]);
                $updated = true;
                continue;
            }

            // Vérifier le stock
            if ($item['quantity'] > $product->stock_quantity) {
                $cart[$productId]['quantity'] = $product->stock_quantity;
                $updated = true;
            }

            // Mettre à jour le prix si nécessaire
            if ($item['price'] !== $product->price) {
                $cart[$productId]['price'] = $product->price;
                $cart[$productId]['product_data']['price'] = $product->price;
                $cart[$productId]['product_data']['formatted_price'] = $product->formatted_price;
                $updated = true;
            }

            // Supprimer si stock à 0
            if ($product->stock_quantity === 0) {
                unset($cart[$productId]);
                $updated = true;
            }
        }

        if ($updated) {
            Session::put($this->sessionKey, $cart);
        }
    }

    /**
     * Obtenir le panier brut depuis la session
     */
    protected function getCart(): array
    {
        return Session::get($this->sessionKey, []);
    }

    /**
     * Formater un prix en centimes
     */
    protected function formatPrice(int $priceInCents): string
    {
        return number_format($priceInCents / 100, 2, ',', ' ') . ' €';
    }

    /**
     * Obtenir les statistiques du panier
     */
    public function getStats(): array
    {
        return [
            'count' => $this->getCount(),
            'total' => $this->getTotal(),
            'formatted_total' => $this->getFormattedTotal(),
            'items_count' => count($this->getCart()),
            'is_empty' => $this->isEmpty()
        ];
    }
}