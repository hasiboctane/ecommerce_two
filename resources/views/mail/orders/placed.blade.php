<x-mail::message>
    # Your order has been placed successfully!
    Order ID - {{ $order->id }}

    <x-mail::button :url="$url">
        View Order
    </x-mail::button>
    Thanks,
    {{ config('app.name') }}
</x-mail::message>
