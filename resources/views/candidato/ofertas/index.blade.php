<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 leading-tight">Ofertas de Empleo</h1>
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

            {{-- Recomendadas --}}
            @if($recomendadas->isNotEmpty())
            <section class="mb-6" aria-labelledby="recomendadas">
                <h2 id="recomendadas" class="text-lg font-semibold text-gray-800 mb-3">Recomendadas para vos</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($recomendadas as $rec)
                        <article class="bg-blue-50 border border-blue-200 rounded-lg p-5 flex flex-col">
                            <div class="flex justify-between items-start">
                                <h3 class="text-lg font-semibold text-gray-800">
                                    <a href="{{ route('candidato.ofertas.show', $rec) }}"
                                       class="text-blue-700 hover:underline focus:outline-none focus:underline">
                                        {{ $rec->titulo }}
                                    </a>
                                </h3>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800 whitespace-nowrap ml-2">
                                    {{ $rec->puntaje_match }}% match
                                </span>
                            </div>
                            <p class="text-sm text-gray-600 mt-1">
                                {{ $rec->empresa->empresaProfile->nombre_empresa ?? $rec->empresa->name }}
                            </p>
                            <div class="flex flex-wrap gap-2 mt-3">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-800">
                                    {{ $rec->categoriaLaboral->nombre ?? '' }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                    {{ ucfirst($rec->modalidad) }}
                                </span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-700">
                                    {{ $rec->departamento->nombre ?? '' }}
                                </span>
                            </div>
                            @if($rec->salario_visible && $rec->salarioFormateado())
                                <p class="text-sm font-medium text-green-700 mt-2">{{ $rec->salarioFormateado() }}</p>
                            @else
                                <p class="text-sm text-gray-500 mt-2">Salario a convenir</p>
                            @endif
                            <p class="text-sm text-gray-700 mt-2 line-clamp-2 flex-1">{{ Str::limit($rec->descripcion, 120) }}</p>
                        </article>
                    @endforeach
                </div>
            </section>
            @endif

            {{-- Resultados --}}
            @if($ofertas->isEmpty())
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <p class="text-gray-600 text-lg">No se encontraron ofertas con esos filtros.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    @foreach($ofertas as $oferta)
                        <article class="bg-white shadow rounded-lg p-5 flex flex-col">
                            <h2 class="text-lg font-semibold text-gray-800">
                                <a href="{{ route('candidato.ofertas.show', $oferta) }}"
                                   class="text-blue-700 hover:underline focus:outline-none focus:underline">
                                    {{ $oferta->titulo }}
                                </a>
                            </h2>
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
                            @if($oferta->salario_visible && $oferta->salarioFormateado())
                                <p class="text-sm font-medium text-green-700 mt-2">{{ $oferta->salarioFormateado() }}</p>
                            @elseif(!$oferta->salario_visible || (!$oferta->salario_min && !$oferta->salario_max))
                                <p class="text-sm text-gray-500 mt-2">Salario a convenir</p>
                            @endif
                            <p class="text-sm text-gray-700 mt-2 line-clamp-3 flex-1">{{ Str::limit($oferta->descripcion, 150) }}</p>
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
