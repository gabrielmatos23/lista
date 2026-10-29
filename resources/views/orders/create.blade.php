@extends('layouts.app')
@section('title', 'Novo pedido')
@section('content')
<div class="heading"><div><span class="eyebrow">Da encomenda à entrega</span><h1>Novo pedido</h1><p>Escolha cliente, produto e quantidade disponível.</p></div></div>
<div class="card form-card"><form method="POST" action="{{ route('orders.store') }}" data-cy="order-form">@csrf
<div class="form-grid">
    <div class="field full"><label for="client_id">Cliente</label><select id="client_id" name="client_id" data-cy="order-client" required><option value="">Selecione um cliente</option>@foreach($clients as $client)<option value="{{ $client->id }}" @selected(old('client_id') == $client->id)>{{ $client->name }}</option>@endforeach</select>@error('client_id')<span class="error">{{ $message }}</span>@enderror</div>
    <div class="field full"><label for="product_id">Produto</label><select id="product_id" name="product_id" data-cy="order-product" required><option value="">Selecione um produto</option>@foreach($products as $product)<option value="{{ $product->id }}" @selected(old('product_id') == $product->id)>{{ $product->name }} · {{ $product->stock }} disponíveis</option>@endforeach</select>@error('product_id')<span class="error">{{ $message }}</span>@enderror</div>
    <div class="field"><label for="quantity">Quantidade</label><input id="quantity" type="number" name="quantity" data-cy="order-quantity" min="1" step="1" value="{{ old('quantity', 1) }}" required>@error('quantity')<span class="error">{{ $message }}</span>@enderror</div>
</div>
<div class="form-actions"><button class="btn" type="submit" data-cy="save-order">Registrar pedido</button><a class="btn secondary" href="{{ route('orders.index') }}">Cancelar</a></div>
</form></div>
@endsection
