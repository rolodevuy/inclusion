<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ $oferta->titulo }}</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info de la empresa --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-800 mb-2">Empresa</h3>
                <p class="text-gray-700 font-medium">
                    {{ $oferta->empresa->empresaProfile->nombre_empresa ?? $oferta->empresa->name }}
                </p>
                @if($oferta->empresa->empresaProfile)
                    @if($oferta->empresa->empresaProfile->sector)
                        <p class="text-sm text-gray-600">Sector: {{ $oferta->empresa->empresaProfile->sector }}</p>
                    @endif
                    @if($oferta->empresa->empresaProfile->descripcion)
                        <p class="text-sm text-gray-600 mt-1">{{ Str::limit($oferta->empresa->empresaProfile->descripcion, 200) }}</p>
                    @endif
                @endif
            </div>

            {{-- Detalle de la oferta --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-wrap gap-3 mb-4">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-800">
                        {{ $oferta->categoriaLaboral->nombre ?? '' }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                        {{ ucfirst($oferta->modalidad) }}
                    </span>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                        {{ $oferta->departamento->nombre ?? '' }}
                    </span>
                    @if($oferta->horario)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-700">
                            {{ $oferta->horario }}
                        </span>
                    @endif
                </div>

                <h3 class="text-lg font-semibold text-gray-800">Descripción</h3>
                <p class="text-gray-700 whitespace-pre-line mt-1">{{ $oferta->descripcion }}</p>

                @if($oferta->requisitos)
                    <h3 class="text-lg font-semibold text-gray-800 mt-4">Requisitos</h3>
                    <p class="text-gray-700 whitespace-pre-line mt-1">{{ $oferta->requisitos }}</p>
                @endif

                @if($oferta->beneficios)
                    <h3 class="text-lg font-semibold text-gray-800 mt-4">Beneficios</h3>
                    <p class="text-gray-700 whitespace-pre-line mt-1">{{ $oferta->beneficios }}</p>
                @endif

                @if($oferta->adaptaciones_disponibles)
                    <h3 class="text-lg font-semibold text-gray-800 mt-4">Adaptaciones disponibles</h3>
                    <p class="text-gray-700 whitespace-pre-line mt-1">{{ $oferta->adaptaciones_disponibles }}</p>
                @endif

                <p class="mt-4 text-sm text-gray-500">Publicada {{ $oferta->created_at->diffForHumans() }}</p>
            </div>

            {{-- Postulación --}}
            <div class="bg-white shadow rounded-lg p-6">
                @if($postulacionExistente)
                    <div class="flex items-center gap-3">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($postulacionExistente->estado === 'pendiente') bg-yellow-100 text-yellow-800
                            @elseif($postulacionExistente->estado === 'vista') bg-blue-100 text-blue-800
                            @elseif($postulacionExistente->estado === 'aceptada') bg-green-100 text-green-800
                            @else bg-red-100 text-red-800 @endif">
                            {{ ucfirst($postulacionExistente->estado) }}
                        </span>
                        <p class="text-gray-700">Ya te postulaste a esta oferta ({{ $postulacionExistente->created_at->diffForHumans() }}).</p>
                    </div>
                @else
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Postularte a esta oferta</h3>
                    <form method="POST" action="{{ route('candidato.postulaciones.store', $oferta) }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="mensaje" value="Mensaje (opcional)" />
                            <textarea id="mensaje" name="mensaje" rows="3" maxlength="2000"
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base"
                                placeholder="Contale a la empresa por qué te interesa este puesto...">{{ old('mensaje') }}</textarea>
                            <x-input-error :messages="$errors->get('mensaje')" class="mt-2" />
                        </div>
                        <x-primary-button>Enviar postulación</x-primary-button>
                    </form>
                @endif
            </div>

            <div>
                <a href="{{ route('candidato.ofertas.index') }}" class="text-sm text-blue-700 hover:underline">&larr; Volver a ofertas</a>
            </div>
        </div>
    </div>
</x-app-layout>
