@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/create.css')
@endpush

@section('content')
<div class="reservation-container">
    <h1 class="page-title">Nova Reserva</h1>

    <!-- Mensagem de sucesso -->
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

    @php
        $allPets = session('pets', []);
        $allServices = session('services', []);
    @endphp

    <form action="{{ route('reservations.store') }}" method="POST" class="reservation-form">
        @csrf

        <div class="form-group">
            <label for="pet_id">Pet:</label>
            <select name="pet_id" id="pet_id" required>
                @foreach($allPets as $pet)
                    <option value="{{ $pet['id'] }}" {{ request('pet_id') == $pet['id'] ? 'selected' : '' }}>
                        {{ $pet['name'] }} ({{ $pet['species'] }})
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="service_id">Serviço:</label>
            <select name="service_id" id="service_id" required>
                @foreach($allServices as $service)
                    <option value="{{ $service['id'] }}" {{ old('service_id') == $service['id'] ? 'selected' : '' }}>
                        {{ $service['name'] }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="date">Data:</label>
            <input type="date" name="date" id="date" value="{{ old('date') }}" required>
        </div>

        <div class="form-group">
            <label for="time">Hora:</label>
            <input type="time" name="time" id="time" value="{{ old('time') }}" required>
        </div>

        <button type="submit" class="btn-submit">Criar Reserva</button>
    </form>
</div>
@endsection
