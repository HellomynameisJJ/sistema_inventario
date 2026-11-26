<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listado Completo de Objetos - I.E. Tungasuca</title>

    <script>
        (function() {
            const savedTheme = localStorage.getItem('theme') || 'light';
            if (savedTheme === 'dark') document.documentElement.classList.add('dark');
            else document.documentElement.classList.remove('dark');
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
                            sky: '#48B9E8',
                            yellow: '#F5C542',
                            dark: '#172B4D',
                            success: '#22A06B',
                            danger: '#D64545',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hover-shine { position: relative; overflow: hidden; }
        .hover-shine::after {
            content: ''; position: absolute; top: -50%; left: -60%; width: 20%; height: 200%;
            background: rgba(255, 255, 255, 0.2); transform: rotate(30deg); transition: none;
        }
        .hover-shine:hover::after { left: 120%; transition: all 0.6s cubic-bezier(0.19, 1, 0.22, 1); }
    </style>
</head>
<body class="bg-[#F3F6F9] dark:bg-slate-950 text-brand-dark dark:text-slate-100 min-h-screen flex flex-col md:flex-row transition-colors duration-300 overflow-x-hidden">

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
                Catálogo Institucional
            </span>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-wide uppercase mt-2">I.E. TUNGASUCA</h2>
            <p class="text-sky-700 dark:text-sky-400 text-xs font-semibold tracking-wide flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-sky-500 animate-ping"></span>
                Cargando listado de objetos...
            </p>
        </div>
    </div>

    <!-- SIDEBAR PARCIAL -->
    @include('partials.sidebar')

    <!-- CONTENIDO -->
    <div class="flex-grow p-6 md:p-8 overflow-y-auto max-w-7xl mx-auto w-full">

        <!-- HEADER -->
        <header class="mb-8 p-6 md:p-8 rounded-3xl bg-brand-blue dark:bg-slate-900 text-white shadow-xl shadow-brand-blue/15 flex flex-col md:flex-row justify-between items-center gap-6 relative z-30 border border-slate-800">
            <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-3xl">
                <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-brand-sky/20 rounded-full blur-3xl"></div>
                <div class="absolute right-1/3 -top-12 w-48 h-48 bg-brand-yellow/20 rounded-full blur-2xl"></div>
            </div>

            <div class="z-10 flex items-center gap-5">
                <img
                    src="{{ asset('images/escudo-tungasuca.png') }}"
                    alt="Escudo I.E. Tungasuca"
                    class="w-16 h-16 rounded-2xl object-cover shadow-lg border border-white/25 bg-[#0b3c8c] shrink-0"
                >
                <div>
                    <div class="flex items-center gap-2 mb-1">
                        <span class="px-3 py-0.5 rounded-full text-[11px] font-extrabold bg-brand-yellow text-brand-dark uppercase tracking-widest shadow-sm">I.E. Tungasuca</span>
                        <span class="text-xs text-brand-sky font-semibold tracking-wide">Catálogo completo</span>
                    </div>
                    <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Listado Completo de Objetos</h1>
                    <p class="text-sm text-brand-sky mt-1">{{ $objetos->count() }} tipos diferentes de objetos registrados</p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-3 z-30 relative">
                <form method="GET" action="{{ route('inventory.objetos') }}" class="flex items-center gap-2">
                    <select name="classroom_id" onchange="this.form.submit()" class="px-4 py-2.5 bg-white dark:bg-slate-800 text-brand-dark dark:text-slate-100 border border-white/30 dark:border-slate-700 rounded-2xl text-sm font-semibold focus:outline-none cursor-pointer">
                        <option value="">🌐 Todo el Colegio</option>
                        @foreach($classroomsList as $room)
                            <option value="{{ $room->id }}" {{ $classroomId == $room->id ? 'selected' : '' }}>
                                🏫 {{ $room->name }}
                            </option>
                        @endforeach
                    </select>
                </form>
                <a href="{{ route('inventory.dashboard') }}" class="bg-white/10 hover:bg-white/20 text-white border border-white/20 px-5 py-2.5 rounded-2xl font-bold flex items-center gap-2 transition-all shadow-md text-sm whitespace-nowrap">
                    <span>⬅️</span>
                    <span>Volver al Dashboard</span>
                </a>
            </div>
        </header>

        <!-- TARJETAS DE RESUMEN -->
        <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 border-l-4 border-l-brand-blue shadow-sm">
                <p class="text-xs text-slate-500 dark:text-slate-400 font-extrabold uppercase tracking-wider">Total</p>
                <h3 class="text-3xl font-black text-brand-dark dark:text-white mt-2 font-mono">{{ $totalGeneral }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Unidades</p>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 border-l-4 border-l-brand-success shadow-sm">
                <p class="text-xs text-brand-success font-extrabold uppercase tracking-wider">Bueno</p>
                <h3 class="text-3xl font-black text-brand-success mt-2 font-mono">{{ $totalBueno }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Operativos</p>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 border-l-4 border-l-brand-yellow shadow-sm">
                <p class="text-xs text-amber-600 font-extrabold uppercase tracking-wider">Regular</p>
                <h3 class="text-3xl font-black text-amber-500 mt-2 font-mono">{{ $totalRegular }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">A revisar</p>
            </div>
            <div class="bg-white dark:bg-slate-900 p-6 rounded-3xl border border-slate-200/80 dark:border-slate-800 border-l-4 border-l-brand-danger shadow-sm">
                <p class="text-xs text-brand-danger font-extrabold uppercase tracking-wider">Malo</p>
                <h3 class="text-3xl font-black text-brand-danger mt-2 font-mono">{{ $totalMalo }}</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">Reemplazo</p>
            </div>
        </div>

        <!-- TABLA COMPLETA -->
        <div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm">
            <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                <div>
                    <h2 class="text-lg font-bold text-brand-dark dark:text-white tracking-wide">Todos los Objetos</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Listado jerárquico por cantidad total</p>
                </div>
                <div class="relative w-full md:w-72">
                    <input type="text" id="buscador" placeholder="Buscar objeto..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-brand-dark dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-brand-blue transition">
                    <span class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm">🔍</span>
                </div>
            </div>

            <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-800">
                <table class="w-full text-left border-collapse" id="tablaObjetos">
                    <thead>
                        <tr class="bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200 dark:border-slate-800">
                            <th class="py-4 px-5">#</th>
                            <th class="py-4 px-5">Objeto</th>
                            <th class="py-4 px-5 text-center">Bueno</th>
                            <th class="py-4 px-5 text-center">Regular</th>
                            <th class="py-4 px-5 text-center">Malo</th>
                            <th class="py-4 px-5 text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                        @forelse($objetos as $i => $obj)
                        <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition objeto-fila" data-text="{{ strtolower($obj->objeto) }}">
                            <td class="py-3.5 px-5 font-mono text-slate-400 text-xs">{{ $i + 1 }}</td>
                            <td class="py-3.5 px-5 font-semibold text-brand-dark dark:text-white">{{ $obj->objeto }}</td>
                            <td class="py-3.5 px-5 text-center">
                                @if($obj->buenas > 0)
                                    <span class="inline-block px-2.5 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/50 text-emerald-700 dark:text-emerald-400 text-xs font-bold border border-emerald-200 dark:border-emerald-800">{{ $obj->buenas }}</span>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                @if($obj->regulares > 0)
                                    <span class="inline-block px-2.5 py-1 rounded-lg bg-amber-50 dark:bg-amber-950/50 text-amber-700 dark:text-amber-400 text-xs font-bold border border-amber-200 dark:border-amber-800">{{ $obj->regulares }}</span>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 text-center">
                                @if($obj->malas > 0)
                                    <span class="inline-block px-2.5 py-1 rounded-lg bg-rose-50 dark:bg-rose-950/50 text-rose-700 dark:text-rose-400 text-xs font-bold border border-rose-200 dark:border-rose-800">{{ $obj->malas }}</span>
                                @else
                                    <span class="text-slate-300 dark:text-slate-600">—</span>
                                @endif
                            </td>
                            <td class="py-3.5 px-5 text-right font-black text-brand-blue dark:text-brand-sky font-mono text-base">{{ $obj->total }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400">
                                <div class="text-4xl mb-2">📋</div>
                                <p class="text-sm">No hay objetos registrados para esta selección.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

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
            const label = document.getElementById('themeTextLabel');
            if (label) label.innerText = currentTheme === 'dark' ? 'Oscuro' : 'Claro';
        });

        function toggleDarkMode() {
            const html = document.documentElement;
            const isDark = html.classList.contains('dark');
            const label = document.getElementById('themeTextLabel');

            if (isDark) {
                html.classList.remove('dark');
                if (label) label.innerText = 'Claro';
                localStorage.setItem('theme', 'light');
            } else {
                html.classList.add('dark');
                if (label) label.innerText = 'Oscuro';
                localStorage.setItem('theme', 'dark');
            }
        }

        const buscador = document.getElementById('buscador');
        if (buscador) {
            buscador.addEventListener('input', function() {
                const q = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                document.querySelectorAll('.objeto-fila').forEach(fila => {
                    const t = (fila.getAttribute('data-text') || '').normalize("NFD").replace(/[\u0300-\u036f]/g, "");
                    fila.classList.toggle('hidden', !t.includes(q));
                });
            });
        }
    </script>
</body>
</html>