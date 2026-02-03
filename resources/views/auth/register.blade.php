<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- User Type -->
        <div class="mt-6">
            <x-input-label :value="__('Type d\'utilisateur')" />
            <div class="mt-2 grid grid-cols-1 sm:grid-cols-2 gap-3">
                <label class="flex items-center gap-2 border rounded-lg p-3 cursor-pointer">
                    <input type="radio" name="user_type" value="client" {{ old('user_type', request('type','client')) === 'client' ? 'checked' : '' }}>
                    <span>Acheteur (Client)</span>
                </label>
                <label class="flex items-center gap-2 border rounded-lg p-3 cursor-pointer">
                    <input type="radio" name="user_type" value="artisan" {{ old('user_type') === 'artisan' ? 'checked' : '' }}>
                    <span>Artisan (Vendeur)</span>
                </label>
            </div>
            <p class="text-sm text-gray-500 mt-2">Les artisans pourront créer leur boutique après l'inscription.</p>
            <x-input-error :messages="$errors->get('user_type')" class="mt-2" />
        </div>

        <!-- Hint: différences client vs artisan -->
        <div class="mt-6 p-4 bg-gray-50 border rounded-lg text-sm text-gray-700">
            <p class="mb-2"><strong>Client :</strong> achetez des œuvres, gérez votre panier et suivez vos commandes.</p>
            <p><strong>Artisan :</strong> vendez vos créations, gérez votre boutique et vos commandes. 
                <a href="{{ route('register', ['type' => 'artisan']) }}" class="text-amber-600 underline">Créer un compte artisan</a>
            </p>
        </div>

        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
