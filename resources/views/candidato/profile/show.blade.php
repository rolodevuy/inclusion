<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">Mi perfil profesional</h1>
            <a href="{{ route('candidato.perfil.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-700 text-white font-medium rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Editar perfil
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <!-- Info básica -->
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="info-basica">
                <h2 id="info-basica" class="text-lg font-semibold text-gray-900 mb-4">Información básica</h2>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd class="text-base text-gray-900">{{ auth()->user()->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Departamento</dt>
                        <dd class="text-base text-gray-900">{{ $profile->departamento->nombre }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Área laboral</dt>
                        <dd class="text-base text-gray-900">{{ $profile->categoriaLaboral->nombre }}</dd>
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

            <!-- Habilidades -->
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

            <!-- Experiencia -->
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="experiencia">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="experiencia" class="text-lg font-semibold text-gray-900">Experiencia laboral</h2>
                    <a href="{{ route('candidato.experiencias.create') }}" class="text-blue-700 hover:text-blue-800 font-medium focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 rounded-md px-2 py-1">
                        + Agregar
                    </a>
                </div>
                @forelse($profile->experiencias as $exp)
                    <div class="border-b border-gray-200 pb-4 mb-4 last:border-0 last:pb-0 last:mb-0">
                        <div class="flex justify-between items-start">
                            <div>
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
                            <div class="flex gap-2">
                                <a href="{{ route('candidato.experiencias.edit', $exp) }}" class="text-sm text-blue-700 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded">Editar</a>
                                <form method="POST" action="{{ route('candidato.experiencias.destroy', $exp) }}" onsubmit="return confirm('¿Eliminar esta experiencia?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 rounded">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No tenés experiencias cargadas todavía.</p>
                @endforelse
            </section>

            <!-- Info accesibilidad (solo para el candidato) -->
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="accesibilidad-info">
                <h2 id="accesibilidad-info" class="text-lg font-semibold text-gray-900 mb-4">Información de accesibilidad</h2>
                <dl class="space-y-3">
                    @if($profile->tipo_discapacidad)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tipo de discapacidad</dt>
                        <dd class="text-base text-gray-900">{{ $profile->tipo_discapacidad }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Certificado de discapacidad</dt>
                        <dd class="text-base text-gray-900">{{ $profile->tiene_certificado ? 'Sí' : 'No' }}</dd>
                    </div>
                    @if($profile->certificado_path)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Estado de verificación</dt>
                        <dd class="text-base">
                            @switch($profile->certificado_estado)
                                @case('pendiente')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">Pendiente de verificación</span>
                                    @break
                                @case('verificado')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-green-100 text-green-800">Verificado</span>
                                    @break
                                @case('rechazado')
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-sm font-medium bg-red-100 text-red-800">Rechazado</span>
                                    @if($profile->certificado_observaciones)
                                        <p class="text-sm text-red-600 mt-1">{{ $profile->certificado_observaciones }}</p>
                                    @endif
                                    @break
                            @endswitch
                        </dd>
                    </div>
                    @endif
                    @if($profile->necesidades_adaptacion)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Necesidades de adaptación</dt>
                        <dd class="text-base text-gray-900">{{ $profile->necesidades_adaptacion }}</dd>
                    </div>
                    @endif
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Visibilidad</dt>
                        <dd class="text-base text-gray-900">
                            @switch($profile->visibilidad_discapacidad)
                                @case('publica') Pública @break
                                @case('bajo_solicitud') Bajo solicitud @break
                                @case('privada') Privada @break
                            @endswitch
                        </dd>
                    </div>
                </dl>
            </section>

        </div>
    </div>
</x-app-layout>
