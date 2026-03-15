<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Buscar candidatos</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filtros -->
            <form method="GET" action="{{ route('empresa.buscador.index') }}" class="bg-white shadow rounded-lg p-6 mb-6">
                <fieldset>
                    <legend class="text-lg font-semibold text-gray-900 mb-4">Filtros de búsqueda</legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        <div>
                            <label for="departamento_id" class="block text-sm font-medium text-gray-700">Departamento</label>
                            <select id="departamento_id" name="departamento_id" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todos</option>
                                @foreach($departamentos as $dep)
                                    <option value="{{ $dep->id }}" {{ request('departamento_id') == $dep->id ? 'selected' : '' }}>{{ $dep->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="categoria_laboral_id" class="block text-sm font-medium text-gray-700">Área laboral</label>
                            <select id="categoria_laboral_id" name="categoria_laboral_id" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todas</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ request('categoria_laboral_id') == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="modalidad_trabajo" class="block text-sm font-medium text-gray-700">Modalidad</label>
                            <select id="modalidad_trabajo" name="modalidad_trabajo" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todas</option>
                                <option value="presencial" {{ request('modalidad_trabajo') === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="remoto" {{ request('modalidad_trabajo') === 'remoto' ? 'selected' : '' }}>Remoto</option>
                                <option value="hibrido" {{ request('modalidad_trabajo') === 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                            </select>
                        </div>

                        <div>
                            <label for="habilidad_id" class="block text-sm font-medium text-gray-700">Habilidad</label>
                            <select id="habilidad_id" name="habilidad_id" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Todas</option>
                                @foreach($habilidades as $hab)
                                    <option value="{{ $hab->id }}" {{ request('habilidad_id') == $hab->id ? 'selected' : '' }}>{{ $hab->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="mt-4 flex gap-2">
                        <x-primary-button>Buscar</x-primary-button>
                        <a href="{{ route('empresa.buscador.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Limpiar</a>
                    </div>
                </fieldset>
            </form>

            <!-- Resultados -->
            <div class="space-y-4">
                <p class="text-gray-600">{{ $candidatos->total() }} candidato(s) encontrado(s)</p>

                @forelse($candidatos as $candidato)
                    <article class="bg-white shadow rounded-lg p-6 hover:shadow-md transition-shadow">
                        <div class="flex justify-between items-start">
                            <div>
                                <h2 class="text-lg font-semibold text-gray-900">{{ $candidato->user->name }}</h2>
                                <p class="text-gray-600">{{ $candidato->categoriaLaboral->nombre }} — {{ $candidato->departamento->nombre }}</p>
                                <p class="text-sm text-gray-500">{{ ucfirst($candidato->modalidad_trabajo) }}</p>
                                @if($candidato->habilidades->count())
                                    <div class="flex flex-wrap gap-1 mt-2">
                                        @foreach($candidato->habilidades->take(5) as $hab)
                                            <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">{{ $hab->nombre }}</span>
                                        @endforeach
                                        @if($candidato->habilidades->count() > 5)
                                            <span class="text-xs text-gray-500">+{{ $candidato->habilidades->count() - 5 }} más</span>
                                        @endif
                                    </div>
                                @endif
                            </div>
                            <a href="{{ route('empresa.buscador.show', $candidato) }}" class="inline-flex items-center px-3 py-2 bg-blue-700 text-white text-sm font-medium rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                Ver perfil
                            </a>
                        </div>
                    </article>
                @empty
                    <div class="bg-white shadow rounded-lg p-8 text-center">
                        <p class="text-gray-500 text-lg">No se encontraron candidatos con los filtros seleccionados.</p>
                    </div>
                @endforelse

                <div class="mt-6">
                    {{ $candidatos->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
