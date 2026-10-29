@extends('layouts.app')
@section('title', 'Atualizar frete')
@section('content')
<div class="heading"><div><span class="eyebrow">Caminho até a entrega</span><h1>Atualizar frete</h1><p>Pedido #{{ $freight->order_id }} · {{ $freight->order->client->name }}</p></div></div>
<div class="card form-card"><form method="POST" action="{{ route('freights.update', $freight) }}" data-cy="freight-form">@csrf @method('PUT')
<div class="form-grid">@include('freights.fields', ['freight' => $freight])</div>
<div class="form-actions"><button class="btn" type="submit" data-cy="save-freight">Atualizar frete</button><a class="btn secondary" href="{{ route('freights.index') }}">Cancelar</a></div>
</form></div>
@endsection
