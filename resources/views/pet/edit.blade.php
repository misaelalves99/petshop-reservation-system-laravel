<!-- petshop-reservation-system/resources/views/pet/edit.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/edit.css')
@endpush

@section('content')
<div class="form-container">
    <h1 class="form-title">Editar Pet</h1>

    @if(session('success'))
        <div class="form-success">{{ session('success') }}</div>
    @endif

    @if($errors->any())
        <div class="form-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pet.update', $pet['id']) }}" method="POST" class="pet-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $pet['name']) }}" required>
        </div>

        <div class="form-group">
            <label for="species">Espécie:</label>
            <input type="text" name="species" id="species" value="{{ old('species', $pet['species']) }}" required>
        </div>

        <div class="form-group">
            <label for="age">Idade:</label>
            <input type="number" name="age" id="age" value="{{ old('age', $pet['age']) }}">
        </div>

        <button type="submit" class="btn-submit">Atualizar Pet</button>
    </form>
</div>

<hr class="separator">

<div class="reservations-section">
    <h2>Reservas de {{ $pet['name'] }}</h2>
    <a href="{{ route('reservations.create') }}?pet_id={{ $pet['id'] }}" class="btn-new-reservation">Adicionar Nova Reserva</a>

    @php
        $allReservations = session('reservations', []);
        $petReservations = array_filter($allReservations, fn($r) => $r['pet_id'] == $pet['id']);
    @endphp

    <table class="reservations-table">
        <thead>
            <tr>
                <th>Serviço</th>
                <th>Data</th>
                <th>Hora</th>
                <th>Status</th>
                <th>Ações</th>
            </tr>
        </thead>
        <tbody>
            @forelse($petReservations as $res)
                @php
                    $service = collect($services)->firstWhere('id', $res['service_id']);
                @endphp
                <tr>
                    <td>{{ $service['name'] ?? '-' }}</td>
                    <td>{{ $res['date'] }}</td>
                    <td>{{ $res['time'] }}</td>
                    <td>{{ ucfirst($res['status'] ?? 'pendente') }}</td>
                    <td>
                        <a href="{{ route('reservations.edit', $res['id']) }}" class="action-edit">Editar</a>
                        <form action="{{ route('reservations.destroy', $res['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-delete" onclick="return confirm('Tem certeza que deseja deletar esta reserva?')">Deletar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">Nenhuma reserva encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
