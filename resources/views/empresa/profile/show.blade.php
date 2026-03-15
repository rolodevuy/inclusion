<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h1 class="text-xl font-semibold text-gray-900">Mi empresa</h1>
            <a href="{{ route('empresa.perfil.edit') }}" class="inline-flex items-center px-4 py-2 bg-blue-700 text-white font-medium rounded-md hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">Editar</a>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white shadow rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd class="text-base text-gray-900">{{ auth()->user()->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">RUT</dt>
                        <dd class="text-base text-gray-900">{{ $profile->rut }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sector</dt>
                        <dd class="text-base text-gray-900">{{ $profile->sector }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ubicación</dt>
                        <dd class="text-base text-gray-900">{{ $profile->departamento->nombre }}</dd>
                    </div>
                    @if($profile->sitio_web)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sitio web</dt>
                        <dd><a href="{{ $profile->sitio_web }}" target="_blank" rel="noopener noreferrer" class="text-blue-700 hover:text-blue-800 underline">{{ $profile->sitio_web }}</a></dd>
                    </div>
                    @endif
                </dl>
                @if($profile->descripcion)
                    <div class="mt-4">
                        <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                        <dd class="text-base text-gray-900 mt-1">{{ $profile->descripcion }}</dd>
                    </div>
                @endif
                @if($profile->politicas_inclusion)
                    <div class="mt-4">
                        <dt class="text-sm font-medium text-gray-500">Políticas de inclusión</dt>
                        <dd class="text-base text-gray-900 mt-1">{{ $profile->politicas_inclusion }}</dd>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
