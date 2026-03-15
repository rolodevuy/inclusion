<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 leading-tight">Verificación de Certificados</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Pendientes --}}
            <section>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">
                    Pendientes de verificación ({{ $pendientes->count() }})
                </h2>

                @if($pendientes->isEmpty())
                    <div class="bg-white shadow rounded-lg p-6 text-center">
                        <p class="text-gray-500">No hay certificados pendientes de verificación.</p>
                    </div>
                @else
                    <div class="space-y-4">
                        @foreach($pendientes as $profile)
                            <div class="bg-white shadow rounded-lg p-5">
                                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                                    <div>
                                        <p class="font-semibold text-gray-800">{{ $profile->user->name }}</p>
                                        <p class="text-sm text-gray-600">{{ $profile->user->email }}</p>
                                        @if($profile->tipo_discapacidad)
                                            <p class="text-sm text-gray-600">Tipo: {{ $profile->tipo_discapacidad }}</p>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-1">Enviado {{ $profile->updated_at->diffForHumans() }}</p>
                                    </div>

                                    <div class="flex items-center gap-2 flex-wrap">
                                        <a href="{{ route('admin.certificados.descargar', $profile) }}"
                                           class="inline-flex items-center px-3 py-1.5 bg-blue-700 text-white text-sm rounded hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                            Descargar
                                        </a>

                                        <form method="POST" action="{{ route('admin.certificados.verificar', $profile) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit"
                                                class="inline-flex items-center px-3 py-1.5 bg-green-600 text-white text-sm rounded hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500">
                                                Verificar
                                            </button>
                                        </form>

                                        <div x-data="{ open: false }" class="relative">
                                            <button @click="open = !open" type="button"
                                                class="inline-flex items-center px-3 py-1.5 bg-red-600 text-white text-sm rounded hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                                Rechazar
                                            </button>

                                            <div x-show="open" @click.outside="open = false"
                                                 class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border p-4 z-10">
                                                <form method="POST" action="{{ route('admin.certificados.rechazar', $profile) }}">
                                                    @csrf
                                                    @method('PATCH')
                                                    <label for="obs-{{ $profile->id }}" class="block text-sm font-medium text-gray-700 mb-1">Motivo del rechazo *</label>
                                                    <textarea id="obs-{{ $profile->id }}" name="certificado_observaciones" rows="2" required maxlength="500"
                                                        class="block w-full border-gray-300 rounded-md text-sm focus:border-blue-500 focus:ring-blue-500"
                                                        placeholder="Ej: Imagen ilegible, documento vencido..."></textarea>
                                                    <button type="submit" class="mt-2 px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700">
                                                        Confirmar rechazo
                                                    </button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </section>

            {{-- Historial --}}
            @if($revisados->isNotEmpty())
            <section>
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Últimos revisados</h2>
                <div class="bg-white shadow rounded-lg overflow-hidden">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Candidato</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Observaciones</th>
                                <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @foreach($revisados as $profile)
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $profile->user->name }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            {{ $profile->certificado_estado === 'verificado' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                            {{ ucfirst($profile->certificado_estado) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">{{ $profile->certificado_observaciones ?? '—' }}</td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $profile->updated_at->format('d/m/Y') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            @endif
        </div>
    </div>
</x-app-layout>
