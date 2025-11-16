<x-guest-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>

        @if (session('success'))
            <div class="mb-4 p-4 bg-green-100 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                {{ session('error') }}
            </div>
        @endif

        @if (Cart::count() > 0)
            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-4 text-left">Product</th>
                            <th class="py-3 px-4 text-left">Price</th>
                            <th class="py-3 px-4 text-left">Quantity</th>
                            <th class="py-3 px-4 text-left">Subtotal</th>
                            <th class="py-3 px-4 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (Cart::content() as $item)
                            <tr class="border-b">
                                <td class="py-3 px-4">{{ $item->name }}</td>
                                <td class="py-3 px-4">${{ number_format($item->price, 2) }}</td>
                                <td class="py-3 px-4">
                                    {{ $item->qty }}
                                </td>
                                <td class="py-3 px-4">${{ number_format($item->subtotal, 2) }}</td>
                                <td class="py-3 px-4">
                                    <!-- REMOVE ITEM FORM -->
                                    <form action="{{ route('cart.destroy', $item->rowId) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900">Remove</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                        <tr class="font-bold bg-gray-50">
                            <td colspan="3" class="py-3 px-4 text-right">Total</td>
                            <td class="py-3 px-4">${{ Cart::total() }}</td>
                            <td>
                                <!-- CLEAR CART FORM -->
                                <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Are you sure you want to clear the entire cart?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-gray-600 hover:text-red-600">
                                        Clear Cart
                                    </button>
                                </form>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="flex justify-between items-center mt-6">
                <a href="{{ route('checkout.index') }}"> 
                    <x-primary-button>
                        Proceed to Checkout
                    </x-primary-button>
                </a>
            </div>
        @else
            <p class="text-center text-gray-500">Your cart is empty.</p>
            <div class="text-center mt-4">
                <a href="{{ route('shop.index') }}" class="text-indigo-600 hover:text-indigo-900 font-semibold">
                    Continue Shopping
                </a>
            </div>
        @endif
    </div>
</x-guest-layout>