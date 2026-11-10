<div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
    <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
        <div>
            <h2 class="text-lg font-bold text-brand-dark dark:text-white tracking-wide">Detalle Estructural por Aula</h2>
            <p class="text-xs text-slate-500 dark:text-slate-400">Listado jerárquico de mobiliario y recursos asignados</p>
        </div>
        
        <div class="flex flex-wrap items-center gap-3 w-full md:w-auto">
            <div class="relative flex-grow sm:flex-grow-0 sm:w-64">
                <input type="text" id="buscadorTabla" onkeyup="filtrarTabla()" placeholder="Buscar aula u objeto..." aria-label="Buscar en la tabla" class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-brand-dark dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:ring-1 focus:ring-brand-blue transition">
                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm">🔍</span>
            </div>

            <button type="button" onclick="exportarPDF()" class="bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 text-rose-600 dark:text-rose-400 hover:text-white border border-rose-200 dark:border-rose-900 px-4 py-2.5 rounded-xl font-bold flex items-center gap-2 transition text-xs shadow-sm cursor-pointer">
                <span>📄</span>
                <span>Exportar PDF</span>
            </button>

            <button type="button" onclick="exportarCSV()" class="bg-emerald-50 dark:bg-emerald-950/40 hover:bg-emerald-600 text-emerald-600 dark:text-emerald-400 hover:text-white border border-emerald-200 dark:border-emerald-900 px-4 py-2.5 rounded-xl font-bold flex items-center gap-2 transition text-xs shadow-sm cursor-pointer">
                <span>📊</span>
                <span>Exportar CSV</span>
            </button>
        </div>
    </div>

    <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-800">
        <table class="w-full text-left border-collapse" id="tablaDetalle">
            <thead>
                <tr class="bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200 dark:border-slate-800">
                    <th scope="col" class="py-4 px-5">Objeto / Mobiliario</th>
                    <th scope="col" class="py-4 px-3 text-center">🟢 Bueno</th>
                    <th scope="col" class="py-4 px-3 text-center">🟡 Regular</th>
                    <th scope="col" class="py-4 px-3 text-center">🔴 Malo</th>
                    <th scope="col" class="py-4 px-5 text-right">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-brand-dark dark:text-slate-200 text-sm">
                @forelse(($detalleAula ?? []) as $aula => $objetos)
                    <tr class="bg-slate-100/70 dark:bg-slate-800/50 bloque-aula" data-aula="{{ strtolower($aula) }}">
                        <td colspan="5" class="py-3 px-5 font-extrabold text-brand-blue dark:text-brand-sky uppercase tracking-wide border-y border-slate-200 dark:border-slate-800">
                            🏫 Aula / Sección: {{ $aula ?: 'Sin Asignar' }}
                        </td>
                    </tr>
                    @foreach($objetos as $obj)
                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition fila-objeto"
                        data-objeto="{{ strtolower($obj->objeto) }}"
                        data-parent-aula="{{ strtolower($aula) }}">
                        <td class="py-3.5 px-5 pl-10 text-slate-700 dark:text-slate-300 font-medium flex items-center gap-2">
                            <span class="text-slate-400">↳</span>
                            <span>{{ $obj->objeto }}</span>
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            @if($obj->buenas > 0)
                                <span class="inline-block px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 text-xs font-bold border border-emerald-200 dark:border-emerald-800">{{ $obj->buenas }}</span>
                            @else
                                <span class="text-slate-300 dark:text-slate-600">—</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            @if($obj->regulares > 0)
                                <span class="inline-block px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-400 text-xs font-bold border border-amber-200 dark:border-amber-800">{{ $obj->regulares }}</span>
                            @else
                                <span class="text-slate-300 dark:text-slate-600">—</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-3 text-center">
                            @if($obj->malas > 0)
                                <span class="inline-block px-2.5 py-1 rounded-lg bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-400 text-xs font-bold border border-rose-200 dark:border-rose-800">{{ $obj->malas }}</span>
                            @else
                                <span class="text-slate-300 dark:text-slate-600">—</span>
                            @endif
                        </td>
                        <td class="py-3.5 px-5 text-brand-dark dark:text-white font-bold text-right font-mono">
                            <span class="bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300">{{ $obj->total }} uds.</span>
                        </td>
                    </tr>
                    @endforeach
                @empty
                    <tr id="filaSinDatos">
                        <td colspan="5" class="py-12 text-center text-slate-400">
                            <div class="text-4xl mb-2">📊</div>
                            <p class="text-sm">No hay datos de inventario disponibles para esta selección.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>