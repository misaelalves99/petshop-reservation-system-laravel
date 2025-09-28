@extends('layouts.app')

@push('styles')
    @vite('resources/css/service/edit.css')
@endpush

@section('content')
<div class="service-edit-container">
    <h1 class="page-title">Editar Serviço</h1>

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

    @php
        $services = session('services', []);
        $service = collect($services)->first(fn($s) => $s['id'] == $service_id);
    @endphp

    <form action="{{ route('service.update', $service['id']) }}" method="POST" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="{{ old('name', $service['name']) }}" required>
        </div>

        <div class="form-group">
            <label for="price">Preço:</label>
            <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $service['price']) }}" required>
        </div>

        <div class="form-group">
            <label for="duration">Duração (minutos):</label>
            <input type="number" name="duration" id="duration" value="{{ old('duration', $service['duration']) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Atualizar Serviço</button>
    </form>
</div>
@endsection
