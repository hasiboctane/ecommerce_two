<?php

namespace App\Helpers;

use App\Models\Product;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Crypt;

class CartManagement
{
    private static $cookieName = 'cart_items';
    private static $cookieExpiration = 60 * 24 * 7; // 1 week

    public static function addItemToCart(int $productId, int $quantity =1): int
    {
        $cart = self::getCartItemsFromCookie();

        $product = Product::find($productId);

        if (!$product) {
            return count($cart);
        }

        $cartItem = [
            'product_id' => $product->id,
            'name' => $product->name,
            'quantity' => $quantity,
            'unit_amount' => $product->price,
            'total_amount' => $product->price * $quantity,
            'image' => $product->images[0] ?? null,
        ];

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = $cartItem;
        }

        self::saveCart($cart);
        return count($cart);
    }

    public static function removeItemFromCart(int $productId): array
    {
        $cart = self::getCartItemsFromCookie();

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            self::saveCart($cart);
        }
        return $cart;
    }

    public static function updateQuantity(int $productId, int $quantity): array
    {
        $cart = self::getCartItemsFromCookie();

        if (isset($cart[$productId])) {
            $cart[$productId]['quantity'] = max(1, $quantity);
            $cart[$productId]['total_amount'] = $cart[$productId]['unit_amount'] * $cart[$productId]['quantity'];
            self::saveCart($cart);
        }
        return $cart;
    }

    public static function getCartItemsFromCookie(): array
    {
        $cartJson = Cookie::get(self::$cookieName);
        if (!$cartJson) {
            return [];
        }

        try {
            return json_decode(Crypt::decryptString($cartJson), true) ?? [];
        } catch (\Exception $e) {
            return [];
        }
    }

    public static function getCartTotal(array $items): float
    {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['unit_amount'] * $item['quantity'];
        }

        return $total;
    }

    // public static function getCartCount(): int
    // {
    //     $cart = self::getCartItemsFromCookie();
    //     return count($cart);
    // }

    // Clear cart item from cookie
    public static function clearCart(): void
    {
        Cookie::queue(Cookie::forget(self::$cookieName));
    }

    // Save cart item to cookie
    private static function saveCart(array $cart): void
    {
        $cartJson = Crypt::encryptString(json_encode($cart));
        Cookie::queue(self::$cookieName, $cartJson, self::$cookieExpiration);
    }
}
