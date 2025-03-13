<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Catálogo de Películas</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}"> <!-- Asegúrate de tener tu CSS -->
</head>
<body>
    <header>
        <h1>Bienvenido al Catálogo de Películas</h1>
        <nav>
            <ul>
                <li><a href="{{ route('catalog.index') }}">Inicio</a></li>
                <li><a href="{{ route('catalog.create') }}">Agregar Película</a></li>
            </ul>
        </nav>
    </header>

    <main>
        @yield('content') <!-- Aquí se insertará el contenido de las vistas -->
    </main>

    <footer>
        <p>&copy; {{ date('Y') }} Catálogo de Películas</p>
    </footer>
</body>
</html>
