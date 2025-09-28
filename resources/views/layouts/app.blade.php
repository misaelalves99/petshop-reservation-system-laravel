<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Petshop Reservation System</title>

    {{-- Vite carrega JS + CSS importados no resources/js/app.js --}}
    @vite(['resources/js/app.js'])

    {{-- Stack para CSS/links específicos de cada página --}}
    @stack('styles')
</head>
<body>
    <header>
        <div class="container header-content">
            <div class="logo">
                <span class="brand">Petshop</span>
            </div>
            <nav>
                <a href="{{ route('home') }}">Home</a>
                <a href="{{ route('reservations.index') }}">Reservations</a>
                <a href="{{ route('service.index') }}">Services</a>
                <a href="{{ route('pet.index') }}">Pets</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Petshop Reservation System. All rights reserved.</p>
    </footer>
</body>
</html>
