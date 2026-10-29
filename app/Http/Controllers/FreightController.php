<?php

namespace App\Http\Controllers;

use App\Models\Freight;
use App\Models\Order;
use Illuminate\Http\Request;

class FreightController extends Controller
{
    public function index()
    {
        $freights = Freight::with(['order.client'])->latest()->paginate(10);
        return view('freights.index', compact('freights'));
    }

    public function create()
    {
        return view('freights.create', ['orders' => Order::with('client')->latest()->get()]);
    }

    public function store(Request $request)
    {
        Freight::create($this->validated($request));
        return redirect()->route('freights.index')->with('success', 'Frete cadastrado com sucesso.');
    }

    public function edit(Freight $freight) { return view('freights.edit', compact('freight')); }

    public function update(Request $request, Freight $freight)
    {
        $freight->update($this->validated($request, $freight));
        return redirect()->route('freights.index')->with('success', 'Status do frete atualizado.');
    }

    public function destroy(Freight $freight)
    {
        $freight->delete();
        return redirect()->route('freights.index')->with('success', 'Frete excluído.');
    }

    private function validated(Request $request, ?Freight $freight = null): array
    {
        return $request->validate([
            'order_id' => [$freight ? 'sometimes' : 'required', 'exists:orders,id'],
            'address' => ['required', 'string', 'max:1000'],
            'fee' => ['required', 'numeric', 'min:0'],
            'expected_date' => ['required', 'date'],
            'tracking_code' => ['nullable', 'string', 'max:100'],
            'status' => ['required', 'in:Preparando,Enviado,Em trânsito,Entregue'],
        ]);
    }
}
