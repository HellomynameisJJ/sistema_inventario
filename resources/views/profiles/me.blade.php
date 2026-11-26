<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Perfil - I.E. Tungasuca</title>

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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
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

    @include('partials.sidebar')

    <div class="flex-grow min-w-0 p-6 md:p-8 overflow-y-auto h-full w-full flex flex-col justify-between">
        <div class="max-w-5xl mx-auto w-full">
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
                            <span class="text-xs text-brand-sky font-semibold tracking-wide">Cuenta Personal</span>
                        </div>
                        <h1 class="text-2xl md:text-3xl font-extrabold text-white tracking-tight">Mi Perfil</h1>
                    </div>
                </div>

                <div class="z-30">
                    <a href="{{ route('dashboard.redirect') }}" class="bg-brand-hover hover:bg-white hover:text-brand-blue dark:bg-slate-700 dark:hover:bg-slate-600 dark:hover:text-white text-white border border-white/20 px-5 py-2.5 rounded-2xl font-bold flex items-center gap-2 transition-all shadow-md text-sm whitespace-nowrap">
                        <span>↩️</span>
                        <span>Volver al Módulo</span>
                    </a>
                </div>
            </header>

            @if(session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-950/50 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl mb-6 shadow-sm flex items-center gap-3">
                    <span class="text-xl">✅</span>
                    <span class="font-semibold text-sm">{{ session('success') }}</span>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-rose-50 dark:bg-rose-950/50 border border-rose-200 dark:border-rose-800 text-rose-800 dark:text-rose-300 px-5 py-4 rounded-2xl mb-6 shadow-sm">
                    <ul class="list-disc list-inside text-xs font-semibold space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-slate-900 p-6 md:p-8 rounded-3xl border border-slate-200/80 dark:border-slate-800 shadow-sm transition-colors">
                <form action="{{ route('my-profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    @php
                        $currentAvatarUrl = !empty($user->avatar)
                            ? asset('storage/' . ltrim($user->avatar, '/'))
                            : null;
                    @endphp

                    <div class="flex flex-col sm:flex-row items-center gap-6 pb-6 border-b border-slate-100 dark:border-slate-800">
                        <div class="relative shrink-0">
                            @if($currentAvatarUrl)
                                <img
                                    id="avatarPreview"
                                    src="{{ $currentAvatarUrl }}"
                                    alt="Foto de {{ $user->name }}"
                                    class="w-24 h-24 rounded-full object-cover border-4 border-brand-blue/20 dark:border-slate-700 shadow-md"
                                >
                            @else
                                <div
                                    id="avatarFallback"
                                    class="w-24 h-24 rounded-full bg-brand-blue text-white flex items-center justify-center text-3xl font-extrabold shadow-md"
                                >
                                    {{ mb_strtoupper(mb_substr($user->name, 0, 1)) }}
                                </div>
                                <img
                                    id="avatarPreview"
                                    src=""
                                    alt="Vista previa"
                                    class="hidden w-24 h-24 rounded-full object-cover border-4 border-brand-blue/20 dark:border-slate-700 shadow-md"
                                >
                            @endif
                        </div>

                        <div class="space-y-2 text-center sm:text-left">
                            <p class="text-sm font-extrabold text-slate-800 dark:text-white">{{ $user->name }}</p>
                            <p class="text-xs font-semibold text-brand-secondary dark:text-brand-sky">{{ $user->getRoleLabel() }}</p>
                            <p class="text-xs text-slate-400 font-mono">DNI: {{ $user->dni }}</p>

                            <div class="pt-2 flex flex-wrap items-center justify-center sm:justify-start gap-3">
                                <label for="avatarInput" class="cursor-pointer bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 px-4 py-2 rounded-xl text-xs font-bold transition border border-slate-200 dark:border-slate-700">
                                    📁 Elegir archivo desde PC (Descargas / Imágenes)
                                </label>
                                <input
                                    type="file"
                                    name="avatar"
                                    id="avatarInput"
                                    accept=".jpg,.jpeg,.png,.webp,image/jpeg,image/png,image/webp"
                                    class="sr-only"
                                >
                                <span id="selectedFileName" class="text-xs text-slate-500 dark:text-slate-400 font-medium">
                                    Ningún archivo seleccionado
                                </span>

                                @if($currentAvatarUrl)
                                    <label class="flex items-center gap-1.5 cursor-pointer text-xs font-semibold text-rose-600 dark:text-rose-400">
                                        <input type="checkbox" name="remove_avatar" value="1" class="rounded text-rose-600">
                                        Quitar foto actual
                                    </label>
                                @endif
                            </div>
                            <p class="text-[11px] text-slate-400">Formatos permitidos: JPG, PNG o WEBP. Máximo 2 MB.</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="name" class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">
                                Nombre Completo
                            </label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                value="{{ old('name', $user->name) }}"
                                required
                                class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-sm font-semibold text-slate-800 dark:text-white focus:outline-none focus:ring-2 focus:ring-brand-blue"
                            >
                        </div>

                        <div>
                            <label class="block text-xs font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400 mb-2">
                                Cargo / Rol Asignado
                            </label>
                            <input
                                type="text"
                                value="{{ $user->getRoleLabel() }}"
                                disabled
                                class="w-full px-4 py-3 rounded-2xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-800 text-sm font-bold text-slate-500 dark:text-slate-400 cursor-not-allowed"
                            >
                        </div>
                    </div>

                    <div class="pt-2 flex justify-end">
                        <button type="submit" class="bg-brand-blue hover:bg-brand-hover text-white px-6 py-3 rounded-2xl text-sm font-bold transition shadow-md cursor-pointer">
                            💾 Guardar Cambios de Perfil
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <footer class="max-w-5xl mx-auto w-full mt-12 py-6 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 text-center text-xs transition-colors rounded-2xl shadow-sm">
            <p class="font-serif italic text-brand-secondary dark:text-brand-sky text-sm mb-1">Más que una institución, una gran familia</p>
            <p class="text-slate-400 dark:text-slate-500">© {{ date('Y') }} <strong>I.E. Tungasuca</strong> - Sistema de Gestión Escolar. Todos los derechos reservados.</p>
        </footer>
    </div>

    <script>
        document.getElementById('avatarInput')?.addEventListener('change', function(event) {
            const file = event.target.files?.[0];
            const nameLabel = document.getElementById('selectedFileName');

            if (!file) {
                if (nameLabel) nameLabel.textContent = 'Ningún archivo seleccionado';
                return;
            }

            if (nameLabel) nameLabel.textContent = file.name;

            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatarPreview');
                const fallback = document.getElementById('avatarFallback');
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                if (fallback) {
                    fallback.classList.add('hidden');
                }
            };
            reader.readAsDataURL(file);
        });

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