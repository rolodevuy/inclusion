<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">Perfil de candidato</h1>
            <a href="{{ route('empresa.buscador.index') }}" class="text-blue-700 hover:text-blue-800 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md px-2 py-1">
                Volver al buscador
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Info básica -->
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="info-candidato">
                <h2 id="info-candidato" class="text-lg font-semibold text-gray-900 mb-4">{{ $candidato->user->name }}</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                        <dd class="text-base text-gray-900">{{ $candidato->departamento->nombre }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Área laboral</dt>
                        <dd class="text-base text-gray-900">{{ $candidato->categoriaLaboral->nombre }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Modalidad</dt>
                        <dd class="text-base text-gray-900">{{ ucfirst($candidato->modalidad_trabajo) }}</dd>
                    </div>
                    @if($candidato->nivel_educativo)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nivel educativo</dt>
                        <dd class="text-base text-gray-900">{{ $candidato->nivel_educativo }}</dd>
                    </div>
                    @endif
                </dl>
                @if($candidato->sobre_mi)
                    <div class="mt-4">
                        <dt class="text-sm font-medium text-gray-500">Sobre el candidato</dt>
                        <dd class="text-base text-gray-900 mt-1">{{ $candidato->sobre_mi }}</dd>
                    </div>
                @endif
            </section>

            <!-- Habilidades -->
            @if($candidato->habilidades->count())
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="hab-candidato">
                <h2 id="hab-candidato" class="text-lg font-semibold text-gray-900 mb-4">Habilidades</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($candidato->habilidades as $hab)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">{{ $hab->nombre }}</span>
                    @endforeach
                </div>
            </section>
            @endif

            <!-- Experiencia -->
            @if($candidato->experiencias->count())
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="exp-candidato">
                <h2 id="exp-candidato" class="text-lg font-semibold text-gray-900 mb-4">Experiencia laboral</h2>
                @foreach($candidato->experiencias as $exp)
                    <div class="border-b border-gray-200 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                        <h3 class="font-medium text-gray-900">{{ $exp->cargo }}</h3>
                        <p class="text-gray-600">{{ $exp->empresa }}</p>
                        <p class="text-sm text-gray-500">
                            {{ $exp->fecha_inicio->format('m/Y') }} —
                            {{ $exp->fecha_fin ? $exp->fecha_fin->format('m/Y') : 'Actualidad' }}
                        </p>
                        @if($exp->descripcion)
                            <p class="text-gray-700 mt-1">{{ $exp->descripcion }}</p>
                        @endif
                    </div>
                @endforeach
            </section>
            @endif

            <!-- Accesibilidad (según visibilidad) -->
            @if($candidato->visibilidad_discapacidad === 'publica' && $candidato->tipo_discapacidad)
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="acc-candidato">
                <h2 id="acc-candidato" class="text-lg font-semibold text-gray-900 mb-4">Información de accesibilidad</h2>
                <dl class="space-y-3">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tipo de discapacidad</dt>
                        <dd class="text-base text-gray-900">{{ $candidato->tipo_discapacidad }}</dd>
                    </div>
                    @if($candidato->necesidades_adaptacion)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Necesidades de adaptación</dt>
                        <dd class="text-base text-gray-900">{{ $candidato->necesidades_adaptacion }}</dd>
                    </div>
                    @endif
                </dl>
            </section>
            @elseif($candidato->visibilidad_discapacidad === 'bajo_solicitud')
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="acc-solicitud">
                <h2 id="acc-solicitud" class="text-lg font-semibold text-gray-900 mb-4">Información de accesibilidad</h2>

                @if($solicitud && $solicitud->estado === 'aprobada')
                    {{-- Solicitud aprobada: mostrar la info --}}
                    <div class="rounded-md bg-green-50 p-3 mb-4" role="status">
                        <p class="text-green-700 text-sm">Solicitud aprobada por el candidato.</p>
                    </div>
                    <dl class="space-y-3">
                        @if($candidato->tipo_discapacidad)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo de discapacidad</dt>
                            <dd class="text-base text-gray-900">{{ $candidato->tipo_discapacidad }}</dd>
                        </div>
                        @endif
                        @if($candidato->tiene_certificado !== null)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Certificado de discapacidad</dt>
                            <dd class="text-base text-gray-900">{{ $candidato->tiene_certificado ? 'Sí' : 'No' }}</dd>
                        </div>
                        @endif
                        @if($candidato->necesidades_adaptacion)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Necesidades de adaptación</dt>
                            <dd class="text-base text-gray-900">{{ $candidato->necesidades_adaptacion }}</dd>
                        </div>
                        @endif
                    </dl>

                @elseif($solicitud && $solicitud->estado === 'pendiente')
                    {{-- Solicitud pendiente --}}
                    <div class="rounded-md bg-yellow-50 p-4" role="status">
                        <p class="text-yellow-800">Tu solicitud fue enviada el {{ $solicitud->created_at->format('d/m/Y') }} y está pendiente de aprobación por el candidato.</p>
                    </div>

                @elseif($solicitud && $solicitud->estado === 'rechazada')
                    {{-- Solicitud rechazada: permitir reintento --}}
                    <div class="rounded-md bg-red-50 p-4 mb-4" role="status">
                        <p class="text-red-700">Tu solicitud anterior fue rechazada. Podés volver a solicitar acceso.</p>
                    </div>

                    <form method="POST" action="{{ route('empresa.solicitud.store', $candidato) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="mensaje" class="block text-base font-medium text-gray-900">Mensaje (opcional)</label>
                            <textarea id="mensaje" name="mensaje" rows="2"
                                      class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Contale al candidato por qué solicitás esta información..." maxlength="500">{{ old('mensaje') }}</textarea>
                            <x-input-error :messages="$errors->get('mensaje')" class="mt-2" />
                        </div>
                        <x-primary-button>Volver a solicitar</x-primary-button>
                    </form>

                @else
                    {{-- Sin solicitud: mostrar formulario --}}
                    <p class="text-gray-600 mb-4">Este candidato tiene información de accesibilidad disponible bajo solicitud. Podés pedir acceso y el candidato decidirá si compartirla.</p>

                    <form method="POST" action="{{ route('empresa.solicitud.store', $candidato) }}" class="space-y-4">
                        @csrf
                        <div>
                            <label for="mensaje" class="block text-base font-medium text-gray-900">Mensaje (opcional)</label>
                            <textarea id="mensaje" name="mensaje" rows="2"
                                      class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Contale al candidato por qué solicitás esta información..." maxlength="500">{{ old('mensaje') }}</textarea>
                            <x-input-error :messages="$errors->get('mensaje')" class="mt-2" />
                        </div>
                        <x-primary-button>Solicitar información de accesibilidad</x-primary-button>
                    </form>
                @endif
            </section>
            @endif

        </div>
    </div>
</x-app-layout>
