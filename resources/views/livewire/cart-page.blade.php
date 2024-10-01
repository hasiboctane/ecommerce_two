<div class="w-full max-w-[85rem] py-10 px-4 sm:px-6 lg:px-8 mx-auto">
    <div class="container mx-auto px-4 py-14">
        <h1 class="text-2xl font-semibold mb-4">Shopping Cart</h1>
        <div class="flex flex-col md:flex-row gap-4">
            <div class="md:w-3/4">
                <div class="bg-white overflow-x-auto rounded-lg shadow-md p-6 mb-4">
                    <table class="w-full">
                        <thead>
                            <tr>
                                <th class="text-left font-semibold">Product</th>
                                <th class="text-left font-semibold">Price</th>
                                <th class="text-left font-semibold">Quantity</th>
                                <th class="text-left font-semibold">Total</th>
                                <th class="text-left font-semibold">Remove</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($cart as $item)
                                <tr wire:key="{{ $item['id'] }}">
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <img class="h-16 w-16 mr-4"
                                                src="{{ $item['image'] ? url('storage/', $item['image']) : asset('images/null.jpg') }}"
                                                alt="{{ $item['name'] }}">
                                            <span class="font-semibold">{{ $item['name'] }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4">{{ Number::currency($item['price'], 'BDT') }}</td>
                                    <td class="py-4">
                                        <div class="flex items-center">
                                            <button wire:click="decrementQuantity({{ $item['id'] }})"
                                                class="border rounded-md py-2 px-4 mr-2">-</button>
                                            <span class="text-center w-8">{{ $item['quantity'] }}</span>
                                            <button wire:click="incrementQuantity({{ $item['id'] }})"
                                                class="border rounded-md py-2 px-4 ml-2">+</button>
                                        </div>
                                    </td>
                                    <td class="py-4">{{ Number::currency($item['price'] * $item['quantity'], 'BDT') }}
                                    </td>
                                    <td>
                                        <button wire:click="removeItemFromCart({{ $item['id'] }})">
                                            <svg class="text-rose-500 w-8 h-8 hover:text-red-800" viewBox="0 0 50 50"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill="currentColor" d="M20 18h2v16h-2z" />
                                                <path fill="currentColor" d="M24 18h2v16h-2z" />
                                                <path fill="currentColor" d="M28 18h2v16h-2z" />
                                                <path fill="currentColor" d="M12 12h26v2H12z" />
                                                <path fill="currentColor"
                                                    d="M30 12h-2v-1c0-.6-.4-1-1-1h-4c-.6 0-1 .4-1 1v1h-2v-1c0-1.7 1.3-3 3-3h4c1.7 0 3 1.3 3 3v1z" />
                                                <path fill="currentColor"
                                                    d="M31 40H19c-1.6 0-3-1.3-3.2-2.9l-1.8-24 2-.2 1.8 24c0 .6.6 1.1 1.2 1.1h12c.6 0 1.1-.5 1.2-1.1l1.8-24 2 .2-1.8 24C34 38.7 32.6 40 31 40z" />
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-2xl font-semibold text-slate-600 py-6">No
                                        items in the cart
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="md:w-1/4">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-lg font-semibold mb-4">Summary</h2>
                    <div class="flex justify-between mb-2">
                        <span>Subtotal</span>
                        <span>{{ Number::currency($subtotal, 'BDT') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Taxes</span>
                        <span>{{ Number::currency(0, 'BDT') }}</span>
                    </div>
                    <div class="flex justify-between mb-2">
                        <span>Shipping</span>
                        <span>{{ Number::currency(0, 'BDT') }}</span>
                    </div>
                    <hr class="my-2">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold">Grand Total</span>
                        <span class="font-semibold">{{ Number::currency($subtotal, 'BDT') }}</span>
                    </div>
                    @if ($cart)
                        <a href="{{ route('checkout') }}"
                            class="bg-blue-500 text-white py-2 block text-center cursor-pointer px-4 rounded-lg mt-4 w-full">Checkout</a>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
