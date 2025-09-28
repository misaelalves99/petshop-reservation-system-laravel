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
            <input type="text" name="search" placeholder="Pesquisar por nome" value="{{ request('search') }}">
            <button type="submit">Buscar</button>
        </form>
        <a href="{{ route('pet.create') }}" class="btn-add-pet">Adicionar Novo Pet</a>
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
                    <th>Nome</th>
                    <th>Espécie</th>
                    <th>Idade</th>
                    <th>Reservas</th>
                    <th>Ações</th>
                    <th>Detalhes</th>
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
                                {{ count($petReservations) }} reserva(s)
                            </a>
                        </td>
                        <td class="actions">
                            <a href="{{ route('pet.edit', $pet['id']) }}" class="action-edit">Editar</a>
                            <a href="{{ route('reservations.create') }}?pet_id={{ $pet['id'] }}" class="action-add">Adicionar Reserva</a>
                            <a href="{{ route('pet.delete', $pet['id']) }}" class="action-delete">Deletar</a>
                        </td>
                        <td class="details">
                            <a href="{{ route('pet.details', $pet['id']) }}" class="btn-details">Ver Detalhes</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="no-data">Nenhum pet encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
