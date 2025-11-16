<form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">

    <div class="mt-4">
        <x-input-label for="image" :value="__('Product Image')" />
        <input id="image" name="image" type="file" class="block mt-1 w-full" />
        <x-input-error :messages="$errors->get('image')" class="mt-2" />
    </div>

    </form>
