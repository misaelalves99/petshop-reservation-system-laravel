@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/index.css')
@endpush

@section('content')
<div class="reservation-container">
    <h1 class="page-title">Reservations</h1>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Ações principais -->
    <div class="actions">
        <a href="{{ route('reservations.create') }}" class="btn btn-primary">New Reservation</a>
        <a href="{{ route('reservation.report') }}" class="btn btn-success">View Report</a>
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
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th class="actions-col">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($reservations as $res)
                <tr>
                    <td>{{ $res['pet']['name'] ?? '-' }}</td>
                    <td>{{ $res['service_type'] }}</td>
                    <td>{{ $res['date'] }}</td>
                    <td>{{ $res['time'] }}</td>
                    <td>
                        <span class="status {{ strtolower($res['status'] ?? 'pending') }}">
                            {{ ucfirst($res['status'] ?? 'Pending') }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('reservations.edit', $res['id']) }}" class="action-link edit">Edit</a>
                        <form action="{{ route('reservations.destroy', $res['id']) }}" method="POST" class="inline-form">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-link delete"
                                onclick="return confirm('Are you sure you want to delete this reservation?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">No reservations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
