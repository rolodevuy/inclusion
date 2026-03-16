<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 leading-tight">{{ $oferta->titulo }}</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info de la empresa --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-2">Empresa</h2>
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
                    @if($oferta->salario_visible && $oferta->salarioFormateado())
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-green-100 text-green-800 font-medium">
                            {{ $oferta->salarioFormateado() }}
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm bg-gray-100 text-gray-600">
                            Salario a convenir
                        </span>
                    @endif
                </div>

                <h2 class="text-lg font-semibold text-gray-800">Descripción</h2>
                <p class="text-gray-700 whitespace-pre-line mt-1">{{ $oferta->descripcion }}</p>

                @if($oferta->requisitos)
                    <h2 class="text-lg font-semibold text-gray-800 mt-4">Requisitos</h2>
                    <p class="text-gray-700 whitespace-pre-line mt-1">{{ $oferta->requisitos }}</p>
                @endif

                @if($oferta->beneficios)
                    <h2 class="text-lg font-semibold text-gray-800 mt-4">Beneficios</h2>
                    <p class="text-gray-700 whitespace-pre-line mt-1">{{ $oferta->beneficios }}</p>
                @endif

                @if($oferta->adaptaciones_disponibles)
                    <h2 class="text-lg font-semibold text-gray-800 mt-4">Adaptaciones disponibles</h2>
                    <p class="text-gray-700 whitespace-pre-line mt-1">{{ $oferta->adaptaciones_disponibles }}</p>
                @endif

                <p class="mt-4 text-sm text-gray-500">Publicada {{ $oferta->created_at->diffForHumans() }}</p>
            </div>

            {{-- Postulación --}}
            <div class="bg-white shadow rounded-lg p-6">
                @if($postulacionExistente)
                    @php
                        $pasos = ['pendiente', 'vista', 'aceptada'];
                        $esRechazada = $postulacionExistente->estado === 'rechazada';
                        $pasoActual = $esRechazada ? -1 : array_search($postulacionExistente->estado, $pasos);
                        $porcentaje = $esRechazada ? 100 : (($pasoActual + 1) / count($pasos)) * 100;
                    @endphp
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Estado de tu postulación</h2>
                    <p class="text-gray-700 mb-3">Te postulaste {{ $postulacionExistente->created_at->diffForHumans() }}.</p>
                    <div>
                        <div class="flex justify-between text-xs font-medium mb-1" aria-hidden="true">
                            <span class="{{ $pasoActual >= 0 && !$esRechazada ? 'text-blue-700' : ($esRechazada ? 'text-red-600' : 'text-gray-400') }}">Enviada</span>
                            <span class="{{ $pasoActual >= 1 && !$esRechazada ? 'text-blue-700' : ($esRechazada ? 'text-red-600' : 'text-gray-400') }}">Vista</span>
                            @if($esRechazada)
                                <span class="text-red-600">Rechazada</span>
                            @else
                                <span class="{{ $pasoActual >= 2 ? 'text-green-700' : 'text-gray-400' }}">Aceptada</span>
                            @endif
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5" role="progressbar"
                             aria-valuenow="{{ round($porcentaje) }}"
                             aria-valuemin="0" aria-valuemax="100"
                             aria-label="Estado de postulación: {{ ucfirst($postulacionExistente->estado) }}">
                            <div class="h-2.5 rounded-full transition-all duration-300
                                {{ $esRechazada ? 'bg-red-500' : ($pasoActual >= 2 ? 'bg-green-500' : 'bg-blue-600') }}"
                                style="width: {{ $porcentaje }}%"></div>
                        </div>
                    </div>
                @else
                    <h2 class="text-lg font-semibold text-gray-800 mb-3">Postularte a esta oferta</h2>
                    <form method="POST" action="{{ route('candidato.postulaciones.store', $oferta) }}">
                        @csrf
                        <div class="mb-4">
                            <x-input-label for="mensaje" value="Mensaje (opcional)" />
                            <textarea id="mensaje" name="mensaje" rows="3" maxlength="2000"
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base"
                                placeholder="Contale a la empresa por qué te interesa este puesto...">{{ old('mensaje') }}</textarea>
                            <x-input-error :messages="$errors->get('mensaje')" class="mt-2" />
                        </div>

                        @if(auth()->user()->candidatoProfile && auth()->user()->candidatoProfile->tipo_discapacidad)
                        <div class="mb-4 p-4 bg-blue-50 rounded-lg border border-blue-200">
                            <label class="flex items-start gap-3 cursor-pointer">
                                <input type="checkbox" name="compartir_accesibilidad" value="1"
                                       {{ old('compartir_accesibilidad') ? 'checked' : '' }}
                                       class="mt-0.5 rounded text-blue-600 focus:ring-blue-500">
                                <div>
                                    <span class="text-base font-medium text-gray-800">Compartir mi información de accesibilidad con esta empresa</span>
                                    <p class="text-sm text-gray-600 mt-1">
                                        Si marcás esta opción, la empresa podrá ver tu información de accesibilidad (tipo de discapacidad, certificado, adaptaciones) mientras tu postulación esté activa.
                                        Si tu postulación es rechazada, el acceso se revoca automáticamente.
                                    </p>
                                </div>
                            </label>
                        </div>
                        @endif

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
