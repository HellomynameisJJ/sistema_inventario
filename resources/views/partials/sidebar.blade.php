<aside class="w-full md:w-72 bg-brand-dark dark:bg-slate-900 text-white flex flex-col justify-between p-6 shrink-0 shadow-xl border-r border-slate-800 z-40 sticky top-0 h-screen overflow-y-auto">
    <div>
        <div class="flex items-center gap-3 mb-6 pb-6 border-b border-slate-800">
            <div class="w-12 h-12 bg-white dark:bg-slate-800 rounded-2xl flex items-center justify-center p-2 shadow-md shrink-0 border border-slate-700">
                <svg class="w-full h-full" viewBox="0 0 100 110" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M50 5 L90 20 V55 C90 80 50 105 50 105 C50 105 10 80 10 55 V20 Z" fill="#0756A3" stroke="#F5C542" stroke-width="4"/>
                    <path d="M50 8 L86 22 V53 C86 76 50 99 50 99 C50 99 14 76 14 53 V22 Z" stroke="white" stroke-width="3"/>
                    <path d="M50 18 C53 25 57 28 50 36 C43 28 47 25 50 18 Z" fill="#F39C12"/>
                    <path d="M50 23 C51.5 27 54 29 50 34 C46 29 48.5 27 50 23 Z" fill="#F5C542"/>
                </svg>
            </div>
            <div>
                <h2 class="font-black text-xs tracking-wide">I.E. TUNGASUCA</h2>
                <p class="text-[10px] text-brand-sky font-semibold tracking-wider uppercase">Gestión Institucional</p>
            </div>
        </div>

        <div class="bg-slate-800/60 dark:bg-slate-800/40 p-4 rounded-2xl mb-8 border border-slate-700/50 flex items-center gap-3">
            <div class="w-10 h-10 bg-brand-blue rounded-full flex items-center justify-center font-bold text-white shadow shrink-0">
                {{ auth()->check() ? substr(auth()->user()->name, 0, 1) : 'U' }}
            </div>
            <div class="overflow-hidden">
                <p class="text-[10px] text-slate-400">Bienvenido,</p>
                <p class="text-xs font-bold truncate text-white">{{ auth()->check() ? auth()->user()->name : 'Invitado' }}</p>
                <div class="flex items-center gap-1.5 mt-0.5">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    <span class="text-[10px] text-emerald-400 font-medium">En línea</span>
                </div>
            </div>
        </div>

        <div class="space-y-1.5">
            <p class="text-[10px] font-extrabold uppercase tracking-widest text-slate-400 mb-3 px-2">Módulos del Sistema</p>

            @if(auth()->check() && in_array(auth()->user()->rol_id, [1, 3]))
                <a href="{{ route('inventory.index') }}" class="hover-shine flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                    <span>🪑</span> Mobiliario (Aulas)
                </a>
            @endif

            @if(auth()->check() && in_array(auth()->user()->rol_id, [1, 2]))
                <a href="{{ route('library.index') }}" class="hover-shine flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                    <span>📚</span> Biblioteca Escolar
                </a>
            @endif

            @if(auth()->check() && in_array(auth()->user()->rol_id, [1, 4]))
                <a href="{{ route('tic.index') }}" class="hover-shine flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                    <span>💻</span> Equipos TIC
                </a>
            @endif

            @if(auth()->check() && in_array(auth()->user()->rol_id, [1, 5]))
                <a href="{{ route('tic.index') }}" class="hover-shine flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-medium text-slate-300 hover:bg-slate-800 hover:text-white transition-all">
                    <span>🖥️</span> Aula AIP
                </a>
            @endif

            @if(auth()->check() && auth()->user()->rol_id == 1)
                <a href="{{ route('inventory.dashboard') }}" class="hover-shine flex items-center gap-3 px-4 py-3 rounded-xl text-sm font-bold bg-brand-blue text-white shadow-md shadow-brand-blue/20 transition-all">
                    <span>📊</span> Dashboard Estadísticas
                </a>
            @endif
        </div>
    </div>

    <div class="pt-6 border-t border-slate-800 space-y-3 mt-6">
        <button type="button" onclick="toggleDarkMode()" class="hover-shine w-full bg-slate-800 hover:bg-slate-700 text-slate-200 px-4 py-2.5 rounded-xl font-bold flex items-center justify-between text-xs transition cursor-pointer border border-slate-700">
            <span class="flex items-center gap-2">☀️ Modo Visual</span>
            <span class="text-[10px] bg-slate-700 px-2.5 py-1 rounded text-brand-sky font-mono uppercase" id="themeTextLabel">Claro</span>
        </button>

        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="hover-shine w-full bg-rose-500/10 hover:bg-rose-600 text-rose-400 hover:text-white px-4 py-2.5 rounded-xl font-bold flex items-center justify-center gap-2 text-xs transition cursor-pointer border border-rose-500/20">
                <span>🚪</span> Cerrar Sesión
            </button>
        </form>
    </div>
</aside>