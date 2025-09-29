@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/details.css')
@endpush

@section('content')
<div class="pet-details-container">
    <h1 class="page-title">Detalhes do Pet</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
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
            <a href="{{ route('pet.index') }}" class="btn btn-secondary">Voltar à Lista</a>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="no-data">Nenhuma reserva encontrada para este pet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
