<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Panel de administración</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Stats -->
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">
                <div class="bg-white shadow rounded-lg p-6">
                    <dt class="text-sm font-medium text-gray-500">Candidatos registrados</dt>
                    <dd class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_candidatos'] }}</dd>
                </div>
                <div class="bg-white shadow rounded-lg p-6">
                    <dt class="text-sm font-medium text-gray-500">Empresas registradas</dt>
                    <dd class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['total_empresas'] }}</dd>
                </div>
                <div class="bg-white shadow rounded-lg p-6">
                    <dt class="text-sm font-medium text-gray-500">Perfiles completados</dt>
                    <dd class="text-3xl font-bold text-gray-900 mt-1">{{ $stats['candidatos_con_perfil'] }}</dd>
                </div>
            </div>

            <!-- Candidatos por departamento -->
            @if($stats['candidatos_por_departamento']->count())
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="por-depto">
                <h2 id="por-depto" class="text-lg font-semibold text-gray-900 mb-4">Candidatos por departamento</h2>
                <div class="space-y-2">
                    @foreach($stats['candidatos_por_departamento'] as $item)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-700">{{ $item->departamento->nombre }}</span>
                            <span class="font-medium text-gray-900">{{ $item->total }}</span>
                        </div>
                    @endforeach
                </div>
            </section>
            @endif

        </div>
    </div>
</x-app-layout>
