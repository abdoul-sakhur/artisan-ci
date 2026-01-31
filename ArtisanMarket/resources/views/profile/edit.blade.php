<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profil') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="max-w-xl">
                    <h3 class="text-lg font-medium text-gray-900">Informations du profil</h3>
                    <p class="mt-1 text-sm text-gray-600">
                        Gérez les informations de votre compte et votre adresse email.
                    </p>

                    <div class="mt-6 space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Nom</label>
                            <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->name }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email</label>
                            <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->email }}</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Rôle(s)</label>
                            <div class="mt-1 flex gap-2">
                                @foreach(Auth::user()->roles as $role)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700">Membre depuis</label>
                            <p class="mt-1 text-sm text-gray-900">{{ Auth::user()->created_at->format('d/m/Y') }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
