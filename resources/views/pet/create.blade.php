@extends('layouts.app')

@push('styles')
    @vite('resources/css/pet/create.css')
@endpush

@section('content')
<div class="form-container">
    <h1 class="form-title">Add New Pet</h1>

    @if($errors->any())
        <div class="form-errors">
            <ul>
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('pet.store') }}" method="POST" class="pet-form">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="species">Species:</label>
            <input type="text" name="species" id="species" value="{{ old('species') }}" required>
        </div>

        <div class="form-group">
            <label for="age">Age:</label>
            <input type="number" name="age" id="age" value="{{ old('age') }}">
        </div>

        <button type="submit" class="btn-submit">Create Pet</button>
    </form>
</div>
@endsection
