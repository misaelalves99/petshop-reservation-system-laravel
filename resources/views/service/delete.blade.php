@extends('layouts.app')

@push('styles')
    @vite('resources/css/service/index.css')
@endpush

@section('content')
<div class="service-delete-container">
    <h1 class="page-title">Excluir Serviço</h1>

    <p>Tem certeza que deseja excluir este serviço?</p>

    <div class="actions">
        <form action="{{ route('service.destroy', $id) }}" method="POST">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger">Sim, excluir</button>
        </form>
        <a href="{{ route('service.index') }}" class="btn btn-secondary">Cancelar</a>
    </div>
</div>
@endsection
