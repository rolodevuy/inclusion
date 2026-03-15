<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Tipo de cuenta -->
        <fieldset class="mb-4">
            <legend class="block text-base font-medium text-gray-900 mb-2">
                Tipo de cuenta <span class="text-red-600" aria-hidden="true">*</span>
                <span class="sr-only">(obligatorio)</span>
            </legend>
            <div class="flex gap-4">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="role" value="candidato"
                           {{ old('role', 'candidato') === 'candidato' ? 'checked' : '' }}
                           class="text-blue-600 focus:ring-blue-500">
                    <span class="text-base text-gray-700">Busco empleo</span>
                </label>
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="radio" name="role" value="empresa"
                           {{ old('role') === 'empresa' ? 'checked' : '' }}
                           class="text-blue-600 focus:ring-blue-500">
                    <span class="text-base text-gray-700">Soy empresa</span>
                </label>
            </div>
            <x-input-error :messages="$errors->get('role')" class="mt-2" />
        </fieldset>

        <!-- Name -->
        <div>
            <x-input-label for="name" value="Nombre completo" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" value="Correo electrónico" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Contraseña" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirmar contraseña" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500" href="{{ route('login') }}">
                ¿Ya tenés cuenta?
            </a>

            <x-primary-button class="ms-4">
                Registrarse
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
