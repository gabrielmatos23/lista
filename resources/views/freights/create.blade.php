@extends('layouts.app')
@section('title', 'Novo frete')
@section('content')
<div class="heading"><div><span class="eyebrow">Caminho até a entrega</span><h1>Novo frete</h1><p>Vincule o envio a um pedido e informe os detalhes.</p></div></div>
<div class="card form-card"><form method="POST" action="{{ route('freights.store') }}" data-cy="freight-form">@csrf
<div class="form-grid">
    <div class="field full"><label for="order_id">Pedido</label><select id="order_id" name="order_id" data-cy="freight-order" required><option value="">Selecione um pedido</option>@foreach($orders as $order)<option value="{{ $order->id }}" @selected(old('order_id') == $order->id)>#{{ $order->id }} · {{ $order->client->name }} ({{ $order->product->name }})</option>@endforeach</select>@error('order_id')<span class="error">{{ $message }}</span>@enderror</div>
    @include('freights.fields', ['freight' => null])
</div><div class="form-actions"><button class="btn" type="submit" data-cy="save-freight">Salvar frete</button><a class="btn secondary" href="{{ route('freights.index') }}">Cancelar</a></div>
</form></div>
@endsection
