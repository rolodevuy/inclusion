<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-800 leading-tight">Mensajes</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            @if($conversaciones->isEmpty())
                <div class="bg-white shadow rounded-lg p-8 text-center">
                    <p class="text-gray-600 text-lg">No tenés conversaciones todavía.</p>
                </div>
            @else
                <div class="bg-white shadow rounded-lg divide-y divide-gray-200">
                    @foreach($conversaciones as $conversacion)
                        @php
                            $otro = $conversacion->otroUsuario(auth()->user());
                            $noLeidos = $conversacion->mensajesNoLeidos(auth()->id());
                        @endphp
                        <a href="{{ route('mensajeria.show', $conversacion) }}"
                           class="block p-4 hover:bg-gray-50 focus:outline-none focus:bg-blue-50 transition {{ $noLeidos > 0 ? 'bg-blue-50' : '' }}">
                            <div class="flex items-center justify-between gap-4">
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <p class="font-semibold text-gray-800 truncate">
                                            @if($otro->role === 'empresa')
                                                {{ $otro->empresaProfile->nombre_empresa ?? $otro->name }}
                                            @else
                                                {{ $otro->name }}
                                            @endif
                                        </p>
                                        @if($noLeidos > 0)
                                            <span class="inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white" aria-label="{{ $noLeidos }} sin leer">
                                                {{ $noLeidos }}
                                            </span>
                                        @endif
                                    </div>
                                    <p class="text-sm text-gray-600 font-medium">{{ $conversacion->asunto }}</p>
                                    @if($conversacion->ultimoMensaje)
                                        <p class="text-sm text-gray-500 truncate mt-1">
                                            {{ Str::limit($conversacion->ultimoMensaje->contenido, 80) }}
                                        </p>
                                    @endif
                                </div>
                                <div class="text-xs text-gray-500 whitespace-nowrap">
                                    {{ $conversacion->updated_at->diffForHumans() }}
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-6">
                    {{ $conversaciones->links() }}
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
