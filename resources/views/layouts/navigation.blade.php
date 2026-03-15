<nav x-data="{ open: false }" class="bg-white border-b border-gray-100" aria-label="Navegación principal">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}" class="text-xl font-bold text-blue-700">
                        Inclusión Laboral
                    </a>
                </div>

                <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                    @if(Auth::user()->hasRole('candidato'))
                        <x-nav-link :href="route('candidato.perfil.show')" :active="request()->routeIs('candidato.perfil.*')">
                            Mi Perfil
                        </x-nav-link>
                        @php
                            $pendientes = Auth::user()->candidatoProfile
                                ? \App\Models\SolicitudAcceso::where('candidato_profile_id', Auth::user()->candidatoProfile->id)->where('estado', 'pendiente')->count()
                                : 0;
                            $mensajesNoLeidos = \App\Models\Mensaje::whereHas('conversacion', function($q) {
                                $q->where('candidato_user_id', Auth::id());
                            })->where('remitente_user_id', '!=', Auth::id())->whereNull('leido_at')->count();
                        @endphp
                        <x-nav-link :href="route('candidato.ofertas.index')" :active="request()->routeIs('candidato.ofertas.*')">
                            Ofertas
                        </x-nav-link>
                        <x-nav-link :href="route('candidato.postulaciones.index')" :active="request()->routeIs('candidato.postulaciones.*')">
                            Mis Postulaciones
                        </x-nav-link>
                        <x-nav-link :href="route('candidato.solicitudes.index')" :active="request()->routeIs('candidato.solicitudes.*')">
                            Solicitudes
                            @if($pendientes > 0)
                                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-600 text-white" aria-label="{{ $pendientes }} pendientes">
                                    {{ $pendientes }}
                                </span>
                            @endif
                        </x-nav-link>
                        <x-nav-link :href="route('mensajeria.index')" :active="request()->routeIs('mensajeria.*')">
                            Mensajes
                            @if($mensajesNoLeidos > 0)
                                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white" aria-label="{{ $mensajesNoLeidos }} sin leer">
                                    {{ $mensajesNoLeidos }}
                                </span>
                            @endif
                        </x-nav-link>
                    @elseif(Auth::user()->hasRole('empresa'))
                        <x-nav-link :href="route('empresa.perfil.show')" :active="request()->routeIs('empresa.perfil.*')">
                            Mi Empresa
                        </x-nav-link>
                        <x-nav-link :href="route('empresa.ofertas.index')" :active="request()->routeIs('empresa.ofertas.*')">
                            Mis Ofertas
                        </x-nav-link>
                        <x-nav-link :href="route('empresa.buscador.index')" :active="request()->routeIs('empresa.buscador.*')">
                            Buscar Candidatos
                        </x-nav-link>
                        <x-nav-link :href="route('empresa.reportes.index')" :active="request()->routeIs('empresa.reportes.*')">
                            Reportes
                        </x-nav-link>
                        @php
                            $mensajesNoLeidos = \App\Models\Mensaje::whereHas('conversacion', function($q) {
                                $q->where('empresa_user_id', Auth::id());
                            })->where('remitente_user_id', '!=', Auth::id())->whereNull('leido_at')->count();
                        @endphp
                        <x-nav-link :href="route('mensajeria.index')" :active="request()->routeIs('mensajeria.*')">
                            Mensajes
                            @if($mensajesNoLeidos > 0)
                                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white" aria-label="{{ $mensajesNoLeidos }} sin leer">
                                    {{ $mensajesNoLeidos }}
                                </span>
                            @endif
                        </x-nav-link>
                    @elseif(Auth::user()->hasRole('admin'))
                        <x-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                            Dashboard
                        </x-nav-link>
                        <x-nav-link :href="route('admin.usuarios.index')" :active="request()->routeIs('admin.usuarios.*')">
                            Usuarios
                        </x-nav-link>
                        <x-nav-link :href="route('admin.catalogos.index')" :active="request()->routeIs('admin.catalogos.*')">
                            Catálogos
                        </x-nav-link>
                        @php
                            $certPendientes = \App\Models\CandidatoProfile::where('certificado_estado', 'pendiente')->count();
                        @endphp
                        <x-nav-link :href="route('admin.certificados.index')" :active="request()->routeIs('admin.certificados.*')">
                            Certificados
                            @if($certPendientes > 0)
                                <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-yellow-500 text-white" aria-label="{{ $certPendientes }} pendientes">
                                    {{ $certPendientes }}
                                </span>
                            @endif
                        </x-nav-link>
                    @endif
                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition ease-in-out duration-150">
                            <div>{{ Auth::user()->name }}</div>
                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Mi Cuenta
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                    onclick="event.preventDefault(); this.closest('form').submit();">
                                Cerrar Sesión
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out" aria-label="Abrir menú de navegación" :aria-expanded="open">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <path :class="{'hidden': open, 'inline-flex': ! open }" class="inline-flex" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{'hidden': ! open, 'inline-flex': open }" class="hidden" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{'block': open, 'hidden': ! open}" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            @if(Auth::user()->hasRole('candidato'))
                <x-responsive-nav-link :href="route('candidato.perfil.show')" :active="request()->routeIs('candidato.perfil.*')">
                    Mi Perfil
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('candidato.ofertas.index')" :active="request()->routeIs('candidato.ofertas.*')">
                    Ofertas
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('candidato.postulaciones.index')" :active="request()->routeIs('candidato.postulaciones.*')">
                    Mis Postulaciones
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('candidato.solicitudes.index')" :active="request()->routeIs('candidato.solicitudes.*')">
                    Solicitudes
                    @if($pendientes > 0)
                        <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-red-600 text-white">{{ $pendientes }}</span>
                    @endif
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('mensajeria.index')" :active="request()->routeIs('mensajeria.*')">
                    Mensajes
                    @if($mensajesNoLeidos > 0)
                        <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white">{{ $mensajesNoLeidos }}</span>
                    @endif
                </x-responsive-nav-link>
            @elseif(Auth::user()->hasRole('empresa'))
                <x-responsive-nav-link :href="route('empresa.perfil.show')" :active="request()->routeIs('empresa.perfil.*')">
                    Mi Empresa
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('empresa.ofertas.index')" :active="request()->routeIs('empresa.ofertas.*')">
                    Mis Ofertas
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('empresa.buscador.index')" :active="request()->routeIs('empresa.buscador.*')">
                    Buscar Candidatos
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('empresa.reportes.index')" :active="request()->routeIs('empresa.reportes.*')">
                    Reportes
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('mensajeria.index')" :active="request()->routeIs('mensajeria.*')">
                    Mensajes
                    @if($mensajesNoLeidos > 0)
                        <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-blue-600 text-white">{{ $mensajesNoLeidos }}</span>
                    @endif
                </x-responsive-nav-link>
            @elseif(Auth::user()->hasRole('admin'))
                <x-responsive-nav-link :href="route('admin.dashboard')" :active="request()->routeIs('admin.dashboard')">
                    Dashboard
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.usuarios.index')" :active="request()->routeIs('admin.usuarios.*')">
                    Usuarios
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.catalogos.index')" :active="request()->routeIs('admin.catalogos.*')">
                    Catálogos
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('admin.certificados.index')" :active="request()->routeIs('admin.certificados.*')">
                    Certificados
                    @if($certPendientes > 0)
                        <span class="ml-1 inline-flex items-center justify-center px-2 py-0.5 rounded-full text-xs font-bold bg-yellow-500 text-white">{{ $certPendientes }}</span>
                    @endif
                </x-responsive-nav-link>
            @endif
        </div>

        <div class="pt-4 pb-1 border-t border-gray-200">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800">{{ Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    Mi Cuenta
                </x-responsive-nav-link>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-responsive-nav-link :href="route('logout')"
                            onclick="event.preventDefault(); this.closest('form').submit();">
                        Cerrar Sesión
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
