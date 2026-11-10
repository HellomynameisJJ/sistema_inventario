<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm lg:col-span-2 flex flex-col transition-colors overflow-hidden">
        <div class="flex flex-wrap justify-between items-center mb-4 pb-3 border-b border-slate-100 dark:border-slate-800 gap-2">
            <div>
                <h2 class="text-base font-bold text-brand-dark dark:text-white">Top 10 Objetos con Mayor Cantidad</h2>
                <p class="text-xs text-slate-500 dark:text-slate-400">Volumen acumulado por tipo de objeto</p>
            </div>
            <div class="flex items-center gap-2">
                <span class="px-3 py-1 rounded-full bg-brand-blue/10 text-brand-blue text-xs font-bold whitespace-nowrap">
                    {{ ($classroomId ?? null) ? 'Aula Filtrada' : 'Todo el Colegio' }}
                </span>
                <a href="{{ route('inventory.objetos', ($classroomId ?? null) ? ['classroom_id' => $classroomId] : []) }}"
                   class="hover-shine bg-brand-blue hover:bg-brand-hover text-white px-3 py-1.5 rounded-xl text-xs font-bold flex items-center gap-1.5 transition shadow-md whitespace-nowrap">
                    <span>📋</span>
                    <span>Ver todos</span>
                </a>
            </div>
        </div>
        <div class="relative w-full" style="height: 380px;">
            <canvas id="graficoTopObjetos"></canvas>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm flex flex-col transition-colors overflow-hidden">
        <div class="mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-base font-bold text-brand-dark dark:text-white">Salud del Inventario</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">Distribución por condición</p>
        </div>
        <div class="relative w-full flex-1" style="min-height: 240px;">
            <canvas id="graficoSaludDona"></canvas>
        </div>
        <div class="mt-4 pt-3 border-t border-slate-100 dark:border-slate-800 text-center">
            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">
                Total: <strong class="text-brand-dark dark:text-white">{{ $totalCantidad ?? 0 }}</strong> unidades
            </span>
        </div>
    </div>

    <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm lg:col-span-3 flex flex-col transition-colors overflow-hidden">
        <div class="mb-4 pb-3 border-b border-slate-100 dark:border-slate-800">
            <h2 class="text-base font-bold text-brand-dark dark:text-white">Comparativa de Condición por Objeto (Top 10)</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">Bueno / Regular / Malo por cada objeto</p>
        </div>
        <div class="relative w-full" style="height: 380px;">
            <canvas id="graficoCondicionesApiladas"></canvas>
        </div>
    </div>
</div>