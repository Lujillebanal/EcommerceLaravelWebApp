<div class="bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden">
    <a href="#"> <img class="h-48 w-full object-cover" 
             src="{{ $product->image ? asset('storage/' . $product->image) : 'https://via.placeholder.com/300' }}" 
             alt="{{ $product->name }}">
    </a>
    <div class="p-4">
        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
        <p class="text-sm text-gray-600 mb-2">{{ $product->category->name ?? 'Uncategorized' }}</p>
        <p class="text-xl font-bold text-gray-900">${{ number_format($product->price, 2) }}</p>
        <p class="text-sm text-gray-500">Stock: {{ $product->stock }}</p>

        <form action="{{ route('cart.store') }}" method="POST" class="mt-4">
            @csrf
            <input type="hidden" name="product_id" value="{{ $product->id }}">
            <x-primary-button class="w-full justify-center">
                Add to Cart
            </x-primary-button>
        </form>
    </div>
</div>
