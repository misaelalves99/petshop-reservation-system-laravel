@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/index.css')
@endpush

@section('content')
<div class="pets-container">
    <h1 class="page-title">
        <i class="fas fa-paw"></i> Pets
    </h1>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="form-success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Busca e botão de adicionar pet -->
    <div class="search-add-container">
        <form method="GET" action="{{ route('pet.index') }}" class="search-form">
            <input type="text" name="search" placeholder="Pesquisar por nome" value="{{ request('search') }}">
            <button type="submit">
                <i class="fas fa-search"></i> Buscar
            </button>
        </form>
        <a href="{{ route('pet.create') }}" class="btn-add-pet">
            <i class="fas fa-plus-circle"></i> Adicionar Novo Pet
        </a>
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
                    <th>ID</th>
                    <th><i class="fas fa-signature"></i> Nome</th>
                    <th><i class="fas fa-dog"></i> Espécie</th>
                    <th><i class="fas fa-birthday-cake"></i> Idade</th>
                    <th><i class="fas fa-calendar-alt"></i> Reservas</th>
                    <th><i class="fas fa-cogs"></i> Ações</th>
                    <th><i class="fas fa-info-circle"></i> Detalhes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($allPets as $pet)
                    @php
                        $allReservations = session('reservations', []);
                        $petReservations = array_filter($allReservations, fn($r) => $r['pet_id'] == $pet['id']);
                    @endphp
                    <tr>
                        <td>{{ $pet['id'] }}</td>
                        <td>{{ $pet['name'] }}</td>
                        <td>{{ $pet['species'] }}</td>
                        <td>{{ $pet['age'] ?? '-' }}</td>
                        <td>
                            <a href="{{ route('pet.edit', $pet['id']) }}" class="link-reservations">
                                <i class="fas fa-calendar-check"></i> {{ count($petReservations) }} reserva(s)
                            </a>
                        </td>
                        <td class="actions">
                            <a href="{{ route('pet.edit', $pet['id']) }}" class="action-edit">
                                ✏️ Editar
                            </a>
                            <a href="{{ route('pet.delete', $pet['id']) }}" class="action-delete">
                                🗑️ Excluir
                            </a>
                        </td>
                        <td class="details">
                            <a href="{{ route('pet.details', $pet['id']) }}" class="btn-details">
                                ℹ️ Ver Detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="no-data">
                            <i class="fas fa-info-circle"></i> Nenhum pet encontrado.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
