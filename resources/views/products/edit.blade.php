@extends('layouts.app')
@section('title', 'Editar produto')
@section('content')
<div class="heading"><div><span class="eyebrow">Catálogo</span><h1>Editar produto</h1><p>Atualize os dados de {{ $product->name }}.</p></div></div>
<div class="card form-card"><form method="POST" action="{{ route('products.update', $product) }}" data-cy="product-form">@csrf @method('PUT') @include('products.form', ['product' => $product])</form></div>
@endsection
