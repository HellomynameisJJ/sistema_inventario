<!DOCTYPE html>
<html lang="es" class="h-full">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Control - Inventario I.E. Tungasuca</title>
    
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
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400&display=swap" rel="stylesheet">
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.0.0"></script>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.8.2/jspdf.plugin.autotable.min.js"></script>
    <script src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>

    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; }
        .hover-shine { position: relative; overflow: hidden; }
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

    <!-- PRELOADER INSTITUCIONAL -->
    <div id="preloader" class="fixed inset-0 z-[9999] flex flex-col items-center justify-center bg-[#F3F6F9] dark:bg-slate-950 transition-opacity duration-500">
        <div class="absolute w-96 h-96 bg-brand-sky/20 rounded-full blur-3xl animate-pulse pointer-events-none"></div>
        <div class="absolute w-64 h-64 bg-brand-yellow/30 rounded-full blur-2xl animate-pulse delay-300 pointer-events-none"></div>

        <div class="relative w-32 h-32 flex items-center justify-center mb-8">
            <div class="w-32 h-32 border-4 border-brand-blue/20 border-t-brand-blue dark:border-brand-sky/20 dark:border-t-brand-sky rounded-full animate-spin"></div>
            <div class="absolute w-24 h-24 border-4 border-brand-yellow/30 border-b-brand-yellow rounded-full animate-spin [animation-duration:1.5s]"></div>
            <img
                src="{{ asset('images/escudo-tungasuca.png') }}"
                alt="Escudo I.E. Tungasuca"
                class="absolute w-16 h-16 rounded-2xl object-cover shadow-lg border-2 border-white dark:border-slate-800 bg-[#0b3c8c] z-10"
            >
        </div>
        
        <div class="text-center space-y-2 z-10 px-4">
            <span class="px-3.5 py-1 rounded-full text-[11px] font-extrabold tracking-widest bg-brand-blue/10 dark:bg-brand-blue/30 text-brand-blue dark:text-brand-sky border border-brand-blue/20 uppercase">
                Estadísticas & Métricas
            </span>
            <h2 class="text-2xl font-black text-brand-blue dark:text-white tracking-wider uppercase mt-2">I.E. TUNGASUCA</h2>
            <p class="text-brand-secondary dark:text-slate-400 text-xs font-semibold tracking-wide flex items-center justify-center gap-2">
                <span class="w-2 h-2 rounded-full bg-brand-yellow animate-ping"></span>
                Cargando métricas e inventario en vivo...
            </p>
        </div>
    </div>

    <!-- INCLUIR SIDEBAR DESDE PARTIALS -->
    @include('partials.sidebar')

    <!-- CONTENEDOR PRINCIPAL CON SCROLL INTERNO -->
    <div class="flex-1 min-w-0 p-6 md:p-8 overflow-y-auto h-full w-full">
        <div class="max-w-7xl mx-auto w-full min-w-0">
            <div id="dashboard-reporte">
                
                <!-- INCLUIR MÉTRICAS Y FILTROS -->
                @include('partials.metrics')

                <!-- INCLUIR DETALLE POR AULA (TABLA Y FILTROS) -->
                <div class="mb-8">
                    @include('partials.table')
                </div>

                <!-- INCLUIR GRÁFICOS -->
                @include('partials.charts')

            </div>

            <footer class="mt-12 py-6 bg-white dark:bg-slate-900 border-t border-slate-200 dark:border-slate-800 text-center text-xs transition-colors rounded-2xl shadow-sm">
                <p class="font-serif italic text-brand-secondary dark:text-brand-sky text-sm mb-1">Más que una institución, una gran familia</p>
                <p class="text-slate-400 dark:text-slate-500">© {{ date('Y') }} <strong>I.E. Tungasuca</strong> - Sistema de Gestión Escolar. Todos los derechos reservados.</p>
            </footer>
        </div>
    </div>

    <!-- DATOS PARA LOS GRÁFICOS (PHP -> JS) -->
    @php
        $chartData = [
            'labels'          => $nombresObjetos ?? [],
            'bueno'           => $datosBueno ?? [],
            'regular'         => $datosRegular ?? [],
            'malo'            => $datosMalo ?? [],
            'totales'         => $cantidadesObjetos ?? [],
            'totalesGlobales' => [$cantBueno ?? 0, $cantRegular ?? 0, $cantMalo ?? 0],
        ];
    @endphp

    <!-- SCRIPTS DE GRÁFICOS, FILTROS Y ACCIONES -->
    <script>
        const rawChartData = @json($chartData);

        let chartEstado, chartSalud, chartObjetos;
        const aulasIndexadas = [];

        function normalizeText(str) {
            return (str || '').toLowerCase().normalize("NFD").replace(/[\u0300-\u036f]/g, "");
        }

        function parsearGradoSeccion(textoAula) {
            const limpio = (textoAula || '').toUpperCase().trim();
            const matchGrado = limpio.match(/\b([1-5])\s*(?:°|º|GRADO)?\b/);
            const matchSeccion = limpio.match(/\b([1-5])\s*(?:°|º)?\s*[-–—:]?\s*([A-Z])\b/)
                || limpio.match(/\bSECCI[ÓO]N\s*([A-Z])\b/)
                || limpio.match(/\b([A-Z])\s*$/);

            return {
                grado: matchGrado ? matchGrado[1] : '',
                seccion: matchSeccion ? matchSeccion[matchSeccion.length - 1] : ''
            };
        }

        function inicializarFiltrosAula() {
            if (aulasIndexadas.length > 0) return;

            const bloquesAula = document.querySelectorAll('#tablaDetalle tbody tr.bloque-aula');
            const filasObjeto = document.querySelectorAll('#tablaDetalle tbody tr.fila-objeto');
            const letrasSet = new Set();

            bloquesAula.forEach(bloque => {
                const rawAulaAttr = (bloque.getAttribute('data-aula') || '').trim();
                const textoVisible = bloque.querySelector('td')?.textContent || rawAulaAttr;
                const { grado, seccion } = parsearGradoSeccion(textoVisible);

                if (seccion) {
                    letrasSet.add(seccion);
                }

                const itemsAsociados = Array.from(filasObjeto).filter(fila => {
                    const parentAula = (fila.getAttribute('data-parent-aula') || '').trim();
                    return parentAula === rawAulaAttr;
                });

                itemsAsociados.forEach(fila => {
                    fila.setAttribute('data-grado', grado);
                    fila.setAttribute('data-seccion', seccion);
                });

                aulasIndexadas.push({
                    bloque,
                    grado,
                    seccion,
                    texto: normalizeText(textoVisible),
                    items: itemsAsociados
                });
            });

            poblarSelectSecciones(letrasSet, '');
            clonarOpcionesSeccionHeader();
        }

        function poblarSelectSecciones(letrasSet, gradoSeleccionado = '') {
            const selectSeccion = document.getElementById('filtroSeccion');
            if (!selectSeccion) return;

            const valorAnterior = selectSeccion.value;
            const conjunto = new Set();

            aulasIndexadas.forEach(entry => {
                if (!entry.seccion) return;
                if (!gradoSeleccionado || entry.grado === gradoSeleccionado) {
                    conjunto.add(entry.seccion);
                }
            });

            if (conjunto.size === 0 && letrasSet) {
                letrasSet.forEach(letra => conjunto.add(letra));
            }

            const letrasOrdenadas = Array.from(conjunto).sort((a, b) => a.localeCompare(b, 'es'));

            selectSeccion.innerHTML = '<option value="">Todas las secciones</option>';
            letrasOrdenadas.forEach(letra => {
                const option = document.createElement('option');
                option.value = letra;
                option.textContent = `Sección ${letra}`;
                selectSeccion.appendChild(option);
            });

            if (valorAnterior && letrasOrdenadas.includes(valorAnterior)) {
                selectSeccion.value = valorAnterior;
            }
        }

        function sincronizarFiltroHeader(origen) {
            const hGrado = document.getElementById('headerFiltroGrado');
            const hSeccion = document.getElementById('headerFiltroSeccion');
            const tGrado = document.getElementById('filtroGrado');
            const tSeccion = document.getElementById('filtroSeccion');

            if (origen === 'grado' && hGrado && tGrado) {
                tGrado.value = hGrado.value;
                onChangeGrado();
                return;
            }

            if (origen === 'seccion' && hSeccion && tSeccion) {
                tSeccion.value = hSeccion.value;
                onChangeSeccion();
            }
        }

        function clonarOpcionesSeccionHeader() {
            const tSeccion = document.getElementById('filtroSeccion');
            const hSeccion = document.getElementById('headerFiltroSeccion');
            if (!tSeccion || !hSeccion) return;

            hSeccion.innerHTML = tSeccion.innerHTML;
            hSeccion.value = tSeccion.value;
        }

        function onChangeGrado() {
            inicializarFiltrosAula();
            const grado = document.getElementById('filtroGrado')?.value || '';
            const hGrado = document.getElementById('headerFiltroGrado');
            if (hGrado && hGrado.value !== grado) {
                hGrado.value = grado;
            }

            const todasLetras = new Set(aulasIndexadas.map(a => a.seccion).filter(Boolean));
            poblarSelectSecciones(todasLetras, grado);
            clonarOpcionesSeccionHeader();
            filtrarTabla();
        }

        function onChangeSeccion() {
            inicializarFiltrosAula();
            const tSeccion = document.getElementById('filtroSeccion');
            const hSeccion = document.getElementById('headerFiltroSeccion');
            if (tSeccion && hSeccion && hSeccion.value !== tSeccion.value) {
                hSeccion.value = tSeccion.value;
            }
            filtrarTabla();
        }

        document.addEventListener("DOMContentLoaded", () => {
            const currentTheme = localStorage.getItem('theme') || 'light';
            const themeLabel = document.getElementById('themeTextLabel');
            if (themeLabel) {
                themeLabel.innerText = currentTheme === 'dark' ? 'Oscuro' : 'Claro';
            }
            inicializarFiltrosAula();
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

            actualizarColoresGraficos(!isDark);
        }

        function actualizarColoresGraficos(isDark) {
            const textColor = isDark ? '#F1F5F9' : '#172B4D';
            const gridColor = isDark ? '#334155' : '#E2E8F0';

            [chartEstado, chartObjetos].forEach(chart => {
                if (chart) {
                    chart.options.scales.x.ticks.color = textColor;
                    chart.options.scales.y.ticks.color = isDark ? '#94A3B8' : '#64748B';
                    if (chart.options.scales.y.grid) {
                        chart.options.scales.y.grid.color = gridColor;
                    }
                    if (chart.options.scales.x.grid) {
                        chart.options.scales.x.grid.color = gridColor;
                    }
                    if (chart.options.plugins.legend?.labels) {
                        chart.options.plugins.legend.labels.color = textColor;
                    }
                    if (chart.options.plugins.datalabels) {
                        chart.options.plugins.datalabels.color = textColor;
                    }
                    chart.update();
                }
            });

            if (chartSalud) {
                chartSalud.options.plugins.legend.labels.color = textColor;
                chartSalud.data.datasets[0].borderColor = isDark ? '#0f172a' : '#ffffff';
                chartSalud.update();
            }
        }

        window.addEventListener('load', () => {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.classList.add('opacity-0');
                setTimeout(() => {
                    preloader.remove();
                    iniciarContadores();
                }, 500);
            } else {
                iniciarContadores();
            }

            inicializarFiltrosAula();
            renderizarGraficos();
        });

        function iniciarContadores() {
            const contadores = document.querySelectorAll('.counter-val');
            contadores.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target')) || 0;
                if (target === 0) {
                    counter.innerText = '0';
                    return;
                }
                
                const duration = 800;
                const startTime = performance.now();

                function updateCounter(currentTime) {
                    const elapsedTime = currentTime - startTime;
                    const progress = Math.min(elapsedTime / duration, 1);
                    counter.innerText = Math.floor(progress * target);

                    if (progress < 1) {
                        requestAnimationFrame(updateCounter);
                    } else {
                        counter.innerText = target;
                    }
                }
                requestAnimationFrame(updateCounter);
            });
        }

        function obtenerDatosGraficosDesdeTabla() {
            const gradoSel = document.getElementById('filtroGrado')?.value || '';
            const seccionSel = document.getElementById('filtroSeccion')?.value || '';
            const query = normalizeText(document.getElementById('buscadorTabla')?.value || '').trim();

            const hayFiltroActivo = Boolean(gradoSel || seccionSel || query);
            if (!hayFiltroActivo) {
                return {
                    labels: [...(rawChartData.labels || [])],
                    bueno: [...(rawChartData.bueno || [])],
                    regular: [...(rawChartData.regular || [])],
                    malo: [...(rawChartData.malo || [])],
                    totales: [...(rawChartData.totales || [])],
                    totalesGlobales: [...(rawChartData.totalesGlobales || [0, 0, 0])]
                };
            }

            const mapaObjetos = new Map();
            let globalBueno = 0;
            let globalRegular = 0;
            let globalMalo = 0;

            document.querySelectorAll('#tablaDetalle tbody tr.fila-objeto:not(.hidden)').forEach(fila => {
                const celdas = fila.querySelectorAll('td');
                if (celdas.length < 5) return;

                const nombreLimpio = (celdas[0].textContent || '')
                    .replace(/↳/g, '')
                    .replace(/\s+/g, ' ')
                    .trim();
                const claveObj = nombreLimpio.toUpperCase();

                const b = parseInt((celdas[1].textContent || '0').replace(/[^\d]/g, ''), 10) || 0;
                const r = parseInt((celdas[2].textContent || '0').replace(/[^\d]/g, ''), 10) || 0;
                const m = parseInt((celdas[3].textContent || '0').replace(/[^\d]/g, ''), 10) || 0;
                const t = parseInt((celdas[4].textContent || '0').replace(/[^\d]/g, ''), 10) || (b + r + m);

                globalBueno += b;
                globalRegular += r;
                globalMalo += m;

                if (!mapaObjetos.has(claveObj)) {
                    mapaObjetos.set(claveObj, {
                        objeto: nombreLimpio,
                        bueno: 0,
                        regular: 0,
                        malo: 0,
                        total: 0
                    });
                }

                const actual = mapaObjetos.get(claveObj);
                actual.bueno += b;
                actual.regular += r;
                actual.malo += m;
                actual.total += t;
            });

            const ordenados = Array.from(mapaObjetos.values())
                .sort((a, b) => b.total - a.total);

            const top10 = ordenados.slice(0, 10);
            const resto = ordenados.slice(10);

            const labels = top10.map(item => item.objeto);
            const bueno = top10.map(item => item.bueno);
            const regular = top10.map(item => item.regular);
            const malo = top10.map(item => item.malo);
            const totales = top10.map(item => item.total);

            if (resto.length > 0) {
                labels.push('Otros Objetos');
                bueno.push(resto.reduce((acc, item) => acc + item.bueno, 0));
                regular.push(resto.reduce((acc, item) => acc + item.regular, 0));
                malo.push(resto.reduce((acc, item) => acc + item.malo, 0));
                totales.push(resto.reduce((acc, item) => acc + item.total, 0));
            }

            return {
                labels,
                bueno,
                regular,
                malo,
                totales,
                totalesGlobales: [globalBueno, globalRegular, globalMalo]
            };
        }

        function actualizarTarjetasMetricas(totalesGlobales) {
            const contadores = document.querySelectorAll('.counter-val');
            if (contadores.length < 4) return;

            const bueno = totalesGlobales[0] ?? 0;
            const regular = totalesGlobales[1] ?? 0;
            const malo = totalesGlobales[2] ?? 0;
            const total = bueno + regular + malo;

            contadores[0].textContent = total;
            contadores[1].textContent = bueno;
            contadores[2].textContent = regular;
            contadores[3].textContent = malo;
        }

        function actualizarGraficosDinamicos() {
            const datos = obtenerDatosGraficosDesdeTabla();
            const isDark = document.documentElement.classList.contains('dark');
            const coloresBarras = [
                '#0756A3', '#1068BD', '#1A7AD6', '#1689D4', '#2298E0',
                '#2FA5E6', '#48B9E8', '#5FC4EC', '#7CCFEF', '#99D9F2'
            ];

            if (chartObjetos) {
                chartObjetos.data.labels = datos.labels;
                chartObjetos.data.datasets[0].data = datos.totales;
                chartObjetos.data.datasets[0].backgroundColor = coloresBarras.slice(0, datos.labels.length);
                chartObjetos.update();
            }

            if (chartSalud) {
                chartSalud.data.labels = ['Bueno', 'Regular', 'Malo'];
                chartSalud.data.datasets[0].data = datos.totalesGlobales;
                chartSalud.data.datasets[0].borderColor = isDark ? '#0f172a' : '#ffffff';
                chartSalud.update();
            }

            if (chartEstado) {
                chartEstado.data.labels = datos.labels;
                chartEstado.data.datasets[0].data = datos.bueno;
                chartEstado.data.datasets[1].data = datos.regular;
                chartEstado.data.datasets[2].data = datos.malo;
                chartEstado.update();
            }

            actualizarTarjetasMetricas(datos.totalesGlobales);

            const totalEl = document.getElementById('totalSaludDona');
            if (totalEl) {
                const suma = datos.totalesGlobales.reduce((a, b) => a + b, 0);
                totalEl.textContent = suma;
            }
        }

        function filtrarTabla() {
            inicializarFiltrosAula();

            const gradoSel = document.getElementById('filtroGrado')?.value || '';
            const seccionSel = document.getElementById('filtroSeccion')?.value || '';
            const inputBuscador = document.getElementById('buscadorTabla');
            const query = normalizeText(inputBuscador ? inputBuscador.value : '').trim();

            aulasIndexadas.forEach(({ bloque, grado, seccion, texto, items }) => {
                const cumpleGrado = !gradoSel || grado === gradoSel;
                const cumpleSeccion = !seccionSel || seccion === seccionSel;
                const aulaCoincide = cumpleGrado && cumpleSeccion;

                let algunItemVisible = false;

                items.forEach(fila => {
                    const objetoTexto = normalizeText(fila.getAttribute('data-objeto'));
                    const aulaTexto = normalizeText(fila.getAttribute('data-parent-aula'));
                    const coincideBusqueda = !query || objetoTexto.includes(query) || aulaTexto.includes(query) || texto.includes(query);

                    const mostrarFila = aulaCoincide && coincideBusqueda;
                    fila.classList.toggle('hidden', !mostrarFila);
                    if (mostrarFila) {
                        algunItemVisible = true;
                    }
                });

                const mostrarBloque = aulaCoincide && (algunItemVisible || (!query && items.length === 0));
                bloque.classList.toggle('hidden', !mostrarBloque);
            });

            actualizarGraficosDinamicos();
        }

        function renderizarGraficos() {
            if (typeof ChartDataLabels !== 'undefined' && !Chart.registry.plugins.get('datalabels')) {
                Chart.register(ChartDataLabels);
            }

            const isDark = document.documentElement.classList.contains('dark');
            const textColor = isDark ? '#F1F5F9' : '#172B4D';
            const gridColor = isDark ? '#334155' : '#E2E8F0';

            const canvasTop = document.getElementById('graficoTopObjetos');
            if (canvasTop) {
                const ctxTop = canvasTop.getContext('2d');
                const coloresBarras = [
                    '#0756A3', '#1068BD', '#1A7AD6', '#1689D4', '#2298E0',
                    '#2FA5E6', '#48B9E8', '#5FC4EC', '#7CCFEF', '#99D9F2'
                ];

                chartObjetos = new Chart(ctxTop, {
                    type: 'bar',
                    data: {
                        labels: rawChartData.labels,
                        datasets: [{
                            label: 'Cantidad',
                            data: rawChartData.totales,
                            backgroundColor: coloresBarras.slice(0, rawChartData.labels.length),
                            borderRadius: 8,
                            borderSkipped: false,
                            barThickness: 'flex',
                            maxBarThickness: 32,
                        }]
                    },
                    options: {
                        indexAxis: 'y',
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { right: 60 } },
                        scales: {
                            x: {
                                ticks: { color: isDark ? '#94A3B8' : '#64748B', font: { size: 11, weight: '600' } },
                                grid: { color: gridColor },
                                border: { display: false },
                                beginAtZero: true
                            },
                            y: {
                                ticks: {
                                    color: textColor,
                                    font: { size: 11, weight: '600' },
                                    callback: function(value) {
                                        const label = this.getLabelForValue(value);
                                        return label.length > 30 ? label.substring(0, 28) + '…' : label;
                                    }
                                },
                                grid: { display: false }
                            }
                        },
                        plugins: {
                            legend: { display: false },
                            tooltip: {
                                backgroundColor: 'rgba(23, 43, 77, 0.95)',
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    title: (items) => items[0].label,
                                    label: (context) => '📦 Total: ' + context.parsed.x + ' unidades'
                                }
                            },
                            datalabels: {
                                color: textColor,
                                anchor: 'end',
                                align: 'right',
                                offset: 6,
                                font: { weight: 'bold', size: 12 },
                                formatter: (val) => val > 0 ? val : ''
                            }
                        }
                    }
                });
            }

            const canvasSalud = document.getElementById('graficoSaludDona');
            if (canvasSalud) {
                const ctxSalud = canvasSalud.getContext('2d');
                chartSalud = new Chart(ctxSalud, {
                    type: 'doughnut',
                    data: {
                        labels: ['Bueno', 'Regular', 'Malo'],
                        datasets: [{
                            data: rawChartData.totalesGlobales,
                            backgroundColor: ['#22A06B', '#F5C542', '#D64545'],
                            borderWidth: 3,
                            borderColor: isDark ? '#0f172a' : '#ffffff',
                            hoverOffset: 12
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        cutout: '68%',
                        plugins: {
                            legend: {
                                position: 'bottom',
                                labels: {
                                    color: textColor,
                                    font: { family: 'Plus Jakarta Sans', weight: '600', size: 12 },
                                    padding: 15,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(23, 43, 77, 0.95)',
                                padding: 12,
                                cornerRadius: 8,
                                callbacks: {
                                    label: function(context) {
                                        const total = context.dataset.data.reduce((a, b) => a + b, 0);
                                        const pct = total > 0 ? ((context.parsed * 100) / total).toFixed(1) : 0;
                                        return ` ${context.label}: ${context.parsed} (${pct}%)`;
                                    }
                                }
                            },
                            datalabels: {
                                color: '#ffffff',
                                font: { weight: 'bold', size: 13 },
                                formatter: (val, ctx) => {
                                    let sum = ctx.dataset.data.reduce((a, b) => a + b, 0);
                                    if (sum === 0 || val === 0) return '';
                                    return ((val * 100) / sum).toFixed(0) + "%";
                                }
                            }
                        }
                    }
                });
            }

            const canvasApiladas = document.getElementById('graficoCondicionesApiladas');
            if (canvasApiladas) {
                const ctxApiladas = canvasApiladas.getContext('2d');
                chartEstado = new Chart(ctxApiladas, {
                    type: 'bar',
                    data: {
                        labels: rawChartData.labels,
                        datasets: [
                            {
                                label: '🟢 Bueno',
                                data: rawChartData.bueno,
                                backgroundColor: '#22A06B',
                                borderRadius: { topLeft: 6, topRight: 6 },
                                barPercentage: 0.7,
                            },
                            {
                                label: '🟡 Regular',
                                data: rawChartData.regular,
                                backgroundColor: '#F5C542',
                                borderRadius: { topLeft: 6, topRight: 6 },
                                barPercentage: 0.7,
                            },
                            {
                                label: '🔴 Malo',
                                data: rawChartData.malo,
                                backgroundColor: '#D64545',
                                borderRadius: { topLeft: 6, topRight: 6, bottomLeft: 6, bottomRight: 6 },
                                barPercentage: 0.7,
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        layout: { padding: { top: 20 } },
                        scales: {
                            x: {
                                stacked: true,
                                ticks: {
                                    color: textColor,
                                    font: { size: 10, weight: '600' },
                                    maxRotation: 45,
                                    minRotation: 30,
                                    callback: function(value) {
                                        const label = this.getLabelForValue(value);
                                        return label.length > 20 ? label.substring(0, 18) + '…' : label;
                                    }
                                },
                                grid: { display: false }
                            },
                            y: {
                                stacked: true,
                                ticks: { color: isDark ? '#94A3B8' : '#64748B', font: { size: 11, weight: '600' } },
                                grid: { color: gridColor },
                                beginAtZero: true
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    color: textColor,
                                    font: { family: 'Plus Jakarta Sans', weight: '600', size: 12 },
                                    padding: 15,
                                    usePointStyle: true,
                                    pointStyle: 'circle'
                                }
                            },
                            tooltip: {
                                backgroundColor: 'rgba(23, 43, 77, 0.95)',
                                padding: 12,
                                cornerRadius: 8,
                                mode: 'index',
                                intersect: false,
                                callbacks: {
                                    title: (items) => items[0].label,
                                    footer: (items) => {
                                        const total = items.reduce((sum, item) => sum + item.parsed.y, 0);
                                        return 'Total: ' + total + ' unidades';
                                    }
                                }
                            },
                            datalabels: {
                                color: '#ffffff',
                                font: { weight: 'bold', size: 10 },
                                display: (context) => context.dataset.data[context.dataIndex] > 3
                            }
                        }
                    }
                });
            }
        }

        function obtenerFilasTabla() {
            const filas = [];
            let aulaActual = '';

            document.querySelectorAll('#tablaDetalle tbody tr').forEach(tr => {
                if (tr.classList.contains('bloque-aula')) {
                    if (tr.classList.contains('hidden')) return;
                    const celda = tr.querySelector('td');
                    let texto = celda ? celda.textContent : '';
                    texto = texto
                        .replace(/[\u{1F300}-\u{1FAFF}\u{2600}-\u{27BF}]/gu, '')
                        .replace(/Aula\s*\/\s*Sección\s*:/gi, '')
                        .replace(/Aula\s*:/gi, '')
                        .replace(/\s+/g, ' ')
                        .trim();
                    aulaActual = texto || 'Sin Asignar';
                } else if (tr.classList.contains('fila-objeto')) {
                    if (tr.classList.contains('hidden')) return;

                    const celdas = tr.querySelectorAll('td');
                    if (celdas.length >= 5) {
                        const objeto = celdas[0].textContent.replace(/↳/g, '').replace(/\s+/g, ' ').trim();
                        const bueno = celdas[1].textContent.replace('—', '0').trim();
                        const regular = celdas[2].textContent.replace('—', '0').trim();
                        const malo = celdas[3].textContent.replace('—', '0').trim();
                        const total = celdas[4].textContent.replace('uds.', '').replace('unidades', '').trim();
                        filas.push([aulaActual, objeto, bueno, regular, malo, total]);
                    }
                }
            });

            return filas;
        }

        function exportarPDF() {
            const { jsPDF } = window.jspdf;
            const doc = new jsPDF({ orientation: 'portrait', unit: 'mm', format: 'a4' });
            const pageWidth = doc.internal.pageSize.getWidth();
            const pageHeight = doc.internal.pageSize.getHeight();

            doc.setFillColor(7, 86, 163);
            doc.rect(0, 0, pageWidth, 28, 'F');

            doc.setTextColor(255, 255, 255);
            doc.setFont('helvetica', 'bold');
            doc.setFontSize(16);
            doc.text('I.E. TUNGASUCA', pageWidth / 2, 12, { align: 'center' });

            doc.setFont('helvetica', 'normal');
            doc.setFontSize(10);
            doc.text('Reporte Oficial de Inventario y Aulas', pageWidth / 2, 19, { align: 'center' });

            const fecha = new Date().toLocaleDateString('es-PE', {
                day: '2-digit', month: 'long', year: 'numeric', hour: '2-digit', minute: '2-digit'
            });
            doc.setFontSize(8);
            doc.text(`Generado el: ${fecha}`, pageWidth - 10, 25, { align: 'right' });

            const filas = obtenerFilasTabla();

            if (filas.length === 0) {
                doc.setTextColor(100);
                doc.setFontSize(12);
                doc.text('No hay datos disponibles para exportar.', pageWidth / 2, 60, { align: 'center' });
                doc.save('Reporte_Inventario_IE_Tungasuca.pdf');
                return;
            }

            doc.autoTable({
                startY: 35,
                head: [['Aula / Sección', 'Objeto / Mobiliario', 'Bueno', 'Regular', 'Malo', 'Total']],
                body: filas,
                theme: 'grid',
                styles: {
                    font: 'helvetica',
                    fontSize: 8,
                    cellPadding: 2.5,
                    textColor: [23, 43, 77],
                    lineColor: [200, 200, 200],
                    lineWidth: 0.2,
                },
                headStyles: {
                    fillColor: [7, 86, 163],
                    textColor: [255, 255, 255],
                    fontStyle: 'bold',
                    halign: 'center',
                    fontSize: 9,
                },
                alternateRowStyles: {
                    fillColor: [243, 246, 249],
                },
                columnStyles: {
                    0: { cellWidth: 30, fontStyle: 'bold', textColor: [7, 86, 163], fontSize: 7 },
                    1: { cellWidth: 'auto' },
                    2: { cellWidth: 16, halign: 'center', textColor: [34, 160, 107], fontStyle: 'bold' },
                    3: { cellWidth: 16, halign: 'center', textColor: [200, 150, 30], fontStyle: 'bold' },
                    4: { cellWidth: 16, halign: 'center', textColor: [214, 69, 69], fontStyle: 'bold' },
                    5: { cellWidth: 16, halign: 'center', fontStyle: 'bold' },
                }
            });

            const totalPaginas = doc.internal.getNumberOfPages();
            for (let i = 1; i <= totalPaginas; i++) {
                doc.setPage(i);
                doc.setFontSize(8);
                doc.setTextColor(120);
                doc.text(
                    `Página ${i} de ${totalPaginas}  |  I.E. Tungasuca - Sistema de Gestión`,
                    pageWidth / 2,
                    pageHeight - 8,
                    { align: 'center' }
                );
            }

            doc.save('Reporte_Inventario_IE_Tungasuca.pdf');
        }

        function exportarCSV() {
            const escaparCSV = (valor) => {
                if (valor === null || valor === undefined) return '';
                let str = String(valor).trim();
                if (str.includes(',') || str.includes('"') || str.includes('\n')) {
                    str = '"' + str.replace(/"/g, '""') + '"';
                }
                return str;
            };

            const filas = obtenerFilasTabla();
            const encabezado = ['Aula / Sección', 'Objeto / Mobiliario', 'Bueno', 'Regular', 'Malo', 'Total'];
            const lineas = [encabezado, ...filas].map(fila => fila.map(escaparCSV).join(','));

            const contenido = '\uFEFF' + lineas.join('\r\n');
            const blob = new Blob([contenido], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);

            const enlace = document.createElement('a');
            enlace.href = url;
            enlace.download = 'Reporte_Inventario_IE_Tungasuca.csv';
            document.body.appendChild(enlace);
            enlace.click();
            document.body.removeChild(enlace);
            URL.revokeObjectURL(url);
        }

        function exportarExcel(ext = 'xlsx') {
            if (typeof XLSX === 'undefined') {
                alert('No se cargó la librería de Excel (SheetJS).');
                return;
            }

            const encabezado = ['Aula / Sección', 'Objeto / Mobiliario', 'Bueno', 'Regular', 'Malo', 'Total'];
            const filas = obtenerFilasTabla();
            const worksheet = XLSX.utils.aoa_to_sheet([encabezado, ...filas]);
            const workbook = XLSX.utils.book_new();
            XLSX.utils.book_append_sheet(workbook, worksheet, 'Detalle_Aulas');

            const bookType = ext === 'xls' ? 'xls' : 'xlsx';
            XLSX.writeFile(workbook, `Reporte_Inventario_IE_Tungasuca.${bookType}`, { bookType });
        }
    </script>
</body>
</html>