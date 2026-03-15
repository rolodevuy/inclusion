<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $oferta->titulo }}</h2>
            <a href="{{ route('empresa.ofertas.edit', $oferta) }}"
               class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-sm text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Editar oferta
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Detalle de la oferta --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-wrap gap-3 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                        @if($oferta->estado === 'activa') bg-green-100 text-green-800
                        @elseif($oferta->estado === 'pausada') bg-yellow-100 text-yellow-800
                        @else bg-gray-100 text-gray-800 @endif">
                        {{ ucfirst($oferta->estado) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                        {{ $oferta->categoriaLaboral->nombre ?? 'Sin categoría' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                        {{ ucfirst($oferta->modalidad) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                        {{ $oferta->departamento->nombre ?? '' }}
                    </span>
                </div>

                @if($oferta->horario)
                    <p class="text-sm text-gray-600 mb-4"><strong>Horario:</strong> {{ $oferta->horario }}</p>
                @endif

                <div class="prose max-w-none">
                    <h3 class="text-lg font-semibold text-gray-800">Descripción</h3>
                    <p class="text-gray-700 whitespace-pre-line">{{ $oferta->descripcion }}</p>

                    @if($oferta->requisitos)
                        <h3 class="text-lg font-semibold text-gray-800 mt-4">Requisitos</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $oferta->requisitos }}</p>
                    @endif

                    @if($oferta->beneficios)
                        <h3 class="text-lg font-semibold text-gray-800 mt-4">Beneficios</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $oferta->beneficios }}</p>
                    @endif

                    @if($oferta->adaptaciones_disponibles)
                        <h3 class="text-lg font-semibold text-gray-800 mt-4">Adaptaciones disponibles</h3>
                        <p class="text-gray-700 whitespace-pre-line">{{ $oferta->adaptaciones_disponibles }}</p>
                    @endif
                </div>

                <p class="mt-4 text-sm text-gray-500">Publicada {{ $oferta->created_at->diffForHumans() }}</p>
            </div>

            {{-- Postulantes --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">
                    Postulantes ({{ $oferta->postulaciones->count() }})
                </h3>

                @if($oferta->postulaciones->isEmpty())
                    <p class="text-gray-500">Todavía no hay postulantes para esta oferta.</p>
                @else
                    <div class="space-y-4">
                        @foreach($oferta->postulaciones as $postulacion)
                            <div class="border border-gray-200 rounded-lg p-4">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                                    <div>
                                        <p class="font-semibold text-gray-800">
                                            <a href="{{ route('empresa.ofertas.postulacion.candidato', [$oferta, $postulacion]) }}"
                                               class="text-blue-700 hover:underline focus:outline-none focus:underline">
                                                {{ $postulacion->candidato->name }}
                                            </a>
                                        </p>
                                        @if($postulacion->candidato->candidatoProfile)
                                            <p class="text-sm text-gray-600">
                                                {{ $postulacion->candidato->candidatoProfile->categoriaLaboral->nombre ?? '' }}
                                                @if($postulacion->candidato->candidatoProfile->departamento)
                                                    &middot; {{ $postulacion->candidato->candidatoProfile->departamento->nombre }}
                                                @endif
                                            </p>
                                        @endif
                                        @if($postulacion->compartir_accesibilidad)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-green-100 text-green-700 mt-1">Compartió info de accesibilidad</span>
                                        @endif
                                        @if($postulacion->mensaje)
                                            <p class="mt-2 text-sm text-gray-700 italic">"{{ $postulacion->mensaje }}"</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">{{ $postulacion->created_at->diffForHumans() }}</p>
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium
                                            @if($postulacion->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                            @elseif($postulacion->estado === 'vista') bg-blue-100 text-blue-800
                                            @elseif($postulacion->estado === 'aceptada') bg-green-100 text-green-800
                                            @else bg-red-100 text-red-800 @endif">
                                            {{ ucfirst($postulacion->estado) }}
                                        </span>

                                        @if($postulacion->estado !== 'aceptada')
                                            <form method="POST" action="{{ route('empresa.ofertas.postulacion.estado', [$oferta, $postulacion]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado" value="aceptada">
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-green-600 text-white text-sm rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                                    Aceptar
                                                </button>
                                            </form>
                                        @endif

                                        @if($postulacion->estado !== 'rechazada')
                                            <form method="POST" action="{{ route('empresa.ofertas.postulacion.estado', [$oferta, $postulacion]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado" value="rechazada">
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                    Rechazar
                                                </button>
                                            </form>
                                        @endif

                                        @if($postulacion->estado === 'pendiente')
                                            <form method="POST" action="{{ route('empresa.ofertas.postulacion.estado', [$oferta, $postulacion]) }}">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="estado" value="vista">
                                                <button type="submit"
                                                    class="inline-flex items-center px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    Marcar vista
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Candidatos sugeridos --}}
            @if($sugeridos->isNotEmpty())
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-4">Candidatos sugeridos</h3>
                <div class="space-y-3">
                    @foreach($sugeridos as $perfil)
                        <div class="border border-gray-200 rounded-lg p-4 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                            <div>
                                <p class="font-semibold text-gray-800">
                                    <a href="{{ route('empresa.buscador.show', $perfil) }}"
                                       class="text-blue-700 hover:underline focus:outline-none focus:underline">
                                        {{ $perfil->user->name }}
                                    </a>
                                </p>
                                <p class="text-sm text-gray-600">
                                    {{ $perfil->categoriaLaboral->nombre ?? '' }}
                                    @if($perfil->departamento)
                                        &middot; {{ $perfil->departamento->nombre }}
                                    @endif
                                    &middot; {{ ucfirst($perfil->modalidad_trabajo) }}
                                </p>
                            </div>
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-green-100 text-green-800">
                                {{ $perfil->puntaje_match }}% match
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <div>
                <a href="{{ route('empresa.ofertas.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Volver a mis ofertas</a>
            </div>
        </div>
    </div>
</x-app-layout>
