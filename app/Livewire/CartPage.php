<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Cart - Dress Zone')]
class CartPage extends Component
{
    public $cart = [];
    public $subtotal = 0;

    public function mount()
    {
        $this->cart = CartManagement::getCartItemsFromCookie();
        $this->subtotal = CartManagement::getCartTotal($this->cart);
    }

    public function incrementQuantity($productId)
    {
        $this->cart = CartManagement::updateQuantity($productId, $this->cart[$productId]['quantity'] + 1);
        $this->subtotal = CartManagement::getCartTotal($this->cart);

    }
    public function removeItemFromCart($productId)
    {
        $this->cart = CartManagement::removeItemFromCart($productId);
        $this->subtotal = CartManagement::getCartTotal($this->cart);
        $this->dispatch('cart-count-updated', total_count:count($this->cart))->to(Navbar::class);
    }

    public function decrementQuantity($productId)
    {
        if ($this->cart[$productId]['quantity'] > 1) {
            $this->cart = CartManagement::updateQuantity($productId, $this->cart[$productId]['quantity'] - 1);
            $this->subtotal = CartManagement::getCartTotal($this->cart);
        }
    }

    private function calculateSubtotal()
    {
        return array_reduce($this->cart, function ($carry, $item) {
            return $carry + ($item['price'] * $item['quantity']);
        }, 0);
    }

    public function render()
    {
        return view('livewire.cart-page');
    }
}
