<!-- petshop-reservation-system/resources/views/home.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/home.css')
@endpush

@section('content')
    <div class="home-container">
        <h1 class="home-title">Welcome to Petshop Reservation System</h1>
        <p class="home-subtitle">Manage pets, services, and reservations easily.</p>

        <div class="home-actions">
            <a href="{{ route('pet.index') }}" class="btn btn-primary">Manage Pets</a>
            <a href="{{ route('service.index') }}" class="btn btn-success">Manage Services</a>
            <a href="{{ route('reservations.index') }}" class="btn btn-info">View Reservations</a>
        </div>
    </div>
@endsection
