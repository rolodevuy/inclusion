<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Gestión de catálogos</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">

            {{-- ========== CATEGORÍAS LABORALES ========== --}}
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="categorias-title">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="categorias-title" class="text-lg font-semibold text-gray-900">Categorías laborales</h2>
                </div>

                {{-- Formulario agregar --}}
                <form method="POST" action="{{ route('admin.catalogos.categorias.store') }}" class="flex gap-2 mb-6">
                    @csrf
                    <div class="flex-1">
                        <label for="nueva_categoria" class="sr-only">Nueva categoría</label>
                        <x-text-input id="nueva_categoria" name="nombre" type="text" class="block w-full" placeholder="Nueva categoría laboral..." required />
                    </div>
                    <x-primary-button>Agregar</x-primary-button>
                </form>
                <x-input-error :messages="$errors->get('nombre')" class="mb-4" />

                {{-- Lista --}}
                <div class="divide-y divide-gray-200">
                    @foreach($categorias as $cat)
                        <div class="py-3 flex items-center justify-between gap-4" x-data="{ editing: false }">
                            {{-- Modo lectura --}}
                            <div x-show="!editing" class="flex items-center justify-between w-full">
                                <span class="text-base text-gray-900">
                                    {{ $cat->nombre }}
                                    <span class="text-sm text-gray-500">({{ $cat->habilidades_count }} habilidades)</span>
                                </span>
                                <div class="flex gap-2">
                                    <button @click="editing = true" class="text-sm text-blue-700 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1">Editar</button>
                                    @if($cat->habilidades_count === 0)
                                        <form method="POST" action="{{ route('admin.catalogos.categorias.destroy', $cat) }}" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-sm text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 rounded px-1">Eliminar</button>
                                        </form>
                                    @endif
                                </div>
                            </div>

                            {{-- Modo edición --}}
                            <form x-show="editing" x-cloak method="POST" action="{{ route('admin.catalogos.categorias.update', $cat) }}" class="flex items-center gap-2 w-full">
                                @csrf
                                @method('PUT')
                                <div class="flex-1">
                                    <label for="cat_{{ $cat->id }}" class="sr-only">Nombre de categoría</label>
                                    <x-text-input id="cat_{{ $cat->id }}" name="nombre" type="text" class="block w-full" :value="$cat->nombre" required />
                                </div>
                                <x-primary-button>Guardar</x-primary-button>
                                <button type="button" @click="editing = false" class="text-sm text-gray-500 hover:text-gray-700 px-2">Cancelar</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </section>

            {{-- ========== HABILIDADES ========== --}}
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="habilidades-title">
                <div class="flex justify-between items-center mb-4">
                    <h2 id="habilidades-title" class="text-lg font-semibold text-gray-900">Habilidades</h2>
                </div>

                {{-- Formulario agregar --}}
                <form method="POST" action="{{ route('admin.catalogos.habilidades.store') }}" class="flex gap-2 mb-6">
                    @csrf
                    <div class="flex-1">
                        <label for="nueva_habilidad" class="sr-only">Nueva habilidad</label>
                        <x-text-input id="nueva_habilidad" name="nombre" type="text" class="block w-full" placeholder="Nueva habilidad..." required />
                    </div>
                    <div class="w-48">
                        <label for="hab_categoria" class="sr-only">Categoría</label>
                        <select id="hab_categoria" name="categoria_laboral_id" class="block w-full rounded-md border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Sin categoría</option>
                            @foreach($categorias as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-primary-button>Agregar</x-primary-button>
                </form>

                {{-- Lista --}}
                <div class="divide-y divide-gray-200">
                    @foreach($habilidades as $hab)
                        <div class="py-3 flex items-center justify-between gap-4" x-data="{ editing: false }">
                            {{-- Modo lectura --}}
                            <div x-show="!editing" class="flex items-center justify-between w-full">
                                <span class="text-base text-gray-900">
                                    {{ $hab->nombre }}
                                    @if($hab->categoriaLaboral)
                                        <span class="text-sm text-gray-500">({{ $hab->categoriaLaboral->nombre }})</span>
                                    @else
                                        <span class="text-sm text-gray-500">(transversal)</span>
                                    @endif
                                </span>
                                <div class="flex gap-2">
                                    <button @click="editing = true" class="text-sm text-blue-700 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1">Editar</button>
                                    <form method="POST" action="{{ route('admin.catalogos.habilidades.destroy', $hab) }}" onsubmit="return confirm('¿Eliminar esta habilidad?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-sm text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 rounded px-1">Eliminar</button>
                                    </form>
                                </div>
                            </div>

                            {{-- Modo edición --}}
                            <form x-show="editing" x-cloak method="POST" action="{{ route('admin.catalogos.habilidades.update', $hab) }}" class="flex items-center gap-2 w-full">
                                @csrf
                                @method('PUT')
                                <div class="flex-1">
                                    <label for="hab_{{ $hab->id }}" class="sr-only">Nombre de habilidad</label>
                                    <x-text-input id="hab_{{ $hab->id }}" name="nombre" type="text" class="block w-full" :value="$hab->nombre" required />
                                </div>
                                <div class="w-48">
                                    <label for="hab_cat_{{ $hab->id }}" class="sr-only">Categoría</label>
                                    <select id="hab_cat_{{ $hab->id }}" name="categoria_laboral_id" class="block w-full rounded-md border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Sin categoría</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}" {{ $hab->categoria_laboral_id == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <x-primary-button>Guardar</x-primary-button>
                                <button type="button" @click="editing = false" class="text-sm text-gray-500 hover:text-gray-700 px-2">Cancelar</button>
                            </form>
                        </div>
                    @endforeach
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
