<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Checkout') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 grid grid-cols-1 md:grid-cols-2 gap-8">

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Shipping Information</h3>

                        @if ($errors->any())
                            <div class="mb-4">
                                <ul class="list-disc list-inside text-sm text-red-600">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('checkout.store') }}" method="POST" id="checkout-form">
                            @csrf
                            <div>
                                <x-input-label for="shipping_name" :value="__('Full Name')" />
                                <x-text-input id="shipping_name" class="block mt-1 w-full" type="text" name="shipping_name" :value="old('shipping_name', auth()->user()->name)" required autofocus />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="shipping_address" :value="__('Street Address')" />
                                <x-text-input id="shipping_address" class="block mt-1 w-full" type="text" name="shipping_address" :value="old('shipping_address')" required />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="shipping_city" :value="__('City')" />
                                <x-text-input id="shipping_city" class="block mt-1 w-full" type="text" name="shipping_city" :value="old('shipping_city')" required />
                            </div>

                            <div class="mt-4">
                                <x-input-label for="shipping_phone" :value="__('Phone Number')" />
                                <x-text-input id="shipping_phone" class="block mt-1 w-full" type="tel" name="shipping_phone" :value="old('shipping_phone')" required />
                            </div>

                            </form>
                    </div>

                    <div>
                        <h3 class="text-lg font-semibold mb-4">Your Order</h3>
                        <div class="space-y-2">
                            @foreach (Cart::content() as $item)
                                <div class="flex justify-between">
                                    <span>{{ $item->name }} (x{{ $item->qty }})</span>
                                    <span>${{ number_format($item->subtotal, 2) }}</span>
                                </div>
                            @endforeach
                        </div>

                        <hr class="my-4">

                        <div class="flex justify-between font-bold text-lg">
                            <span>Total</span>
                            <span>${{ $cartTotal }}</span>
                        </div>

                        <div class="mt-4 p-4 bg-gray-100 rounded">
                            <p class="text-sm text-gray-600">For this tutorial, we are using a "Cash on Delivery" placeholder. No payment is required.</p>
                        </div>

                        <div class="mt-6">
                            <x-primary-button type="submit" form="checkout-form" class="w-full justify-center text-lg">
                                Place Order
                            </x-primary-button>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>