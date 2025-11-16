
<form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
    @method('PUT')

    <div class="mt-4">
        <x-input-label for="image" :value="__('Product Image')" />
        <input id="image" name="image" type="file" class="block mt-1 w-full" />
        <x-input-error :messages="$errors->get('image')" class="mt-2" />

        @if ($product->image)
            <div class="mt-2">
                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-32 h-32 object-cover">
            </div>
        @endif
    </div>

    </form>
