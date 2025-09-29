@extends('layouts.app')

@push('styles')
    @vite('resources/css/service/details.css')
@endpush

@section('content')
<div class="service-details-container">
    <h1 class="page-title">Detalhes do Serviço</h1>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    @php
        $services = session('services', []);
        $service = collect($services)->firstWhere('id', $service['id'] ?? request()->route('service'));
    @endphp

    @if(!$service)
        <div class="no-data">Serviço não encontrado.</div>
    @else
        <div class="service-info">
            <p><strong>Nome:</strong> {{ $service['name'] }}</p>
            <p><strong>Preço:</strong> R$ {{ number_format($service['price'], 2, ',', '.') }}</p>
            <p><strong>Duração:</strong> {{ $service['duration'] }} minutos</p>
        </div>

        <div class="actions">
            <a href="{{ route('service.edit', $service['id']) }}" class="btn btn-primary">Editar Serviço</a>
            <a href="{{ route('service.index') }}" class="btn btn-secondary">Voltar à Lista</a>
        </div>
    @endif
</div>
@endsection
