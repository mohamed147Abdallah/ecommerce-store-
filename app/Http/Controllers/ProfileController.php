<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        $categories = Category::withCount('products')->get();
        
        $totalProducts = Product::count();

        return view('profile.index', compact('user', 'categories', 'totalProducts'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully!');
    }

    
    public function updateCategory(Request $request, $id)
    {
        
        if (!Auth::user()->is_admin) {
            return back()->with('error', 'Unauthorized action.');
        }
        $category = Category::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $category->update(['name' => $request->name]);

        return back()->with('success', 'Category updated successfully!');
    }

    public function deleteCategory($id)
    {
        if (!Auth::user()->is_admin) {
            return back()->with('error', 'Unauthorized action.');
        }

        $category = Category::findOrFail($id);
        $category->delete();

        return back()->with('success', 'Category deleted successfully!');
    }
}