<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 leading-tight">Mis Postulaciones</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($postulaciones->isEmpty())
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <p class="text-gray-600 text-lg">Todavía no te postulaste a ninguna oferta.</p>
                    <a href="{{ route('candidato.ofertas.index') }}"
                       class="mt-4 inline-flex items-center px-4 py-2 bg-blue-700 text-white font-semibold rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Explorar ofertas
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($postulaciones as $postulacion)
                        @php
                            $pasos = ['pendiente', 'vista', 'aceptada'];
                            $esRechazada = $postulacion->estado === 'rechazada';
                            $pasoActual = $esRechazada ? -1 : array_search($postulacion->estado, $pasos);
                            $porcentaje = $esRechazada ? 100 : (($pasoActual + 1) / count($pasos)) * 100;
                        @endphp
                        <div class="bg-white shadow rounded-lg p-5">
                            <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-3">
                                <div class="flex-1">
                                    <h2 class="font-semibold text-gray-800">
                                        @if($postulacion->oferta->estado === 'activa')
                                            <a href="{{ route('candidato.ofertas.show', $postulacion->oferta) }}"
                                               class="text-blue-700 hover:underline focus:outline-none focus:underline">
                                                {{ $postulacion->oferta->titulo }}
                                            </a>
                                        @else
                                            {{ $postulacion->oferta->titulo }}
                                            <span class="text-sm text-gray-500">({{ $postulacion->oferta->estado }})</span>
                                        @endif
                                    </h2>
                                    <p class="text-sm text-gray-600">
                                        {{ $postulacion->oferta->empresa->empresaProfile->nombre_empresa ?? $postulacion->oferta->empresa->name }}
                                        &middot;
                                        {{ $postulacion->oferta->categoriaLaboral->nombre ?? '' }}
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">Postulación enviada {{ $postulacion->created_at->diffForHumans() }}</p>
                                </div>
                            </div>

                            {{-- Progress bar --}}
                            <div class="mt-4">
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
                                     aria-label="Estado de postulación: {{ ucfirst($postulacion->estado) }}">
                                    <div class="h-2.5 rounded-full transition-all duration-300
                                        {{ $esRechazada ? 'bg-red-500' : ($pasoActual >= 2 ? 'bg-green-500' : 'bg-blue-600') }}"
                                        style="width: {{ $porcentaje }}%"></div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $postulaciones->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
