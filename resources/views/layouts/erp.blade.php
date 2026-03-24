<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ERP</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-100 text-slate-800">

<div class="flex h-screen overflow-hidden">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Área principal --}}
    <div class="flex flex-col flex-1 overflow-hidden">

        {{-- Navbar --}}
        <header class="bg-white border-b border-slate-200 shadow-sm">
            @include('layouts.navbar')
        </header>

        {{-- Contenido --}}
        <main class="flex-1 overflow-y-auto p-8">

            <div class="max-w-7xl mx-auto">

                {{-- Contenido de módulos --}}
                @yield('content')

            </div>

        </main>

    </div>

</div>

</body>
</html>