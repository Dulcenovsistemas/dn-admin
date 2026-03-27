@php
$modules = \App\Models\Module::whereHas('permissions', function ($q) {
    $q->where('user_id', auth()->id())
      ->where('can_view', 1);
})->get();
@endphp

<aside class="w-64 bg-slate-900 text-slate-200 flex flex-col">

    {{-- Logo --}}
    <div class="h-16 flex items-center px-6 border-b border-slate-700">
        <span class="text-xl font-semibold tracking-wide">ERP</span>
    </div>

    <nav class="flex-1 overflow-y-auto px-4 py-6 space-y-6">

        {{-- Dashboard --}}
        <div>
            <a href="/dashboard"
               class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">
               
                <span>📊</span>
                Dashboard
            </a>
        </div>

        {{-- Módulos dinámicos --}}
        <div class="space-y-1">

            <p class="text-xs text-slate-400 uppercase tracking-wider px-3">
                Módulos
            </p>

            @foreach($modules as $module)
                <a href="/{{ $module->slug }}"
                   class="flex items-center gap-3 px-3 py-2 rounded-lg hover:bg-slate-800 transition">

                    <span>📁</span>
                    {{ $module->name }}
                </a>
            @endforeach

        </div>

       

    </nav>

    <div class="px-4 pb-6 border-t border-slate-700 pt-4">

        <button onclick="openLogoutModal()"
            class="w-full flex items-center gap-3 px-3 py-2 rounded-lg text-slate-300 hover:bg-red-500/20 hover:text-red-400 transition">

            <span>🚪</span>
            Cerrar sesión
        </button>

    </div>

</aside>

