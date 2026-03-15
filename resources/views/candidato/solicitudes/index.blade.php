<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Solicitudes de acceso</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <p class="text-gray-600 mb-6">
                Las empresas pueden solicitar acceso a tu información de accesibilidad. Acá podés aprobar o rechazar cada solicitud.
            </p>

            @forelse($solicitudes as $solicitud)
                <article class="bg-white shadow rounded-lg p-6 mb-4">
                    <div class="flex flex-col sm:flex-row sm:justify-between sm:items-start gap-4">
                        <div>
                            <h2 class="text-lg font-semibold text-gray-900">
                                <a href="{{ route('candidato.empresa.ver', $solicitud->empresa) }}"
                                   class="text-blue-700 hover:underline focus:outline-none focus:underline">
                                    {{ $solicitud->empresa->name }}
                                </a>
                            </h2>
                            @if($solicitud->empresa->empresaProfile)
                                <p class="text-gray-600">{{ $solicitud->empresa->empresaProfile->sector }} — {{ $solicitud->empresa->empresaProfile->departamento->nombre ?? '' }}</p>
                            @endif
                            <p class="text-sm text-gray-500 mt-1">
                                Recibida el {{ $solicitud->created_at->format('d/m/Y H:i') }}
                            </p>
                            @if($solicitud->mensaje)
                                <div class="mt-3 bg-gray-50 rounded-md p-3">
                                    <p class="text-sm font-medium text-gray-500 mb-1">Mensaje de la empresa:</p>
                                    <p class="text-gray-700">{{ $solicitud->mensaje }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="flex items-center gap-2 shrink-0">
                            @if($solicitud->estado === 'pendiente')
                                <form method="POST" action="{{ route('candidato.solicitudes.aprobar', $solicitud) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-green-600 text-white text-sm font-medium rounded-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                                        Aprobar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('candidato.solicitudes.rechazar', $solicitud) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-red-600 text-white text-sm font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                        Rechazar
                                    </button>
                                </form>
                            @elseif($solicitud->estado === 'aprobada')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    Aprobada
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    Rechazada
                                </span>
                            @endif
                        </div>
                    </div>
                </article>
            @empty
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <p class="text-gray-500 text-lg">No tenés solicitudes de acceso.</p>
                    <p class="text-gray-400 mt-2">Cuando una empresa solicite ver tu información de accesibilidad, aparecerá acá.</p>
                </div>
            @endforelse

        </div>
    </div>
</x-app-layout>
