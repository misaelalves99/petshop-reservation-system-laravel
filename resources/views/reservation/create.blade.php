@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/create.css')
@endpush

@section('content')
<div class="reservation-container">
    <h1 class="page-title">New Reservation</h1>

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
            <label for="service_type">Service Type:</label>
            <select name="service_type" id="service_type" required>
                <option value="Bath" {{ old('service_type') == 'Bath' ? 'selected' : '' }}>Bath</option>
                <option value="Grooming" {{ old('service_type') == 'Grooming' ? 'selected' : '' }}>Grooming</option>
            </select>
        </div>

        <div class="form-group">
            <label for="date">Date:</label>
            <input type="date" name="date" id="date" value="{{ old('date') }}" required>
        </div>

        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" name="time" id="time" value="{{ old('time') }}" required>
        </div>

        <button type="submit" class="btn-submit">Create Reservation</button>
    </form>
</div>
@endsection
