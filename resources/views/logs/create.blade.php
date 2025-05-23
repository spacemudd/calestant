

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create Log') }}
        </h2>
    </x-slot>

    <div class="main">
        <div class="container max-w-7xl mx-auto">
            <div class="grid grid-cols-12 p-10 justify-center">
                <div class="col-span-12">
                    <form method="POST" action="{{ route('provision-logs.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Provision</label>
                            <input type="text" value="{{ $title }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <input type="hidden" name="provision_id" value="{{ $provisionId }}">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Start Time</label>
                            <input name="start_time" type="text" value="{{ $start }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">End Time</label>
                            <input name="end_time" type="text" value="{{ $end }}" readonly class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Log Entry</label>
                            <textarea name="entry" rows="5" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required></textarea>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Save Log
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
