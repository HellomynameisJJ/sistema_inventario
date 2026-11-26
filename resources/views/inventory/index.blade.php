<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventario de Mobiliario - I.E. Tungasuca</title>

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
                            success: '#22A06B',
                            warning: '#F5C542',
                            danger: '#D64545',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@700;800;900&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-heading { font-family: 'Outfit', sans-serif; }
        .text-gradient-brand {
            background: linear-gradient(135deg, #0284c7 0%, #1d4ed8 50%, #1e1b4b 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .dark .text-gradient-brand {
            background: linear-gradient(135deg, #38bdf8 0%, #60a5fa 50%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
        .hover-shine { position: relative; overflow: hidden; }
        .hover-shine::after {
            content: '';
            position: absolute;
            top: -50%; left: -60%; width: 20%; height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(30deg); transition: none;
        }
        .hover-shine:hover::after {
            left: 120%;
            transition: all 0.6s cubic-bezier(0.19, 1, 0.22, 1);
        }
    </style>
</head>
<body class="bg-[#F3F6F9] dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen md:h-screen md:overflow-hidden flex flex-col md:flex-row selection:bg-sky-500 selection:text-white transition-colors duration-300 overflow-x-hidden">

    <!-- PRELOADER INSTITUCIONAL -->
    <div id="preloader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#F3F6F9] dark:bg-slate-950 transition-opacity duration-500">
        <div class="absolute w-96 h-96 bg-sky-200/50 dark:bg-sky-900/30 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
        <div class="absolute w-64 h-64 bg-blue-300/30 dark:bg-blue-800/20 rounded-full blur-2xl animate-pulse delay-300 pointer-events-none"></div>

        <div class="relative w-32 h-32 flex items-center justify-center mb-8">
            <div class="w-32 h-32 border-4 border-sky-200 dark:border-sky-800 border-t-sky-600 dark:border-t-sky-400 rounded-full animate-spin"></div>
            <div class="absolute w-24 h-24 border-4 border-blue-100 dark:border-blue-900 border-b-blue-600 dark:border-b-blue-400 rounded-full animate-spin [animation-duration:1.2s]"></div>
            <img
                src="{{ asset('images/escudo-tungasuca.png') }}"
                alt="Escudo I.E. Tungasuca"
                class="absolute w-16 h-16 rounded-2xl object-cover shadow-lg border-2 border-white dark:border-slate-800 bg-[#0b3c8c] z-10"
            >
        </div>

        <div class="text-center space-y-2 z-10 px-4">
            <span class="px-3.5 py-1 rounded-full text-[11px] font-extrabold tracking-widest bg-sky-100 dark:bg-sky-950 text-sky-800 dark:text-sky-300 border border-sky-200 dark:border-sky-800 uppercase shadow-sm">
                Gestión Institucional
            </span>
            <h2 class="font-heading text-3xl font-black text-slate-900 dark:text-white tracking-wide uppercase mt-2">I.E. TUNGASUCA</h2>
            <p class="text-sky-700 dark:text-sky-400 text-xs font-semibold tracking-wide flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-sky-500 animate-ping"></span>
                Cargando módulos de inventario...
            </p>
        </div>
    </div>

    <!-- INCLUIR SIDEBAR PARCIAL -->
    @include('partials.sidebar')

    <!-- CONTENEDOR PRINCIPAL CON SCROLL INTERNO -->
    <div class="flex-grow min-w-0 p-6 md:p-10 overflow-y-auto h-full w-full flex flex-col justify-between">

        <div class="max-w-7xl mx-auto w-full min-w-0">
            <header class="mb-8 p-6 md:p-8 rounded-3xl bg-white dark:bg-slate-900 border border-sky-100 dark:border-slate-800 shadow-xl shadow-sky-900/5 dark:shadow-black/20 flex flex-col md:flex-row justify-between items-center gap-6 relative z-30 transition-colors duration-300">
                <div class="absolute inset-0 rounded-3xl overflow-hidden pointer-events-none">
                    <div class="absolute -right-10 -bottom-10 w-60 h-60 bg-sky-100/60 dark:bg-sky-900/10 rounded-full blur-2xl"></div>
                    <div class="absolute right-1/3 -top-10 w-40 h-40 bg-blue-50/80 dark:bg-blue-900/10 rounded-full blur-xl"></div>
                </div>

                <div class="z-10 flex items-center gap-5">
                    <img
                        src="{{ asset('images/escudo-tungasuca.png') }}"
                        alt="Escudo I.E. Tungasuca"
                        class="w-16 h-16 rounded-2xl object-cover shadow-lg border border-sky-200 dark:border-slate-700 bg-[#0b3c8c] shrink-0"
                    >
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-3 py-0.5 rounded-full text-[11px] font-extrabold bg-sky-100 dark:bg-sky-950 text-sky-800 dark:text-sky-300 border border-sky-200 dark:border-sky-800 uppercase tracking-wider">Módulo Activo</span>
                            <span class="text-xs text-slate-500 dark:text-slate-400 font-semibold tracking-wide">Gestión de Aulas</span>
                        </div>
                        <h1 class="font-heading text-3xl md:text-4xl font-black tracking-tight text-gradient-brand drop-shadow-sm">
                            I.E. TUNGASUCA
                        </h1>
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400 tracking-wider uppercase mt-0.5">Control & Inventario de Mobiliario</p>
                    </div>
                </div>
            </header>

            <!-- NOTIFICACIONES -->
            @if(session('success'))
                <div id="alertSuccess" class="bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl mb-6 shadow-sm flex items-center justify-between transition-opacity duration-300">
                    <div class="flex items-center gap-3">
                        <span class="text-xl">✅</span>
                        <span class="font-semibold text-sm">{{ session('success') }}</span>
                    </div>
                    <button type="button" onclick="cerrarAlerta()" class="text-emerald-600 dark:text-emerald-400 hover:text-emerald-900 font-bold text-lg cursor-pointer">&times;</button>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-5 py-4 rounded-2xl mb-6 shadow-sm">
                    <div class="flex items-center gap-2 font-bold mb-2">
                        <span class="text-xl">⚠️</span>
                        <span>¡Atención! Revisa los siguientes campos:</span>
                    </div>
                    <ul class="list-disc pl-8 text-sm space-y-1 text-rose-700 dark:text-rose-400">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 min-w-0">

                <!-- FORMULARIO DE REGISTRO CON COMBOBOX EN CASCADA -->
                <div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-sky-100 dark:border-slate-800 shadow-xl shadow-sky-900/5 dark:shadow-black/20 lg:col-span-1 self-start transition-colors duration-300">
                    <div class="flex items-center gap-3 mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <span class="w-10 h-10 rounded-xl bg-sky-100 dark:bg-sky-950 border border-sky-200 dark:border-sky-800 flex items-center justify-center text-sky-700 dark:text-sky-300 font-bold text-lg">➕</span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-wide">Registrar Mobiliario</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Añadir nuevos ítems al sistema</p>
                        </div>
                    </div>

                    <form action="{{ route('inventory.store') }}" method="POST" class="space-y-5">
                        @csrf

                        <!-- COMBOBOX 1: GRADO ESCOLAR -->
                        <div>
                            <label for="selectGrado" class="block text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-2">Grado Escolar</label>
                            <div class="relative">
                                <select id="selectGrado" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-200 dark:focus:ring-sky-900 transition appearance-none cursor-pointer font-medium" onchange="filtrarSecciones()">
                                    <option value="" class="bg-white dark:bg-slate-800">-- Seleccionar Grado --</option>
                                    @foreach($grades as $grade)
                                        @if(str_contains(strtolower($grade->name), 'grado'))
                                            <option value="{{ $grade->id }}" class="bg-white dark:bg-slate-800 text-slate-800 dark:text-slate-100 font-bold">{{ $grade->name }}</option>
                                        @endif
                                    @endforeach
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">▼</div>
                            </div>
                        </div>

                        <!-- COMBOBOX 2: SECCIÓN / AULA -->
                        <div>
                            <label for="selectSeccion" class="block text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-2">Sección / Aula</label>
                            <div class="relative">
                                <select name="classroom_id" id="selectSeccion" required disabled class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-200 dark:focus:ring-sky-900 transition appearance-none cursor-pointer font-medium disabled:opacity-50 disabled:cursor-not-allowed">
                                    <option value="" class="bg-white dark:bg-slate-800">-- Primero seleccione un grado --</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">▼</div>
                            </div>
                        </div>

                        <!-- COMBOBOX 3: TIPO DE OBJETO -->
                        <div>
                            <label for="objeto" class="block text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-2">Tipo de Objeto</label>
                            <div class="relative">
                                <select id="objeto" name="objeto" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-200 dark:focus:ring-sky-900 transition appearance-none cursor-pointer font-medium">
                                    <option value="" class="bg-white dark:bg-slate-800">-- Seleccionar Objeto --</option>
                                    <option value="Ventana" {{ old('objeto') == 'Ventana' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">🪟 Ventana</option>
                                    <option value="Proyector" {{ old('objeto') == 'Proyector' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">📹 Proyector</option>
                                    <option value="Puerta" {{ old('objeto') == 'Puerta' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">🚪 Puerta</option>
                                    <option value="Pizarra" {{ old('objeto') == 'Pizarra' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">📋 Pizarra</option>
                                    <option value="Estante" {{ old('objeto') == 'Estante' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">🗄️ Estante</option>
                                    <option value="Casillero (Locker)" {{ old('objeto') == 'Casillero (Locker)' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">🔒 Casillero (Locker)</option>
                                    <option value="Pupitre" {{ old('objeto') == 'Pupitre' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">🪑 Pupitre</option>
                                    <option value="Equipo Tecnológico" {{ old('objeto') == 'Equipo Tecnológico' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">💻 Equipo Tecnológico</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">▼</div>
                            </div>
                        </div>

                        <div>
                            <label for="cantidad" class="block text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-2">Cantidad</label>
                            <input type="number" id="cantidad" name="cantidad" min="1" value="{{ old('cantidad') }}" placeholder="Ej: 35" required class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-200 dark:focus:ring-sky-900 transition placeholder-slate-400 font-medium">
                        </div>

                        <div>
                            <label for="condicion" class="block text-slate-600 dark:text-slate-300 text-xs font-bold uppercase tracking-wider mb-2">Condición / Estado</label>
                            <div class="relative">
                                <select id="condicion" name="condicion" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-slate-800 dark:text-slate-100 text-sm focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-200 dark:focus:ring-sky-900 transition appearance-none cursor-pointer font-medium">
                                    <option value="Bueno" {{ old('condicion') == 'Bueno' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">🟢 Bueno</option>
                                    <option value="Regular" {{ old('condicion') == 'Regular' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">🟡 Regular</option>
                                    <option value="Malo" {{ old('condicion') == 'Malo' ? 'selected' : '' }} class="bg-white dark:bg-slate-800">🔴 Malo</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none text-slate-400 text-xs">▼</div>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-gradient-to-r from-sky-600 to-blue-600 hover:from-sky-700 hover:to-blue-700 text-white font-bold py-3.5 px-4 rounded-xl shadow-md shadow-sky-600/20 transition-all duration-200 text-sm transform active:scale-95 flex items-center justify-center gap-2 mt-2 cursor-pointer">
                            <span>💾</span> Guardar Registro
                        </button>
                    </form>
                </div>

                <!-- TABLA DE REGISTROS -->
                <div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-sky-100 dark:border-slate-800 shadow-xl shadow-sky-900/5 dark:shadow-black/20 lg:col-span-2 min-w-0 transition-colors duration-300">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 pb-4 border-b border-slate-100 dark:border-slate-800">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900 dark:text-white tracking-wide">Inventario Actual</h2>
                            <p class="text-xs text-slate-500 dark:text-slate-400">Filtra por grado y sección para ver solo lo seleccionado</p>
                        </div>

                        <div class="relative w-full sm:w-64">
                            <input type="text" id="buscador" onkeyup="filtrarInventario()" placeholder="Buscar por aula u objeto..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-slate-700 dark:text-slate-200 placeholder-slate-400 focus:outline-none focus:border-sky-500 focus:ring-2 focus:ring-sky-200 dark:focus:ring-sky-900 transition font-medium">
                            <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm">🔍</span>
                        </div>
                    </div>

                    <!-- COMBOBOX DE GRADO Y SECCIÓN + EXPORTACIÓN -->
                    <div class="flex flex-wrap items-center justify-between gap-3 mb-4">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <select id="filtroGradoTabla" onchange="onChangeGradoTabla()" aria-label="Seleccionar grado"
                                class="px-3.5 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-700 dark:text-slate-200 font-semibold focus:outline-none focus:border-sky-500 transition cursor-pointer">
                                <option value="">Todos los grados</option>
                                <option value="1">1° Grado</option>
                                <option value="2">2° Grado</option>
                                <option value="3">3° Grado</option>
                                <option value="4">4° Grado</option>
                                <option value="5">5° Grado</option>
                            </select>

                            <select id="filtroSeccionTabla" onchange="filtrarInventario()" aria-label="Seleccionar sección"
                                class="px-3.5 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs sm:text-sm text-slate-700 dark:text-slate-200 font-semibold focus:outline-none focus:border-sky-500 transition cursor-pointer">
                                <option value="">Todas las secciones</option>
                            </select>
                        </div>

                        <div class="flex flex-wrap items-center gap-2">
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
                    </div>

                    <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-800">
                        <table class="w-full text-left border-collapse" id="tablaInventario">
                            <thead>
                                <tr class="bg-slate-100/70 dark:bg-slate-800/60 text-slate-600 dark:text-slate-300 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200 dark:border-slate-800">
                                    <th class="py-4 px-5">Objeto / Mobiliario</th>
                                    <th class="py-4 px-5 text-center">Cantidad y Estado</th>
                                    <th class="py-4 px-5 text-center">Fecha y Hora</th>
                                    <th class="py-4 px-5 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-slate-700 dark:text-slate-300 text-sm">
                                @forelse($itemsPorAula as $aula => $items)
                                    @php $slugAula = Str::slug($aula); @endphp
                                    <tr class="bg-sky-50/80 dark:bg-slate-800/90 border-b border-sky-100 dark:border-slate-800 grupo-aula" data-aula="{{ $slugAula }}" data-aula-nombre="{{ $aula }}" data-text="{{ strtolower($aula) }}">
                                        <td colspan="4" class="py-3.5 px-5 font-bold text-sky-800 dark:text-sky-300">
                                            <span class="flex items-center gap-2">
                                                <span class="text-base">🏫</span>
                                                <span class="uppercase tracking-wide text-xs md:text-sm font-extrabold">Aula: {{ $aula }}</span>
                                            </span>
                                        </td>
                                    </tr>

                                    @foreach($items as $item)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/50 transition fila-aula-{{ $slugAula }} item-fila" data-aula-parent="{{ $slugAula }}" data-aula-nombre="{{ $aula }}" data-text="{{ strtolower($item->objeto . ' ' . $aula) }}">
                                        <td class="py-3.5 px-5 font-medium text-slate-800 dark:text-slate-200 pl-8 flex items-center gap-2">
                                            <span class="text-slate-400 dark:text-slate-600">└</span>
                                            <span>{{ $item->objeto }}</span>
                                        </td>
                                        <td class="py-3.5 px-5 text-center">
                                            <div class="flex items-center justify-center gap-3">
                                                <span class="bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-3 py-1 rounded-lg border border-slate-200 dark:border-slate-700 font-mono font-bold">{{ $item->cantidad }} uds.</span>
                                                @if($item->condicion == 'Bueno')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 dark:bg-emerald-950/80 text-emerald-800 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Bueno</span>
                                                @elseif($item->condicion == 'Regular')
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-amber-100 dark:bg-amber-950/80 text-amber-800 dark:text-amber-300 border border-amber-200 dark:border-amber-800"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Regular</span>
                                                @else
                                                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-bold bg-rose-100 dark:bg-rose-950/80 text-rose-800 dark:text-rose-300 border border-rose-200 dark:border-rose-800"><span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span> Malo</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="py-3.5 px-5 text-center">
                                            <span class="text-xs font-medium text-slate-500 dark:text-slate-400 bg-slate-50 dark:bg-slate-900/50 px-2 py-1 rounded-md border border-slate-100 dark:border-slate-800">
                                                🕒 {{ $item->created_at ? $item->created_at->format('d/m/Y H:i') : 'Sin registro' }}
                                            </span>
                                        </td>
                                        <td class="py-3.5 px-5 text-center">
                                            <form action="{{ route('inventory.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que deseas eliminar este registro?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 text-rose-600 dark:text-rose-400 hover:text-white px-3 py-1.5 rounded-xl border border-rose-200 dark:border-rose-900/50 text-xs font-bold transition-all duration-200 flex items-center gap-1 mx-auto shadow-sm cursor-pointer">
                                                    <span>🗑️</span> Eliminar
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                @empty
                                    <tr>
                                        <td colspan="4" class="py-12 text-center text-slate-400">
                                            <div class="text-4xl mb-2">📦</div>
                                            <p class="text-sm font-medium">No hay mobiliario registrado todavía. ¡Agrega el primero!</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <footer class="max-w-7xl mx-auto w-full mt-12 py-6 border-t border-slate-200/80 dark:border-slate-800 bg-white/50 dark:bg-slate-900/50 text-center text-slate-500 dark:text-slate-400 text-xs transition-colors duration-300 rounded-2xl shadow-sm">
            <p>© {{ date('Y') }} <strong class="text-slate-700 dark:text-slate-200">I.E. Tungasuca</strong> - Sistema de Gestión Escolar. Todos los derechos reservados.</p>
        </footer>
    </div>

    @php
        $gradosJs = [];
        foreach($grades as $grade) {
            if(str_contains(strtolower($grade->name), 'grado')) {
                $aulasList = [];
                foreach($grade->classrooms as $classroom) {
                    $aulasList[] = [
                        'id' => $classroom->id,
                        'name' => $classroom->name
                    ];
                }
                $gradosJs[$grade->id] = $aulasList;
            }
        }
    @endphp

    @include('partials.exporter-scripts')

    <script>
        const gradosConAulas = @json($gradosJs);
        const aulasTablaMeta = [];

        function normalizeText(str) {
            return (str || '').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        function parsearGradoSeccionAula(nombreAula) {
            const limpio = (nombreAula || '').toUpperCase().trim();
            const matchGrado = limpio.match(/\b([1-5])\s*(?:°|º|GRADO)?\b/);
            const matchSeccion = limpio.match(/\b([1-5])\s*(?:°|º)?\s*[-–—:]?\s*([A-Z])\b/)
                || limpio.match(/\bSECCI[ÓO]N\s*([A-Z])\b/)
                || limpio.match(/\b([A-Z])\s*$/);

            return {
                grado: matchGrado ? matchGrado[1] : '',
                seccion: matchSeccion ? matchSeccion[matchSeccion.length - 1] : ''
            };
        }

        function inicializarFiltrosTabla() {
            if (aulasTablaMeta.length > 0) return;

            const grupos = document.querySelectorAll('#tablaInventario tbody tr.grupo-aula');
            const items = Array.from(document.querySelectorAll('#tablaInventario tbody tr.item-fila'));
            const letrasEncontradas = new Set();

            grupos.forEach(grupo => {
                const slug = grupo.getAttribute('data-aula');
                const nombreAula = grupo.getAttribute('data-aula-nombre') || '';
                const { grado, seccion } = parsearGradoSeccionAula(nombreAula);

                if (seccion) {
                    letrasEncontradas.add(seccion);
                }

                const filasHijas = items.filter(f => f.getAttribute('data-aula-parent') === slug);
                aulasTablaMeta.push({
                    grupo,
                    slug,
                    nombreAula,
                    grado,
                    seccion,
                    filasHijas
                });
            });

            poblarComboSeccionesTabla(letrasEncontradas, '');
        }

        function poblarComboSeccionesTabla(letrasBase, gradoFiltro = '') {
            const selectSec = document.getElementById('filtroSeccionTabla');
            if (!selectSec) return;

            const valorActual = selectSec.value;
            const letrasFiltradas = new Set();

            aulasTablaMeta.forEach(meta => {
                if (!meta.seccion) return;
                if (!gradoFiltro || meta.grado === gradoFiltro) {
                    letrasFiltradas.add(meta.seccion);
                }
            });

            const conjuntoFinal = letrasFiltradas.size > 0 ? letrasFiltradas : letrasBase;
            const ordenadas = Array.from(conjuntoFinal).sort((a, b) => a.localeCompare(b, 'es'));

            selectSec.innerHTML = '<option value="">Todas las secciones</option>';
            ordenadas.forEach(letra => {
                const opt = document.createElement('option');
                opt.value = letra;
                opt.textContent = `Sección ${letra}`;
                selectSec.appendChild(opt);
            });

            if (valorActual && ordenadas.includes(valorActual)) {
                selectSec.value = valorActual;
            }
        }

        function onChangeGradoTabla() {
            inicializarFiltrosTabla();
            const gradoSel = document.getElementById('filtroGradoTabla')?.value || '';
            const todasLetras = new Set(aulasTablaMeta.map(m => m.seccion).filter(Boolean));
            poblarComboSeccionesTabla(todasLetras, gradoSel);
            filtrarInventario();
        }

        function filtrarSecciones() {
            const gradoId = document.getElementById('selectGrado').value;
            const selectSeccion = document.getElementById('selectSeccion');

            selectSeccion.innerHTML = '<option value="">-- Seleccionar Sección --</option>';

            if (gradoId && gradosConAulas[gradoId]) {
                selectSeccion.removeAttribute('disabled');
                gradosConAulas[gradoId].forEach(aula => {
                    const option = document.createElement('option');
                    option.value = aula.id;
                    option.textContent = aula.name;
                    option.className = "bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-200";
                    selectSeccion.appendChild(option);
                });
            } else {
                selectSeccion.setAttribute('disabled', 'true');
                selectSeccion.innerHTML = '<option value="">-- Primero seleccione un grado --</option>';
            }
        }

        document.addEventListener("DOMContentLoaded", () => {
            const currentTheme = localStorage.getItem('theme') || 'light';
            const themeLabel = document.getElementById('themeTextLabel');
            if (themeLabel) {
                themeLabel.innerText = currentTheme === 'dark' ? 'Oscuro' : 'Claro';
            }
            inicializarFiltrosTabla();
        });

        function toggleDarkMode() {
            const htmlElement = document.documentElement;
            const isDark = htmlElement.classList.contains('dark');
            const themeLabel = document.getElementById('themeTextLabel');

            if (isDark) {
                htmlElement.classList.remove('dark');
                if (themeLabel) themeLabel.innerText = 'Claro';
                localStorage.setItem('theme', 'light');
            } else {
                htmlElement.classList.add('dark');
                if (themeLabel) themeLabel.innerText = 'Oscuro';
                localStorage.setItem('theme', 'dark');
            }
        }

        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('opacity-0');
                setTimeout(() => preloader.remove(), 500);
            }
            inicializarFiltrosTabla();
        });

        function filtrarInventario() {
            inicializarFiltrosTabla();

            const gradoSel = document.getElementById('filtroGradoTabla')?.value || '';
            const seccionSel = document.getElementById('filtroSeccionTabla')?.value || '';
            const query = normalizeText(document.getElementById('buscador')?.value || '').trim();

            aulasTablaMeta.forEach(({ grupo, grado, seccion, nombreAula, filasHijas }) => {
                const cumpleGrado = !gradoSel || grado === gradoSel;
                const cumpleSeccion = !seccionSel || seccion === seccionSel;
                const aulaCumpleFiltro = cumpleGrado && cumpleSeccion;

                if (!aulaCumpleFiltro) {
                    grupo.classList.add('hidden');
                    filasHijas.forEach(f => f.classList.add('hidden'));
                    return;
                }

                const aulaTextoNorm = normalizeText(nombreAula);
                let algunaFilaVisible = false;

                filasHijas.forEach(fila => {
                    const filaTextoNorm = normalizeText(fila.getAttribute('data-text'));
                    const coincideTexto = !query || filaTextoNorm.includes(query) || aulaTextoNorm.includes(query);
                    fila.classList.toggle('hidden', !coincideTexto);
                    if (coincideTexto) {
                        algunaFilaVisible = true;
                    }
                });

                const mostrarGrupo = algunaFilaVisible || (!query && filasHijas.length === 0);
                grupo.classList.toggle('hidden', !mostrarGrupo);
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
            const gradoSel = document.getElementById('filtroGradoTabla')?.value || '';
            const seccionSel = document.getElementById('filtroSeccionTabla')?.value || '';
            const sufijo = [
                gradoSel ? `${gradoSel}Grado` : '',
                seccionSel ? `Sec_${seccionSel}` : ''
            ].filter(Boolean).join('_');

            const data = window.TungasucaExporter.extractFromTable('#tablaInventario', [3], {
                groupedByHeaderRow: true,
                groupPrefix: 'Aula / Sección'
            });
            window.TungasucaExporter.run(formato, {
                title: sufijo ? `Inventario de Mobiliario (${sufijo.replaceAll('_', ' ')})` : 'Inventario de Mobiliario por Aula',
                subtitle: 'I.E. Tungasuca',
                sheetName: 'Mobiliario_Aulas',
                filename: sufijo ? `Mobiliario_${sufijo}_IE_Tungasuca` : 'Mobiliario_Aulas_IE_Tungasuca',
                headers: data.headers,
                rows: data.rows
            });
        }
    </script>
</body>
</html>