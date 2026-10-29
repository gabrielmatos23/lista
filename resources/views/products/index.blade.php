@extends('layouts.app')
@section('title', 'Produtos')
@section('content')
<div class="heading"><div><span class="eyebrow">Seu catálogo</span><h1>Produtos</h1><p>Receitas, ingredientes e estoque em ordem.</p></div><a class="btn" href="{{ route('products.create') }}" data-cy="create-product">＋ Novo produto</a></div>
<div class="card table-wrap"><table data-cy="product-table"><thead><tr><th>Nome</th><th>Categoria</th><th>Preço</th><th>Estoque</th><th>Estoque mínimo</th><th>Ações</th></tr></thead><tbody>
@forelse($products as $product)
<tr data-cy="product-row"><td><strong>{{ $product->name }}</strong></td><td>{{ $product->category }}</td><td>R$ {{ number_format($product->price, 2, ',', '.') }}</td><td><span class="badge {{ $product->stock <= $product->minimum_stock ? 'low' : 'ok' }}" data-cy="stock-badge">{{ $product->stock }} un.</span></td><td>{{ $product->minimum_stock }} un.</td><td><div class="actions"><a class="link" href="{{ route('products.edit', $product) }}" data-cy="edit-product">Editar</a><form method="POST" action="{{ route('products.destroy', $product) }}" onsubmit="return confirm('Excluir este produto?')">@csrf @method('DELETE')<button class="btn danger" type="submit" data-cy="delete-product">Excluir</button></form></div></td></tr>
@empty<tr><td colspan="6"><div class="empty"><strong>Seu catálogo começa aqui</strong>Nenhum produto cadastrado ainda.</div></td></tr>@endforelse
</tbody></table><div class="pagination">{{ $products->links() }}</div></div>
@endsection
