@extends('layouts.app')

@push('styles')
    @vite('resources/css/service/index.css')
@endpush

@section('content')
<div class="service-container">
    <h1 class="page-title">Serviços</h1>

    {{-- Mensagem de sucesso --}}
    @if(session('success'))
        <div class="alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Ações principais --}}
    <div class="actions">
        <a href="{{ route('service.create') }}" class="btn btn-primary">
            <span class="icon">➕</span> Novo Serviço
        </a>
    </div>

    @php
        $services = session('services', []);
    @endphp

    {{-- Tabela --}}
    <div class="table-container">
        <table class="service-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nome</th>
                    <th>Preço (R$)</th>
                    <th>Duração (min)</th>
                    <th class="actions-col">Ações</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $service['id'] }}</td>
                        <td>{{ $service['name'] }}</td>
                        <td>R$ {{ number_format($service['price'], 2, ',', '.') }}</td>
                        <td>{{ $service['duration'] }}</td>
                        <td>
                            {{-- Botão Editar --}}
                            <a href="{{ route('service.edit', $service['id']) }}" class="action-link edit">
                                <span class="icon">✏️</span> Editar
                            </a>

                            {{-- Botão Excluir --}}
                            <a href="{{ route('service.delete', $service['id']) }}" class="action-link delete">
                                <span class="icon">🗑️</span> Excluir
                            </a>
                        </td>
                        <td>
                            {{-- Botão Detalhes --}}
                            <a href="{{ route('service.details', $service['id']) }}" class="btn-details">
                                <span class="icon">ℹ️</span> Ver Detalhes
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Nenhum serviço encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
