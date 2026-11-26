<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Módulo Biblioteca Escolar - I.E. Tungasuca</title>
    
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
                            secondary: '#1689D4',
                            sky: '#48B9E8',
                            dark: '#172B4D',
                            hover: '#064681',
                        }
                    }
                }
            }
        }
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Plus Jakarta Sans', sans-serif; }</style>
</head>
<body class="bg-[#F3F6F9] dark:bg-slate-950 text-slate-800 dark:text-slate-100 min-h-screen md:h-screen md:overflow-hidden flex flex-col md:flex-row transition-colors duration-300 overflow-x-hidden">

    <!-- PANTALLA DE CARGA INSTITUCIONAL -->
    <div id="preloader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#F3F6F9] dark:bg-slate-950 transition-opacity duration-500">
        <div class="absolute w-96 h-96 bg-sky-200/40 dark:bg-blue-900/25 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
        <div class="absolute w-64 h-64 bg-amber-300/20 dark:bg-sky-900/20 rounded-full blur-2xl animate-pulse delay-300 pointer-events-none"></div>

        <div class="relative w-32 h-32 flex items-center justify-center mb-8">
            <div class="w-32 h-32 border-4 border-[#0756A3]/20 border-t-[#0756A3] dark:border-[#48B9E8]/20 dark:border-t-[#48B9E8] rounded-full animate-spin"></div>
            <div class="absolute w-24 h-24 border-4 border-amber-400/30 border-b-amber-500 dark:border-[#1689D4]/25 dark:border-b-[#48B9E8] rounded-full animate-spin [animation-duration:1.4s]"></div>
            <img
                src="{{ asset('images/escudo-tungasuca.png') }}"
                alt="Escudo I.E. Tungasuca"
                class="absolute w-16 h-16 rounded-2xl object-cover shadow-lg border-2 border-white dark:border-slate-800 bg-[#0b3c8c] z-10"
            >
        </div>

        <div class="text-center space-y-2 z-10 px-4">
            <span class="px-3.5 py-1 rounded-full text-[10px] font-extrabold tracking-widest bg-slate-100 dark:bg-slate-800 text-[#0756A3] dark:text-[#48B9E8] uppercase">
                Biblioteca Escolar & Libros
            </span>
            <h2 class="text-2xl font-black text-slate-900 dark:text-white tracking-wider uppercase mt-2">I.E. TUNGASUCA</h2>
            <p class="text-slate-500 dark:text-slate-400 text-xs font-medium tracking-wide flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#1689D4] animate-ping"></span>
                Cargando inventario bibliográfico...
            </p>
        </div>
    </div>

    <!-- SIDEBAR -->
    @include('partials.sidebar')

    <!-- CONTENEDOR PRINCIPAL CON SCROLL INTERNO -->
    <div class="flex-grow min-w-0 p-6 md:p-10 overflow-y-auto h-full w-full flex flex-col justify-between">
        <div class="max-w-7xl mx-auto w-full min-w-0">
            <header class="mb-8 p-6 md:p-8 rounded-3xl bg-[#0756A3] text-white shadow-xl flex flex-col md:flex-row justify-between items-center gap-6">
                <div class="flex items-center gap-5">
                    <img
                        src="{{ asset('images/escudo-tungasuca.png') }}"
                        alt="Escudo I.E. Tungasuca"
                        class="w-16 h-16 rounded-2xl object-cover shadow-lg border border-white/25 bg-[#0b3c8c] shrink-0"
                    >
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-3 py-0.5 rounded-full text-[10px] font-black bg-amber-400 text-slate-900 uppercase">I.E. Tungasuca</span>
                            <span class="text-xs text-white/80">Gestión de Biblioteca</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white">Inventario General de Libros</h1>
                    </div>
                </div>
            </header>

            @if(session('success'))
                <div id="alertSuccess" class="bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl mb-6 flex items-center justify-between transition-opacity duration-300">
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
                        <span class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-[#0756A3] font-bold text-lg">➕</span>
                        <div>
                            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Registrar Libro</h2>
                            <p class="text-xs text-slate-500">Campos oficiales del inventario</p>
                        </div>
                    </div>

                    <form action="{{ route('library.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label for="identificador" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Identificador / Código</label>
                            <input type="text" id="identificador" name="identificador" value="{{ old('identificador') }}" placeholder="Ej: 000 GENERALIDADES / 15" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-mono focus:outline-none focus:border-[#0756A3]">
                        </div>

                        <div>
                            <label for="denominacion" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Denominación / Título</label>
                            <input type="text" id="denominacion" name="denominacion" value="{{ old('denominacion') }}" required placeholder="Ej: Docta Matemática" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-[#0756A3]">
                        </div>

                        <div>
                            <label for="coleccion" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Colección / Tomo / Volumen</label>
                            <input type="text" id="coleccion" name="coleccion" value="{{ old('coleccion') }}" placeholder="Ej: VOLUMEN I / TOMO 2" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-[#0756A3]">
                        </div>

                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label for="autor" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Autor</label>
                                <input type="text" id="autor" name="autor" value="{{ old('autor') }}" placeholder="Ej: MED / Lexus" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-[#0756A3]">
                            </div>
                            <div>
                                <label for="editorial" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Editorial</label>
                                <input type="text" id="editorial" name="editorial" value="{{ old('editorial') }}" placeholder="Ej: Carroggio / FCE" class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-[#0756A3]">
                            </div>
                        </div>

                        <div class="grid grid-cols-3 gap-3">
                            <div>
                                <label for="anio_edicion" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Año</label>
                                <input type="text" id="anio_edicion" name="anio_edicion" value="{{ old('anio_edicion') }}" placeholder="Ej: 2008" class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-[#0756A3]">
                            </div>
                            <div>
                                <label for="cantidad" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Cant.</label>
                                <input type="number" id="cantidad" name="cantidad" min="1" value="{{ old('cantidad', 1) }}" required class="w-full px-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold focus:outline-none focus:border-[#0756A3]">
                            </div>
                            <div>
                                <label for="estado" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Estado</label>
                                <select id="estado" name="estado" class="w-full px-3 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-[#0756A3]">
                                    <option value="Bueno" {{ old('estado') == 'Bueno' ? 'selected' : '' }}>🟢 Bueno</option>
                                    <option value="Regular" {{ old('estado') == 'Regular' ? 'selected' : '' }}>🟡 Regular</option>
                                    <option value="Malo" {{ old('estado') == 'Malo' ? 'selected' : '' }}>🔴 Malo</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label for="observaciones" class="block text-slate-700 dark:text-slate-300 text-xs font-bold uppercase mb-1">Observaciones</label>
                            <textarea id="observaciones" name="observaciones" rows="2" placeholder="Observaciones generales..." class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-[#0756A3]">{{ old('observaciones') }}</textarea>
                        </div>

                        <button type="submit" class="w-full bg-[#0756A3] hover:bg-[#064681] text-white font-bold py-3.5 px-4 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2 cursor-pointer">
                            <span>💾</span> Guardar Libro
                        </button>
                    </form>
                </div>

                <!-- TABLA DE LIBROS -->
                <div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-slate-200 dark:border-slate-800 shadow-sm lg:col-span-2 min-w-0">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4 pb-4 border-b border-slate-200 dark:border-slate-800">
                        <div>
                            <h2 class="text-lg font-bold text-slate-800 dark:text-white">Catálogo Registrado</h2>
                            <p class="text-xs text-slate-500">Inventario oficial de la biblioteca</p>
                        </div>
                        <div class="relative w-full sm:w-72">
                            <input type="text" id="buscador" placeholder="Buscar título, autor, id..." class="w-full pl-10 pr-4 py-2.5 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm focus:outline-none focus:border-[#0756A3]">
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
                        <table class="w-full text-left border-collapse" id="tablaBiblioteca">
                            <thead>
                                <tr class="bg-slate-100 dark:bg-slate-950 text-[#0756A3] dark:text-[#48B9E8] uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200 dark:border-slate-800">
                                    <th class="py-4 px-4">ID & Denominación</th>
                                    <th class="py-4 px-4">Autor / Editorial</th>
                                    <th class="py-4 px-3 text-center">Colección / Año</th>
                                    <th class="py-4 px-3 text-center">Cant.</th>
                                    <th class="py-4 px-3 text-center">Estado</th>
                                    <th class="py-4 px-3 text-center">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-sm">
                                @forelse($items as $item)
                                    <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition item-fila" data-text="{{ strtolower(($item->identificador ?? '') . ' ' . ($item->denominacion ?? '') . ' ' . ($item->autor ?? '') . ' ' . ($item->editorial ?? '') . ' ' . ($item->coleccion ?? '') . ' ' . ($item->observaciones ?? '')) }}">
                                        <td class="py-3.5 px-4">
                                            <div class="font-bold text-slate-800 dark:text-white text-sm">{{ $item->denominacion }}</div>
                                            <div class="text-xs text-[#1689D4] font-mono font-semibold mt-0.5">🏷️ ID: {{ $item->identificador ?? 'S/N' }}</div>
                                        </td>
                                        <td class="py-3.5 px-4">
                                            <div class="font-medium text-slate-800 dark:text-slate-200">{{ $item->autor ?? 'Sin autor' }}</div>
                                            <div class="text-xs text-slate-400 italic line-clamp-1 mt-0.5">{{ $item->editorial ?? 'Sin editorial' }}</div>
                                        </td>
                                        <td class="py-3.5 px-3 text-center text-xs">
                                            <div class="font-semibold text-slate-700 dark:text-slate-300">{{ $item->coleccion ?? '-' }}</div>
                                            <div class="text-[11px] text-slate-400 mt-0.5">{{ $item->anio_edicion ? 'Año: '.$item->anio_edicion : '' }}</div>
                                        </td>
                                        <td class="py-3.5 px-3 text-center font-bold">
                                            <span class="bg-slate-100 dark:bg-slate-800 px-2.5 py-1 rounded-lg border border-slate-200 dark:border-slate-700 text-[#0756A3] font-black">{{ $item->cantidad }}</span>
                                        </td>
                                        <td class="py-3.5 px-3 text-center">
                                            @if($item->estado == 'Bueno')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 dark:bg-emerald-950 dark:text-emerald-300">🟢 Bueno</span>
                                            @elseif($item->estado == 'Regular')
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-300">🟡 Regular</span>
                                            @else
                                                <span class="px-2.5 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 dark:bg-rose-950 dark:text-rose-300">🔴 Malo</span>
                                            @endif
                                        </td>
                                        <td class="py-3.5 px-3 text-center">
                                            <form action="{{ route('library.destroy', $item->id) }}" method="POST" onsubmit="return confirm('¿Desea eliminar este registro?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="bg-rose-50 hover:bg-rose-600 text-rose-600 hover:text-white px-2.5 py-1 rounded-xl border border-rose-200 text-xs font-bold transition cursor-pointer">
                                                    🗑️
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="py-12 text-center text-slate-400">
                                            <div class="text-4xl mb-2">📚</div>
                                            <p class="text-sm">No hay libros registrados en el inventario.</p>
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
            <p>© {{ date('Y') }} I.E. Tungasuca - Biblioteca Escolar. Todos los derechos reservados.</p>
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
            if (themeLabel) themeLabel.innerText = currentTheme === 'dark' ? 'Oscuro' : 'Claro';
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
                const query = this.value.toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
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
            const data = window.TungasucaExporter.extractFromTable('#tablaBiblioteca', [5]);
            window.TungasucaExporter.run(formato, {
                title: 'Inventario General de Biblioteca Escolar',
                subtitle: 'I.E. Tungasuca',
                sheetName: 'Biblioteca',
                filename: 'Biblioteca_IE_Tungasuca',
                headers: data.headers,
                rows: data.rows
            });
        }
    </script>
</body>
</html>