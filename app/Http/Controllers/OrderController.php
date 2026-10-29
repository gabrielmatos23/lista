<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['client', 'product'])->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function create()
    {
        return view('orders.create', ['clients' => Client::orderBy('name')->get(), 'products' => Product::orderBy('name')->get()]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'client_id' => ['required', 'exists:clients,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
        ]);

        $order = DB::transaction(function () use ($data) {
            $product = Product::query()->lockForUpdate()->findOrFail($data['product_id']);
            if ($data['quantity'] > $product->stock) {
                throw ValidationException::withMessages(['quantity' => 'Estoque insuficiente para essa quantidade.']);
            }

            $unitPrice = (float) $product->price;
            $order = Order::create([
                ...$data,
                'unit_price' => $unitPrice,
                'total' => $unitPrice * $data['quantity'],
                'status' => 'Recebido',
            ]);
            $product->decrement('stock', $data['quantity']);
            return $order;
        });

        return redirect()->route('orders.index')->with('success', "Pedido #{$order->id} registrado. Estoque atualizado.");
    }
}
