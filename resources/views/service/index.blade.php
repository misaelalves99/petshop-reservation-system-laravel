<!-- petshop-reservation-system/resources/views/service/index.blade.php -->

@extends('layouts.app')

@push('styles')
    @vite('resources/css/service/index.css')
@endpush

@section('content')
<div class="service-index-container">
    <h1 class="page-title">Services</h1>

    <!-- Mensagem de sucesso -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Botão de adicionar serviço -->
    <div class="actions-bar">
        <a href="{{ route('service.create') }}" class="btn btn-primary">+ Add New Service</a>
    </div>

    @php
        $services = session('services', []);
    @endphp

    <!-- Tabela de serviços -->
    <div class="table-container">
        <table class="styled-table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Price</th>
                    <th>Duration (min)</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>
                        <td>{{ $service['name'] }}</td>
                        <td>${{ number_format($service['price'], 2) }}</td>
                        <td>{{ $service['duration'] }}</td>
                        <td class="table-actions">
                            <a href="{{ route('service.edit', $service['id']) }}" class="btn-link edit">Edit</a>
                            <form action="{{ route('service.destroy', $service['id']) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-link delete" onclick="return confirm('Are you sure you want to delete this service?')">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="no-data">No services found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
