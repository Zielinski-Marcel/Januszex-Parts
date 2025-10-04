<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{

    public function index(): Response
    {
        $products = Product::all();

        return Inertia::render('Products/Index', [
            'products' => $products
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Products/Create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand'        => 'required|string|max:255',
            'type'         => 'required|string|max:255',
            'color'        => 'nullable|string|max:255',
            'size'         => 'nullable|string|max:255',
            'price'        => 'required|numeric|min:0',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'availability' => 'boolean',
        ]);

        $product = Product::create($validated);

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['product_id' => $product->id])
            ->log('Created a new product.');

        return redirect()->route('products.index')
            ->with('status', 'Product created successfully.');
    }

    public function edit(Product $product): Response
    {
        return Inertia::render('Products/Edit', [
            'product' => $product
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'brand'        => 'required|string|max:255',
            'type'         => 'required|string|max:255',
            'color'        => 'nullable|string|max:255',
            'size'         => 'nullable|string|max:255',
            'price'        => 'required|numeric|min:0',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string',
            'availability' => 'boolean',
        ]);

        $product->update($validated);

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['product_id' => $product->id])
            ->log('Updated a product.');

        return redirect()->route('products.index')
            ->with('status', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();

        activity()
            ->causedBy(Auth::user())
            ->withProperties(['product_id' => $product->id])
            ->log('Deleted a product.');

        return redirect()->route('products.index')
            ->with('status', 'Product deleted successfully.');
    }
}
