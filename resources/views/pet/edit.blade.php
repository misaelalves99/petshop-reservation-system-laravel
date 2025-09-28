<!-- petshop-reservation-system/resources/views/pet/edit.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/edit.css')
@endpush

@section('content')
<div class="form-container">
    <h1 class="form-title">Edit Pet</h1>

    <!-- Mensagens de sucesso -->
    @if(session('success'))
        <div class="form-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Mensagens de erro -->
    @if($errors->any())
        <div class="form-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário de edição do pet -->
    <form action="{{ route('pet.update', $pet['id']) }}" method="POST" class="pet-form">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $pet['name']) }}" required>
        </div>

        <div class="form-group">
            <label for="species">Species:</label>
            <input type="text" name="species" id="species" value="{{ old('species', $pet['species']) }}" required>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" name="age" id="age" value="{{ old('age', $pet['age']) }}">
        </div>

        <button type="submit" class="btn-submit">Update Pet</button>
    </form>
</div>

<hr class="separator">

<!-- Reservas do pet -->
<div class="reservations-section">
    <h2>Reservations for {{ $pet['name'] }}</h2>

    <a href="{{ route('reservations.create') }}?pet_id={{ $pet['id'] }}" class="btn-new-reservation">Add New Reservation</a>

    <table class="reservations-table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @php
                $allReservations = session('reservations', []);
                $petReservations = array_filter($allReservations, fn($r) => $r['pet_id'] == $pet['id']);
            @endphp

            @forelse($petReservations as $res)
                @php
                    $services = session('services', []);
                    $service = collect($services)->firstWhere('id', $res['service_id']);
                @endphp
                <tr>
                    <td>{{ $service['name'] ?? '-' }}</td>
                    <td>{{ $res['date'] }}</td>
                    <td>{{ $res['time'] }}</td>
                    <td>{{ ucfirst($res['status'] ?? 'pending') }}</td>
                    <td class="actions">
                        <a href="{{ route('reservations.edit', $res['id']) }}" class="action-edit">Edit</a>
                        <form action="{{ route('reservations.destroy', $res['id']) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="action-delete" onclick="return confirm('Are you sure you want to delete this reservation?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No reservations found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
