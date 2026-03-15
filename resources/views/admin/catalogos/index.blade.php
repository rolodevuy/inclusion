<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Gestión de catálogos</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            {{-- Mensajes flash --}}
            @if(session('success'))
                <div class="bg-green-50 border border-green-200 rounded-lg p-3 text-sm text-green-800" role="alert">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-200 rounded-lg p-3 text-sm text-red-800" role="alert">{{ session('error') }}</div>
            @endif

            {{-- Agregar categoría --}}
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Agregar categoría laboral</h2>
                <form method="POST" action="{{ route('admin.catalogos.categorias.store') }}" class="flex gap-2">
                    @csrf
                    <div class="flex-1">
                        <label for="nueva_categoria" class="sr-only">Nueva categoría</label>
                        <x-text-input id="nueva_categoria" name="nombre" type="text" class="block w-full" placeholder="Nombre de la nueva categoría..." required />
                    </div>
                    <x-primary-button>Agregar</x-primary-button>
                </form>
                <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
            </div>

            {{-- Categorías como acordeones --}}
            @foreach($categorias as $cat)
                <div class="bg-white shadow rounded-lg overflow-hidden" x-data="{ open: false, editingCat: false }">
                    {{-- Cabecera del acordeón --}}
                    <div class="flex items-center justify-between p-4 cursor-pointer hover:bg-gray-50" @click="if (!editingCat) open = !open">
                        {{-- Modo lectura --}}
                        <div x-show="!editingCat" class="flex items-center gap-2 flex-1">
                            <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <h2 class="text-base font-semibold text-gray-900">{{ $cat->nombre }}</h2>
                            <span class="text-sm text-gray-500">({{ $cat->habilidades_count }} habilidades)</span>
                        </div>

                        {{-- Botones categoría --}}
                        <div x-show="!editingCat" class="flex gap-2" @click.stop>
                            <button @click="editingCat = true" class="text-sm text-blue-700 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-2 py-1">Editar</button>
                            @if($cat->habilidades_count === 0)
                                <form method="POST" action="{{ route('admin.catalogos.categorias.destroy', $cat) }}" onsubmit="return confirm('¿Eliminar esta categoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-sm text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 rounded px-2 py-1">Eliminar</button>
                                </form>
                            @endif
                        </div>

                        {{-- Modo edición de categoría --}}
                        <form x-show="editingCat" x-cloak @click.stop method="POST" action="{{ route('admin.catalogos.categorias.update', $cat) }}" class="flex items-center gap-2 w-full">
                            @csrf
                            @method('PUT')
                            <div class="flex-1">
                                <label for="cat_{{ $cat->id }}" class="sr-only">Nombre de categoría</label>
                                <x-text-input id="cat_{{ $cat->id }}" name="nombre" type="text" class="block w-full" :value="$cat->nombre" required />
                            </div>
                            <x-primary-button>Guardar</x-primary-button>
                            <button type="button" @click="editingCat = false" class="text-sm text-gray-500 hover:text-gray-700 px-2">Cancelar</button>
                        </form>
                    </div>

                    {{-- Contenido del acordeón: habilidades --}}
                    <div x-show="open" x-cloak class="border-t border-gray-200 bg-gray-50 p-4 space-y-3">
                        {{-- Agregar habilidad a esta categoría --}}
                        <form method="POST" action="{{ route('admin.catalogos.habilidades.store') }}" class="flex gap-2">
                            @csrf
                            <input type="hidden" name="categoria_laboral_id" value="{{ $cat->id }}">
                            <div class="flex-1">
                                <label for="nueva_hab_{{ $cat->id }}" class="sr-only">Nueva habilidad para {{ $cat->nombre }}</label>
                                <x-text-input id="nueva_hab_{{ $cat->id }}" name="nombre" type="text" class="block w-full text-sm" placeholder="Agregar habilidad a {{ $cat->nombre }}..." required />
                            </div>
                            <x-primary-button class="text-sm">Agregar</x-primary-button>
                        </form>

                        {{-- Lista de habilidades --}}
                        @forelse($cat->habilidades as $hab)
                            <div class="flex items-center justify-between bg-white rounded-md px-3 py-2" x-data="{ editingHab: false }">
                                {{-- Lectura --}}
                                <div x-show="!editingHab" class="flex items-center justify-between w-full">
                                    <span class="text-sm text-gray-900">{{ $hab->nombre }}</span>
                                    <div class="flex gap-2">
                                        <button @click="editingHab = true" class="text-xs text-blue-700 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1">Editar</button>
                                        <form method="POST" action="{{ route('admin.catalogos.habilidades.destroy', $hab) }}" onsubmit="return confirm('¿Eliminar esta habilidad?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 rounded px-1">Eliminar</button>
                                        </form>
                                    </div>
                                </div>

                                {{-- Edición --}}
                                <form x-show="editingHab" x-cloak method="POST" action="{{ route('admin.catalogos.habilidades.update', $hab) }}" class="flex items-center gap-2 w-full">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex-1">
                                        <label for="hab_{{ $hab->id }}" class="sr-only">Nombre de habilidad</label>
                                        <x-text-input id="hab_{{ $hab->id }}" name="nombre" type="text" class="block w-full text-sm" :value="$hab->nombre" required />
                                    </div>
                                    <input type="hidden" name="categoria_laboral_id" value="{{ $cat->id }}">
                                    <x-primary-button class="text-sm">Guardar</x-primary-button>
                                    <button type="button" @click="editingHab = false" class="text-xs text-gray-500 hover:text-gray-700 px-1">Cancelar</button>
                                </form>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500 italic">No hay habilidades en esta categoría.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach

            {{-- Habilidades sin categoría (transversales) --}}
            @if($sinCategoria->isNotEmpty())
                <div class="bg-white shadow rounded-lg overflow-hidden" x-data="{ open: false }">
                    <div class="flex items-center gap-2 p-4 cursor-pointer hover:bg-gray-50" @click="open = !open">
                        <svg class="w-5 h-5 text-gray-500 transition-transform" :class="{ 'rotate-90': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                        </svg>
                        <h2 class="text-base font-semibold text-gray-900">Habilidades transversales</h2>
                        <span class="text-sm text-gray-500">({{ $sinCategoria->count() }})</span>
                    </div>

                    <div x-show="open" x-cloak class="border-t border-gray-200 bg-gray-50 p-4 space-y-3">
                        @foreach($sinCategoria as $hab)
                            <div class="flex items-center justify-between bg-white rounded-md px-3 py-2" x-data="{ editingHab: false }">
                                <div x-show="!editingHab" class="flex items-center justify-between w-full">
                                    <span class="text-sm text-gray-900">{{ $hab->nombre }}</span>
                                    <div class="flex gap-2">
                                        <button @click="editingHab = true" class="text-xs text-blue-700 hover:text-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 rounded px-1">Editar</button>
                                        <form method="POST" action="{{ route('admin.catalogos.habilidades.destroy', $hab) }}" onsubmit="return confirm('¿Eliminar esta habilidad?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-xs text-red-600 hover:text-red-800 focus:outline-none focus:ring-2 focus:ring-red-500 rounded px-1">Eliminar</button>
                                        </form>
                                    </div>
                                </div>

                                <form x-show="editingHab" x-cloak method="POST" action="{{ route('admin.catalogos.habilidades.update', $hab) }}" class="flex items-center gap-2 w-full">
                                    @csrf
                                    @method('PUT')
                                    <div class="flex-1">
                                        <label for="hab_{{ $hab->id }}" class="sr-only">Nombre de habilidad</label>
                                        <x-text-input id="hab_{{ $hab->id }}" name="nombre" type="text" class="block w-full text-sm" :value="$hab->nombre" required />
                                    </div>
                                    <select name="categoria_laboral_id" class="w-48 rounded-md border-gray-300 text-sm focus:border-blue-500 focus:ring-blue-500">
                                        <option value="">Sin categoría</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}">{{ $cat->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <x-primary-button class="text-sm">Guardar</x-primary-button>
                                    <button type="button" @click="editingHab = false" class="text-xs text-gray-500 hover:text-gray-700 px-1">Cancelar</button>
                                </form>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
</x-app-layout>
