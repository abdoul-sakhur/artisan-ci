<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Gestion des Rôles et Permissions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-2xl font-bold">Rôles et Permissions</h3>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Rôles -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Rôles</h4>
                            <div class="space-y-3">
                                @php
                                    $roles = \Spatie\Permission\Models\Role::withCount('users', 'permissions')->get();
                                @endphp
                                
                                @foreach($roles as $role)
                                    <div class="border rounded-lg p-4 hover:shadow-md transition">
                                        <div class="flex justify-between items-start">
                                            <div>
                                                <h5 class="font-semibold text-lg capitalize">{{ $role->name }}</h5>
                                                <p class="text-sm text-gray-600 mt-1">
                                                    {{ $role->users_count }} utilisateur(s) • {{ $role->permissions_count }} permission(s)
                                                </p>
                                            </div>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if($role->name === 'admin') bg-red-100 text-red-800
                                                @elseif($role->name === 'artisan') bg-blue-100 text-blue-800
                                                @else bg-green-100 text-green-800
                                                @endif">
                                                {{ ucfirst($role->name) }}
                                            </span>
                                        </div>
                                        <div class="mt-3 flex gap-2">
                                            <button class="text-xs text-indigo-600 hover:text-indigo-900">Voir détails</button>
                                            <button class="text-xs text-gray-600 hover:text-gray-900">Modifier</button>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Permissions -->
                        <div>
                            <h4 class="text-lg font-semibold mb-4">Permissions</h4>
                            <div class="space-y-2">
                                @php
                                    $permissions = \Spatie\Permission\Models\Permission::all();
                                @endphp
                                
                                @foreach($permissions as $permission)
                                    <div class="border rounded p-3 text-sm">
                                        <div class="flex justify-between items-center">
                                            <span class="font-medium">{{ $permission->name }}</span>
                                            <span class="text-xs text-gray-500">ID: {{ $permission->id }}</span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 p-4 bg-purple-50 border-l-4 border-purple-400">
                        <p class="text-sm text-purple-700">
                            <strong>Total :</strong> {{ $roles->count() }} rôle(s) et {{ $permissions->count() }} permission(s)
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
