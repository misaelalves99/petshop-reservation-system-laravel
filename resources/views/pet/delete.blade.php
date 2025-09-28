@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/delete.css')
@endpush

@section('content')
<div class="delete-container">
    <h1 class="page-title">Confirmação de Exclusão</h1>

    <div class="delete-card">
        <p>Você tem certeza que deseja deletar o pet <strong>{{ $pet['name'] }}</strong>?</p>

        <div class="actions">
            <form action="{{ route('pet.destroy', $pet['id']) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Sim, deletar</button>
            </form>
            <a href="{{ route('pet.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    </div>
</div>
@endsection
