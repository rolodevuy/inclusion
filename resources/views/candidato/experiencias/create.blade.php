<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Agregar experiencia laboral</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('candidato.experiencias.store') }}" class="bg-white shadow rounded-lg p-6 space-y-4">
                @csrf

                <div>
                    <label for="cargo" class="block text-base font-medium text-gray-900">Cargo <span class="text-red-600" aria-hidden="true">*</span></label>
                    <x-text-input id="cargo" name="cargo" type="text" class="mt-1 block w-full" :value="old('cargo')" required />
                    <x-input-error :messages="$errors->get('cargo')" class="mt-2" />
                </div>

                <div>
                    <label for="empresa" class="block text-base font-medium text-gray-900">Empresa <span class="text-red-600" aria-hidden="true">*</span></label>
                    <x-text-input id="empresa" name="empresa" type="text" class="mt-1 block w-full" :value="old('empresa')" required />
                    <x-input-error :messages="$errors->get('empresa')" class="mt-2" />
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="fecha_inicio" class="block text-base font-medium text-gray-900">Fecha de inicio <span class="text-red-600" aria-hidden="true">*</span></label>
                        <x-text-input id="fecha_inicio" name="fecha_inicio" type="date" class="mt-1 block w-full" :value="old('fecha_inicio')" required />
                        <x-input-error :messages="$errors->get('fecha_inicio')" class="mt-2" />
                    </div>
                    <div>
                        <label for="fecha_fin" class="block text-base font-medium text-gray-900">Fecha de fin</label>
                        <x-text-input id="fecha_fin" name="fecha_fin" type="date" class="mt-1 block w-full" :value="old('fecha_fin')" />
                        <p class="text-sm text-gray-500 mt-1">Dejalo vacío si es tu trabajo actual.</p>
                        <x-input-error :messages="$errors->get('fecha_fin')" class="mt-2" />
                    </div>
                </div>

                <div>
                    <label for="descripcion" class="block text-base font-medium text-gray-900">Descripción de tareas</label>
                    <textarea id="descripcion" name="descripcion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">{{ old('descripcion') }}</textarea>
                    <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                </div>

                <div class="flex justify-between pt-4">
                    <a href="{{ route('candidato.perfil.show') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">Cancelar</a>
                    <x-primary-button>Agregar experiencia</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
