<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Crear mi perfil profesional</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <form method="POST" action="{{ route('candidato.perfil.store') }}" class="bg-white shadow rounded-lg p-6 space-y-6">
                @csrf

                <!-- Paso 1: Información básica -->
                <fieldset>
                    <legend class="text-lg font-semibold text-gray-900 mb-4">Información básica</legend>

                    <div class="space-y-4">
                        <div>
                            <label for="departamento_id" class="block text-base font-medium text-gray-900">
                                Departamento <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <select id="departamento_id" name="departamento_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccionar departamento</option>
                                @foreach($departamentos as $dep)
                                    <option value="{{ $dep->id }}" {{ old('departamento_id') == $dep->id ? 'selected' : '' }}>
                                        {{ $dep->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('departamento_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="categoria_laboral_id" class="block text-base font-medium text-gray-900">
                                Área laboral <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <select id="categoria_laboral_id" name="categoria_laboral_id" required
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccionar área</option>
                                @foreach($categorias as $cat)
                                    <option value="{{ $cat->id }}" {{ old('categoria_laboral_id') == $cat->id ? 'selected' : '' }}>
                                        {{ $cat->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('categoria_laboral_id')" class="mt-2" />
                        </div>

                        <div>
                            <label for="modalidad_trabajo" class="block text-base font-medium text-gray-900">
                                Modalidad de trabajo preferida <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <select id="modalidad_trabajo" name="modalidad_trabajo" required
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Seleccionar modalidad</option>
                                <option value="presencial" {{ old('modalidad_trabajo') === 'presencial' ? 'selected' : '' }}>Presencial</option>
                                <option value="remoto" {{ old('modalidad_trabajo') === 'remoto' ? 'selected' : '' }}>Remoto</option>
                                <option value="hibrido" {{ old('modalidad_trabajo') === 'hibrido' ? 'selected' : '' }}>Híbrido</option>
                            </select>
                            <x-input-error :messages="$errors->get('modalidad_trabajo')" class="mt-2" />
                        </div>

                        <div>
                            <label for="nivel_educativo" class="block text-base font-medium text-gray-900">Nivel educativo</label>
                            <x-text-input id="nivel_educativo" name="nivel_educativo" type="text" class="mt-1 block w-full" :value="old('nivel_educativo')" placeholder="Ej: Secundaria completa, Terciario en curso..." />
                            <x-input-error :messages="$errors->get('nivel_educativo')" class="mt-2" />
                        </div>

                        <div>
                            <label for="sobre_mi" class="block text-base font-medium text-gray-900">Sobre mí</label>
                            <textarea id="sobre_mi" name="sobre_mi" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Contanos brevemente sobre vos...">{{ old('sobre_mi') }}</textarea>
                            <x-input-error :messages="$errors->get('sobre_mi')" class="mt-2" />
                        </div>
                    </div>
                </fieldset>

                <!-- Habilidades -->
                <fieldset>
                    <legend class="text-lg font-semibold text-gray-900 mb-4">Habilidades</legend>
                    <p class="text-sm text-gray-600 mb-3">Seleccioná las habilidades que tenés.</p>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-2 max-h-60 overflow-y-auto border rounded-md p-3">
                        @foreach($habilidades as $hab)
                            <label class="flex items-center gap-2 p-1 cursor-pointer">
                                <input type="checkbox" name="habilidades[]" value="{{ $hab->id }}"
                                       {{ in_array($hab->id, old('habilidades', [])) ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-base text-gray-700">{{ $hab->nombre }}</span>
                            </label>
                        @endforeach
                    </div>
                </fieldset>

                <!-- Información de accesibilidad -->
                <fieldset>
                    <legend class="text-lg font-semibold text-gray-900 mb-2">Información de accesibilidad</legend>
                    <p class="text-sm text-gray-600 mb-4">Esta sección es completamente opcional. Compartí solo lo que desees.</p>

                    <div class="space-y-4">
                        <div>
                            <label for="tipo_discapacidad" class="block text-base font-medium text-gray-900">Tipo de discapacidad</label>
                            <select id="tipo_discapacidad" name="tipo_discapacidad"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="">Prefiero no indicar</option>
                                <option value="Motriz" {{ old('tipo_discapacidad') === 'Motriz' ? 'selected' : '' }}>Motriz</option>
                                <option value="Visual" {{ old('tipo_discapacidad') === 'Visual' ? 'selected' : '' }}>Visual</option>
                                <option value="Auditiva" {{ old('tipo_discapacidad') === 'Auditiva' ? 'selected' : '' }}>Auditiva</option>
                                <option value="Cognitiva / Intelectual" {{ old('tipo_discapacidad') === 'Cognitiva / Intelectual' ? 'selected' : '' }}>Cognitiva / Intelectual</option>
                                <option value="Psicosocial" {{ old('tipo_discapacidad') === 'Psicosocial' ? 'selected' : '' }}>Psicosocial</option>
                                <option value="Visceral" {{ old('tipo_discapacidad') === 'Visceral' ? 'selected' : '' }}>Visceral</option>
                                <option value="Múltiple" {{ old('tipo_discapacidad') === 'Múltiple' ? 'selected' : '' }}>Múltiple</option>
                                <option value="Otra" {{ old('tipo_discapacidad') === 'Otra' ? 'selected' : '' }}>Otra</option>
                            </select>
                        </div>

                        <div>
                            <label class="flex items-center gap-2 cursor-pointer">
                                <input type="checkbox" name="tiene_certificado" value="1"
                                       {{ old('tiene_certificado') ? 'checked' : '' }}
                                       class="rounded text-blue-600 focus:ring-blue-500">
                                <span class="text-base text-gray-700">Tengo certificado de discapacidad</span>
                            </label>
                        </div>

                        <div>
                            <label for="necesidades_adaptacion" class="block text-base font-medium text-gray-900">Necesidades de adaptación laboral</label>
                            <textarea id="necesidades_adaptacion" name="necesidades_adaptacion" rows="3"
                                      class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500"
                                      placeholder="Describí las adaptaciones que necesitás en el entorno laboral...">{{ old('necesidades_adaptacion') }}</textarea>
                        </div>

                        <div>
                            <label for="visibilidad_discapacidad" class="block text-base font-medium text-gray-900">
                                Visibilidad de esta información <span class="text-red-600" aria-hidden="true">*</span>
                            </label>
                            <select id="visibilidad_discapacidad" name="visibilidad_discapacidad" required
                                    aria-describedby="visibilidad-help"
                                    class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                                <option value="privada" {{ old('visibilidad_discapacidad', 'privada') === 'privada' ? 'selected' : '' }}>Privada — No visible para empresas</option>
                                <option value="bajo_solicitud" {{ old('visibilidad_discapacidad') === 'bajo_solicitud' ? 'selected' : '' }}>Bajo solicitud — Solo cuando la empresa lo solicite</option>
                                <option value="publica" {{ old('visibilidad_discapacidad') === 'publica' ? 'selected' : '' }}>Pública — Visible para empresas registradas</option>
                            </select>
                            <p id="visibilidad-help" class="text-sm text-gray-500 mt-1">Controlá quién puede ver tu información de accesibilidad.</p>
                        </div>
                    </div>
                </fieldset>

                <div class="flex justify-end pt-4">
                    <x-primary-button>Crear perfil</x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
