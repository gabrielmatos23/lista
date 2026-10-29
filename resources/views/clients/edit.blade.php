@extends('layouts.app')
@section('title', 'Editar cliente')
@section('content')
<div class="heading"><div><span class="eyebrow">Relacionamento</span><h1>Editar cliente</h1><p>Atualize os dados de {{ $client->name }}.</p></div></div>
<div class="card form-card"><form method="POST" action="{{ route('clients.update', $client) }}" data-cy="client-form">@csrf @method('PUT') @include('clients.form', ['client' => $client])</form></div>
@endsection
