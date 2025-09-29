@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/create.css')
@endpush

@section('content')
<div class="form-container">
    <h1 class="form-title">Adicionar Novo Pet</h1>

    <!-- Erros de validação -->
    @if($errors->any())
        <div class="form-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Formulário -->
    <form action="{{ route('pet.store') }}" method="POST" class="pet-form">
        @csrf <!-- Token CSRF obrigatório -->
        
        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="species">Espécie:</label>
            <input type="text" name="species" id="species" value="{{ old('species') }}" required>
        </div>

        <div class="form-group">
            <label for="age">Idade:</label>
            <input type="number" name="age" id="age" value="{{ old('age') }}">
        </div>

        <div class="form-buttons">
            <button type="submit" class="btn-submit">Criar Pet</button>
            <a href="{{ route('pet.index') }}" class="btn-back">⬅️ Voltar</a>
        </div>
    </form>
</div>
@endsection
