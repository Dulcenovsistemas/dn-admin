@extends('layouts.erp')

@section('content')

<div class="space-y-8">

    {{-- BIENVENIDA --}}
    <div class="bg-white rounded-3xl shadow-sm border border-slate-200 p-8 md:p-10">
        <div class="flex flex-col md:flex-row md:items-start md:justify-between gap-6">
            <div>
                <p class="text-sm uppercase tracking-[0.25em] text-slate-400 mb-3">
                    Panel ERP
                </p>

                <h1 class="text-3xl md:text-4xl font-bold text-slate-800">
                    Bienvenido de vuelta, {{ auth()->user()->name ?? 'usuario' }} 👋
                </h1>

                <p class="mt-4 text-slate-600 max-w-3xl leading-relaxed">
                    Aquí puedes acceder rápidamente a los módulos del sistema, consultar información importante y mantener al día las operaciones del día a día.
                </p>
            </div>

            <div class="bg-slate-50 rounded-2xl border border-slate-200 px-5 py-4 min-w-[240px]">
                <p class="text-sm text-slate-500 mb-1">
                    Sesión activa
                </p>
                <p class="text-lg font-semibold text-slate-800">
                    {{ auth()->user()->name ?? 'Usuario' }}
                </p>
            </div>
        </div>
    </div>


    {{-- BOLETINES / AVISOS --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="lg:col-span-2 bg-white rounded-3xl shadow-sm border border-slate-200 p-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h2 class="text-xl font-semibold text-slate-800">
                        Boletines informativos
                    </h2>
                    <p class="text-sm text-slate-500">
                        Avisos y recordatorios importantes del sistema
                    </p>
                </div>
            </div>

            <div class="space-y-4">

                <div class="rounded-2xl border border-slate-200 p-5 bg-slate-50">
                    <p class="text-xs uppercase tracking-wide text-blue-600 font-semibold mb-2">
                        RH
                    </p>
                    <p class="text-slate-800 font-medium">
                        Revisa el expediente de nuevos empleados antes de cerrar incidencias de la semana.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 p-5 bg-slate-50">
                    <p class="text-xs uppercase tracking-wide text-emerald-600 font-semibold mb-2">
                        Recetario
                    </p>
                    <p class="text-slate-800 font-medium">
                        Verifica costos actualizados en ingredientes y subproductos antes de liberar recetas nuevas.
                    </p>
                </div>

                <div class="rounded-2xl border border-slate-200 p-5 bg-slate-50">
                    <p class="text-xs uppercase tracking-wide text-amber-600 font-semibold mb-2">
                        Producción
                    </p>
                    <p class="text-slate-800 font-medium">
                        Recuerda validar materias primas y disponibilidad antes del arranque de turno.
                    </p>
                </div>

            </div>
        </div>

        
    </div>

</div>

@endsection