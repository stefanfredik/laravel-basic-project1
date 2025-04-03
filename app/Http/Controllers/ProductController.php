<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::paginate(10);
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' =>  'required|string|max:255|unique:products',
            'description' => 'nullable|string'
        ]);


        $validated['slug'] = Str::slug($validated['name']);

        Category::create($validated);


        return redirect()->route('products.index')->with('success', 'Produk berhasil dibuat.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' =>  'required|string|max:255|unique:products,update',
            'description' => 'nullable|string'
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('categories.index')->with('success', 'Kategori berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if ($product->products()->exists()) {
            return redirect()->route('products.index')->with('error', 'Tidak dapat mengapus product.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product berhasil dihapus.');
    }
}
