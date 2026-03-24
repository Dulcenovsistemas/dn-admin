<div class="flex items-center justify-between px-6 h-16">

    {{-- Título / breadcrumb --}}
    <div class="flex items-center gap-4">

        <h1 class="text-lg font-semibold text-slate-700">
            Panel ERP
        </h1>

    </div>

    {{-- Lado derecho --}}
    <div class="flex items-center gap-6">

        {{-- Usuario --}}
        <div class="flex items-center gap-3">

            <div class="w-8 h-8 bg-slate-300 rounded-full flex items-center justify-center text-sm font-semibold text-slate-700">
                {{ strtoupper(substr(auth()->user()->name,0,1)) }}
            </div>

            <span class="text-sm text-slate-700 font-medium">
                {{ auth()->user()->name }}
            </span>

        </div>

    </div>

</div>