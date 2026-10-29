@extends('layouts.app')
@section('title', 'Fretes')
@section('content')
<div class="heading"><div><span class="eyebrow">Caminho até a entrega</span><h1>Fretes</h1><p>Organize o envio e acompanhe o status de cada encomenda.</p></div><a class="btn" href="{{ route('freights.create') }}" data-cy="create-freight">＋ Novo frete</a></div>
<div class="card table-wrap"><table data-cy="freight-table"><thead><tr><th>Pedido</th><th>Cliente</th><th>Endereço</th><th>Previsão</th><th>Rastreio</th><th>Status</th><th>Ações</th></tr></thead><tbody>
@forelse($freights as $freight)<tr data-cy="freight-row"><td>#{{ $freight->order_id }}</td><td>{{ $freight->order->client->name }}</td><td>{{ $freight->address }}</td><td>{{ $freight->expected_date->format('d/m/Y') }}</td><td>{{ $freight->tracking_code ?: '—' }}</td><td><span class="badge">{{ $freight->status }}</span></td><td><a class="link" href="{{ route('freights.edit', $freight) }}">Atualizar</a></td></tr>
@empty<tr><td colspan="7"><div class="empty"><strong>Envios organizados, em breve</strong>Nenhum frete cadastrado ainda.</div></td></tr>@endforelse
</tbody></table><div class="pagination">{{ $freights->links() }}</div></div>
@endsection
