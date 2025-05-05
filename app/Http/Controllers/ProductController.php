<?php

namespace App\Http\Controllers;

use App\Exports\ProductsExports;
use App\Imports\ProductImports;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Excel;
use Illuminate\Support\Facades\Storage;

use function Laravel\Prompts\error;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category');

        // Search by name, SKU, or category name
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%")
                    ->orWhereHas('category', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->where('category_id', $request->category);
        }

        // Filter by stock status
        if ($request->has('stock_status')) {
            switch ($request->stock_status) {
                case 'low':
                    $query->where('stock_quantity', '<', 10)->where('stock_quantity', '>', 0);
                    break;
                case 'out':
                    $query->where('stock_quantity', 0);
                    break;
                case 'available':
                    $query->where('stock_quantity', '>=', 10);
                    break;
            }
        }

        // Filter by price range
        if ($request->has('min_price') && $request->min_price !== null) {
            $query->where('price', '>=', $request->min_price);
        }
        if ($request->has('max_price') && $request->max_price !== null) {
            $query->where('price', '<=', $request->max_price);
        }

        $products = $query->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        // dd($categories);

        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' =>  'required|string|max:255|unique:products',
            'description' => 'required|nullable|string',
            'price' => 'required',
            'stock_quantity' => 'required|integer',
            'sku' => 'required|unique:products',
            'category_id' => 'required',
            'image' => 'nullable|image'
        ]);

        // dd($validated);


        if ($request->hasFile('image')) {
            // dd(true);
            $path = $request->file('image')->store('products', 'public');
            $validated['image_path'] = $path;
        }


        $validated['slug'] = Str::slug($validated['name']);

        // dd($validated);
        Product::create($validated);


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
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' =>  'required|string|max:255',
            'description' => 'nullable|string'
        ]);


        if ($request->hasFile('image')) {
            if ($product->image_path && Storage::disk('public')->exists($product->image_path)) {
                Storage::disk('public')->delete($product->image_path);
            }
        }

        $validated['slug'] = Str::slug($validated['name']);

        $product->update($validated);

        return redirect()->route('products.index')->with('success', 'Produk berhasil diperbaharui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if (!$product->exists) {
            return redirect()->route('products.index')->with('error', 'Tidak dapat menghapus product karena tidak ditemukan.');
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product berhasil dihapus.');
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv'
        ]);



        try {
            Excel::import(new ProductImports, $request->file('file'));
            return redirect()->route('product.index')->with('success', 'Product berhasil diimport');
        } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
            $failures = $e->failures();
            $error = [];

            foreach ($failures as $failrule) {
                $errors[] = 'Baris' . $failrule->row() . ':' . implode(',', $failrule->errors());
            }


            return redirect()->back()->withErrors(['import_errors' => $errors]);
        }
    }

    public function export()
    {
        return Excel::download(new ProductsExports, 'product.xlsx');
    }
}
