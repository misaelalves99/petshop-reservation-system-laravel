@extends('layouts.app')

@push('styles')
    @vite('resources/css/service/index.css')
@endpush

@section('content')
<div class="service-index-container">
    <h1 class="page-title">Serviços</h1>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Botão de adicionar serviço -->
    <div class="actions-bar">
        <a href="{{ route('service.create') }}" class="btn btn-primary">+ Adicionar Novo Serviço</a>
    </div>

    @php
        $services = session('services', []);
    @endphp

    <!-- Tabela de serviços -->
    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>Preço (R$)</th>
                    <th>Duração (min)</th>
                    <th>Ações</th>
                    <th>Detalhes</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $service['name'] }}</td>
                        <td>R$ {{ number_format($service['price'], 2, ',', '.') }}</td>
                        <td>{{ $service['duration'] }}</td>
                        <td class="table-actions">
                            <a href="{{ route('service.edit', $service['id']) }}" class="btn-link edit">Editar</a>
                            <form action="{{ route('service.destroy', $service['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-link delete"
                                    onclick="return confirm('Tem certeza que deseja excluir este serviço?')">
                                    Excluir
                                </button>
                            </form>
                        </td>
                        <td>
                            <a href="{{ route('service.details', $service['id']) }}" class="btn-details">Ver Detalhes</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="no-data">Nenhum serviço encontrado.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
