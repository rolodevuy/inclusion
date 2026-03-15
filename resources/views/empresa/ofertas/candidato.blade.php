<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 leading-tight">
            Perfil de {{ $candidato->name }}
        </h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Contexto de la postulación --}}
            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                <p class="text-sm text-blue-800">
                    Postulación a <strong>{{ $oferta->titulo }}</strong>
                    &middot;
                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                        @if($postulacion->estado === 'pendiente') bg-yellow-100 text-yellow-800
                        @elseif($postulacion->estado === 'vista') bg-blue-100 text-blue-800
                        @elseif($postulacion->estado === 'aceptada') bg-green-100 text-green-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($postulacion->estado) }}
                    </span>
                    &middot;
                    {{ $postulacion->created_at->diffForHumans() }}
                </p>
                @if($postulacion->mensaje)
                    <p class="text-sm text-blue-700 mt-2 italic">"{{ $postulacion->mensaje }}"</p>
                @endif
            </div>

            {{-- Info básica --}}
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="info-basica">
                <h2 id="info-basica" class="text-lg font-semibold text-gray-900 mb-4">Información profesional</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd class="text-base text-gray-900">{{ $candidato->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                        <dd class="text-base text-gray-900">{{ $profile->departamento->nombre ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Área laboral</dt>
                        <dd class="text-base text-gray-900">{{ $profile->categoriaLaboral->nombre ?? '—' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Modalidad de trabajo</dt>
                        <dd class="text-base text-gray-900">{{ ucfirst($profile->modalidad_trabajo) }}</dd>
                    </div>
                    @if($profile->nivel_educativo)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nivel educativo</dt>
                        <dd class="text-base text-gray-900">{{ $profile->nivel_educativo }}</dd>
                    </div>
                    @endif
                </dl>
                @if($profile->sobre_mi)
                    <div class="mt-4">
                        <dt class="text-sm font-medium text-gray-500">Sobre mí</dt>
                        <dd class="text-base text-gray-900 mt-1">{{ $profile->sobre_mi }}</dd>
                    </div>
                @endif
            </section>

            {{-- Habilidades --}}
            @if($profile->habilidades->count())
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="habilidades">
                <h2 id="habilidades" class="text-lg font-semibold text-gray-900 mb-4">Habilidades</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($profile->habilidades as $hab)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800">
                            {{ $hab->nombre }}
                        </span>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Experiencia --}}
            @if($profile->experiencias->count())
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="experiencia">
                <h2 id="experiencia" class="text-lg font-semibold text-gray-900 mb-4">Experiencia laboral</h2>
                @foreach($profile->experiencias as $exp)
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

            {{-- Información de accesibilidad --}}
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="accesibilidad">
                <h2 id="accesibilidad" class="text-lg font-semibold text-gray-900 mb-4">Información de accesibilidad</h2>

                @if($puedeVerAccesibilidad)
                    <dl class="space-y-3">
                        @if($profile->tipo_discapacidad)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Tipo de discapacidad</dt>
                            <dd class="text-base text-gray-900">{{ $profile->tipo_discapacidad }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Certificado</dt>
                            <dd class="text-base text-gray-900">
                                {{ $profile->tiene_certificado ? 'Sí' : 'No' }}
                                @if($profile->certificado_estado === 'verificado')
                                    <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 ml-1">Verificado</span>
                                @endif
                            </dd>
                        </div>
                        @if($profile->necesidades_adaptacion)
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Necesidades de adaptación</dt>
                            <dd class="text-base text-gray-900">{{ $profile->necesidades_adaptacion }}</dd>
                        </div>
                        @endif
                    </dl>
                @else
                    <div class="text-center py-4">
                        <p class="text-gray-500">
                            El candidato no compartió su información de accesibilidad para esta postulación.
                        </p>
                        @if($profile->visibilidad_discapacidad === 'bajo_solicitud')
                            <p class="text-sm text-gray-500 mt-1">
                                Podés solicitar acceso desde el
                                <a href="{{ route('empresa.buscador.show', $profile) }}" class="text-blue-700 hover:underline">buscador de candidatos</a>.
                            </p>
                        @endif
                    </div>
                @endif
            </section>

            {{-- Acciones --}}
            <div class="bg-white shadow rounded-lg p-6">
                <div class="flex flex-wrap items-center gap-3">
                    @if($postulacion->estado !== 'aceptada')
                        <form method="POST" action="{{ route('empresa.ofertas.postulacion.estado', [$oferta, $postulacion]) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="estado" value="aceptada">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white font-semibold rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                Aceptar postulación
                            </button>
                        </form>
                    @endif

                    @if($postulacion->estado !== 'rechazada')
                        <form method="POST" action="{{ route('empresa.ofertas.postulacion.estado', [$oferta, $postulacion]) }}">
                            @csrf
                            @method('PATCH')
                            <input type="hidden" name="estado" value="rechazada">
                            <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white font-semibold rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Rechazar postulación
                            </button>
                        </form>
                    @endif

                    <a href="{{ route('empresa.ofertas.show', $oferta) }}" class="text-sm text-blue-700 hover:underline">&larr; Volver a la oferta</a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
