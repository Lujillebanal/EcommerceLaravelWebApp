<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    //newwwww
        public function index()
        // {
        //     // We'll show all categories and a form to create a new one, all on one page.
        //     $categories = Category::withCount('products')->latest()->get(); // 'withCount' gets the number of products
        //     return view('categories.index', compact('categories'));
        // }
            
        {
        // Use paginate instead of all
        $categories = Category::latest()->paginate(10);
        return view('categories.index', compact('categories'));
    }


        public function store(Request $request)
        {
            $request->validate([
                'name' => 'required|string|max:255|unique:categories',
            ]);

            Category::create($request->all());

            return redirect()->route('admin.categories.index')
                            ->with('success', 'Category created successfully.');
        }

        public function destroy(Category $category)
        {
            // Note: Because we used `onDelete('set null')` in our migration,
            // deleting a category will not delete the products.
            // It will just set their `category_id` to null.
            $category->delete();

            return redirect()->route('admin.categories.index')
                            ->with('success', 'Category deleted successfully.');
        }
}