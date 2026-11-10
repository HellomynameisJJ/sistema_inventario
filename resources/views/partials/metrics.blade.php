<header class="mb-8 p-6 md:p-8 rounded-3xl bg-brand-blue dark:bg-slate-900 text-white shadow-xl shadow-brand-blue/15 flex flex-col md:flex-row justify-between items-center gap-6 relative z-30 transition-colors duration-300 border border-slate-800">
    <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-3xl">
        <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-brand-sky/20 rounded-full blur-3xl"></div>
        <div class="absolute right-1/3 -top-12 w-48 h-48 bg-brand-yellow/20 rounded-full blur-2xl"></div>
    </div>
    
    <div class="z-10 flex items-center gap-5">
        <div>
            <div class="flex items-center gap-2 mb-1">
                <span class="px-3 py-0.5 rounded-full text-[11px] font-extrabold bg-brand-yellow text-brand-dark uppercase tracking-widest shadow-sm">I.E. Tungasuca</span>
                <span class="text-xs text-brand-sky font-semibold tracking-wide">Panel de Métricas</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Estadísticas del Inventario</h1>
        </div>
    </div>

    <div class="flex flex-wrap items-center gap-3 z-30 relative w-full md:w-auto justify-end">
        <form method="GET" action="{{ route('inventory.dashboard') }}" id="formAulaFilter" class="relative w-full sm:w-auto z-50">
            <input type="hidden" name="classroom_id" id="inputClassroomId" value="{{ request('classroom_id') }}">

            <button type="button" onclick="toggleAulaDropdown()" id="btnAulaDropdown" class="w-full sm:w-auto px-4 py-2.5 bg-white dark:bg-slate-800 text-brand-dark dark:text-slate-100 border border-white/30 dark:border-slate-700 rounded-2xl text-sm font-semibold focus:outline-none transition flex items-center justify-between gap-3 shadow-md cursor-pointer">
                <div class="flex items-center gap-2 overflow-hidden">
                    <span id="selectedAulaLabel" class="truncate">
                        @if(request('classroom_id'))
                            Aula: {{ (($classroomsList ?? collect())->firstWhere('id', request('classroom_id')))?->name ?? 'Seleccionada' }}
                        @else
                            Vista General (Todo el Colegio)
                        @endif
                    </span>
                </div>
                <span class="text-brand-blue dark:text-brand-sky text-xs transition-transform duration-200" id="arrowAulaDropdown">▼</span>
            </button>

            <div id="menuAulaDropdown" class="hidden absolute right-0 w-full sm:w-72 mt-2 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-2xl shadow-2xl z-50 overflow-hidden py-1 text-slate-800 dark:text-slate-100">
                <button type="button" onclick="selectAula('')" class="w-full px-4 py-2.5 text-left text-sm font-medium hover:bg-brand-blue/10 dark:hover:bg-slate-800 flex items-center gap-2.5 transition cursor-pointer">
                    <span class="font-bold truncate">🌐 Vista General (Todo el Colegio)</span>
                </button>
                <div class="border-t border-slate-100 dark:border-slate-800 my-1"></div>
                @foreach(($classroomsList ?? collect()) as $room)
                    <button type="button" onclick="selectAula('{{ $room->id }}')" class="w-full px-4 py-2.5 text-left text-sm font-medium hover:bg-brand-blue/10 dark:hover:bg-slate-800 flex items-center gap-2.5 transition cursor-pointer">
                        <span class="text-base">🏫</span>
                        <span class="truncate">Aula: {{ $room->name }}</span>
                    </button>
                @endforeach
            </div>
        </form>

        <a href="{{ route('inventory.index') }}" class="bg-brand-hover hover:bg-white hover:text-brand-blue dark:bg-slate-700 dark:hover:bg-slate-600 dark:hover:text-white text-white border border-white/20 px-5 py-2.5 rounded-2xl font-bold flex items-center gap-2 transition-all shadow-md text-sm whitespace-nowrap">
            <span>⬅️</span>
            <span>Volver al Registro</span>
        </a>
    </div>
</header>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 border-l-4 border-l-brand-blue shadow-sm hover:shadow-md transition">
        <div class="flex justify-between items-start">
            <p class="text-xs text-slate-500 dark:text-slate-400 font-extrabold uppercase tracking-wider">Total de Recursos</p>
            <span class="p-2.5 rounded-2xl bg-brand-blue/10 dark:bg-brand-blue/30 text-brand-blue dark:text-brand-sky text-lg font-bold">📦</span>
        </div>
        <h3 class="text-4xl font-black text-brand-dark dark:text-white mt-3 font-mono counter-val" data-target="{{ $totalCantidad ?? 0 }}">0</h3>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Unidades registradas</p>
    </div>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 border-l-4 border-l-brand-success shadow-sm hover:shadow-md transition">
        <div class="flex justify-between items-start">
            <p class="text-xs text-brand-success font-extrabold uppercase tracking-wider">Buen Estado</p>
            <span class="p-2.5 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 text-brand-success text-lg">🟢</span>
        </div>
        <h3 class="text-4xl font-black text-brand-success mt-3 font-mono counter-val" data-target="{{ $cantBueno ?? 0 }}">0</h3>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Operativos al 100%</p>
    </div>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 border-l-4 border-l-brand-yellow shadow-sm hover:shadow-md transition">
        <div class="flex justify-between items-start">
            <p class="text-xs text-amber-600 dark:text-amber-400 font-extrabold uppercase tracking-wider">Estado Regular</p>
            <span class="p-2.5 rounded-2xl bg-amber-50 dark:bg-amber-950/40 text-amber-600 dark:text-amber-400 text-lg">🟡</span>
        </div>
        <h3 class="text-4xl font-black text-amber-500 dark:text-amber-400 mt-3 font-mono counter-val" data-target="{{ $cantRegular ?? 0 }}">0</h3>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Mantenimiento preventivo</p>
    </div>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 border-l-4 border-l-brand-danger shadow-sm hover:shadow-md transition">
        <div class="flex justify-between items-start">
            <p class="text-xs text-brand-danger font-extrabold uppercase tracking-wider">Mal Estado</p>
            <span class="p-2.5 rounded-2xl bg-rose-50 dark:bg-rose-950/40 text-brand-danger text-lg">🔴</span>
        </div>
        <h3 class="text-4xl font-black text-brand-danger mt-3 font-mono counter-val" data-target="{{ $cantMalo ?? 0 }}">0</h3>
        <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">Requieren reemplazo/reparación</p>
    </div>
</div>