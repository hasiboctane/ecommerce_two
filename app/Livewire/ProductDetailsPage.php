<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Title('Product Details - Dress Zone')]
class ProductDetailsPage extends Component
{
    public $slug;
    public $quantity = 1;
    public function mount($slug){
        $this->slug = $slug;
    }
    public function increment(){
        $this->quantity++;
    }
    public function decrement(){
        if($this->quantity > 1){
            $this->quantity--;
        }
    }
    public function addToCart(int $productId){
        $total_count = CartManagement::addItemToCart($productId, $this->quantity);
        $this->dispatch('cart-count-updated', total_count:$total_count)->to(Navbar::class);
        $this->dispatch('show-toast', message:'Product added to cart',type:'success');
    }
    public function render()
    {
        return view('livewire.product-details-page',[
            'product' => Product::where('slug', $this->slug)->firstOrFail()
        ]);
    }
}
