<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Oferta</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('empresa.ofertas.update', $oferta) }}">
                    @csrf
                    @method('PUT')

                    <fieldset>
                        <legend class="text-lg font-semibold text-gray-800 mb-4">Información de la oferta</legend>

                        <div class="space-y-4">
                            <div>
                                <x-input-label for="titulo" value="Título del puesto *" />
                                <x-text-input id="titulo" name="titulo" type="text" class="mt-1 block w-full"
                                    :value="old('titulo', $oferta->titulo)" required />
                                <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="descripcion" value="Descripción del puesto *" />
                                <textarea id="descripcion" name="descripcion" rows="5" required
                                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">{{ old('descripcion', $oferta->descripcion) }}</textarea>
                                <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="categoria_laboral_id" value="Categoría laboral *" />
                                    <select id="categoria_laboral_id" name="categoria_laboral_id" required
                                        class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">
                                        <option value="">Seleccioná una categoría</option>
                                        @foreach($categorias as $cat)
                                            <option value="{{ $cat->id }}" @selected(old('categoria_laboral_id', $oferta->categoria_laboral_id) == $cat->id)>{{ $cat->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('categoria_laboral_id')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="departamento_id" value="Departamento *" />
                                    <select id="departamento_id" name="departamento_id" required
                                        class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">
                                        <option value="">Seleccioná un departamento</option>
                                        @foreach($departamentos as $dep)
                                            <option value="{{ $dep->id }}" @selected(old('departamento_id', $oferta->departamento_id) == $dep->id)>{{ $dep->nombre }}</option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('departamento_id')" class="mt-2" />
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <x-input-label for="modalidad" value="Modalidad *" />
                                    <select id="modalidad" name="modalidad" required
                                        class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">
                                        <option value="presencial" @selected(old('modalidad', $oferta->modalidad) === 'presencial')>Presencial</option>
                                        <option value="remoto" @selected(old('modalidad', $oferta->modalidad) === 'remoto')>Remoto</option>
                                        <option value="hibrido" @selected(old('modalidad', $oferta->modalidad) === 'hibrido')>Híbrido</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('modalidad')" class="mt-2" />
                                </div>

                                <div>
                                    <x-input-label for="horario" value="Horario" />
                                    <x-text-input id="horario" name="horario" type="text" class="mt-1 block w-full"
                                        :value="old('horario', $oferta->horario)" />
                                    <x-input-error :messages="$errors->get('horario')" class="mt-2" />
                                </div>
                            </div>

                            <div>
                                <x-input-label for="requisitos" value="Requisitos" />
                                <textarea id="requisitos" name="requisitos" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">{{ old('requisitos', $oferta->requisitos) }}</textarea>
                                <x-input-error :messages="$errors->get('requisitos')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="beneficios" value="Beneficios" />
                                <textarea id="beneficios" name="beneficios" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">{{ old('beneficios', $oferta->beneficios) }}</textarea>
                                <x-input-error :messages="$errors->get('beneficios')" class="mt-2" />
                            </div>

                            <div>
                                <x-input-label for="adaptaciones_disponibles" value="Adaptaciones disponibles" />
                                <textarea id="adaptaciones_disponibles" name="adaptaciones_disponibles" rows="3"
                                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">{{ old('adaptaciones_disponibles', $oferta->adaptaciones_disponibles) }}</textarea>
                                <x-input-error :messages="$errors->get('adaptaciones_disponibles')" class="mt-2" />
                            </div>

                            {{-- Estado --}}
                            <div>
                                <x-input-label for="estado" value="Estado de la oferta *" />
                                <select id="estado" name="estado" required
                                    class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base">
                                    <option value="activa" @selected(old('estado', $oferta->estado) === 'activa')>Activa</option>
                                    <option value="pausada" @selected(old('estado', $oferta->estado) === 'pausada')>Pausada</option>
                                    <option value="cerrada" @selected(old('estado', $oferta->estado) === 'cerrada')>Cerrada</option>
                                </select>
                                <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                            </div>
                        </div>
                    </fieldset>

                    <div class="mt-6 flex items-center gap-4">
                        <x-primary-button>Guardar cambios</x-primary-button>
                        <a href="{{ route('empresa.ofertas.show', $oferta) }}" class="text-sm text-gray-600 hover:underline">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
