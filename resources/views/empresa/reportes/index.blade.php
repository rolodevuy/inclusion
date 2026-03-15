<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes de Inclusión</h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

            {{-- Resumen general --}}
            <section aria-labelledby="resumen">
                <h3 id="resumen" class="text-lg font-semibold text-gray-800 mb-4">Resumen general</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    <div class="bg-white shadow rounded-lg p-5 text-center">
                        <p class="text-3xl font-bold text-blue-700">{{ $totalOfertas }}</p>
                        <p class="text-sm text-gray-600 mt-1">Ofertas publicadas</p>
                    </div>
                    <div class="bg-white shadow rounded-lg p-5 text-center">
                        <p class="text-3xl font-bold text-blue-700">{{ $totalPostulaciones }}</p>
                        <p class="text-sm text-gray-600 mt-1">Postulaciones recibidas</p>
                    </div>
                    <div class="bg-white shadow rounded-lg p-5 text-center">
                        <p class="text-3xl font-bold text-{{ $tasaAceptacion !== null ? 'green' : 'gray' }}-700">
                            {{ $tasaAceptacion !== null ? $tasaAceptacion . '%' : '—' }}
                        </p>
                        <p class="text-sm text-gray-600 mt-1">Tasa de aceptación</p>
                    </div>
                    <div class="bg-white shadow rounded-lg p-5 text-center">
                        <p class="text-3xl font-bold text-blue-700">{{ $ofertasConAdaptaciones }}</p>
                        <p class="text-sm text-gray-600 mt-1">Ofertas con adaptaciones</p>
                    </div>
                </div>
            </section>

            {{-- Ofertas por estado --}}
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="ofertas-estado">
                <h3 id="ofertas-estado" class="text-lg font-semibold text-gray-800 mb-4">Ofertas por estado</h3>
                @if($totalOfertas > 0)
                    <div class="space-y-3">
                        @foreach(['activa' => 'green', 'pausada' => 'yellow', 'cerrada' => 'gray'] as $estado => $color)
                            @php $cantidad = $ofertasPorEstado->get($estado, 0); @endphp
                            <div>
                                <div class="flex justify-between text-sm mb-1">
                                    <span class="font-medium text-gray-700">{{ ucfirst($estado) }}</span>
                                    <span class="text-gray-600">{{ $cantidad }}</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-{{ $color }}-500 h-2.5 rounded-full" style="width: {{ $totalOfertas > 0 ? round(($cantidad / $totalOfertas) * 100) : 0 }}%"></div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aún no publicaste ofertas.</p>
                @endif
            </section>

            {{-- Postulaciones por estado --}}
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="postulaciones-estado">
                <h3 id="postulaciones-estado" class="text-lg font-semibold text-gray-800 mb-4">Postulaciones por estado</h3>
                @if($totalPostulaciones > 0)
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                        @foreach(['pendiente' => 'yellow', 'vista' => 'blue', 'aceptada' => 'green', 'rechazada' => 'red'] as $estado => $color)
                            <div class="border rounded-lg p-4">
                                <p class="text-2xl font-bold text-{{ $color }}-700">{{ $postulacionesPorEstado->get($estado, 0) }}</p>
                                <p class="text-sm text-gray-600">{{ ucfirst($estado) }}</p>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500 text-center py-4">Aún no recibiste postulaciones.</p>
                @endif
            </section>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                {{-- Postulaciones por mes --}}
                <section class="bg-white shadow rounded-lg p-6" aria-labelledby="por-mes">
                    <h3 id="por-mes" class="text-lg font-semibold text-gray-800 mb-4">Postulaciones (últimos 6 meses)</h3>
                    @if($postulacionesPorMes->isNotEmpty())
                        @php $maxMes = $postulacionesPorMes->max() ?: 1; @endphp
                        <div class="space-y-2">
                            @foreach($postulacionesPorMes as $mes => $total)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700">{{ \Carbon\Carbon::createFromFormat('Y-m', $mes)->translatedFormat('M Y') }}</span>
                                        <span class="font-medium">{{ $total }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" style="width: {{ round(($total / $maxMes) * 100) }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Sin datos en los últimos 6 meses.</p>
                    @endif
                </section>

                {{-- Postulaciones por categoría --}}
                <section class="bg-white shadow rounded-lg p-6" aria-labelledby="por-categoria">
                    <h3 id="por-categoria" class="text-lg font-semibold text-gray-800 mb-4">Postulaciones por área laboral</h3>
                    @if($porCategoria->isNotEmpty())
                        @php $maxCat = $porCategoria->max() ?: 1; @endphp
                        <div class="space-y-2">
                            @foreach($porCategoria as $nombre => $total)
                                <div>
                                    <div class="flex justify-between text-sm mb-1">
                                        <span class="text-gray-700">{{ $nombre }}</span>
                                        <span class="font-medium">{{ $total }}</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-green-600 h-2 rounded-full" style="width: {{ round(($total / $maxCat) * 100) }}%"></div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-500 text-center py-4">Sin datos.</p>
                    @endif
                </section>
            </div>

            {{-- Top ofertas --}}
            @if($topOfertas->where('postulaciones_count', '>', 0)->isNotEmpty())
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="top-ofertas">
                <h3 id="top-ofertas" class="text-lg font-semibold text-gray-800 mb-4">Ofertas con más postulaciones</h3>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Oferta</th>
                                <th scope="col" class="px-4 py-3 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                <th scope="col" class="px-4 py-3 text-right text-xs font-medium text-gray-500 uppercase">Postulaciones</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                            @foreach($topOfertas->where('postulaciones_count', '>', 0) as $oferta)
                                <tr>
                                    <td class="px-4 py-3 text-sm">
                                        <a href="{{ route('empresa.ofertas.show', $oferta) }}" class="text-blue-700 hover:underline">{{ $oferta->titulo }}</a>
                                    </td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium
                                            @if($oferta->estado === 'activa') bg-green-100 text-green-800
                                            @elseif($oferta->estado === 'pausada') bg-yellow-100 text-yellow-800
                                            @else bg-gray-100 text-gray-800 @endif">
                                            {{ ucfirst($oferta->estado) }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm text-right font-medium">{{ $oferta->postulaciones_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </section>
            @endif

            {{-- Accesibilidad --}}
            <section class="bg-white shadow rounded-lg p-6" aria-labelledby="accesibilidad-info">
                <h3 id="accesibilidad-info" class="text-lg font-semibold text-gray-800 mb-4">Indicadores de inclusión</h3>
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                    <div class="border rounded-lg p-4">
                        <p class="text-2xl font-bold text-blue-700">{{ $compartieronAccesibilidad }}</p>
                        <p class="text-sm text-gray-600">Candidatos compartieron info de accesibilidad</p>
                    </div>
                    <div class="border rounded-lg p-4">
                        <p class="text-2xl font-bold text-green-700">{{ $ofertasConAdaptaciones }}</p>
                        <p class="text-sm text-gray-600">Ofertas con adaptaciones disponibles</p>
                    </div>
                    <div class="border rounded-lg p-4">
                        <p class="text-2xl font-bold text-green-700">
                            {{ $totalOfertas > 0 ? round(($ofertasConAdaptaciones / $totalOfertas) * 100) : 0 }}%
                        </p>
                        <p class="text-sm text-gray-600">Tus ofertas incluyen adaptaciones</p>
                    </div>
                </div>
            </section>

        </div>
    </div>
</x-app-layout>
