<x-guest-layout>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-4xl font-bold text-center mb-8">Our Shop</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @forelse ($products as $product)
                <!-- Use the reusable component -->
                <x-product-card :product="$product" />
            @empty
                <p class="col-span-full text-center text-gray-500">No products found.</p>
            @endforelse
        </div>

        <div class="mt-8">
            {{ $products->links() }}
        </div>
    </div>
</x-guest-layout>
