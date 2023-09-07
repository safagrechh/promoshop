<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\ProductStoreRequest;
use App\Models\Product; 
use App\Models\Category;
use Inertia\Inertia;
use Inertia\Response;
use Illuminate\Support\Str ; 
use Illuminate\Support\Facades\Storage ; 



class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        return Inertia::render('Products/Index', [
            'products' => $products,
        ]);
    }
    
    public function create()
    {
        $categories = Category::all();

        return Inertia::render('Products/Create', [
            'categories' => $categories,
        ]);
    }
    public function store(Request $request)
    {
        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'imagePr' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
    
        $imagePath = null;
    
        if ($request->hasFile('imagePr')) {
          
    
            $imagePath = $request->file('imagePr')->store('products', 'public');
            
        }
    
    
        $product = Product::create([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'category_id' => $request->category_id, // Make sure this field is included
            'imagePr' => $imagePath,
        ]);
        
    
        return redirect()->route('products.index')->with('success', 'Product created successfully');
    }
    
    
    public function show(string $id)
    {
        $product = Product::findOrFail($id);
    
        return Inertia::render('Products/Show', [
            'product' => $product,
        ]);
    }
    

    public function edit(string $id)
{
    $product = Product::findOrFail($id);
    $categories = Category::all(); // Fetch categories from the database

    return Inertia::render('Products/Edit', [
        'product' => $product,
        'categories' => $categories,
    ]);
}



    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'titre' => 'required|string|max:255',
            'description' => 'nullable|string',
            'prix' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'imagePr' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $imagePath = $product->image_path;

        if ($request->hasFile('imagePr')) {
            Storage::delete('public/' . $imagePath);
            $imagePath = $request->file('imagePr')->store('products', 'public');
        }

        $product->update([
            'titre' => $request->titre,
            'description' => $request->description,
            'prix' => $request->prix,
            'category_id' => $request->category_id,
            'imagePr' => $imagePath,
        ]);

        return redirect()->route('products.index')->with('success', 'Product updated successfully');
    }

    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image_path) {
            Storage::delete('public/' . $product->image_path);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully');
    }
}

