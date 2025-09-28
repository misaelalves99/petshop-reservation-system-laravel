@extends('layouts.app')

@push('styles')
    @vite('resources/css/reservation/delete.css')
@endpush

@section('content')
<div class="reservation-delete-container">
    <h1 class="page-title">Excluir Reserva</h1>

    @if(!$reservation)
        <div class="alert-error">
            Reserva não encontrada.
        </div>
        <a href="{{ route('reservations.index') }}" class="btn btn-primary">Voltar</a>
    @else
        <p>Tem certeza que deseja excluir esta reserva?</p>

        <div class="actions">
            <form action="{{ route('reservations.destroy', $reservation['id']) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Sim, excluir</button>
            </form>
            <a href="{{ route('reservations.index') }}" class="btn btn-secondary">Cancelar</a>
        </div>
    @endif
</div>
@endsection
