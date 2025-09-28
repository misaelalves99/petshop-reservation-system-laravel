<!-- petshop-reservation-system/resources/views/service/create.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/service/create.css')
@endpush

@section('content')
<div class="service-create-container">
    <h1 class="page-title">Adicionar Novo Serviço</h1>

    <!-- Mensagens de erro -->
    @if($errors->any())
        <div class="alert alert-error">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('service.store') }}" method="POST" class="form-card">
        @csrf

        <div class="form-group">
            <label for="name">Nome do Serviço:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="price">Preço (R$):</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price') }}" required>
        </div>

        <div class="form-group">
            <label for="duration">Duração (minutos):</label>
            <input type="number" name="duration" id="duration" value="{{ old('duration') }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Criar Serviço</button>
        <a href="{{ route('service.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection
