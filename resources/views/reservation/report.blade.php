@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/report.css')
@endpush

@section('content')
<div class="report-container">
    <h1 class="report-title">Relatório de Reservas</h1>

    @php
        $allReservations = session('reservations', []);
        $allPets = session('pets', []);

        // Conecta pets
        foreach($allReservations as &$res) {
            $res['pet'] = collect($allPets)->first(fn($p) => $p['id'] == $res['pet_id']);
        }

        // Filtro por período
        if(request('start_date')) {
            $allReservations = array_filter($allReservations, fn($r) => $r['date'] >= request('start_date'));
        }
        if(request('end_date')) {
            $allReservations = array_filter($allReservations, fn($r) => $r['date'] <= request('end_date'));
        }
    @endphp

    <!-- Formulário de filtros -->
    <form method="GET" action="{{ route('reservation.report') }}" class="filter-form">
        <label for="start_date">De:</label>
        <input type="date" name="start_date" id="start_date" value="{{ request('start_date') }}">

        <label for="end_date">Até:</label>
        <input type="date" name="end_date" id="end_date" value="{{ request('end_date') }}">

        <button type="submit" class="btn btn-primary">Filtrar</button>
        <a href="{{ route('reservation.report') }}" class="btn btn-secondary">Redefinir</a>
    </form>

    <!-- Resumo -->
    <div class="summary-card">
        <h3>Resumo</h3>
        <ul>
            <li><strong>Total de Reservas:</strong> {{ count($allReservations) }}</li>
            <li><strong>Banho:</strong> {{ count(array_filter($allReservations, fn($r) => $r['service_type']=='Bath')) }}</li>
            <li><strong>Tosa:</strong> {{ count(array_filter($allReservations, fn($r) => $r['service_type']=='Grooming')) }}</li>
        </ul>
    </div>

    <!-- Tabela -->
    <div class="table-container">
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>Pet</th>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allReservations as $res)
                    <tr>
                        <td>{{ $res['pet']['name'] ?? '-' }}</td>
                        <td>{{ $res['service_type'] }}</td>
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
                        <td colspan="5" class="no-data">Nenhuma reserva encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
