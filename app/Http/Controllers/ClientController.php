<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::query()->latest()->paginate(10);
        return view('clients.index', compact('clients'));
    }

    public function create() { return view('clients.create'); }

    public function store(Request $request)
    {
        Client::create($this->validated($request));
        return redirect()->route('clients.index')->with('success', 'Cliente cadastrado com sucesso.');
    }

    public function edit(Client $client) { return view('clients.edit', compact('client')); }

    public function update(Request $request, Client $client)
    {
        $client->update($this->validated($request, $client));
        return redirect()->route('clients.index')->with('success', 'Cliente atualizado com sucesso.');
    }

    public function destroy(Client $client)
    {
        if ($client->orders()->exists()) {
            return back()->with('error', 'Este cliente possui pedidos e não pode ser excluído.');
        }
        $client->delete();
        return redirect()->route('clients.index')->with('success', 'Cliente excluído com sucesso.');
    }

    private function validated(Request $request, ?Client $client = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['nullable', 'email', 'max:160', Rule::unique('clients', 'email')->ignore($client?->id)],
            'phone' => ['nullable', 'string', 'max:30'],
            'address' => ['nullable', 'string', 'max:1000'],
        ]);
    }
}
