@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/details.css')
@endpush

@section('content')
<div class="reservation-details-container">
    <h1 class="page-title">Detalhes da Reserva</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @php
        $pets = session('pets', []);
        $services = session('services', []);
        $reservation['pet'] = collect($pets)->firstWhere('id', $reservation['pet_id']);
        $reservation['service'] = collect($services)->firstWhere('id', $reservation['service_id']);
    @endphp

    <div class="reservation-info">
        <h2>Informações da Reserva</h2>
        <p><strong>Pet:</strong> {{ $reservation['pet']['name'] ?? '-' }}</p>
        <p><strong>Serviço:</strong> {{ $reservation['service']['name'] ?? $reservation['service_type'] }}</p>
        <p><strong>Data:</strong> {{ $reservation['date'] }}</p>
        <p><strong>Hora:</strong> {{ $reservation['time'] }}</p>
        <p><strong>Status:</strong> 
            <span class="status {{ strtolower($reservation['status'] ?? 'pendente') }}">
                {{ ucfirst($reservation['status'] ?? 'Pendente') }}
            </span>
        </p>

        <div class="actions">
            <a href="{{ route('reservations.edit', $reservation['id']) }}" class="btn btn-primary">Editar Reserva</a>
            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Voltar à Lista</a>
        </div>
    </div>
</div>
@endsection
