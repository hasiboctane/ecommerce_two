<?php

namespace App\Livewire\Partials;

use App\Helpers\CartManagement;
use App\Models\Category;
use App\Models\ParentCategory;
use Livewire\Attributes\On;
use Livewire\Component;

class Navbar extends Component
{
    public $total_count = 0;
    public function mount()
    {
        $this->total_count = count(CartManagement::getCartItemsFromCookie());
    }

    #[On('cart-count-updated')]
    public function cartCountUpdated($total_count)
    {
        $this->total_count = $total_count;
    }

    public function render()
    {
        // return view('livewire.partials.navbar',[
        //     'categories' => Category::where('is_active', true)->orderBy('id','desc')->get(),
        //     'parent_categories' => ParentCategory::where('is_active', true)->orderBy('id','desc')->get(),
        // ]);
        return view('livewire.partials.navbar',[
            // 'categories' => Category::where('is_active', 1)->get(['id','name','slug']),
            'parent_categories' => ParentCategory::with('categories')->where('is_active', true)->orderBy('id','desc')->get(),
        ]);
    }
}
