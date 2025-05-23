<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="main">
        <div class="container max-w-7xl mx-auto">
            <div class="grid grid-cols-12 p-10 justify-center">
                <div class="col-span-12">
                    <h1 class="text-2xl font-bold text-center lowercase">welcome, {{ auth()->user()->name }}.</h1>
                </div>
            </div>

            <div class="grid grid-cols-12 p-10 justify-normal gap-5">
                <div class="col-span-4">
                    <div class="bg-blue-200 p-5 rounded-lg shadow-lg">
                        <p class="text-center lowercase">{{ auth()->user()->name }}</p>
                        <p class="text-center mt-5"><a href="{{ route('my-timetable.index') }}" class="text-sm text-center border p-1 bg-blue-600 text-white rounded hover:bg-blue-800">view timetable</a></p>
                    </div>
                </div>


                <div class="col-span-4">
                    <div class="bg-blue-200 p-5 rounded-lg shadow-lg">
                        <p class="text-center lowercase">sana</p>
                        <p class="text-center mt-5"><a href="#" class="text-sm text-center border p-1 bg-blue-600 text-white rounded hover:bg-blue-800">view timetable</a></p>
                    </div>
                </div>

                <div class="col-span-4">
                    <div class="bg-blue-200 p-5 rounded-lg shadow-lg">
                        <p class="text-center lowercase">rana</p>
                        <p class="text-center mt-5"><a href="#" class="text-sm text-center border p-1 bg-blue-600 text-white rounded hover:bg-blue-800">view timetable</a></p>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
