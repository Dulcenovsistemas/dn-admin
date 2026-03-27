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
                {{-- ALERTAS --}}
            <div class="fixed top-5 right-5 z-50 space-y-2">

                @if(session('success'))
                    <div data-alert class="bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg text-sm transition-opacity duration-300">
                        {{ session('success') }}
                    </div>
                @endif

                @if(session('error'))
                    <div data-alert class="bg-red-500 text-white px-4 py-3 rounded-lg shadow-lg text-sm transition-opacity duration-300">
                        {{ session('error') }}
                    </div>
                @endif

            </div>

            <div id="logoutModal" class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white rounded-xl shadow-lg w-full max-w-sm p-6">

        <h2 class="text-lg font-semibold text-gray-800 mb-2">
            Cerrar sesión
        </h2>

        <p class="text-sm text-gray-500 mb-6">
            ¿Seguro que deseas cerrar sesión?
        </p>

        <div class="flex justify-end gap-3">

            <button onclick="closeLogoutModal()"
                class="px-4 py-2 text-sm text-gray-600 hover:text-black">
                Cancelar
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-600 transition text-sm">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </div>

</div>

                {{-- Contenido de módulos --}}
                @yield('content')

            </div>

        </main>

    </div>

</div>
    <script>
        setTimeout(() => {
            document.querySelectorAll('[data-alert]').forEach(el => {
                el.style.opacity = '0'; // fade out

                setTimeout(() => {
                    el.remove(); // eliminar del DOM
                }, 300);
            });
        }, 3000); // 3 segundos

        function openLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeLogoutModal() {
    const modal = document.getElementById('logoutModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
    </script>
</body>
</html>