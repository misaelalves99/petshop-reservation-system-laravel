@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/index.css')
@endpush

@section('content')
<div class="reservation-container">
    <h1 class="page-title">Reservas</h1>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Ações principais -->
    <div class="actions">
        <a href="{{ route('reservations.create') }}" class="btn btn-primary">Nova Reserva</a>
        <a href="{{ route('reservation.report') }}" class="btn btn-success">Ver Relatório</a>
    </div>

    @php
        $reservations = session('reservations', []);
        $pets = session('pets', []);

        foreach($reservations as &$res) {
            $res['pet'] = collect($pets)->first(fn($p) => $p['id'] == $res['pet_id']);
        }
    @endphp

    <!-- Tabela -->
    <table class="reservation-table">
        <thead>
            <tr>
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
                    <td>{{ $res['pet']['name'] ?? '-' }}</td>
                    <td>{{ $res['service_type'] ?? '-' }}</td>
                    <td>{{ $res['date'] }}</td>
                    <td>{{ $res['time'] }}</td>
                    <td>
                        <span class="status {{ strtolower($res['status'] ?? 'pendente') }}">
                            {{ ucfirst($res['status'] ?? 'Pendente') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('reservations.edit', $res['id']) }}" class="action-link edit">Editar</a>
                        <form action="{{ route('reservations.destroy', $res['id']) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link delete"
                                onclick="return confirm('Tem certeza que deseja deletar esta reserva?')">
                                Excluir
                            </button>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('reservations.details', $res['id']) }}" class="btn-details">Ver Detalhes</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty">Nenhuma reserva encontrada.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
