@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/index.css')
@endpush

@section('content')
<div class="reservation-container">
    <h1 class="page-title">Reservas</h1>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Ações principais --}}
    <div class="actions">
        <a href="{{ route('reservations.create') }}" class="btn btn-primary">
            <span class="icon">➕</span> Nova Reserva
        </a>
        <a href="{{ route('reservation.report') }}" class="btn btn-success">
            <span class="icon">📊</span> Ver Relatório
        </a>
    </div>

    @php
        $reservations = session('reservations', []);
        $pets = session('pets', []);

        foreach($reservations as &$res) {
            $res['pet'] = collect($pets)->first(fn($p) => $p['id'] == ($res['pet_id'] ?? null));
        }
    @endphp

    {{-- Tabela --}}
    <div class="table-container">
        <table class="reservation-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Pet</th>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Status</th>
                    <th class="actions-col">Ações</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reservations as $res)
                    <tr>
                        <td>{{ $res['id'] }}</td>
                        <td>{{ $res['pet']['name'] ?? '-' }}</td>
                        <td>{{ $res['service_type'] ?? '-' }}</td>
                        <td>{{ $res['date'] ?? '-' }}</td>
                        <td>{{ $res['time'] ?? '-' }}</td>
                        <td>
                            <span class="status {{ strtolower($res['status'] ?? 'pendente') }}">
                                {{ ucfirst($res['status'] ?? 'Pendente') }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('reservations.edit', $res['id']) }}" class="action-link edit">
                                <span class="icon">✏️</span> Editar
                            </a>
                            <a href="{{ route('reservations.delete', $res['id']) }}" class="action-link delete">
                                <span class="icon">🗑️</span> Excluir
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('reservations.details', $res['id']) }}" class="btn-details">
                                <span class="icon">ℹ️</span> Ver Detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="empty">Nenhuma reserva encontrada.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
