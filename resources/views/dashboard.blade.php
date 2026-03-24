@extends('layouts.erp')

@section('content')

<div class="space-y-8">

    {{-- Título --}}
    <div>
        <h1 class="text-2xl font-semibold text-slate-800">
            Dashboard
        </h1>

        <p class="text-sm text-slate-500">
            Bienvenido al panel del sistema ERP
        </p>
    </div>


    {{-- Métricas --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Ingredientes</p>
            <p class="text-2xl font-bold text-slate-800">32</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Subproductos</p>
            <p class="text-2xl font-bold text-slate-800">12</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Recetas</p>
            <p class="text-2xl font-bold text-slate-800">18</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow-sm border border-slate-200">
            <p class="text-sm text-slate-500">Usuarios</p>
            <p class="text-2xl font-bold text-slate-800">5</p>
        </div>

    </div>


    {{-- Accesos rápidos --}}
    <div>

        <h2 class="text-lg font-semibold text-slate-700 mb-4">
            Accesos rápidos
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <a href="{{ route('ingredientes.index') }}"
               class="bg-white border border-slate-200 rounded-lg p-4 hover:shadow-md transition">

                <p class="font-medium text-slate-700">
                    Ingredientes
                </p>

                <p class="text-sm text-slate-500">
                    Administrar ingredientes
                </p>

            </a>


            <a href="/subproductos"
               class="bg-white border border-slate-200 rounded-lg p-4 hover:shadow-md transition">

                <p class="font-medium text-slate-700">
                    Subproductos
                </p>

                <p class="text-sm text-slate-500">
                    Administrar subproductos
                </p>

            </a>


            <a href="/recetas"
               class="bg-white border border-slate-200 rounded-lg p-4 hover:shadow-md transition">

                <p class="font-medium text-slate-700">
                    Recetas
                </p>

                <p class="text-sm text-slate-500">
                    Administrar recetas
                </p>

            </a>

        </div>

    </div>

</div>

@endsection