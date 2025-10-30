<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @can('users.read')
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <livewire:users.user-list />
                </div>
            @else
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <div class="text-center">
                            <h3 class="text-lg font-medium text-gray-900 mb-2">Access Denied</h3>
                            <p class="text-gray-600">You don't have permission to access user management.</p>
                        </div>
                    </div>
                </div>
            @endcan
        </div>
    </div>
</x-app-layout>