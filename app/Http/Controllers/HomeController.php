<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    
    public function index()
    {
        $products = Product::paginate(12);
        $categories = Category::all();
        $latestProducts = Product::with('category')->latest()->take(8)->get();

        return view('welcome', compact('categories', 'latestProducts','products'));
    }

  
     
    public function search(Request $request)
    {
        $query = $request->input('query');
        $categories = Category::all();
        $products = Product::where('name', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->with('category')
            ->paginate(12);

        return view('products.index', compact('categories', 'products'));
    }

    
    public function category($id)
    {
        $categories = Category::all();
        $category = Category::findOrFail($id);
        $currentCategory = $category; 
        $products = Product::where('category_id', $id)
            ->with('category')
            ->paginate(12);

        return view('products.index', compact('categories', 'products', 'currentCategory'));
    }
}