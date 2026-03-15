<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Ofertas de Empleo</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtros --}}
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('candidato.ofertas.index') }}" role="search" aria-label="Filtrar ofertas">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
                        <div>
                            <x-input-label for="buscar" value="Buscar" />
                            <x-text-input id="buscar" name="buscar" type="search" class="mt-1 block w-full"
                                :value="request('buscar')" placeholder="Título o descripción" />
                        </div>

                        <div>
                            <x-input-label for="categoria" value="Categoría" />
                            <select id="categoria" name="categoria"
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">
                                <option value="">Todas</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" @selected(request('categoria') == $cat->id)>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="departamento" value="Departamento" />
                            <select id="departamento" name="departamento"
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">
                                <option value="">Todos</option>
                                @foreach($departamentos as $dep)
                                    <option value="{{ $dep->id }}" @selected(request('departamento') == $dep->id)>{{ $dep->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <x-input-label for="modalidad" value="Modalidad" />
                            <select id="modalidad" name="modalidad"
                                class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">
                                <option value="">Todas</option>
                                <option value="presencial" @selected(request('modalidad') === 'presencial')>Presencial</option>
                                <option value="remoto" @selected(request('modalidad') === 'remoto')>Remoto</option>
                                <option value="hibrido" @selected(request('modalidad') === 'hibrido')>Híbrido</option>
                            </select>
                        </div>

                        <div class="flex items-end">
                            <x-primary-button class="w-full justify-center">Buscar</x-primary-button>
                        </div>
                    </div>
                </form>
            </div>

            {{-- Resultados --}}
            @if($ofertas->isEmpty())
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <p class="text-gray-600 text-lg">No se encontraron ofertas con esos filtros.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($ofertas as $oferta)
                        <article class="bg-white shadow rounded-lg p-5 flex flex-col">
                            <h3 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('candidato.ofertas.show', $oferta) }}"
                                   class="text-blue-700 hover:underline focus:outline-none focus:underline">
                                    {{ $oferta->titulo }}
                                </a>
                            </h3>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $oferta->empresa->empresaProfile->nombre_empresa ?? $oferta->empresa->name }}
                            </p>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-800">
                                    {{ $oferta->categoriaLaboral->nombre ?? '' }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                    {{ ucfirst($oferta->modalidad) }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                    {{ $oferta->departamento->nombre ?? '' }}
                                </span>
                            </div>
                            <p class="text-sm text-gray-700 mt-3 line-clamp-3 flex-1">{{ Str::limit($oferta->descripcion, 150) }}</p>
                            <p class="text-xs text-gray-500 mt-3">{{ $oferta->created_at->diffForHumans() }}</p>
                        </article>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $ofertas->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
