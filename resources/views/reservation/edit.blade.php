<!-- petshop-reservation-system/resources/views/reservation/edit.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/edit.css')
@endpush

@section('content')
<div class="reservation-edit-container">
    <h1 class="page-title">Editar Reserva</h1>

    <!-- Mensagens de erro -->
    @if($errors->any())
        <div class="alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('reservations.update', $reservation['id']) }}" method="POST" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="pet_id">Pet:</label>
            <select name="pet_id" id="pet_id" required>
                <option value="">Selecione um pet</option>
                @foreach($pets as $pet)
                    <option value="{{ $pet['id'] }}" {{ $reservation['pet_id'] == $pet['id'] ? 'selected' : '' }}>
                        {{ $pet['name'] }} ({{ $pet['species'] }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="service_id">Serviço:</label>
            <select name="service_id" id="service_id" required>
                <option value="">Selecione um serviço</option>
                @foreach($services as $service)
                    <option value="{{ $service['id'] }}" {{ $reservation['service_id'] == $service['id'] ? 'selected' : '' }}>
                        {{ $service['name'] }} - R$ {{ number_format($service['price'],2,',','.') }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Data:</label>
            <input type="date" name="date" id="date" value="{{ $reservation['date'] }}" required>
        </div>

        <div class="form-group">
            <label for="time">Hora:</label>
            <input type="time" name="time" id="time" value="{{ $reservation['time'] }}" required>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" required>
                <option value="pendente" {{ $reservation['status'] == 'pendente' ? 'selected' : '' }}>Pendente</option>
                <option value="concluída" {{ $reservation['status'] == 'concluída' ? 'selected' : '' }}>Concluída</option>
                <option value="cancelada" {{ $reservation['status'] == 'cancelada' ? 'selected' : '' }}>Cancelada</option>
            </select>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Atualizar Reserva</button>
            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </form>
</div>
@endsection
