@extends('layouts.app')
@section('title', 'Pedidos')
@section('content')
<div class="heading"><div><span class="eyebrow">Da encomenda à entrega</span><h1>Pedidos</h1><p>Acompanhe cada pedido e a baixa automática no estoque.</p></div><a class="btn" href="{{ route('orders.create') }}" data-cy="create-order">＋ Novo pedido</a></div>
<div class="card table-wrap"><table data-cy="order-table"><thead><tr><th>Pedido</th><th>Cliente</th><th>Produto</th><th>Quantidade</th><th>Total</th><th>Status</th></tr></thead><tbody>
@forelse($orders as $order)<tr data-cy="order-row"><td>#{{ $order->id }}</td><td>{{ $order->client->name }}</td><td>{{ $order->product->name }}</td><td>{{ $order->quantity }}</td><td>R$ {{ number_format($order->total, 2, ',', '.') }}</td><td><span class="badge">{{ $order->status }}</span></td></tr>
@empty<tr><td colspan="6"><div class="empty"><strong>Seu próximo pedido começa aqui</strong>Nenhum pedido registrado ainda.</div></td></tr>@endforelse
</tbody></table><div class="pagination">{{ $orders->links() }}</div></div>
@endsection
