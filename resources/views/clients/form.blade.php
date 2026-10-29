<div class="form-grid">
    <div class="field full"><label for="name">Nome completo</label><input id="name" name="name" data-cy="client-name" value="{{ old('name', $client?->name) }}" required>@error('name')<span class="error">{{ $message }}</span>@enderror</div>
    <div class="field"><label for="email">E-mail</label><input id="email" type="email" name="email" data-cy="client-email" value="{{ old('email', $client?->email) }}">@error('email')<span class="error">{{ $message }}</span>@enderror</div>
    <div class="field"><label for="phone">Telefone</label><input id="phone" name="phone" data-cy="client-phone" value="{{ old('phone', $client?->phone) }}"></div>
    <div class="field full"><label for="address">Endereço</label><textarea id="address" name="address" data-cy="client-address" rows="3">{{ old('address', $client?->address) }}</textarea></div>
</div>
<div class="form-actions"><button class="btn" type="submit" data-cy="save-client">Salvar cliente</button><a class="btn secondary" href="{{ route('clients.index') }}">Cancelar</a></div>
