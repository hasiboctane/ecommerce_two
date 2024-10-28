<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Livewire\Partials\Navbar;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Livewire\Attributes\Title;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
#[Title('Products - Dress Zone')]
class ProductsPage extends Component
{
    use WithPagination;

    #[Url]
    public $selected_categories = [];
    #[Url]
    public $selected_brands = [];
    public $price_range = 3000;

    #[Url]
    public $parent_category = null;
    #[Url]
    public $category = null;
    public function addToCart(int $productId){
        $total_count = CartManagement::addItemToCart($productId);
        $this->dispatch('cart-count-updated', total_count:$total_count)->to(Navbar::class);
        $this->dispatch('show-toast', message:'Product added to cart',type:'success');
    }

    public function mount($parent_category = null, $category = null)
    {
        $this->parent_category = $parent_category;
        $this->category = $category;
        if ($category) {
            $category_model = Category::where('slug', $category)->first();
            if ($category_model) {
                $this->selected_categories = [$category_model->id];
            }
        }
    }
    public function render()
    {
        // $products = Product::all();
        // dd($products->count());
        $productQuery = Product::query()->where('is_active', true);

        if (!empty($this->parent_category)) {
            $productQuery->whereHas('parentCategory', function ($query) {
                $query->where('slug', $this->parent_category);
            });
        }

        // if (!empty($this->selected_categories)) {
        //     $productQuery->whereIn('category_id', $this->selected_categories);
        // } elseif (!empty($this->category)) {
        //     $productQuery->whereHas('category', function ($query) {
        //         $query->where('slug', $this->category);
        //     });
        // }

        if (!empty($this->selected_categories)) {
            $productQuery->whereIn('category_id', $this->selected_categories);
            // dd($productQuery->get());
        }
        if(!empty($this->selected_brands)){
            $productQuery->whereIn('brand_id',$this->selected_brands);
        }
        if(!empty($this->price_range)){
            $productQuery->whereBetween('price',[0,$this->price_range]);
        }
        return view('livewire.products-page',[
            'products' => $productQuery->paginate(9),
            'categories' => Category::where('is_active', 1)->get(['id','name','slug']),
            'brands' => Brand::where('is_active', 1)->get(['id','name','slug']),
        ]);
    }
}
