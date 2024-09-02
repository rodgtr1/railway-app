<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 dark:text-gray-200 leading-tight text-center">
            {{ __('Thumbs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-12">
                @if (session('status') === 'thumbnail-uploaded' || session('status') === 'background-job-initiated')
                    <div x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 3000)"
                    class="max-w-lg mx-auto rounded-md bg-gray-200 p-4 mb-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <svg class="h-5 w-5 text-green-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <div class="text-sm font-medium text-green-800">{{ session('status') === 'thumbnail-uploaded' ? 'Thumbnail uploaded!' : 'Background removal init!' }}</div>
                            </div>
                        </div>
                    </div>
                    @endif
                @include('components.uploadform')
            </div>
            <div>
                <livewire:show-thumbnails />
            </div>

        </div>
    </div>
</x-app-layout>
