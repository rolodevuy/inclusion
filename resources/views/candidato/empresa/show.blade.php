<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 leading-tight">{{ $empresa->name }}</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white shadow rounded-lg p-6">
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                        <dd class="text-base text-gray-900">{{ $empresa->name }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sector</dt>
                        <dd class="text-base text-gray-900">{{ $profile->sector }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Ubicación</dt>
                        <dd class="text-base text-gray-900">{{ $profile->departamento->nombre ?? '—' }}</dd>
                    </div>
                    @if($profile->sitio_web)
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Sitio web</dt>
                        <dd><a href="{{ $profile->sitio_web }}" target="_blank" rel="noopener noreferrer" class="text-blue-700 hover:underline">{{ $profile->sitio_web }}</a></dd>
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

            {{-- Ofertas activas de esta empresa --}}
            @if($ofertasActivas->isNotEmpty())
            <div class="bg-white shadow rounded-lg p-6">
                <h2 class="text-lg font-semibold text-gray-800 mb-4">Ofertas activas ({{ $ofertasActivas->count() }})</h2>
                <div class="space-y-3">
                    @foreach($ofertasActivas as $oferta)
                        <div class="border border-gray-200 rounded-lg p-4">
                            <h3 class="font-medium text-gray-900">
                                <a href="{{ route('candidato.ofertas.show', $oferta) }}" class="text-blue-700 hover:underline">{{ $oferta->titulo }}</a>
                            </h3>
                            <div class="flex flex-wrap gap-2 mt-2">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-blue-100 text-blue-800">{{ $oferta->categoriaLaboral->nombre ?? '' }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-700">{{ ucfirst($oferta->modalidad) }}</span>
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs bg-gray-100 text-gray-700">{{ $oferta->departamento->nombre ?? '' }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

            <a href="{{ url()->previous() }}" class="text-sm text-blue-700 hover:underline">&larr; Volver</a>
        </div>
    </div>
</x-app-layout>
