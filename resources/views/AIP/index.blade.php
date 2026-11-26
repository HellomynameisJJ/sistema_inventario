<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Aula AIP - I.E. Tungasuca</title>
    
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
<body class="bg-[#F3F6F9] dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen md:h-screen md:overflow-hidden flex flex-col md:flex-row selection:bg-indigo-500 selection:text-white transition-colors duration-300 overflow-x-hidden">

    <!-- PRELOADER INSTITUCIONAL -->
    <div id="preloader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#F3F6F9] dark:bg-slate-950 transition-opacity duration-500">
        <div class="absolute w-96 h-96 bg-indigo-200/50 dark:bg-indigo-900/30 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
        <div class="absolute w-64 h-64 bg-amber-300/20 dark:bg-indigo-800/20 rounded-full blur-2xl animate-pulse delay-300 pointer-events-none"></div>

        <div class="relative w-32 h-32 flex items-center justify-center mb-8">
            <div class="w-32 h-32 border-4 border-indigo-500/20 border-t-indigo-600 dark:border-indigo-400/20 dark:border-t-indigo-400 rounded-full animate-spin"></div>
            <div class="absolute w-24 h-24 border-4 border-amber-400/30 border-b-amber-500 dark:border-indigo-400/20 dark:border-b-indigo-400 rounded-full animate-spin [animation-duration:1.5s]"></div>
            <img
                src="{{ asset('images/escudo-tungasuca.png') }}"
                alt="Escudo I.E. Tungasuca"
                class="absolute w-16 h-16 rounded-2xl object-cover shadow-lg border-2 border-white dark:border-slate-800 bg-[#0b3c8c] z-10"
            >
        </div>

        <div class="text-center space-y-2 z-10 px-4">
            <span class="px-3.5 py-1 rounded-full text-[10px] font-extrabold tracking-widest bg-indigo-100 dark:bg-indigo-950 text-indigo-800 dark:text-indigo-300 uppercase">
                Aula AIP & Innovación
            </span>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-wider uppercase mt-2">I.E. TUNGASUCA</h2>
            <p class="text-indigo-700 dark:text-indigo-400 text-xs font-semibold tracking-wide flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-indigo-500 animate-ping"></span>
                Cargando equipamiento del Aula AIP...
            </p>
        </div>
    </div>

    <!-- SIDEBAR -->
    @include('partials.sidebar')

    <!-- CONTENEDOR PRINCIPAL CON SCROLL INTERNO -->
    <div class="flex-grow min-w-0 p-6 md:p-10 overflow-y-auto h-full w-full flex flex-col justify-between">
        <div class="max-w-7xl mx-auto w-full min-w-0">
            <header class="mb-8 p-6 md:p-8 rounded-3xl bg-gradient-to-r from-indigo-800 to-purple-900 text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6 relative z-30">
                <div class="z-10 flex items-center gap-5">
                    <img
                        src="{{ asset('images/escudo-tungasuca.png') }}"
                        alt="Escudo I.E. Tungasuca"
                        class="w-16 h-16 rounded-2xl object-cover shadow-lg border border-white/25 bg-[#0b3c8c] shrink-0"
                    >
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-3 py-0.5 rounded-full text-[10px] font-black bg-indigo-400 text-slate-950 uppercase">Módulo Activo</span>
                            <span class="text-xs text-indigo-100">Aula de Innovación Pedagógica</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white">Inventario Aula AIP</h1>
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
                        <span class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 flex items-center justify-center text-indigo-600 font-bold text-lg">➕</span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Registrar Equipo AIP</h2>
                            <p class="text-xs text-slate-500">Recurso tecnológico del aula</p>
                        </div>
                    </div>

                    <form action="{{ route('aip.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="name" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Equipo / Dispositivo</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Ej: Computadora Escritorio HP, Proyector Multimedia" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="serial" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Código / N° Serie / Etiqueta</label>
                            <input type="text" id="serial" name="serial" value="{{ old('serial') }}" placeholder="Ej: AIP-PC-01" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-mono focus:outline-none focus:border-indigo-500">
                        </div>

                        <div>
                            <label for="type" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Tipo de Recurso</label>
                            <select id="type" name="type" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                                <option value="Computadora de Escritorio" {{ old('type') == 'Computadora de Escritorio' ? 'selected' : '' }}>🖥️ Computadora de Escritorio</option>
                                <option value="Laptop / XO" {{ old('type') == 'Laptop / XO' ? 'selected' : '' }}>💻 Laptop / XO</option>
                                <option value="Proyector / Ecran" {{ old('type') == 'Proyector / Ecran' ? 'selected' : '' }}>📹 Proyector / Ecran</option>
                                <option value="Equipo de Audio / Parlantes" {{ old('type') == 'Equipo de Audio / Parlantes' ? 'selected' : '' }}>🔊 Equipo de Audio / Parlantes</option>
                                <option value="Redes / Router / Switch" {{ old('type') == 'Redes / Router / Switch' ? 'selected' : '' }}>🌐 Redes / Router / Switch</option>
                                <option value="Accesorios (Teclado, Mouse, UPS)" {{ old('type') == 'Accesorios (Teclado, Mouse, UPS)' ? 'selected' : '' }}>⌨️ Accesorios (Teclado, Mouse, UPS)</option>
                            </select>
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="quantity" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Cantidad</label>
                                <input type="number" id="quantity" name="quantity" min="1" value="{{ old('quantity', 1) }}" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold focus:outline-none focus:border-indigo-500">
                            </div>
                            <div>
                                <label for="status" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Estado</label>
                                <select id="status" name="status" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                                    <option value="Operativo" {{ old('status') == 'Operativo' ? 'selected' : '' }}>🟢 Operativo</option>
                                    <option value="En Mantenimiento" {{ old('status') == 'En Mantenimiento' ? 'selected' : '' }}>🟡 Mantenimiento</option>
                                    <option value="Inoperativo" {{ old('status') == 'Inoperativo' ? 'selected' : '' }}>🔴 Inoperativo</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="observations" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Observaciones</label>
                            <textarea id="observations" name="observations" rows="2" placeholder="Ej: Ubicado en Mesa 3, requiere cambio de mouse" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-indigo-500">{{ old('observations') }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2 cursor-pointer">
                            <span>💾</span> Guardar en Aula AIP
                        </button>
                    </form>
                </div>

                <!-- TABLA -->
                <div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm lg:col-span-2 min-w-0">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Equipamiento del AIP</h2>
                            <p class="text-xs text-slate-500">Inventario tecnológico de la sala de innovación</p>
                        </div>
                        <div class="flex flex-col sm:flex-row gap-2.5 w-full sm:w-auto">
                            <select id="filtroEstadoAip" class="px-3.5 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-slate-700 dark:text-slate-200 focus:outline-none focus:border-indigo-500 cursor-pointer">
                                <option value="">Todos los estados</option>
                                <option value="operativo">🟢 Operativo</option>
                                <option value="en mantenimiento">🟡 En Mantenimiento</option>
                                <option value="inoperativo">🔴 Inoperativo</option>
                            </select>
                            <div class="relative w-full sm:w-64">
                                <input type="text" id="buscador" placeholder="Buscar por serie, nombre..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-indigo-500">
                                <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm">🔍</span>
                            </div>
                        </div>
                    </div>

                    <!-- FILTRO RÁPIDO POR TIPO DE RECURSO AIP -->
                    <div class="flex flex-wrap items-center gap-2 mb-4" id="tipoAipFilterGroup">
                        <button type="button" data-tipo="" class="tipo-aip-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-indigo-600 text-white shadow-sm transition cursor-pointer">
                            Todos
                        </button>
                        <button type="button" data-tipo="computadora de escritorio" class="tipo-aip-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 transition cursor-pointer">
                            🖥️ PCs
                        </button>
                        <button type="button" data-tipo="laptop / xo" class="tipo-aip-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 transition cursor-pointer">
                            💻 Laptops / XO
                        </button>
                        <button type="button" data-tipo="proyector / ecran" class="tipo-aip-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 transition cursor-pointer">
                            📹 Proyector / Ecran
                        </button>
                        <button type="button" data-tipo="redes / router / switch" class="tipo-aip-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 transition cursor-pointer">
                            🌐 Redes
                        </button>
                        <button type="button" data-tipo="accesorios" class="tipo-aip-btn px-3 py-1.5 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:bg-indigo-50 dark:hover:bg-slate-700 transition cursor-pointer">
                            ⌨️ Accesorios
                        </button>
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
                        <table class="w-full text-left border-collapse" id="tablaAip">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950 text-indigo-700 dark:text-indigo-400 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200 dark:border-slate-800">
                                    <th class="py-4 px-5">Equipo / Serie</th>
                                    <th class="py-4 px-5">Tipo</th>
                                    <th class="py-4 px-5 text-center">Cant.</th>
                                    <th class="py-4 px-5 text-center">Estado</th>
                                    <th class="py-4 px-5 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                @forelse($items as $item)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition item-fila"
                                        data-text="{{ strtolower($item->name . ' ' . $item->serial . ' ' . $item->type . ' ' . $item->observations) }}"
                                        data-type="{{ strtolower($item->type) }}"
                                        data-status="{{ strtolower($item->status) }}">
                                        <td class="py-3.5 px-5">
                                            <div class="font-bold text-slate-800 dark:text-white">{{ $item->name }}</div>
                                            <div class="text-xs font-mono text-indigo-600 dark:text-indigo-400">🏷️ {{ $item->serial ?? 'S/N' }}</div>
                                            @if($item->observations)
                                                <div class="text-xs text-slate-500 dark:text-slate-400 italic mt-0.5">{{ $item->observations }}</div>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-5">
                                            <span class="px-2.5 py-1 rounded-md bg-slate-100 dark:bg-slate-800 text-xs font-semibold text-indigo-700 dark:text-indigo-300">
                                                {{ $item->type }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-5 text-center font-bold">
                                            <span class="bg-slate-100 dark:bg-slate-800 px-3 py-1 rounded-lg border border-slate-200 dark:border-slate-700">{{ $item->quantity }}</span>
                                        </td>
                                        <td class="py-3.5 px-5 text-center">
                                            @if($item->status == 'Operativo')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300">🟢 Operativo</span>
                                            @elseif($item->status == 'En Mantenimiento')
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300">🟡 Mantenimiento</span>
                                            @else
                                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 dark:bg-rose-950/80 text-rose-800 dark:text-rose-300">🔴 Inoperativo</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-5 text-center">
                                            <form action="{{ route('aip.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Desea eliminar este equipo del Aula AIP?');">
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
                                        <td colspan="5" class="py-12 text-center text-slate-400">
                                            <div class="text-4xl mb-2">🖥️</div>
                                            <p class="text-sm">No hay equipos registrados en el Aula AIP.</p>
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
            <p>© {{ date('Y') }} I.E. Tungasuca - Aula AIP. Todos los derechos reservados.</p>
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

        let tipoAipSeleccionado = '';
        const buscador = document.getElementById('buscador');
        const filtroEstado = document.getElementById('filtroEstadoAip');
        const tipoBtns = document.querySelectorAll('.tipo-aip-btn');

        function normalizeText(str) {
            return (str || '').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        function aplicarFiltrosAip() {
            const query = normalizeText(buscador ? buscador.value : '');
            const estado = normalizeText(filtroEstado ? filtroEstado.value : '');
            const tipo = normalizeText(tipoAipSeleccionado);

            document.querySelectorAll('.item-fila').forEach(fila => {
                const texto = normalizeText(fila.getAttribute('data-text'));
                const rowType = normalizeText(fila.getAttribute('data-type'));
                const rowStatus = normalizeText(fila.getAttribute('data-status'));

                const matchQuery = !query || texto.includes(query);
                const matchType = !tipo || rowType === tipo || rowType.includes(tipo);
                const matchStatus = !estado || rowStatus === estado;

                fila.classList.toggle('hidden', !(matchQuery && matchType && matchStatus));
            });
        }

        tipoBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                tipoAipSeleccionado = this.getAttribute('data-tipo') || '';
                tipoBtns.forEach(b => {
                    b.classList.remove('bg-indigo-600', 'text-white', 'shadow-sm');
                    b.classList.add('bg-slate-100', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300');
                });
                this.classList.remove('bg-slate-100', 'dark:bg-slate-800', 'text-slate-700', 'dark:text-slate-300');
                this.classList.add('bg-indigo-600', 'text-white', 'shadow-sm');
                aplicarFiltrosAip();
            });
        });

        if (buscador) buscador.addEventListener('input', aplicarFiltrosAip);
        if (filtroEstado) filtroEstado.addEventListener('change', aplicarFiltrosAip);

        function cerrarAlerta() {
            const alert = document.getElementById('alertSuccess');
            if (alert) {
                alert.classList.add('opacity-0');
                setTimeout(() => alert.remove(), 300);
            }
        }

        function exportarVista(formato) {
            const data = window.TungasucaExporter.extractFromTable('#tablaAip', [4]);
            window.TungasucaExporter.run(formato, {
                title: 'Inventario de Equipamiento Aula AIP',
                subtitle: 'I.E. Tungasuca',
                sheetName: 'Aula_AIP',
                filename: 'Aula_AIP_IE_Tungasuca',
                headers: data.headers,
                rows: data.rows
            });
        }
    </script>
</body>
</html>