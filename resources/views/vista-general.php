<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arquitectura Laravel de Alto Rendimiento</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700;800&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8fafc;
        }

        .node-card:hover {
            transform: translateY(-5px) scale(1.02);
            border-color: #3b82f6;
            box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.1);
        }

        .pulse-icon {
            animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: .5;
            }
        }
    </style>
</head>

<body class="p-4 md:p-8 text-slate-900">

    <div class="max-w-6xl mx-auto">
        <!-- Header -->
        <header class="mb-12 text-center">
            <h1 class="text-3xl md:text-4xl font-extrabold text-slate-800 mb-2 italic">Arquitectura Laravel de Alto Rendimiento</h1>
            <p class="text-slate-600 max-w-2xl mx-auto">Ecosistema diseñado para tráfico masivo (millones de requests) y procesamiento de datos críticos bajo estándares de seguridad.</p>
            <p href="{{ route('vista-detalle-1') }}" class="text-slate-600 max-w-2xl mx-auto" Ir a detalle></p>
        </header>

        <!-- Main Diagram Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 items-start">

            <!-- Capa de Entrada -->
            <div class="space-y-6">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest text-center mb-4">Entrada & Red</h2>

                <!-- Cloudflare -->
                <div class="node-card bg-white p-4 rounded-xl border-2 border-gray-100 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-lg bg-orange-100 text-orange-600">
                            <i class="fa-solid fa-cloud"></i>
                        </div>
                        <h3 class="font-bold text-sm text-gray-800 uppercase">Cloudflare / CDN</h3>
                    </div>
                    <p class="text-xs text-gray-500">WAF, protección DDoS y caché de bordes (Edge Computing).</p>
                    <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 inline-block">Security</span>
                </div>

                <div class="flex justify-center text-blue-200">
                    <i class="fa-solid fa-arrow-down fa-xl"></i>
                </div>

                <!-- Load Balancer -->
                <div class="node-card bg-white p-4 rounded-xl border-2 border-gray-100 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-lg bg-blue-100 text-blue-600">
                            <i class="fa-solid fa-shield-halved"></i>
                        </div>
                        <h3 class="font-bold text-sm text-gray-800 uppercase">Load Balancer</h3>
                    </div>
                    <p class="text-xs text-gray-500">AWS ALB o Azure App Gateway. Distribución inteligente de carga.</p>
                    <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 inline-block">Infrastructure</span>
                </div>
            </div>

            <!-- Capa de Aplicación (Central) -->
            <div class="md:col-span-2 space-y-6">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest text-center mb-4">Capa de Aplicación (Laravel Octane)</h2>

                <div class="bg-white p-6 rounded-3xl border-2 border-dashed border-blue-200 grid grid-cols-1 sm:grid-cols-2 gap-4 relative">
                    <div class="absolute top-4 right-4 pulse-icon">
                        <i class="fa-solid fa-bolt text-yellow-400"></i>
                    </div>

                    <!-- Laravel Octane -->
                    <div class="node-card bg-blue-50 p-4 rounded-xl border-2 border-blue-200 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-blue-500 text-white shadow-lg shadow-blue-200">
                                <i class="fa-solid fa-server"></i>
                            </div>
                            <h3 class="font-bold text-sm text-gray-800 uppercase">Laravel Octane</h3>
                        </div>
                        <p class="text-xs text-gray-500">Servidor en memoria (Swoole). Latencia mínima y alta concurrencia.</p>
                        <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 inline-block">Runtime</span>
                    </div>

                    <!-- Laravel Reverb -->
                    <div class="node-card bg-white p-4 rounded-xl border-2 border-gray-100 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-indigo-100 text-indigo-600">
                                <i class="fa-solid fa-tower-broadcast"></i>
                            </div>
                            <h3 class="font-bold text-sm text-gray-800 uppercase">Laravel Reverb</h3>
                        </div>
                        <p class="text-xs text-gray-500">WebSockets nativos para feedback en tiempo real al usuario.</p>
                        <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 inline-block">Real-time</span>
                    </div>

                    <!-- Event Listeners -->
                    <div class="node-card bg-white p-4 rounded-xl border-2 border-gray-100 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-emerald-100 text-emerald-600">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <h3 class="font-bold text-sm text-gray-800 uppercase">Event Listeners</h3>
                        </div>
                        <p class="text-xs text-gray-500">Desacoplamiento total de lógica pesada vía eventos asíncronos.</p>
                        <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 inline-block">Architecture</span>
                    </div>

                    <!-- AI Agent Bridge -->
                    <div class="node-card bg-white p-4 rounded-xl border-2 border-gray-100 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-purple-100 text-purple-600">
                                <i class="fa-solid fa-microscope"></i>
                            </div>
                            <h3 class="font-bold text-sm text-gray-800 uppercase">AI Agent Bridge</h3>
                        </div>
                        <p class="text-xs text-gray-500">Integración con LLMs para análisis de datos o automatización.</p>
                        <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 inline-block">AI</span>
                    </div>
                </div>

                <div class="flex justify-center text-blue-200">
                    <i class="fa-solid fa-arrow-down fa-xl"></i>
                </div>

                <!-- Capa de Monitoreo y Colas -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="node-card bg-slate-800 p-4 rounded-xl border-2 border-slate-700 transition-all duration-300">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-pink-500 text-white">
                                <i class="fa-solid fa-gears"></i>
                            </div>
                            <h3 class="font-bold text-sm text-white uppercase tracking-tight">Laravel Horizon</h3>
                        </div>
                        <p class="text-xs text-slate-400">Control maestro de colas sobre Redis para tareas de fondo.</p>
                        <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-700 text-slate-300 inline-block">Async Workers</span>
                    </div>

                    <div class="node-card bg-white p-4 rounded-xl border-2 border-gray-100 transition-all duration-300 text-slate-900">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="p-2 rounded-lg bg-teal-100 text-teal-600">
                                <i class="fa-solid fa-chart-line"></i>
                            </div>
                            <h3 class="font-bold text-sm text-gray-800 uppercase">Laravel Pulse</h3>
                        </div>
                        <p class="text-xs text-gray-500">Observabilidad completa y salud del sistema en vivo.</p>
                        <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 inline-block">Monitoring</span>
                    </div>
                </div>
            </div>

            <!-- Capa de Datos -->
            <div class="space-y-6">
                <h2 class="text-xs font-bold text-slate-400 uppercase tracking-widest text-center mb-4">Persistencia & Caché</h2>

                <!-- Database -->
                <div class="node-card bg-white p-4 rounded-xl border-2 border-blue-500 bg-blue-50/30 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-lg bg-blue-600 text-white">
                            <i class="fa-solid fa-database"></i>
                        </div>
                        <h3 class="font-bold text-sm text-gray-800 uppercase">MySQL Cluster</h3>
                    </div>
                    <p class="text-xs text-gray-500">Réplicas de lectura y Master para escrituras consistentes.</p>
                    <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-blue-100 text-blue-600 inline-block">Database</span>
                </div>

                <div class="flex justify-center text-blue-200">
                    <i class="fa-solid fa-arrow-down fa-xl"></i>
                </div>

                <!-- Redis -->
                <div class="node-card bg-white p-4 rounded-xl border-2 border-gray-100 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-lg bg-red-100 text-red-600">
                            <i class="fa-solid fa-bolt-lightning"></i>
                        </div>
                        <h3 class="font-bold text-sm text-gray-800 uppercase">Redis Cluster</h3>
                    </div>
                    <p class="text-xs text-gray-500">Cache distribuido y broker de mensajes ultra rápido.</p>
                    <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 inline-block">In-Memory</span>
                </div>

                <div class="flex justify-center text-blue-200">
                    <i class="fa-solid fa-arrow-down fa-xl"></i>
                </div>

                <!-- Storage -->
                <div class="node-card bg-white p-4 rounded-xl border-2 border-gray-100 transition-all duration-300">
                    <div class="flex items-center gap-3 mb-2">
                        <div class="p-2 rounded-lg bg-cyan-100 text-cyan-600">
                            <i class="fa-solid fa-box-archive"></i>
                        </div>
                        <h3 class="font-bold text-sm text-gray-800 uppercase">S3 / Blob Storage</h3>
                    </div>
                    <p class="text-xs text-gray-500">Almacenamiento de archivos y documentos auditables.</p>
                    <span class="mt-2 text-[10px] font-semibold px-2 py-0.5 rounded-full bg-slate-100 text-slate-600 inline-block">Storage</span>
                </div>
            </div>

        </div>

        <!-- Section explaining the Senior approach -->
        <section class="mt-16 bg-white p-8 rounded-2xl shadow-sm border border-slate-200">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2 text-slate-800">
                <i class="fa-solid fa-circle-info text-blue-500"></i>
                Pilares de un Perfil Senior Backend
            </h2>
            <div class="grid md:grid-cols-3 gap-8 text-sm text-slate-600 leading-relaxed">
                <div class="bg-slate-50 p-5 rounded-xl border border-slate-100">
                    <h3 class="font-extrabold text-slate-800 mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-expand text-blue-400"></i>
                        Escalabilidad
                    </h3>
                    <p>Dominio de <strong>Laravel Octane</strong> y arquitecturas sin estado para escalar horizontalmente en la nube. Entender el cuello de botella del I/O es la diferencia entre un Junior y un Senior.</p>
                </div>
                <div class="bg-slate-50 p-5 rounded-xl border border-slate-100">
                    <h3 class="font-extrabold text-slate-800 mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-shield-virus text-emerald-400"></i>
                        Resiliencia
                    </h3>
                    <p>Implementación de colas (Queues) para procesos fallibles. El uso de <strong>Horizon</strong> garantiza que si una API externa falla, el sistema reintenta automáticamente sin afectar al usuario.</p>
                </div>
                <div class="bg-slate-50 p-5 rounded-xl border border-slate-100">
                    <h3 class="font-extrabold text-slate-800 mb-2 flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass-chart text-purple-400"></i>
                        Observabilidad
                    </h3>
                    <p>Un Senior no adivina; mide. El uso de <strong>Pulse</strong> y telemetría avanzada permite identificar queries lentos de MySQL o picos de CPU antes de que causen una caída del servicio.</p>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="mt-12 text-center text-slate-400 text-xs italic">
            Visualización técnica para perfiles de Ingeniería de Software Senior • 2024
        </footer>
    </div>

</body>

</html>