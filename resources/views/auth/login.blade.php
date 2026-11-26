<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - I.E. Tungasuca</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0756A3',
                            hover: '#054380',
                            secondary: '#1689D4',
                            sky: '#48B9E8',
                            yellow: '#F5C542',
                            dark: '#172B4D',
                        }
                    }
                }
            }
        }
    </script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800;900&family=Caveat:wght@600;700&display=swap" rel="stylesheet">

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .font-handwriting { font-family: 'Caveat', cursive; }
    </style>
</head>
<body class="min-h-full bg-slate-950 text-brand-dark flex flex-col justify-between relative overflow-x-hidden selection:bg-brand-sky selection:text-white">

    <!-- FONDO AMBIENTAL -->
    <div class="fixed inset-0 z-0 pointer-events-none overflow-hidden bg-gradient-to-br from-[#061833] via-[#092752] to-[#040e1f]">
        <div class="absolute -top-28 -left-24 w-96 h-96 bg-brand-sky/20 rounded-full blur-3xl"></div>
        <div class="absolute top-1/3 right-1/4 w-80 h-80 bg-brand-secondary/15 rounded-full blur-3xl"></div>
        <div class="absolute -bottom-28 -right-24 w-96 h-96 bg-brand-yellow/15 rounded-full blur-3xl"></div>
    </div>

    <!-- BARRA SUPERIOR -->
    <header class="relative z-10 w-full max-w-6xl mx-auto px-6 pt-6 flex items-center justify-between">
        <div class="inline-flex items-center gap-2.5 bg-slate-900/75 backdrop-blur-md px-4 py-2 rounded-full border border-white/15 text-white text-xs font-semibold shadow-md">
            <span class="w-2.5 h-2.5 rounded-full bg-emerald-400 animate-pulse"></span>
            <span>I.E Tungasuca</span>
        </div>

        <span class="hidden sm:inline-block text-xs font-semibold text-white/60 tracking-wide">
            Gestión Institucional • I.E. Tungasuca
        </span>
    </header>

    <!-- CONTENEDOR PRINCIPAL -->
    <main class="relative z-10 flex-grow flex items-center justify-center px-4 py-6">
        <div class="w-full max-w-5xl grid grid-cols-1 lg:grid-cols-12 gap-6 items-stretch">

            <!-- COLUMNA IZQUIERDA: TARJETA DE LOGIN -->
            <section class="lg:col-span-6 bg-white/95 backdrop-blur-2xl rounded-3xl shadow-[0_25px_70px_rgba(0,0,0,0.45)] border border-white/70 p-8 sm:p-10 relative overflow-hidden flex flex-col justify-between">
                <div class="absolute top-0 left-0 right-0 h-2 flex">
                    <div class="w-1/3 bg-brand-yellow"></div>
                    <div class="w-1/3 bg-brand-sky"></div>
                    <div class="w-1/3 bg-brand-blue"></div>
                </div>

                <div>
                    <!-- Encabezado con Logo Institucional -->
                    <div class="flex items-center gap-4 mb-8 pt-1">
                        <img
                            src="{{ asset('images/escudo-tungasuca.png') }}"
                            alt="Logo Institucional I.E. Tungasuca"
                            class="w-16 h-16 rounded-2xl object-cover shadow-md border border-brand-blue/20 shrink-0 bg-[#0b3c8c]"
                        >
                        <div>
                            <h2 class="text-xl sm:text-2xl font-black text-brand-dark tracking-tight leading-none uppercase">
                                I.E. TUNGASUCA
                            </h2>
                            <p class="text-[11px] font-extrabold tracking-wider text-amber-500 uppercase mt-1.5">
                                Formación con visión de futuro
                            </p>
                        </div>
                    </div>

                    <div class="mb-6">
                        <h1 class="text-2xl sm:text-3xl font-black text-slate-900 tracking-tight">
                            Iniciar Sesión
                        </h1>
                        <p class="text-xs sm:text-sm text-slate-500 font-medium mt-1">
                            Introduce tu DNI institucional para acceder al sistema
                        </p>
                    </div>

                    @if ($errors->any())
                        <div class="mb-5 p-3.5 bg-rose-50 border-l-4 border-rose-500 text-rose-700 rounded-2xl text-xs font-semibold shadow-sm flex items-center gap-2.5">
                            <span class="text-base font-black">!</span>
                            <span>{{ $errors->first() }}</span>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}" class="space-y-4">
                        @csrf

                        <div>
                            <label for="dni" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-600 mb-1.5 ml-1">
                                Número de DNI
                            </label>
                            <div class="relative group">
                                <input
                                    type="text"
                                    id="dni"
                                    name="dni"
                                    value="{{ old('dni') }}"
                                    required
                                    autofocus
                                    maxlength="8"
                                    inputmode="numeric"
                                    pattern="[0-9]{8}"
                                    placeholder="Ingrese su DNI (8 dígitos)"
                                    class="w-full pr-11 pl-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-brand-dark placeholder-slate-400 focus:outline-none focus:bg-white focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/15 transition-all"
                                >
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none group-focus-within:text-brand-blue transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8h2m-2 4h6m-2-4h.01M17 16h.01"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div>
                            <label for="password" class="block text-[11px] font-extrabold uppercase tracking-wider text-slate-600 mb-1.5 ml-1">
                                Contraseña
                            </label>
                            <div class="relative group">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    required
                                    placeholder="••••••••"
                                    class="w-full pr-11 pl-4 py-3.5 bg-slate-50 border border-slate-200 rounded-2xl text-sm font-semibold text-brand-dark placeholder-slate-400 focus:outline-none focus:bg-white focus:border-brand-blue focus:ring-4 focus:ring-brand-blue/15 transition-all"
                                >
                                <span class="absolute right-3.5 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none group-focus-within:text-brand-blue transition-colors">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <div class="pt-2">
                            <button
                                type="submit"
                                class="w-full py-4 bg-brand-blue hover:bg-brand-hover text-white font-extrabold rounded-2xl shadow-lg shadow-brand-blue/30 hover:shadow-xl hover:shadow-brand-blue/40 transition-all duration-300 text-sm flex items-center justify-center gap-2.5 group cursor-pointer active:scale-[0.99]"
                            >
                                <span>Ingresar al Sistema</span>
                                <svg class="w-4 h-4 group-hover:translate-x-1.5 transition-transform duration-300" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="mt-6 pt-4 border-t border-slate-100 text-center">
                    <p class="text-[11px] text-slate-400 font-medium">
                        Panel de Control y Gestión Institucional
                    </p>
                </div>
            </section>

            <!-- COLUMNA DERECHA: PANEL INSTITUCIONAL -->
            <aside class="lg:col-span-6 rounded-3xl overflow-hidden relative min-h-[340px] sm:min-h-[420px] shadow-[0_25px_70px_rgba(0,0,0,0.45)] border border-white/15 flex items-end p-8 sm:p-10 bg-gradient-to-br from-[#0756A3] via-[#0b3c8c] to-[#051b3b]">
                <img
                    src="{{ asset('images/tungasuca-foto.png') }}"
                    alt="Comunidad y patio de la I.E. Tungasuca"
                    class="absolute inset-0 w-full h-full object-cover object-center"
                >

                <div class="absolute inset-0 bg-gradient-to-t from-[#061833]/90 via-[#072654]/45 to-sky-950/15"></div>

                <div class="absolute top-5 right-5 z-10 flex items-center gap-2 bg-slate-950/65 backdrop-blur-md px-3 py-1.5 rounded-2xl border border-white/15">
                    <img
                        src="{{ asset('images/escudo-tungasuca.png') }}"
                        alt="Emblema I.E. Tungasuca"
                        class="w-7 h-7 rounded-lg object-cover"
                    >
                    <span class="text-[11px] font-bold text-white/90 tracking-wide">I.E. Tungasuca</span>
                </div>

                <div class="relative z-10 w-full">
                    <h2 class="text-2xl sm:text-4xl font-black text-white uppercase tracking-tight leading-tight drop-shadow-md">
                        BIENVENIDOS AL<br>PORTAL DE GESTIÓN
                    </h2>
                    <p class="font-handwriting text-brand-yellow text-2xl sm:text-3xl mt-2 leading-snug drop-shadow">
                        Más que una institución,<br>una gran familia
                    </p>
                </div>
            </aside>

        </div>
    </main>

    <!-- PIE DE PÁGINA -->
    <footer class="relative z-10 py-4 px-6 text-center text-xs text-white/70">
        <p>© {{ date('Y') }} I.E. Tungasuca. Todos los derechos reservados.</p>
    </footer>

</body>
</html>