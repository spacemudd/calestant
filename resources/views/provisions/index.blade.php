<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Provisions') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between mb-4">
                        <h3 class="text-lg font-semibold">My Provisions</h3>
                        <a href="{{ route('provisions.create') }}"
                           class="inline-block px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">
                            + New Provision
                        </a>
                    </div>

                    @if($provisions->isEmpty())
                        <p class="text-gray-500">You have not added any provisions yet.</p>
                    @else
                        <ul class="divide-y divide-gray-200">
                            @foreach($provisions as $provision)
                                <li class="py-2">
                                    <a href="{{ route('provisions.show', $provision) }}"
                                       class="text-blue-600 hover:underline">
                                        {{ $provision->title }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
