<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Timetable') }}
        </h2>
    </x-slot>

    <div class="main">
        <div class="container max-w-7xl mx-auto">
            <div class="grid grid-cols-12 p-10 justify-center">
                <div class="col-span-12">
                    <h1 class="text-2xl font-bold text-center lowercase">Welcome, {{ auth()->user()->name }}.</h1>
                    <p class="text-center mb-4">Here’s your weekly calendar (Sunday–Thursday)</p>

                    <div id="calendarContainer" class="p-4">
                        <div id="calendar" class="bg-white shadow rounded p-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>

        </script>
    @endpush
</x-app-layout>
