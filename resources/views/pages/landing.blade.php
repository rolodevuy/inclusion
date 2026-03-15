<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inclusión Laboral — Conectando talento con oportunidades</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-white">
    <a href="#main-content"
       class="sr-only focus:not-sr-only focus:absolute focus:top-4 focus:left-4 focus:bg-white focus:px-4 focus:py-2 focus:z-50 focus:rounded-md focus:shadow-lg focus:text-blue-700 focus:outline-2 focus:outline-offset-2 focus:outline-blue-600">
        Ir al contenido principal
    </a>

    <!-- Header -->
    <header class="bg-white shadow-sm">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex justify-between items-center h-16" aria-label="Navegación principal">
            <span class="text-xl font-bold text-blue-700">Inclusión Laboral</span>
            <div class="flex gap-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="text-base font-medium text-gray-700 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md px-3 py-2">
                        Ir al panel
                    </a>
                @else
                    <a href="{{ route('login') }}" class="text-base font-medium text-gray-700 hover:text-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md px-3 py-2">
                        Iniciar sesión
                    </a>
                    <a href="{{ route('register') }}" class="inline-flex items-center px-4 py-2 bg-blue-700 text-white font-medium rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Registrarse
                    </a>
                @endauth
            </div>
        </nav>
    </header>

    <main id="main-content">
        <!-- Hero -->
        <section class="bg-blue-700 text-white py-20">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <h1 class="text-3xl sm:text-4xl font-bold mb-6">
                    Conectamos talento con oportunidades
                </h1>
                <p class="text-lg sm:text-xl mb-8 text-blue-100">
                    Plataforma inclusiva de intermediación laboral para personas con discapacidad en Uruguay.
                    Tus habilidades son lo que importa.
                </p>
                <div class="flex flex-col sm:flex-row gap-4 justify-center">
                    <a href="{{ route('register') }}?role=candidato" class="inline-flex items-center justify-center px-6 py-3 bg-white text-blue-700 font-semibold rounded-md hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-700 text-lg">
                        Busco empleo
                    </a>
                    <a href="{{ route('register') }}?role=empresa" class="inline-flex items-center justify-center px-6 py-3 bg-blue-600 text-white font-semibold rounded-md border-2 border-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-white focus:ring-offset-2 focus:ring-offset-blue-700 text-lg">
                        Soy empresa
                    </a>
                </div>
            </div>
        </section>

        <!-- Beneficios candidatos -->
        <section class="py-16 bg-white" aria-labelledby="beneficios-candidatos">
            <div class="max-w-6xl mx-auto px-4">
                <h2 id="beneficios-candidatos" class="text-2xl font-bold text-gray-900 text-center mb-10">
                    Para personas que buscan empleo
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Mostrá tus habilidades</h3>
                        <p class="text-gray-600">Creá tu perfil profesional destacando lo que sabés hacer. Tus capacidades son el centro.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Controlá tu privacidad</h3>
                        <p class="text-gray-600">Decidí qué información compartir y con quién. Tu condición es tu decisión.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                            <svg class="w-8 h-8 text-blue-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Acceso gratuito</h3>
                        <p class="text-gray-600">La plataforma es y será siempre gratuita para personas que buscan empleo.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Beneficios empresas -->
        <section class="py-16 bg-gray-50" aria-labelledby="beneficios-empresas">
            <div class="max-w-6xl mx-auto px-4">
                <h2 id="beneficios-empresas" class="text-2xl font-bold text-gray-900 text-center mb-10">
                    Para empresas
                </h2>
                <div class="grid md:grid-cols-3 gap-8">
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Encontrá talento diverso</h3>
                        <p class="text-gray-600">Accedé a un directorio de candidatos con habilidades verificadas y perfiles profesionales.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Cumplí con la inclusión</h3>
                        <p class="text-gray-600">Facilitamos el cumplimiento de políticas y cuotas de inclusión laboral.</p>
                    </div>
                    <div class="text-center p-6">
                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4" aria-hidden="true">
                            <svg class="w-8 h-8 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Contratación ética</h3>
                        <p class="text-gray-600">Un entorno transparente y respetuoso para conectar con candidatos.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Accesibilidad -->
        <section class="py-16 bg-white" aria-labelledby="accesibilidad-info">
            <div class="max-w-3xl mx-auto px-4 text-center">
                <h2 id="accesibilidad-info" class="text-2xl font-bold text-gray-900 mb-4">
                    Plataforma accesible
                </h2>
                <p class="text-gray-600 text-lg">
                    Este sitio fue diseñado siguiendo los estándares de accesibilidad WCAG 2.1 nivel AA.
                    Es compatible con lectores de pantalla, navegación por teclado y cumple con los ratios de contraste recomendados.
                </p>
            </div>
        </section>
    </main>

    <footer class="bg-gray-900 text-gray-300 py-8">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p class="text-base">Inclusión Laboral — Uruguay</p>
            <p class="text-sm mt-2">Plataforma de intermediación laboral inclusiva</p>
        </div>
    </footer>
</body>
</html>
