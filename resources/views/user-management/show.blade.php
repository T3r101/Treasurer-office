<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('User Details') }}
        </h2>
    </x-slot>

<div class="py-6 bg-[#1a1d29]">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="mb-4">
                        <strong>ID:</strong> {{ $user->id }}
                    </div>
                    <div class="mb-4">
                        <strong>Name:</strong> {{ $user->name }}
                    </div>
                    <div class="mb-4">
                        <strong>Email:</strong> {{ $user->email }}
                    </div>
                    <div class="mb-4">
                        <strong>Role:</strong> {{ ucfirst($user->role) }}
                    </div>
                    <div class="mb-4">
                        <strong>Email Verified At:</strong> {{ $user->email_verified_at ? $user->email_verified_at->format('Y-m-d H:i:s') : 'Not verified' }}
                    </div>
                    <div class="mb-4">
                        <strong>Created At:</strong> {{ $user->created_at->format('Y-m-d H:i:s') }}
                    </div>
                    <div class="mb-4">
                        <strong>Updated At:</strong> {{ $user->updated_at->format('Y-m-d H:i:s') }}
                    </div>

                    <div class="flex items-center justify-end">
                        <a href="{{ route('user-management.index') }}" class="mr-4 text-gray-600 hover:text-gray-900">Back to List</a>
                        <a href="{{ route('user-management.edit', $user) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>