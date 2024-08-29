<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Thumbs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12">
                @include('components.uploadform')
            </div>
            <div>
                <livewire:show-thumbnails />
            </div>

        </div>
    </div>
</x-app-layout>
