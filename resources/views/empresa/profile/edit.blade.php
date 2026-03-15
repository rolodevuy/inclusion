<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Editar perfil de empresa</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('empresa.perfil.update') }}" class="bg-white shadow rounded-lg p-6 space-y-4">
                @csrf
                @method('PUT')

                <div>
                    <label for="rut" class="block text-base font-medium text-gray-900">RUT <span class="text-red-600" aria-hidden="true">*</span></label>
                    <x-text-input id="rut" name="rut" type="text" class="mt-1 block w-full" :value="old('rut', $profile->rut)" required />
                    <x-input-error :messages="$errors->get('rut')" class="mt-2" />
                </div>

                <div>
                    <label for="sector" class="block text-base font-medium text-gray-900">Sector / Industria <span class="text-red-600" aria-hidden="true">*</span></label>
                    <x-text-input id="sector" name="sector" type="text" class="mt-1 block w-full" :value="old('sector', $profile->sector)" required />
                    <x-input-error :messages="$errors->get('sector')" class="mt-2" />
                </div>

                <div>
                    <label for="departamento_id" class="block text-base font-medium text-gray-900">Ubicación <span class="text-red-600" aria-hidden="true">*</span></label>
                    <select id="departamento_id" name="departamento_id" required class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                        @foreach($departamentos as $dep)
                            <option value="{{ $dep->id }}" {{ old('departamento_id', $profile->departamento_id) == $dep->id ? 'selected' : '' }}>{{ $dep->nombre }}</option>
                        @endforeach
                    </select>
                    <x-input-error :messages="$errors->get('departamento_id')" class="mt-2" />
                </div>

                <div>
                    <label for="descripcion" class="block text-base font-medium text-gray-900">Descripción</label>
                    <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">{{ old('descripcion', $profile->descripcion) }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <div>
                    <label for="sitio_web" class="block text-base font-medium text-gray-900">Sitio web</label>
                    <x-text-input id="sitio_web" name="sitio_web" type="url" class="mt-1 block w-full" :value="old('sitio_web', $profile->sitio_web)" />
                    <x-input-error :messages="$errors->get('sitio_web')" class="mt-2" />
                </div>

                <div>
                    <label for="politicas_inclusion" class="block text-base font-medium text-gray-900">Políticas de inclusión</label>
                    <textarea id="politicas_inclusion" name="politicas_inclusion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">{{ old('politicas_inclusion', $profile->politicas_inclusion) }}</textarea>
                    <x-input-error :messages="$errors->get('politicas_inclusion')" class="mt-2" />
                </div>

                <div class="flex justify-between pt-4">
                    <a href="{{ route('empresa.perfil.show') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Cancelar</a>
                    <x-primary-button>Guardar cambios</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
