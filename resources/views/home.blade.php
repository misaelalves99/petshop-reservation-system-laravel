<!-- petshop-reservation-system/resources/views/home.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/home.css')
@endpush

@section('content')
    <div class="home-container">
        <h1 class="home-title">Bem-vindo ao Sistema de Reservas do Petshop</h1>
        <p class="home-subtitle">Gerencie pets, serviços e reservas com facilidade.</p>

        <div class="home-actions">
            <a href="{{ route('pet.index') }}" class="btn btn-primary">Gerenciar Pets</a>
            <a href="{{ route('service.index') }}" class="btn btn-success">Gerenciar Serviços</a>
            <a href="{{ route('reservations.index') }}" class="btn btn-info">Ver Reservas</a>
        </div>
    </div>
@endsection
