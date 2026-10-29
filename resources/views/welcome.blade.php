@extends('layouts.app')
@section('title', 'Início')
@section('content')
<section class="welcome">
    <div>
        <span class="eyebrow">O sabor de cuidar bem</span>
        <h1>Doçura em cada detalhe. <span>Gestão sem complicação.</span></h1>
        <p>Organize seus produtos, acompanhe pedidos e cuide dos seus clientes em um só lugar.</p>
        <a class="btn" href="{{ route('products.index') }}" data-cy="home-products">Ver meus produtos <span aria-hidden="true">→</span></a>
        <div class="stat-grid">
            <a class="stat" href="{{ route('products.index') }}"><b>{{ \App\Models\Product::count() }}</b><span>produtos cadastrados</span></a>
            <a class="stat" href="{{ route('clients.index') }}"><b>{{ \App\Models\Client::count() }}</b><span>clientes especiais</span></a>
            <a class="stat" href="{{ route('orders.index') }}"><b>{{ \App\Models\Order::count() }}</b><span>pedidos registrados</span></a>
        </div>
    </div>
    <div class="welcome-art" aria-hidden="true">🧁</div>
</section>
@endsection
