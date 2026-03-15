<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Editar mi perfil</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('candidato.perfil.update') }}" enctype="multipart/form-data" class="bg-white shadow rounded-lg p-6 space-y-6">
                @csrf
                @method('PUT')

                <fieldset>
                    <legend class="text-lg font-semibold text-gray-900 mb-4">Información básica</legend>
                    <div class="space-y-4">
                        <div>
                            <label for="departamento_id" class="block text-base font-medium text-gray-900">Departamento <span class="text-red-600" aria-hidden="true">*</span></label>
                            <select id="departamento_id" name="departamento_id" required class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                @foreach($departamentos as $dep)
                                    <option value="{{ $dep->id }}" {{ old('departamento_id', $profile->departamento_id) == $dep->id ? 'selected' : '' }}>{{ $dep->nombre }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('departamento_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="categoria_laboral_id" class="block text-base font-medium text-gray-900">Área laboral <span class="text-red-600" aria-hidden="true">*</span></label>
                            <select id="categoria_laboral_id" name="categoria_laboral_id" required class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoria_laboral_id', $profile->categoria_laboral_id) == $cat->id ? 'selected' : '' }}>{{ $cat->nombre }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categoria_laboral_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="modalidad_trabajo" class="block text-base font-medium text-gray-900">Modalidad de trabajo <span class="text-red-600" aria-hidden="true">*</span></label>
                            <select id="modalidad_trabajo" name="modalidad_trabajo" required class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="presencial" {{ old('modalidad_trabajo', $profile->modalidad_trabajo) === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="remoto" {{ old('modalidad_trabajo', $profile->modalidad_trabajo) === 'remoto' ? 'selected' : '' }}>Remoto</option>
                                <option value="hibrido" {{ old('modalidad_trabajo', $profile->modalidad_trabajo) === 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                            </select>
                            <x-input-error :messages="$errors->get('modalidad_trabajo')" class="mt-2" />
                        </div>

                        <div>
                            <label for="nivel_educativo" class="block text-base font-medium text-gray-900">Nivel educativo</label>
                            <x-text-input id="nivel_educativo" name="nivel_educativo" type="text" class="mt-1 block w-full" :value="old('nivel_educativo', $profile->nivel_educativo)" />
                            <x-input-error :messages="$errors->get('nivel_educativo')" class="mt-2" />
                        </div>

                        <div>
                            <label for="sobre_mi" class="block text-base font-medium text-gray-900">Sobre mí</label>
                            <textarea id="sobre_mi" name="sobre_mi" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">{{ old('sobre_mi', $profile->sobre_mi) }}</textarea>
                            <x-input-error :messages="$errors->get('sobre_mi')" class="mt-2" />
                        </div>
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="text-lg font-semibold text-gray-900 mb-4">Habilidades</legend>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-60 overflow-y-auto border rounded-md p-3">
                        @php $selectedHabilidades = old('habilidades', $profile->habilidades->pluck('id')->toArray()); @endphp
                        @foreach($habilidades as $hab)
                            <label class="flex items-center gap-2 p-1 cursor-pointer">
                                <input type="checkbox" name="habilidades[]" value="{{ $hab->id }}"
                                       {{ in_array($hab->id, $selectedHabilidades) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-base text-gray-700">{{ $hab->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <fieldset>
                    <legend class="text-lg font-semibold text-gray-900 mb-2">Información de accesibilidad</legend>
                    <p class="text-sm text-gray-600 mb-4">Esta sección es completamente opcional.</p>
                    <div class="space-y-4">
                        <div>
                            <label for="tipo_discapacidad" class="block text-base font-medium text-gray-900">Tipo de discapacidad</label>
                            <select id="tipo_discapacidad" name="tipo_discapacidad" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Prefiero no indicar</option>
                                @foreach(['Motriz', 'Visual', 'Auditiva', 'Cognitiva / Intelectual', 'Psicosocial', 'Visceral', 'Múltiple', 'Otra'] as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_discapacidad', $profile->tipo_discapacidad) === $tipo ? 'selected' : '' }}>{{ $tipo }}</option>
                                @endforeach
                            </select>
                        </div>

                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="tiene_certificado" value="1"
                                   {{ old('tiene_certificado', $profile->tiene_certificado) ? 'checked' : '' }}
                                   class="rounded text-blue-600 focus:ring-blue-500">
                            <span class="text-base text-gray-700">Tengo certificado de discapacidad</span>
                        </label>

                        <div>
                            <label for="certificado" class="block text-base font-medium text-gray-900">
                                {{ $profile->certificado_path ? 'Reemplazar certificado' : 'Subir certificado (opcional)' }}
                            </label>
                            @if($profile->certificado_path)
                                <p class="text-sm text-gray-600 mt-1">
                                    Certificado actual:
                                    <span class="font-medium
                                        @if($profile->certificado_estado === 'verificado') text-green-700
                                        @elseif($profile->certificado_estado === 'rechazado') text-red-700
                                        @else text-yellow-700 @endif">
                                        {{ ucfirst($profile->certificado_estado) }}
                                    </span>
                                </p>
                            @endif
                            <input type="file" id="certificado" name="certificado" accept=".pdf,.jpg,.jpeg,.png"
                                   class="mt-1 block w-full text-base text-gray-700 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <p class="text-sm text-gray-500 mt-1">PDF, JPG o PNG. Máximo 5 MB.</p>
                            <x-input-error :messages="$errors->get('certificado')" class="mt-2" />
                        </div>

                        <div>
                            <label for="necesidades_adaptacion" class="block text-base font-medium text-gray-900">Necesidades de adaptación laboral</label>
                            <textarea id="necesidades_adaptacion" name="necesidades_adaptacion" rows="3" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">{{ old('necesidades_adaptacion', $profile->necesidades_adaptacion) }}</textarea>
                        </div>

                        <div>
                            <label for="visibilidad_discapacidad" class="block text-base font-medium text-gray-900">Visibilidad de esta información <span class="text-red-600" aria-hidden="true">*</span></label>
                            <select id="visibilidad_discapacidad" name="visibilidad_discapacidad" required class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="privada" {{ old('visibilidad_discapacidad', $profile->visibilidad_discapacidad) === 'privada' ? 'selected' : '' }}>Privada</option>
                                <option value="bajo_solicitud" {{ old('visibilidad_discapacidad', $profile->visibilidad_discapacidad) === 'bajo_solicitud' ? 'selected' : '' }}>Bajo solicitud</option>
                                <option value="publica" {{ old('visibilidad_discapacidad', $profile->visibilidad_discapacidad) === 'publica' ? 'selected' : '' }}>Pública</option>
                            </select>
                        </div>
                    </div>
                </fieldset>

                <div class="flex justify-between pt-4">
                    <a href="{{ route('candidato.perfil.show') }}" class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 font-medium rounded-md hover:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">
                        Cancelar
                    </a>
                    <x-primary-button>Guardar cambios</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
