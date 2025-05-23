<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main>
                {{ $slot }}
            </main>
        </div>
        @stack('scripts')
        <div id="log-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
                <h2 class="text-lg font-semibold mb-4">Create Log</h2>
                <form method="POST" action="{{ route('provision-logs.store') }}">
                    @csrf
                    <input type="hidden" name="provision_id">
                    <input type="hidden" name="start_time">
                    <input type="hidden" name="end_time">
                    <input type="hidden" name="title">

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Log Entry</label>
                        <textarea name="entry" rows="4" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm" required></textarea>
                    </div>

                    <div class="flex justify-end">
                        <button type="button" onclick="document.getElementById('log-modal').classList.add('hidden')" class="px-4 py-2 mr-2 bg-gray-300 text-black rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>
