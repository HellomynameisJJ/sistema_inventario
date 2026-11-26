@php
    $currentUser = auth()->user();
    $isAdmin = $currentUser && ((int) $currentUser->rol_id === 1 || in_array($currentUser->role, ['admin', 'directiva'], true));

    $canLibrary = $currentUser && ($isAdmin || $currentUser->hasModulePermission('library'));
    $canInventory = $currentUser && ($isAdmin || $currentUser->hasModulePermission('inventory'));
    $canTic = $currentUser && ($isAdmin || $currentUser->hasModulePermission('tic'));
    $canAip = $currentUser && ($isAdmin || $currentUser->hasModulePermission('aip'));
    $canLaboratory = $currentUser && ($isAdmin || $currentUser->hasModulePermission('laboratory'));

    $avatarUrl = ($currentUser && !empty($currentUser->avatar))
        ? asset('storage/' . ltrim($currentUser->avatar, '/'))
        : null;
@endphp

<aside class="w-full md:w-72 md:h-screen md:sticky md:top-0 md:overflow-y-auto bg-[#172B4D] dark:bg-slate-900 text-slate-200 flex-shrink-0 flex flex-col justify-start p-6 shadow-2xl border-r border-slate-800/80 transition-colors duration-300">
    <div>
        {{-- Encabezado Institucional --}}
        <div class="flex items-center gap-3.5 pb-6 border-b border-slate-700/60 mb-6">
            <div class="w-12 h-12 bg-[#0b3c8c] rounded-2xl flex items-center justify-center overflow-hidden shadow-md border border-white/15 shrink-0">
                <img
                    src="{{ asset('images/escudo-tungasuca.png') }}"
                    alt="Escudo I.E. Tungasuca"
                    class="w-full h-full object-cover"
                >
            </div>
            <div class="overflow-hidden">
                <p class="text-sm font-extrabold text-white tracking-tight truncate">I.E. TUNGASUCA</p>
                <p class="text-[10px] font-bold text-brand-sky uppercase tracking-widest truncate">Gestión Institucional</p>
            </div>
        </div>

        {{-- Tarjeta de Usuario (clic para ir a Mi Perfil) --}}
        <a
            href="{{ route('my-profile.edit') }}"
            title="Editar mi nombre y foto de perfil"
            class="bg-slate-800/60 hover:bg-slate-800 dark:bg-slate-800/50 dark:hover:bg-slate-800 p-4 rounded-2xl mb-8 border border-slate-700/50 flex items-center gap-3 transition group"
        >
            @if($avatarUrl)
                <img
                    src="{{ $avatarUrl }}"
                    alt="Foto de {{ $currentUser->name }}"
                    class="w-11 h-11 rounded-full object-cover shadow shrink-0 border-2 border-brand-sky/40"
                >
            @else
                <div class="w-11 h-11 bg-brand-blue rounded-full flex items-center justify-center font-extrabold text-white shadow shrink-0">
                    {{ $currentUser ? mb_strtoupper(mb_substr($currentUser->name, 0, 1)) : 'U' }}
                </div>
            @endif

            <div class="overflow-hidden min-w-0 flex-1">
                <p class="text-[10px] text-slate-400">Bienvenido,</p>
                <p class="text-xs font-bold truncate text-white group-hover:text-brand-sky transition">
                    {{ $currentUser ? $currentUser->name : 'Invitado' }}
                </p>
                <p class="text-[10px] text-brand-sky font-semibold truncate">
                    {{ $currentUser ? $currentUser->getRoleLabel() : '' }}
                </p>
                <div class="flex items-center gap-1.5 mt-1">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse shrink-0"></span>
                    <span class="text-[10px] text-emerald-400 font-medium">En línea</span>
                </div>
            </div>
        </a>

        {{-- Navegación de Módulos --}}
        <p class="text-[10px] font-extrabold text-slate-400 uppercase tracking-widest px-3 mb-3">
            Módulos del Sistema
        </p>

        <nav class="space-y-1.5">
            @if($isAdmin)
                <a
                    href="{{ route('inventory.dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('inventory.dashboard') ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <span class="text-base">📊</span>
                    <span class="truncate">Panel General</span>
                </a>
            @endif

            @if($canInventory)
                <a
                    href="{{ route('inventory.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('inventory.index') || request()->routeIs('inventory.edit') ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <span class="text-base">🪑</span>
                    <span class="truncate">Mobiliario (Aulas)</span>
                </a>
            @endif

            @if($canLibrary)
                <a
                    href="{{ route('library.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('library.*') ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <span class="text-base">📚</span>
                    <span class="truncate">Biblioteca Escolar</span>
                </a>
            @endif

            @if($canTic)
                <a
                    href="{{ route('tic.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('tic.*') ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <span class="text-base">💻</span>
                    <span class="truncate">Equipos TIC</span>
                </a>
            @endif

            @if($canAip)
                <a
                    href="{{ route('aip.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('aip.*') ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <span class="text-base">🖥️</span>
                    <span class="truncate">Aula AIP</span>
                </a>
            @endif

            @if($canLaboratory)
                <a
                    href="{{ route('laboratory.index') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('laboratory.*') ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <span class="text-base">🔬</span>
                    <span class="truncate">Laboratorio</span>
                </a>
            @endif

            @if($isAdmin)
                <div class="pt-3 mt-3 border-t border-slate-800">
                    <p class="text-[10px] font-extrabold text-slate-500 uppercase tracking-widest px-3 mb-2">
                        Administración
                    </p>
                    <a
                        href="{{ route('profiles.index') }}"
                        class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('profiles.*') ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                    >
                        <span class="text-base">🛡️</span>
                        <span class="truncate">Gestión de Perfiles</span>
                    </a>
                </div>
            @endif

            <div class="pt-2">
                <a
                    href="{{ route('my-profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-2xl text-xs font-bold transition {{ request()->routeIs('my-profile.*') ? 'bg-brand-blue text-white shadow-md shadow-brand-blue/30' : 'text-slate-300 hover:bg-slate-800/80 hover:text-white' }}"
                >
                    <span class="text-base">👤</span>
                    <span class="truncate">Mi Perfil</span>
                </a>
            </div>
        </nav>

        {{-- Modo Visual y Cerrar Sesión pegados justo debajo de la navegación --}}
        <div class="pt-4 mt-4 border-t border-slate-700/60 space-y-2.5">
            <button
                type="button"
                onclick="toggleDarkMode()"
                class="w-full flex items-center justify-between px-4 py-3 rounded-2xl bg-slate-800/80 hover:bg-slate-800 text-xs font-bold text-slate-200 border border-slate-700/60 transition cursor-pointer"
            >
                <span class="flex items-center gap-2">
                    <span>☀️</span>
                    <span>Modo Visual</span>
                </span>
                <span id="themeTextLabel" class="px-2.5 py-0.5 rounded-lg bg-slate-900 text-[10px] font-extrabold uppercase tracking-wider text-brand-sky">
                    Claro
                </span>
            </button>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button
                    type="submit"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 rounded-2xl bg-rose-950/60 hover:bg-rose-600 text-rose-200 hover:text-white border border-rose-800/60 text-xs font-bold transition cursor-pointer"
                >
                    <span>🚪</span>
                    <span>Cerrar Sesión</span>
                </button>
            </form>
        </div>
    </div>
</aside>