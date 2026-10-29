@extends('layouts.app')
@section('title', 'Clientes')
@section('content')
<div class="heading"><div><span class="eyebrow">Relacionamento</span><h1>Clientes</h1><p>Um bom atendimento começa por conhecer quem compra.</p></div><a class="btn" href="{{ route('clients.create') }}" data-cy="create-client">＋ Novo cliente</a></div>
<div class="card table-wrap"><table data-cy="client-table"><thead><tr><th>Nome</th><th>Contato</th><th>Endereço</th><th>Ações</th></tr></thead><tbody>
@forelse($clients as $client)<tr data-cy="client-row"><td><strong>{{ $client->name }}</strong></td><td>{{ $client->email }}<br><span class="muted">{{ $client->phone }}</span></td><td>{{ $client->address ?: '—' }}</td><td><div class="actions"><a class="link" href="{{ route('clients.edit', $client) }}">Editar</a><form method="POST" action="{{ route('clients.destroy', $client) }}" onsubmit="return confirm('Excluir este cliente?')">@csrf @method('DELETE')<button class="btn danger" type="submit">Excluir</button></form></div></td></tr>
@empty<tr><td colspan="4"><div class="empty"><strong>Clientes queridos, em breve</strong>Nenhum cliente cadastrado ainda.</div></td></tr>@endforelse
</tbody></table><div class="pagination">{{ $clients->links() }}</div></div>
@endsection
