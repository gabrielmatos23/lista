@extends('layouts.app')
@section('title', 'Novo cliente')
@section('content')
<div class="heading"><div><span class="eyebrow">Relacionamento</span><h1>Novo cliente</h1><p>Cadastre os dados para agilizar os próximos pedidos.</p></div></div>
<div class="card form-card"><form method="POST" action="{{ route('clients.store') }}" data-cy="client-form">@csrf @include('clients.form', ['client' => null])</form></div>
@endsection
