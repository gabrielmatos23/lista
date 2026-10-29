@extends('layouts.app')
@section('title', 'Novo produto')
@section('content')
<div class="heading"><div><span class="eyebrow">Catálogo</span><h1>Novo produto</h1><p>Preencha os dados para cadastrar um item.</p></div></div>
<div class="card form-card"><form method="POST" action="{{ route('products.store') }}" data-cy="product-form">@csrf @include('products.form', ['product' => null])</form></div>
@endsection
