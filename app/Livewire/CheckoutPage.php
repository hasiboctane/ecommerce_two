<?php

namespace App\Livewire;

use App\Helpers\CartManagement;
use App\Mail\OrderPlaced;
use App\Models\Address;
use App\Models\Order;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\Title;
use Livewire\Component;
use Stripe\Stripe;

#[Title('Checkout - Dress Zone')]
class CheckoutPage extends Component
{
    public $first_name;
    public $last_name;
    public $phone;
    public $city;
    public $street_address;
    public $zip_code;
    public $payment_method;

    public function mount(){
        $cart = CartManagement::getCartItemsFromCookie();
        if(count($cart) == 0){
            return redirect()->route('products');
        }
    }
    public function placeOrder(){
        $this->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'phone' => 'required',
            'city' => 'required',
            'street_address' => 'required',
            'zip_code' => 'required',
            'payment_method' => 'required',
        ]);

        $cart = CartManagement::getCartItemsFromCookie();
        $lineItems = [];
        foreach($cart as $item){
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'unit_amount' => $item['unit_amount'] * 100,
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                ],
                'quantity' => $item['quantity'],
            ];
        }
        $order = new Order();
        $order->user_id = auth()->guard()->user()->id;
        $order->grand_total = CartManagement::getCartTotal($cart);
        $order->payment_method = $this->payment_method;
        $order->payment_status = 'pending';
        $order->status = 'new';
        $order->currency = 'usd';
        $order->shipping_amount = 0;
        $order->shipping_method = 'Free Shipping';
        $order->notes = 'Order placed by ' . auth()->guard()->user()->name;

        $address = new Address();
        $address->first_name = $this->first_name;
        $address->last_name = $this->last_name;
        $address->phone = $this->phone;
        $address->city = $this->city;
        $address->street_address = $this->street_address;
        $address->zip_code = $this->zip_code;

        $redirect_url = '';
        if($this->payment_method == 'stripe'){
            Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            $sessionCheckout = \Stripe\Checkout\Session::create([
                'payment_method_types' => ['card'],
                'customer_email' => auth()->guard()->user()->email,
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('success').'?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cancel'),
            ]);
            $redirect_url = $sessionCheckout->url;
        }else{
            $redirect_url = route('success');
        }
        $order->save();
        $address->order_id = $order->id;
        $address->save();
        $order->items()->createMany($cart);
        CartManagement::clearCart();
        Mail::to(request()->user())->send(new OrderPlaced($order));
        return redirect($redirect_url);

    }
    public function render()
    {
        $cart = CartManagement::getCartItemsFromCookie();
        $subtotal = CartManagement::getCartTotal($cart);
        return view('livewire.checkout-page',[
            'cart' => $cart,
            'subtotal' => $subtotal,
        ]);
    }
}
