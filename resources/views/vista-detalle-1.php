<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Técnico: Capa de Aplicación Laravel Senior</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Inter:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #0f172a;
            color: #f1f5f9;
        }

        .code-font {
            font-family: 'Fira Code', monospace;
        }

        .flow-line {
            border-left: 2px dashed #334155;
            height: 40px;
            margin-left: 20px;
        }

        .component-box {
            transition: all 0.3s ease;
            border: 1px solid #1e293b;
        }

        .component-box:hover {
            border-color: #38bdf8;
            background-color: #1e293b;
        }
    </style>
</head>

<body class="p-4 md:p-8">

    <div class="max-w-5xl mx-auto">
        <header class="mb-10">
            <h1 class="text-2xl font-bold text-sky-400 mb-2 underline decoration-sky-500/30">Deep Dive: Laravel
                Application Layer</h1>
            <p class="text-slate-400 text-sm">Estructura interna, flujo reactivo e integración de servicios
                distribuidos.</p>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">

            <!-- Columna 1: Estructura de Directorios -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-folder-tree text-amber-400"></i>
                    Directorio y Runtime Octane
                </h2>
                <div class="bg-slate-900 border border-slate-800 rounded-xl p-5 overflow-x-auto">
                    <div class="code-font text-xs space-y-1">
                        <div class="text-slate-500"># El esqueleto es el estándar, pero con configuraciones críticas:
                        </div>
                        <div><span class="text-blue-400">app/</span></div>
                        <div class="pl-4 text-emerald-400">├── Agents/ <span class="text-slate-500">// AI Agent Bridge
                                logic</span></div>
                        <div class="pl-4 text-emerald-400">├── Events/ <span class="text-slate-500">//
                                MedicalDataReceived.php</span></div>
                        <div class="pl-4 text-emerald-400">├── Listeners/ <span class="text-slate-500">//
                                NotifyAIBridge.php</span></div>
                        <div class="pl-4 text-emerald-400">└── Jobs/ <span class="text-slate-500">//
                                ProcessHeavyAnalysis.php</span></div>
                        <div><span class="text-blue-400">config/</span></div>
                        <div class="pl-4 text-pink-400">├── octane.php <span class="text-slate-500">// Warm-up & Worker
                                config</span></div>
                        <div class="pl-4 text-pink-400">├── horizon.php <span class="text-slate-500">// Queue
                                monitoring</span></div>
                        <div class="pl-4 text-pink-400">└── reverb.php <span class="text-slate-500">// WebSocket
                                settings</span></div>
                        <div><span class="text-amber-400">server.php</span> <span class="text-slate-500">// Punto de
                                entrada Octane</span></div>
                    </div>
                </div>
                <div
                    class="text-sm text-slate-400 leading-relaxed bg-slate-800/50 p-4 rounded-lg border-l-4 border-amber-400">
                    <p><strong>Nota:</strong> Laravel Octane no cambia las carpetas, cambia el <strong>ciclo de
                            vida</strong>. En lugar de morir después de cada request, PHP mantiene la aplicación "viva"
                        en memoria (RAM). Las variables globales y singletons persisten entre peticiones.</p>
                </div>
            </div>

            <!-- Columna 2: Flujo Técnico de Piezas -->
            <div class="space-y-6">
                <h2 class="text-lg font-semibold flex items-center gap-2">
                    <i class="fa-solid fa-route text-sky-400"></i>
                    Flujo de Eventos (Reactive Flow)
                </h2>

                <div class="space-y-4">
                    <!-- Paso 1 -->
                    <div class="component-box p-4 rounded-xl bg-slate-900">
                        <div class="flex items-start gap-4">
                            <div class="bg-sky-500/20 text-sky-400 p-2 rounded-lg text-xs font-bold">1</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-200 uppercase tracking-tighter">Event Dispatch
                                </h4>
                                <p class="text-xs text-slate-400 mt-1">El controlador dispara un Evento: <code
                                        class="text-sky-300">DataReceived</code>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flow-line"></div>

                    <!-- Paso 2 -->
                    <div class="component-box p-4 rounded-xl bg-slate-900 border-l-4 border-pink-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-pink-500/20 text-pink-400 p-2 rounded-lg text-xs font-bold">2</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-200 uppercase tracking-tighter">Queue (Horizon)
                                </h4>
                                <p class="text-xs text-slate-400 mt-1">El Listener pone un <code
                                        class="text-pink-300">Job</code> en Redis. Horizon lo detecta y lo procesa
                                    asíncronamente.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flow-line"></div>

                    <!-- Paso 3 -->
                    <div class="component-box p-4 rounded-xl bg-slate-900 border-l-4 border-purple-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-purple-500/20 text-purple-400 p-2 rounded-lg text-xs font-bold">3</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-200 uppercase tracking-tighter">AI Agent Bridge
                                </h4>
                                <p class="text-xs text-slate-400 mt-1">El Job ejecuta la lógica de IA (LLM). Al
                                    terminar, dispara un nuevo evento <code
                                        class="text-purple-300">AnalysisFinished</code>.</p>
                            </div>
                        </div>
                    </div>

                    <div class="flow-line"></div>

                    <!-- Paso 4 -->
                    <div class="component-box p-4 rounded-xl bg-slate-900 border-l-4 border-emerald-500">
                        <div class="flex items-start gap-4">
                            <div class="bg-emerald-500/20 text-emerald-400 p-2 rounded-lg text-xs font-bold">4</div>
                            <div>
                                <h4 class="text-sm font-bold text-slate-200 uppercase tracking-tighter">Laravel Reverb
                                </h4>
                                <p class="text-xs text-slate-400 mt-1">El evento implementa <code
                                        class="text-emerald-300">ShouldBroadcast</code>. Reverb envía la actualización
                                    al frontend por WebSockets.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Conexiones Técnicas Pulse y Horizon -->
        <section class="mt-12 bg-slate-900/50 p-6 rounded-2xl border border-slate-800">
            <h2 class="text-xl font-bold mb-6 text-slate-200">¿Cómo se conectan técnicamente?</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-pink-400 uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-eye"></i> Horizon -> Queue
                    </h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Horizon vive como un proceso **independiente** (Supervisor) que monitorea las listas de
                        **Redis**. Se conecta a la App mediante el <code
                            class="bg-slate-800 p-1 rounded">HorizonServiceProvider</code>, que registra las rutas del
                        dashboard y la lógica de autenticación. No afecta el performance de la App principal porque
                        corre en sus propios hilos de CPU.
                    </p>
                </div>
                <div class="space-y-4">
                    <h3 class="text-sm font-bold text-teal-400 uppercase tracking-widest flex items-center gap-2">
                        <i class="fa-solid fa-heart-pulse"></i> Pulse -> Runtime
                    </h3>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Pulse se conecta mediante **Middleware** y **Recorders**. Cada vez que entra un request a Octane
                        o se ejecuta un Job en Horizon, Pulse captura telemetría (memoria, tiempo, queries). Usa un
                        **Ingest** eficiente para no ralentizar la App, enviando los datos a una tabla optimizada en
                        MySQL.
                    </p>
                </div>
            </div>
        </section>

        <footer class="mt-8 text-center text-slate-500 text-[10px] uppercase tracking-widest">
            Ingeniería de Sistemas Distribuidos • Laravel Senior Stack
        </footer>
    </div>

</body>

</html>