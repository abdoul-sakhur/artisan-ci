<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('En Attente d\'Approbation') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            
            <x-ui.card>
                <div class="p-8 text-center">
                    <svg class="mx-auto h-24 w-24 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    
                    <h3 class="mt-6 text-2xl font-semibold text-gray-900">
                        Votre boutique est en cours de révision
                    </h3>
                    
                    <p class="mt-4 text-gray-600">
                        Merci d'avoir créé votre boutique <strong>{{ $artisan->shop_name }}</strong> !
                    </p>
                    
                    <p class="mt-2 text-gray-600">
                        Notre équipe examine votre demande. Vous recevrez un email dès que votre boutique sera approuvée.
                        Cela peut prendre jusqu'à 48 heures.
                    </p>

                    <div class="mt-8 bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <h4 class="font-medium text-blue-900">Pendant ce temps</h4>
                        <ul class="mt-2 text-sm text-blue-700 text-left list-disc list-inside">
                            <li>Assurez-vous que vos informations de contact sont à jour</li>
                            <li>Préparez vos premiers produits à ajouter</li>
                            <li>Réfléchissez à votre stratégie de prix</li>
                        </ul>
                    </div>

                    <div class="mt-8">
                        <x-ui.button variant="outline" href="{{ route('artisan.profile.edit') }}">
                            Modifier ma Boutique
                        </x-ui.button>
                    </div>
                </div>
            </x-ui.card>

        </div>
    </div>
</x-app-layout>
