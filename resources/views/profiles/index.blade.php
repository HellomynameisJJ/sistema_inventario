<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Perfiles y Accesos - I.E. Tungasuca</title>

    <!-- SCRIPT ANTI-PARPADEO MEDIANTE LOCALSTORAGE -->
    <script>
        (function() {
            try {
                const savedTheme = localStorage.getItem('theme') || 'light';
                if (savedTheme === 'dark') {
                    document.documentElement.classList.add('dark');
                } else {
                    document.documentElement.classList.remove('dark');
                }
            } catch (e) {
                document.documentElement.classList.remove('dark');
            }
        })();
    </script>

    <!-- Tailwind CSS CDN -->
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

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }

        /* EFECTO HOVER SHINE (Líneas blancas deslizantes al pasar el cursor) */
        .hover-shine {
            position: relative;
            overflow: hidden;
        }
        .hover-shine::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -60%;
            width: 20%;
            height: 200%;
            background: rgba(255, 255, 255, 0.2);
            transform: rotate(30deg);
            transition: none;
        }
        .hover-shine:hover::after {
            left: 120%;
            transition: all 0.6s cubic-bezier(0.19, 1, 0.22, 1);
        }
    </style>
</head>
<body class="bg-[#F3F6F9] dark:bg-slate-950 text-brand-dark dark:text-slate-100 min-h-screen md:h-screen md:overflow-hidden flex flex-col md:flex-row selection:bg-brand-sky selection:text-white transition-colors duration-300 overflow-x-hidden">

    <!-- SIDEBAR / MENÚ LATERAL IZQUIERDO -->
    @include('partials.sidebar')

    <!-- CONTENEDOR PRINCIPAL CON SCROLL INTERNO -->
    <div class="flex-grow min-w-0 p-6 md:p-8 overflow-y-auto h-full w-full flex flex-col justify-between">
        <div class="max-w-7xl mx-auto w-full min-w-0">
            <!-- ENCABEZADO SUPERIOR -->
            <header class="mb-8 p-6 md:p-8 rounded-3xl bg-brand-blue dark:bg-slate-900 text-white shadow-xl shadow-brand-blue/15 flex flex-col md:flex-row justify-between items-center gap-6 relative z-30 transition-colors duration-300 border border-slate-800">
                <div class="absolute inset-0 pointer-events-none overflow-hidden rounded-3xl">
                    <div class="absolute -right-12 -bottom-12 w-64 h-64 bg-brand-sky/20 rounded-full blur-3xl"></div>
                    <div class="absolute right-1/3 -top-12 w-48 h-48 bg-brand-yellow/20 rounded-full blur-2xl"></div>
                </div>

                <div class="z-10 flex items-center gap-5">
                    <div class="w-16 h-16 bg-[#0b3c8c] dark:bg-slate-800 rounded-2xl flex items-center justify-center overflow-hidden shadow-lg border-2 border-white/30 shrink-0">
                        <img
                            src="{{ asset('images/escudo-tungasuca.png') }}"
                            alt="Escudo I.E. Tungasuca"
                            class="w-full h-full object-cover"
                        >
                    </div>
                    <div>
                        <div class="flex items-center gap-2 mb-1">
                            <span class="px-3 py-0.5 rounded-full text-[11px] font-extrabold bg-brand-yellow text-brand-dark uppercase tracking-widest shadow-sm">I.E. Tungasuca</span>
                            <span class="text-xs text-brand-sky font-semibold tracking-wide">Seguridad & Control</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Administración de Perfiles y Accesos</h1>
                    </div>
                </div>

                <!-- ACCIONES A LA DERECHA -->
                <div class="z-30 flex flex-wrap items-center gap-3">
                    <button
                        type="button"
                        id="btnToggleNuevoUsuario"
                        onclick="toggleNuevoUsuarioBox()"
                        class="bg-brand-yellow hover:bg-amber-300 text-brand-dark px-5 py-2.5 rounded-2xl font-extrabold flex items-center gap-2 transition-all shadow-md text-sm whitespace-nowrap cursor-pointer"
                    >
                        <span>➕</span>
                        <span>Agregar nuevo usuario</span>
                    </button>

                    <a href="{{ route('inventory.dashboard') }}" class="bg-brand-hover hover:bg-white hover:text-brand-blue dark:bg-slate-700 dark:hover:bg-slate-600 dark:hover:text-white text-white border border-white/20 px-5 py-2.5 rounded-2xl font-bold flex items-center gap-2 transition-all shadow-md text-sm whitespace-nowrap">
                        <span>📊</span>
                        <span>Ir al Dashboard</span>
                    </a>
                </div>
            </header>

            <!-- PANEL DESPLEGABLE: AGREGAR NUEVO USUARIO -->
            <div id="boxNuevoUsuario" class="{{ $errors->any() ? '' : 'hidden' }} bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-brand-blue/30 dark:border-brand-sky/30 shadow-lg mb-8 transition-all">
                <div class="flex items-center justify-between mb-5 pb-3 border-b border-slate-100 dark:border-slate-800">
                    <div>
                        <h2 class="text-lg font-extrabold text-brand-dark dark:text-white">Agregar nuevo usuario</h2>
                        <p class="text-xs text-slate-500 dark:text-slate-400">Complete Nombre, Rol, DNI y Contraseña (si la dejas vacía, se usará el DNI como contraseña inicial).</p>
                    </div>
                    <button type="button" onclick="toggleNuevoUsuarioBox()" class="text-slate-400 hover:text-rose-500 font-bold text-xl px-2 cursor-pointer">&times;</button>
                </div>

                <form action="{{ route('profiles.store') }}" method="POST" class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
                    @csrf

                    <div>
                        <label for="nuevo_nombre" class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Nombre
                        </label>
                        <input
                            type="text"
                            id="nuevo_nombre"
                            name="name"
                            value="{{ old('name') }}"
                            required
                            placeholder="Ej: María Pérez"
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-brand-dark dark:text-white focus:outline-none focus:border-brand-blue"
                        >
                    </div>

                    <div>
                        <label for="nuevo_rol" class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Rol
                        </label>
                        <select
                            id="nuevo_rol"
                            name="rol_id"
                            required
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-bold text-sky-600 dark:text-sky-400 focus:outline-none focus:border-brand-blue cursor-pointer"
                        >
                            <option value="2" {{ (string) old('rol_id') === '2' ? 'selected' : '' }}>Encargado de Biblioteca</option>
                            <option value="3" {{ (string) old('rol_id') === '3' ? 'selected' : '' }}>Encargado de Mobiliario</option>
                            <option value="4" {{ (string) old('rol_id') === '4' ? 'selected' : '' }}>Encargado de Equipos TIC</option>
                            <option value="5" {{ (string) old('rol_id') === '5' ? 'selected' : '' }}>Encargado de Aula AIP</option>
                            <option value="6" {{ (string) old('rol_id') === '6' ? 'selected' : '' }}>Encargado de Laboratorio</option>
                            <option value="1" {{ (string) old('rol_id') === '1' ? 'selected' : '' }}>Administrador / Directiva</option>
                        </select>
                    </div>

                    <div>
                        <label for="nuevo_dni" class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            DNI
                        </label>
                        <input
                            type="text"
                            id="nuevo_dni"
                            name="dni"
                            value="{{ old('dni') }}"
                            required
                            maxlength="15"
                            placeholder="Ej: 71234567"
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm font-mono text-brand-dark dark:text-white focus:outline-none focus:border-brand-blue"
                        >
                    </div>

                    <div>
                        <label for="nueva_password" class="block text-xs font-extrabold uppercase tracking-wider text-slate-600 dark:text-slate-300 mb-2">
                            Contraseña
                        </label>
                        <input
                            type="password"
                            id="nueva_password"
                            name="password"
                            placeholder="Mín. 6 caracteres (opcional)"
                            class="w-full px-4 py-3 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-sm text-brand-dark dark:text-white focus:outline-none focus:border-brand-blue"
                        >
                    </div>

                    <div>
                        <button
                            type="submit"
                            class="w-full bg-brand-blue hover:bg-brand-hover text-white font-extrabold py-3 px-4 rounded-xl shadow-md transition text-sm flex items-center justify-center gap-2 cursor-pointer"
                        >
                            <span>✅</span>
                            <span>Crear y Asignar Módulo</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- NOTIFICACIÓN DE ÉXITO -->
            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl mb-6 shadow-sm flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            <!-- ERRORES DE VALIDACIÓN -->
            @if($errors->any())
                <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-5 py-4 rounded-2xl mb-6 shadow-sm">
                    <div class="font-bold text-sm mb-1">⚠️ Revisa los datos ingresados:</div>
                    <ul class="list-disc pl-6 text-xs space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- TABLA DE GESTIÓN DE PERFILES -->
            <div class="bg-white dark:bg-slate-900 p-6 md:p-7 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
                <div class="mb-6 pb-4 border-b border-slate-100 dark:border-slate-800">
                    <h2 class="text-lg font-bold text-brand-dark dark:text-white tracking-wide">Personal Institucional y Permisos</h2>
                    <p class="text-xs text-slate-500 dark:text-slate-400">Asigne el rol principal, active o desactive los módulos permitidos o elimine usuarios.</p>
                </div>

                <div class="overflow-x-auto rounded-2xl border border-slate-200/80 dark:border-slate-800">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-slate-50 dark:bg-slate-950 text-slate-500 dark:text-slate-400 uppercase text-[11px] font-extrabold tracking-wider border-b border-slate-200 dark:border-slate-800">
                                <th class="py-4 px-5">Usuario / DNI</th>
                                <th class="py-4 px-5">Rol del Sistema</th>
                                <th class="py-4 px-5">Módulos Autorizados (Permisos)</th>
                                <th class="py-4 px-5 text-center">Acciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-brand-dark dark:text-slate-200 text-sm">
                            @foreach($users as $u)
                                @php
                                    $formId = 'form-user-' . $u->id;
                                    $userPerms = is_array($u->permissions)
                                        ? $u->permissions
                                        : (json_decode($u->permissions ?? '[]', true) ?: []);
                                @endphp
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800/40 transition">
                                    <td class="py-4 px-5 font-bold text-slate-800 dark:text-white">
                                        {{ $u->name }}
                                        <div class="text-xs font-normal text-slate-400 font-mono">DNI: {{ $u->dni }}</div>
                                    </td>
                                    <td class="py-4 px-5">
                                        <form id="{{ $formId }}" action="{{ route('profiles.update-access', $u->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                        </form>

                                        <select name="rol_id" form="{{ $formId }}" class="px-3 py-2 bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-bold text-sky-600 dark:text-sky-400 focus:outline-none cursor-pointer">
                                            <option value="1" {{ (int) $u->rol_id === 1 ? 'selected' : '' }}>Administrador / Directiva</option>
                                            <option value="2" {{ (int) $u->rol_id === 2 ? 'selected' : '' }}>Encargado de Biblioteca</option>
                                            <option value="3" {{ (int) $u->rol_id === 3 ? 'selected' : '' }}>Encargado de Mobiliario</option>
                                            <option value="4" {{ (int) $u->rol_id === 4 ? 'selected' : '' }}>Encargado de Equipos TIC</option>
                                            <option value="5" {{ (int) $u->rol_id === 5 ? 'selected' : '' }}>Encargado de Aula AIP</option>
                                            <option value="6" {{ (int) $u->rol_id === 6 ? 'selected' : '' }}>Encargado de Laboratorio</option>
                                        </select>
                                    </td>
                                    <td class="py-4 px-5">
                                        <div class="flex flex-wrap items-center gap-3 text-xs font-semibold">
                                            <label class="flex items-center gap-1.5 cursor-pointer bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700">
                                                <input type="checkbox" form="{{ $formId }}" name="permissions[]" value="inventory" {{ in_array('inventory', $userPerms, true) ? 'checked' : '' }} class="rounded text-sky-600"> 🪑 Mobiliario
                                            </label>
                                            <label class="flex items-center gap-1.5 cursor-pointer bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700">
                                                <input type="checkbox" form="{{ $formId }}" name="permissions[]" value="library" {{ in_array('library', $userPerms, true) ? 'checked' : '' }} class="rounded text-sky-600"> 📚 Biblioteca
                                            </label>
                                            <label class="flex items-center gap-1.5 cursor-pointer bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700">
                                                <input type="checkbox" form="{{ $formId }}" name="permissions[]" value="tic" {{ in_array('tic', $userPerms, true) ? 'checked' : '' }} class="rounded text-sky-600"> 💻 Equipos TIC
                                            </label>
                                            <label class="flex items-center gap-1.5 cursor-pointer bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700">
                                                <input type="checkbox" form="{{ $formId }}" name="permissions[]" value="aip" {{ in_array('aip', $userPerms, true) ? 'checked' : '' }} class="rounded text-sky-600"> 🖥️ Aula AIP
                                            </label>
                                            <label class="flex items-center gap-1.5 cursor-pointer bg-slate-50 dark:bg-slate-800 px-3 py-2 rounded-xl border border-slate-200 dark:border-slate-700">
                                                <input type="checkbox" form="{{ $formId }}" name="permissions[]" value="laboratory" {{ in_array('laboratory', $userPerms, true) ? 'checked' : '' }} class="rounded text-sky-600"> 🔬 Laboratorio
                                            </label>
                                        </div>
                                    </td>
                                    <td class="py-4 px-5 text-center">
                                        <div class="flex items-center justify-center gap-2">
                                            <button type="submit" form="{{ $formId }}" class="bg-brand-blue hover:bg-brand-hover text-white px-4 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer whitespace-nowrap">
                                                💾 Guardar Accesos
                                            </button>

                                            @if((int) auth()->id() !== (int) $u->id)
                                                <form action="{{ route('profiles.destroy', $u->id) }}" method="POST" onsubmit="return confirm('¿Desea eliminar al usuario {{ addslashes($u->name) }} (DNI: {{ $u->dni }})?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-rose-50 dark:bg-rose-950/40 hover:bg-rose-600 text-rose-600 dark:text-rose-400 hover:text-white border border-rose-200 dark:border-rose-900 px-3.5 py-2.5 rounded-xl text-xs font-bold transition shadow-sm cursor-pointer whitespace-nowrap">
                                                        🗑️ Eliminar usuario
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer class="max-w-7xl mx-auto w-full mt-12 py-6 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 text-center text-xs transition-colors rounded-2xl shadow-sm">
            <p class="font-serif italic text-brand-secondary dark:text-brand-sky text-sm mb-1">Más que una institución, una gran familia</p>
            <p class="text-slate-400 dark:text-slate-500">© {{ date('Y') }} <strong>I.E. Tungasuca</strong> - Sistema de Gestión Escolar. Todos los derechos reservados.</p>
        </footer>
    </div>

    <!-- SCRIPT DE TEMA Y FORMULARIO DE NUEVO USUARIO -->
    <script>
        function toggleNuevoUsuarioBox() {
            const box = document.getElementById('boxNuevoUsuario');
            if (!box) return;
            box.classList.toggle('hidden');
            if (!box.classList.contains('hidden')) {
                document.getElementById('nuevo_nombre')?.focus();
            }
        }

        function getSavedTheme() {
            try {
                return localStorage.getItem('theme') || 'light';
            } catch (e) {
                return 'light';
            }
        }

        function setSavedTheme(value) {
            try {
                localStorage.setItem('theme', value);
            } catch (e) {}
        }

        function syncThemeLabel() {
            const label = document.getElementById('themeTextLabel');
            if (!label) return;
            const isDark = document.documentElement.classList.contains('dark');
            label.innerText = isDark ? 'Oscuro' : 'Claro';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const currentTheme = getSavedTheme();
            document.documentElement.classList.toggle('dark', currentTheme === 'dark');
            syncThemeLabel();
        });

        function toggleDarkMode() {
            const htmlElement = document.documentElement;
            const willBeDark = !htmlElement.classList.contains('dark');
            const newTheme = willBeDark ? 'dark' : 'light';

            htmlElement.classList.toggle('dark', willBeDark);
            setSavedTheme(newTheme);
            syncThemeLabel();
        }
    </script>
</body>
</html>