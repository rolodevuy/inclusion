<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold text-gray-900">Gestión de usuarios</h1>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Filtros -->
            <form method="GET" action="{{ route('admin.usuarios.index') }}" class="bg-white shadow rounded-lg p-6 mb-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700">Buscar</label>
                        <x-text-input id="search" name="search" type="text" class="mt-1 block w-full" :value="request('search')" placeholder="Nombre o email..." />
                    </div>
                    <div>
                        <label for="role" class="block text-sm font-medium text-gray-700">Rol</label>
                        <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 text-base focus:border-blue-500 focus:ring-blue-500">
                            <option value="">Todos</option>
                            <option value="candidato" {{ request('role') === 'candidato' ? 'selected' : '' }}>Candidato</option>
                            <option value="empresa" {{ request('role') === 'empresa' ? 'selected' : '' }}>Empresa</option>
                            <option value="admin" {{ request('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                        </select>
                    </div>
                    <div class="flex items-end">
                        <x-primary-button>Filtrar</x-primary-button>
                    </div>
                </div>
            </form>

            <!-- Tabla -->
            <div class="bg-white shadow rounded-lg overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500">Rol</th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500">Estado</th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500">Registro</th>
                            <th scope="col" class="px-6 py-3 text-left text-sm font-medium text-gray-500">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($users as $user)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-base text-gray-900">{{ $user->name }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-base text-gray-600">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        {{ $user->role === 'admin' ? 'bg-purple-100 text-purple-800' : ($user->role === 'empresa' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800') }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $user->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $user->is_active ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->created_at->format('d/m/Y') }}</td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @if(!$user->hasRole('admin'))
                                        <form method="POST" action="{{ route('admin.usuarios.toggle', $user) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button type="submit" class="text-sm font-medium {{ $user->is_active ? 'text-red-600 hover:text-red-800' : 'text-green-600 hover:text-green-800' }} focus:outline-none focus:ring-2 focus:ring-blue-500 rounded">
                                                {{ $user->is_active ? 'Desactivar' : 'Activar' }}
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-sm text-gray-500">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-8 text-center text-gray-500">No se encontraron usuarios.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-6">
                {{ $users->links() }}
            </div>

        </div>
    </div>
</x-app-layout>
