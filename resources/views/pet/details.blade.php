<!-- petshop-reservation-system/resources/views/pet/details.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/details.css')
@endpush

@section('content')
<div class="pet-details-container">
    <h1 class="page-title">Detalhes do Pet</h1>

    @if(session('success'))
        <div class="form-success">
            {{ session('success') }}
        </div>
    @endif

    @php
        $allReservations = session('reservations', []);
        $petReservations = array_filter($allReservations, fn($r) => $r['pet_id'] == $pet['id']);
        $services = session('services', []);
    @endphp

    <!-- Informações do pet -->
    <div class="pet-info">
        <h2>{{ $pet['name'] }}</h2>
        <p><strong>Espécie:</strong> {{ $pet['species'] }}</p>
        <p><strong>Idade:</strong> {{ $pet['age'] ?? '-' }} anos</p>
        <div class="actions">
            <a href="{{ route('pet.edit', $pet['id']) }}" class="btn btn-primary">Editar Pet</a>
            <form action="{{ route('pet.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Deseja realmente deletar este pet?')">Deletar Pet</button>
            </form>
            <a href="{{ route('reservations.create') }}?pet_id={{ $pet['id'] }}" class="btn btn-success">Nova Reserva</a>
        </div>
    </div>

    <hr class="separator">

    <!-- Reservas do pet -->
    <div class="reservations-section">
        <h2>Reservas de {{ $pet['name'] }}</h2>

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
                        <td>
                            <span class="status {{ strtolower($res['status'] ?? 'pendente') }}">
                                {{ ucfirst($res['status'] ?? 'Pendente') }}
                            </span>
                        </td>
                        <td class="actions">
                            <a href="{{ route('reservations.edit', $res['id']) }}" class="action-edit">Editar</a>
                            <form action="{{ route('reservations.destroy', $res['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-delete" onclick="return confirm('Deseja realmente deletar esta reserva?')">Deletar</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">Nenhuma reserva encontrada para este pet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
