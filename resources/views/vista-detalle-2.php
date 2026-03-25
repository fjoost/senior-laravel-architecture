<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deep Dive: Ciclo de Vida y Procesos Laravel</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Fira+Code:wght@400;500&family=Inter:wght@300;400;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617;
            color: #e2e8f0;
        }

        .code {
            font-family: 'Fira Code', monospace;
            font-size: 0.8rem;
        }

        .process-box {
            border: 1px solid #1e293b;
            background: #0f172a;
            transition: all 0.2s;
        }

        .process-box:hover {
            border-color: #38bdf8;
        }

        .highlight-blue {
            color: #38bdf8;
        }

        .highlight-purple {
            color: #c084fc;
        }

        .highlight-amber {
            color: #fbbf24;
        }
    </style>
</head>

<body class="p-4 md:p-10">

    <div class="max-w-6xl mx-auto">
        <header class="mb-12 border-b border-slate-800 pb-6">
            <h1 class="text-3xl font-extrabold text-white mb-2">Internal Engine: Octane, Reverb & Horizon</h1>
            <p class="text-slate-400 italic">Análisis de bajo nivel sobre la persistencia de estado y orquestación de servicios.</p>
        </header>

        <!-- Sección 1: El Dilema de la Memoria (Octane vs Standard) -->
        <section class="mb-16">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-3">
                <i class="fa-solid fa-memory text-blue-400"></i>
                1. Gestión de Memoria y Estado
            </h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- PHP-FPM -->
                <div class="process-box p-6 rounded-2xl">
                    <h3 class="text-sm font-bold uppercase text-slate-400 mb-4 tracking-widest">PHP-FPM (Tradicional)</h3>
                    <div class="space-y-2 mb-4">
                        <div class="bg-slate-800 p-2 rounded border-l-4 border-red-500 text-xs">Petición entra -> Boot Framework -> Ejecuta -> <span class="text-red-400 font-bold">Flush (Muere)</span></div>
                    </div>
                    <p class="text-xs text-slate-400 mb-4">Cada request es una "pizarra limpia". No hay fugas de memoria entre usuarios.</p>
                    <div class="code bg-black p-3 rounded text-pink-400">
                        static $counter = 0;<br>
                        $counter++; // Siempre será 1 para cada usuario
                    </div>
                </div>

                <!-- OCTANE -->
                <div class="process-box p-6 rounded-2xl border-blue-500/30 bg-blue-900/10">
                    <h3 class="text-sm font-bold uppercase text-blue-400 mb-4 tracking-widest">Laravel Octane (Swoole/RoadRunner)</h3>
                    <div class="space-y-2 mb-4">
                        <div class="bg-blue-900/40 p-2 rounded border-l-4 border-blue-400 text-xs">Boot Framework (Una vez) -> <span class="text-blue-300 font-bold">[ Bucle: Request -> Ejecuta ]</span></div>
                    </div>
                    <p class="text-xs text-slate-400 mb-4">El estado persiste. Peligro de <span class="text-amber-400">Memory Leaks</span> y contaminación de datos.</p>
                    <div class="code bg-black p-3 rounded text-blue-300">
                        static $activeUser = null;<br>
                        // Si no lo limpias, el Usuario B podría ver al Usuario A
                    </div>
                </div>
            </div>
            <div class="mt-6 bg-slate-900 p-4 rounded-xl border border-slate-800">
                <h4 class="text-xs font-bold text-amber-400 mb-2 uppercase">Caso Práctico: El "Trap" del Singleton</h4>
                <p class="text-sm text-slate-300">Si registras un servicio como Singleton que guarda el ID del usuario actual, en Octane ese ID se quedará pegado en el worker. El Senior debe usar <code>Octane::tick()</code> o resetear manualmente el estado en el Service Provider.</p>
            </div>
        </section>

        <!-- Sección 2: El Árbol de Procesos (Reverb & Horizon) -->
        <section class="mb-16">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-3">
                <i class="fa-solid fa-microchip text-purple-400"></i>
                2. Orquestación de Procesos Linux
            </h2>
            <div class="bg-slate-900 p-8 rounded-3xl border border-slate-800 relative">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Proceso Reverb -->
                    <div class="p-4 bg-black/50 rounded-xl border border-emerald-900/50">
                        <h4 class="text-xs font-bold text-emerald-400 mb-2 uppercase italic">Proceso: Reverb</h4>
                        <p class="text-[11px] text-slate-400 mb-3">Se inicia vía CLI: <code class="text-emerald-300">php artisan reverb:start</code></p>
                        <ul class="text-[10px] space-y-1 text-slate-500">
                            <li>• Servidor WebSocket independiente.</li>
                            <li>• Event-Loop de alta performance.</li>
                            <li>• Detecta <code class="text-slate-300">ShouldBroadcast</code> mediante Reflection API.</li>
                        </ul>
                    </div>

                    <!-- Proceso Octane -->
                    <div class="p-4 bg-black/50 rounded-xl border border-blue-900/50 scale-105 shadow-2xl shadow-blue-500/10">
                        <h4 class="text-xs font-bold text-blue-400 mb-2 uppercase italic">Proceso: Octane (Master)</h4>
                        <p class="text-[11px] text-slate-400 mb-3">Controla los <code class="text-blue-300">Workers</code> de la App.</p>
                        <div class="flex gap-1 justify-center mt-2">
                            <div class="h-4 w-2 bg-blue-500 rounded-full animate-bounce"></div>
                            <div class="h-4 w-2 bg-blue-400 rounded-full animate-bounce" style="animation-delay: 0.1s"></div>
                            <div class="h-4 w-2 bg-blue-300 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                        </div>
                    </div>

                    <!-- Proceso Horizon -->
                    <div class="p-4 bg-black/50 rounded-xl border border-pink-900/50">
                        <h4 class="text-xs font-bold text-pink-400 mb-2 uppercase italic">Proceso: Horizon</h4>
                        <p class="text-[11px] text-slate-400 mb-3">Iniciado por: <code class="text-pink-300">php artisan horizon</code></p>
                        <ul class="text-[10px] space-y-1 text-slate-500">
                            <li>• Master process que hace "fork" a workers.</li>
                            <li>• Conecta a Redis vía TCP/Unix Sockets.</li>
                            <li>• Orquesta balanceo de carga entre colas.</li>
                        </ul>
                    </div>
                </div>

                <!-- Redis: El pegamento -->
                <div class="mt-10 flex justify-center">
                    <div class="bg-red-500/10 border border-red-500/50 px-8 py-4 rounded-full text-red-400 text-xs font-bold uppercase tracking-widest flex items-center gap-4">
                        <i class="fa-solid fa-link"></i>
                        Redis (The Shared State)
                        <i class="fa-solid fa-link"></i>
                    </div>
                </div>
            </div>
        </section>

        <!-- Sección 3: Deep Q&A Técnico -->
        <section>
            <h2 class="text-xl font-bold mb-6 text-slate-200">Respuestas al Deep Dive</h2>
            <div class="grid md:grid-cols-2 gap-6">
                <div class="process-box p-5 rounded-xl">
                    <h4 class="text-sm font-bold text-emerald-400 mb-2">¿Cómo detecta Reverb el Broadcast?</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Cuando disparas <code class="text-slate-200">event(new MyEvent)</code>, el Event Dispatcher de Laravel verifica si la clase implementa la interfaz <code class="highlight-blue">ShouldBroadcast</code> usando un check de <code class="text-slate-300">is_subclass_of</code>. Si es positivo, Laravel envía el payload al <strong>Broadcasting Manager</strong>, el cual tiene a Reverb configurado como driver en <code class="text-slate-300">config/broadcasting.php</code>.
                    </p>
                </div>
                <div class="process-box p-5 rounded-xl">
                    <h4 class="text-sm font-bold text-pink-400 mb-2">¿Horizon y la conexión Redis?</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Horizon no es un "servidor" externo; es un proceso PHP de larga duración que vive en tu servidor de aplicaciones. Se conecta a Redis usando los parámetros de <code class="text-slate-300">config/database.php</code>. Utiliza el comando <code class="text-slate-300">BRPOP</code> de Redis para quedar en espera (bloqueado) hasta que aparezca un nuevo Job, evitando así el consumo innecesario de CPU.
                    </p>
                </div>
                <div class="process-box p-5 rounded-xl">
                    <h4 class="text-sm font-bold text-teal-400 mb-2">¿Cómo Pulse registra escuchadores?</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Pulse utiliza el **Service Provider Bootstrapping**. En el método <code class="text-slate-200">boot()</code> de su proveedor, registra "Recorders" que se suscriben a eventos internos del core de Laravel como <code class="text-slate-300">QueryExecuted</code>, <code class="text-slate-300">JobProcessed</code> o <code class="text-slate-300">RequestHandled</code>. Es una implementación limpia del patrón Observador.
                    </p>
                </div>
                <div class="process-box p-5 rounded-xl">
                    <h4 class="text-sm font-bold text-amber-400 mb-2">Reverb: ¿PHP distinto o servicio?</h4>
                    <p class="text-xs text-slate-400 leading-relaxed">
                        Reverb es un ejecutable PHP que corre bajo un servidor HTTP especializado (basado en Ratchet/ReactPHP). En producción, **no** se inicia solo. Debes usar un monitor de procesos como **Supervisor** para asegurar que si el comando <code class="text-slate-300">reverb:start</code> falla, se reinicie automáticamente. Vive en el mismo código base, pero en su propio hilo de ejecución.
                    </p>
                </div>
            </div>
        </section>

        <footer class="mt-12 text-center text-slate-600 text-[10px] uppercase tracking-widest border-t border-slate-900 pt-6">
            Ingeniería de Software Avanzada • Masterizado para Laravel Senior
        </footer>
    </div>

</body>

</html>