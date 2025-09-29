<!-- resources/views/layouts/app.blade.php -->

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Sistema de Reservas do Petshop</title>

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
                <a href="{{ route('home') }}">Início</a>
                <a href="{{ route('pet.index') }}">Pets</a>
                <a href="{{ route('service.index') }}">Serviços</a>
                <a href="{{ route('reservations.index') }}">Reservas</a>
            </nav>
        </div>
    </header>

    <main class="container">
        @yield('content')
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Sistema de Reservas do Petshop. Todos os direitos reservados.</p>
    </footer>
</body>
</html>
