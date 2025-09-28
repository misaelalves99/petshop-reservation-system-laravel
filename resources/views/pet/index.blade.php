<!-- petshop-reservation-system/resources/views/pet/index.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/index.css')
@endpush

@section('content')
<div class="pets-container">
    <h1 class="page-title">Pets</h1>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="form-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Busca e botão de adicionar pet -->
    <div class="search-add-container">
        <form method="GET" action="{{ route('pet.index') }}" class="search-form">
            <input type="text" name="search" placeholder="Search by name" value="{{ request('search') }}">
            <button type="submit">Search</button>
        </form>
        <a href="{{ route('pet.create') }}" class="btn-add-pet">Add New Pet</a>
    </div>

    @php
        $allPets = session('pets', []);

        // Aplica filtro de busca
        if(request('search')) {
            $allPets = array_filter($allPets, fn($p) => stripos($p['name'], request('search')) !== false);
        }
    @endphp

    <!-- Tabela de pets -->
    <div class="table-container">
        <table class="pets-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Species</th>
                    <th>Age</th>
                    <th>Reservations</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allPets as $pet)
                    @php
                        $allReservations = session('reservations', []);
                        $petReservations = array_filter($allReservations, fn($r) => $r['pet_id'] == $pet['id']);
                    @endphp
                    <tr>
                        <td>{{ $pet['name'] }}</td>
                        <td>{{ $pet['species'] }}</td>
                        <td>{{ $pet['age'] ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pet.edit', $pet['id']) }}" class="link-reservations">
                                {{ count($petReservations) }} reservation(s)
                            </a>
                        </td>
                        <td class="actions">
                            <a href="{{ route('pet.edit', $pet['id']) }}" class="action-edit">Edit</a>
                            <a href="{{ route('reservations.create') }}?pet_id={{ $pet['id'] }}" class="action-add">Add Reservation</a>
                            <form action="{{ route('pet.destroy', $pet['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-delete" onclick="return confirm('Are you sure you want to delete this pet?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">No pets found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
