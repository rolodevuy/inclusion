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
                        <div class="bg-white shadow rounded-lg p-5">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
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
                                <div>
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($postulacion->estado === 'pendiente') bg-yellow-100 text-yellow-800
                                        @elseif($postulacion->estado === 'vista') bg-blue-100 text-blue-800
                                        @elseif($postulacion->estado === 'aceptada') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($postulacion->estado) }}
                                    </span>
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
