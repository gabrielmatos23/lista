<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::query()->latest()->paginate(10);
        return view('products.index', compact('products'));
    }

    public function create() { return view('products.create'); }

    public function store(Request $request)
    {
        Product::create($this->validated($request));
        return redirect()->route('products.index')->with('success', 'Produto cadastrado com sucesso.');
    }

    public function edit(Product $product) { return view('products.edit', compact('product')); }

    public function update(Request $request, Product $product)
    {
        $product->update($this->validated($request));
        return redirect()->route('products.index')->with('success', 'Produto atualizado com sucesso.');
    }

    public function destroy(Product $product)
    {
        if ($product->orders()->exists()) {
            return back()->with('error', 'Este produto possui pedidos e não pode ser excluído.');
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produto excluído com sucesso.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'max:80'],
            'price' => ['required', 'numeric', 'min:0'],
            'stock' => ['required', 'integer', 'min:0'],
            'minimum_stock' => ['required', 'integer', 'min:0'],
        ]);
    }
}
