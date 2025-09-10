<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Servidores - PCPB</title>

    <!-- Favicon -->
    <link rel="icon" href="{{ asset('/images/brasaopc.ico') }}" type="image/x-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet" />

    <!-- Vite: CSS e JS do Vue -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">

    <!-- Div onde o Vue será montado -->
    <div id="app"></div>

    <!-- Dados globais para o Vue -->
    <script>
        window.Laravel = {
            csrfToken: '{{ csrf_token() }}',
            baseUrl: '{{ url('/') }}'
        };
    </script>
    
</body>
</html>
