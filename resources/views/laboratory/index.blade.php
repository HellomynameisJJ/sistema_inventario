<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo de Laboratorio de Ciencias - I.E. Tungasuca</title>
    
    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') {
                document.documentElement.classList.add('dark');
            } else {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0756A3',
                            hover: '#064681',
                            secondary: '#1689D4',
                            sky: '#48B9E8',
                            yellow: '#F5C542',
                            dark: '#172B4D',
                            bg: '#F3F6F9',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
    </style>
</head>
<body class="bg-[#F3F6F9] dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen md:h-screen md:overflow-hidden flex flex-col md:flex-row selection:bg-emerald-500 selection:text-white transition-colors duration-300 overflow-x-hidden">

    <!-- PRELOADER INSTITUCIONAL -->
    <div id="preloader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#F3F6F9] dark:bg-slate-950 transition-opacity duration-500">
        <div class="absolute w-96 h-96 bg-emerald-200/50 dark:bg-emerald-900/30 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
        <div class="absolute w-64 h-64 bg-amber-300/20 dark:bg-teal-900/20 rounded-full blur-2xl animate-pulse delay-300 pointer-events-none"></div>

        <div class="relative w-32 h-32 flex items-center justify-center mb-8">
            <div class="w-32 h-32 border-4 border-emerald-500/20 border-t-emerald-600 dark:border-emerald-400/20 dark:border-t-emerald-400 rounded-full animate-spin"></div>
            <div class="absolute w-24 h-24 border-4 border-amber-400/30 border-b-amber-500 dark:border-teal-400/20 dark:border-b-teal-400 rounded-full animate-spin [animation-duration:1.5s]"></div>
            <img
                src="{{ asset('images/escudo-tungasuca.png') }}"
                alt="Escudo I.E. Tungasuca"
                class="absolute w-16 h-16 rounded-2xl object-cover shadow-lg border-2 border-white dark:border-slate-800 bg-[#0b3c8c] z-10"
            >
        </div>

        <div class="text-center space-y-2 z-10 px-4">
            <span class="px-3.5 py-1 rounded-full text-[10px] font-extrabold tracking-widest bg-emerald-100 dark:bg-emerald-950 text-emerald-800 dark:text-emerald-300 uppercase">
                Laboratorio de Ciencias
            </span>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-wider uppercase mt-2">I.E. TUNGASUCA</h2>
            <p class="text-emerald-700 dark:text-emerald-400 text-xs font-semibold tracking-wide flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-ping"></span>
                Cargando inventario de laboratorio...
            </p>
        </div>
    </div>

    <!-- SIDEBAR -->
    @include('partials.sidebar')

    <!-- CONTENEDOR PRINCIPAL CON SCROLL INTERNO -->
    <div class="flex-grow min-w-0 p-6 md:p-10 overflow-y-auto h-full w-full flex flex-col justify-between">
        <div class="max-w-7xl mx-auto w-full min-w-0">
            <header class="mb-8 p-6 md:p-8 rounded-3xl bg-gradient-to-r from-emerald-800 to-teal-900 text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6 relative z-30">
                <div class="z-10 flex items-center gap-5">
                    <img
                        src="{{ asset('images/escudo-tungasuca.png') }}"
                        alt="Escudo I.E. Tungasuca"
                        class="w-16 h-16 rounded-2xl object-cover shadow-lg border border-white/25 bg-[#0b3c8c] shrink-0"
                    >
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-3 py-0.5 rounded-full text-[10px] font-black bg-emerald-400 text-slate-950 uppercase">Módulo Activo</span>
                            <span class="text-xs text-emerald-100">Área de Ciencias</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white">Inventario de Laboratorio</h1>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div id="alertSuccess" class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl mb-6 shadow-sm flex items-center justify-between transition-opacity duration-300">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">✅</span>
                        <span class="font-semibold text-sm">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="cerrarAlerta()" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 font-bold text-lg cursor-pointer">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 dark:bg-rose-950/40 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-5 py-4 rounded-2xl mb-6 shadow-sm">
                    <div class="font-bold text-sm mb-1">⚠️ Revisa los datos del formulario:</div>
                    <ul class="list-disc pl-6 text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 min-w-0">
                <!-- FORMULARIO -->
                <div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm lg:col-span-1 self-start">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-200 dark:border-slate-800">
                        <span class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 flex items-center justify-center text-emerald-600 font-bold text-lg">➕</span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Registrar Material</h2>
                            <p class="text-xs text-slate-500">Campos oficiales de laboratorio</p>
                        </div>
                    </div>

                    <form action="{{ route('laboratory.store') }}" method="POST" class="space-y-4">
                        @csrf

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="item" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">ITEM</label>
                                <input type="text" id="item" name="item" value="{{ old('item') }}" placeholder="Ej: 19" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                            </div>

                            <div>
                                <label for="codigo_interno" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">CODIGO INTERNO</label>
                                <input type="text" id="codigo_interno" name="codigo_interno" value="{{ old('codigo_interno') }}" placeholder="Ej: 02010027" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-mono focus:outline-none focus:border-emerald-500">
                            </div>
                        </div>

                        <div>
                            <label for="denominacion_tecnica" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">DENOMINACION TECNICA</label>
                            <input type="text" id="denominacion_tecnica" name="denominacion_tecnica" value="{{ old('denominacion_tecnica') }}" required placeholder="Ej: Set de Cilindros" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                        </div>

                        <div>
                            <label for="descripcion_tecnica" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">DESCRIPCION TECNICA</label>
                            <textarea id="descripcion_tecnica" name="descripcion_tecnica" rows="2" placeholder="Ej: Bueno" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-emerald-500">{{ old('descripcion_tecnica') }}</textarea>
                        </div>

                        <div>
                            <label for="cantidad" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">CANTIDAD</label>
                            <input type="number" id="cantidad" name="cantidad" min="1" value="{{ old('cantidad', 1) }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold focus:outline-none focus:border-emerald-500">
                        </div>

                        <button type="submit" class="w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2 cursor-pointer">
                            <span>💾</span> Guardar Registro
                        </button>
                    </form>
                </div>

                <!-- TABLA -->
                <div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm lg:col-span-2 min-w-0">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Inventario Registrado</h2>
                            <p class="text-xs text-slate-500">Listado de registros del laboratorio</p>
                        </div>
                        <div class="relative w-full sm:w-72">
                            <input type="text" id="buscador" placeholder="Buscar item, código, denominación..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-emerald-500">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm">🔍</span>
                        </div>
                    </div>

                    <div class="flex flex-wrap items-center justify-end gap-2 mb-4">
                        <button type="button" onclick="exportarVista('pdf')" class="px-3 py-1.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold transition cursor-pointer shadow-sm">
                            📄 PDF
                        </button>
                        <button type="button" onclick="exportarVista('csv')" class="px-3 py-1.5 rounded-xl bg-slate-700 hover:bg-slate-800 text-white text-xs font-bold transition cursor-pointer shadow-sm">
                            📑 CSV
                        </button>
                        <button type="button" onclick="exportarVista('xlsx')" class="px-3 py-1.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition cursor-pointer shadow-sm">
                            📊 .XLSX
                        </button>
                        <button type="button" onclick="exportarVista('xls')" class="px-3 py-1.5 rounded-xl bg-teal-600 hover:bg-teal-700 text-white text-xs font-bold transition cursor-pointer shadow-sm">
                            📗 .XLS
                        </button>
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-slate-200 dark:border-slate-800">
                        <table class="w-full text-left border-collapse" id="tablaLaboratorio">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950 text-emerald-700 dark:text-emerald-400 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200 dark:border-slate-800">
                                    <th class="py-4 px-4">ITEM</th>
                                    <th class="py-4 px-4">CODIGO INTERNO</th>
                                    <th class="py-4 px-4">DENOMINACION TECNICA</th>
                                    <th class="py-4 px-4">DESCRIPCION TECNICA</th>
                                    <th class="py-4 px-4 text-center">CANTIDAD</th>
                                    <th class="py-4 px-4 text-center">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                @forelse($items as $item)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition item-fila"
                                        data-text="{{ strtolower(($item->item ?? '') . ' ' . ($item->codigo_interno ?? '') . ' ' . ($item->denominacion_tecnica ?? '') . ' ' . ($item->descripcion_tecnica ?? '') . ' ' . ($item->cantidad ?? '')) }}">
                                        <td class="py-3.5 px-4 font-semibold text-slate-800 dark:text-white">{{ $item->item ?? '—' }}</td>
                                        <td class="py-3.5 px-4 font-mono text-xs text-emerald-700 dark:text-emerald-400">{{ $item->codigo_interno ?? '—' }}</td>
                                        <td class="py-3.5 px-4 font-bold text-slate-800 dark:text-white">{{ $item->denominacion_tecnica }}</td>
                                        <td class="py-3.5 px-4 text-slate-600 dark:text-slate-300">{{ $item->descripcion_tecnica ?? '—' }}</td>
                                        <td class="py-3.5 px-4 text-center font-bold">
                                            <span class="bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg border border-slate-200 dark:border-slate-700">{{ $item->cantidad }}</span>
                                        </td>
                                        <td class="py-3.5 px-4 text-center">
                                            <form action="{{ route('laboratory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Desea eliminar este registro?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 text-rose-600 hover:text-white px-3 py-1.5 rounded-xl border border-rose-200 text-xs font-bold transition cursor-pointer">
                                                    🗑️ Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-slate-400">
                                            <div class="text-4xl mb-2">🧪</div>
                                            <p class="text-sm">No hay registros en el laboratorio.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <footer class="max-w-7xl mx-auto w-full mt-12 py-6 border-t border-slate-200 dark:border-slate-800 text-center text-slate-500 text-xs">
            <p>© {{ date('Y') }} I.E. Tungasuca - Laboratorio de Ciencias. Todos los derechos reservados.</p>
        </footer>
    </div>

    @include('partials.exporter-scripts')

    <script>
        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('opacity-0');
                setTimeout(() => preloader.remove(), 500);
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            const currentTheme = localStorage.getItem('theme') || 'light';
            const themeLabel = document.getElementById('themeTextLabel');
            if (themeLabel) {
                themeLabel.innerText = currentTheme === 'dark' ? 'Oscuro' : 'Claro';
            }
        });

        function toggleDarkMode() {
            const htmlElement = document.documentElement;
            const isDark = htmlElement.classList.contains('dark');
            if (isDark) {
                htmlElement.classList.remove('dark');
                if (document.getElementById('themeTextLabel')) document.getElementById('themeTextLabel').innerText = 'Claro';
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.classList.add('dark');
                if (document.getElementById('themeTextLabel')) document.getElementById('themeTextLabel').innerText = 'Oscuro';
                localStorage.setItem('theme', 'dark');
            }
        }

        const buscador = document.getElementById('buscador');
        if (buscador) {
            buscador.addEventListener('input', function() {
                const query = (this.value || '').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                document.querySelectorAll('.item-fila').forEach(fila => {
                    const texto = (fila.getAttribute('data-text') || '').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    fila.classList.toggle('hidden', !texto.includes(query));
                });
            });
        }

        function cerrarAlerta() {
            const alert = document.getElementById('alertSuccess');
            if (alert) {
                alert.classList.add('opacity-0');
                setTimeout(() => alert.remove(), 300);
            }
        }

        function exportarVista(formato) {
            const data = window.TungasucaExporter.extractFromTable('#tablaLaboratorio', [5]);
            window.TungasucaExporter.run(formato, {
                title: 'Inventario de Laboratorio de Ciencias',
                subtitle: 'I.E. Tungasuca',
                sheetName: 'Laboratorio',
                filename: 'Laboratorio_IE_Tungasuca',
                headers: data.headers,
                rows: data.rows
            });
        }
    </script>
</body>
</html>