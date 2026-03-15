<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $conversacion->asunto }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Info del otro participante --}}
            @php
                $otro = $conversacion->otroUsuario(auth()->user());
            @endphp
            <div class="bg-white shadow rounded-lg p-4">
                <p class="text-sm text-gray-600">
                    Conversación con
                    <span class="font-semibold text-gray-800">
                        @if($otro->role === 'empresa')
                            {{ $otro->empresaProfile->nombre_empresa ?? $otro->name }}
                        @else
                            {{ $otro->name }}
                        @endif
                    </span>
                    <span class="text-gray-500">({{ $otro->role === 'empresa' ? 'Empresa' : 'Candidato' }})</span>
                </p>
            </div>

            {{-- Mensajes --}}
            <div class="bg-white shadow rounded-lg p-6 space-y-4" aria-label="Mensajes de la conversación">
                @foreach($mensajes as $mensaje)
                    @php
                        $esMio = $mensaje->remitente_user_id === auth()->id();
                    @endphp
                    <div class="flex {{ $esMio ? 'justify-end' : 'justify-start' }}">
                        <div class="max-w-[75%] rounded-lg p-3 {{ $esMio ? 'bg-blue-100 text-blue-900' : 'bg-gray-100 text-gray-800' }}">
                            <p class="text-sm font-semibold mb-1">
                                {{ $esMio ? 'Vos' : $mensaje->remitente->name }}
                            </p>
                            <p class="text-sm whitespace-pre-line">{{ $mensaje->contenido }}</p>
                            <p class="text-xs mt-1 {{ $esMio ? 'text-blue-600' : 'text-gray-500' }}">
                                {{ $mensaje->created_at->format('d/m/Y H:i') }}
                                @if($esMio && $mensaje->leido_at)
                                    &middot; Leído
                                @endif
                            </p>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Responder --}}
            <div class="bg-white shadow rounded-lg p-6">
                <form method="POST" action="{{ route('mensajeria.store', $conversacion) }}">
                    @csrf
                    <div>
                        <x-input-label for="contenido" value="Escribí tu mensaje" />
                        <textarea id="contenido" name="contenido" rows="3" required maxlength="5000"
                            class="mt-1 block w-full border-gray-300 focus:border-blue-500 focus:ring-blue-500 rounded-md shadow-sm text-base"
                            placeholder="Escribí tu respuesta...">{{ old('contenido') }}</textarea>
                        <x-input-error :messages="$errors->get('contenido')" class="mt-2" />
                    </div>
                    <div class="mt-3 flex items-center gap-4">
                        <x-primary-button>Enviar</x-primary-button>
                        <a href="{{ route('mensajeria.index') }}" class="text-sm text-gray-600 hover:underline">&larr; Volver a mensajes</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
