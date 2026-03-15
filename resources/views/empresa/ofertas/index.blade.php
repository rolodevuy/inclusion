<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Mis Ofertas de Empleo</h2>
            <a href="{{ route('empresa.ofertas.create') }}"
               class="inline-flex items-center px-4 py-2 bg-blue-700 text-white font-semibold rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                + Nueva Oferta
            </a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if($ofertas->isEmpty())
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <p class="text-gray-600 text-lg">Todavía no publicaste ninguna oferta.</p>
                    <a href="{{ route('empresa.ofertas.create') }}"
                       class="mt-4 inline-flex items-center px-4 py-2 bg-blue-700 text-white font-semibold rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                        Publicar primera oferta
                    </a>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($ofertas as $oferta)
                        <div class="bg-white shadow rounded-lg p-6">
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                <div class="flex-1">
                                    <a href="{{ route('empresa.ofertas.show', $oferta) }}"
                                       class="text-lg font-semibold text-blue-700 hover:underline focus:outline-none focus:underline">
                                        {{ $oferta->titulo }}
                                    </a>
                                    <div class="mt-1 flex flex-wrap gap-2 text-sm text-gray-600">
                                        <span>{{ ucfirst($oferta->modalidad) }}</span>
                                        <span aria-hidden="true">&middot;</span>
                                        <span>{{ $oferta->created_at->diffForHumans() }}</span>
                                    </div>
                                </div>
                                <div class="flex items-center gap-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                                        @if($oferta->estado === 'activa') bg-green-100 text-green-800
                                        @elseif($oferta->estado === 'pausada') bg-yellow-100 text-yellow-800
                                        @else bg-gray-100 text-gray-800 @endif">
                                        {{ ucfirst($oferta->estado) }}
                                    </span>
                                    <span class="text-sm text-gray-600">
                                        {{ $oferta->postulaciones_count }} {{ $oferta->postulaciones_count === 1 ? 'postulante' : 'postulantes' }}
                                    </span>
                                    <a href="{{ route('empresa.ofertas.edit', $oferta) }}"
                                       class="text-sm text-blue-700 hover:underline focus:outline-none focus:underline">
                                        Editar
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $ofertas->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
