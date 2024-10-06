<?php

namespace App\Livewire;

use App\Models\Order;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Title('My Orders - Dress Zone')]
class MyOrdersPage extends Component
{
    use WithPagination;
    public function render()
    {
        $orders = Order::where('user_id', auth()->guard()->user()->id)->paginate(3);
        return view('livewire.my-orders-page', [
            'my_orders' => $orders
        ]);
    }
}
