<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Storage; // ✅ Added for image handling

class ProductController extends Controller
{
    // Show all products
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    // Show the "create new product" form
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // Store the new product in the database / Save the new product
    public function store(Request $request)
    {
        // ✅ 1. Validate including image
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ added image validation
        ]);

        // ✅ 2. Get all data except image
        $data = $request->except('image');

        // ✅ 3. Handle File Upload
        if ($request->hasFile('image')) {
            // Store in 'public/products' folder
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path; // Save path
        }

        // ✅ 4. Create Product
        Product::create($data);

        // ✅ 5. Redirect
        return redirect()->route('admin.products.index')
                         ->with('success', 'Craft added successfully.');
    }

    // Show a single product
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    // Show the "edit product" form
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    // Save the changes to an existing product
    public function update(Request $request, Product $product)
    {
        // ✅ 1. Validate including image
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'category_id' => 'nullable|exists:categories,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048', // ✅ added image validation
        ]);

        // ✅ 2. Get all data except image
        $data = $request->except('image');

        // ✅ 3. Handle File Upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            // Store new image
            $path = $request->file('image')->store('products', 'public');
            $data['image'] = $path;
        }

        // ✅ 4. Update Product
        $product->update($data);

        // ✅ 5. Redirect
        return redirect()->route('admin.products.index')
                         ->with('success', 'Craft updated successfully.');
    }

    // Delete a product
    public function destroy(Product $product)
    {
        // ✅ Delete associated image if exists
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('admin.products.index')
                         ->with('success', 'Craft deleted successfully.');
    }

    // This is a new method, separate from index(), create(), etc.
    public function shop()
    {
        // We eager load 'category' to show it on the shop page
        $products = Product::with('category')->latest()->paginate(12);

        return view('shop.index', compact('products'));
    }
}
