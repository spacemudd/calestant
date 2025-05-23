

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ $provision->title }}
        </h2>
    </x-slot>

    <div class="main">
        <div class="container max-w-7xl mx-auto">
            <div class="grid grid-cols-12 p-10 justify-center">
                <div class="col-span-12">
                    <div class="bg-white p-6 shadow rounded">
                        <div class="mb-4">
                            <strong>Type:</strong> {{ $provision->type ?? '—' }}
                        </div>
                        <div class="mb-4">
                            <strong>Length:</strong> {{ $provision->length ?? '—' }}
                        </div>
                        <div class="mb-4">
                            <strong>Support Level:</strong> {{ $provision->support_level ?? '—' }}
                        </div>
                        <div class="mb-4">
                            <strong>Number of Students:</strong> {{ $provision->students_count }}
                        </div>
                        <div class="mb-4">
                            <strong>Includes Students with Plans:</strong>
                            {{ $provision->includes_with_plans ? 'Yes' : 'No' }}
                        </div>
                        <div class="mb-4">
                            <strong>Starts At:</strong> {{ \Carbon\Carbon::parse($provision->starts_at)->format('F j, Y') }}
                            <span class="text-gray-500 text-sm">({{ \Carbon\Carbon::parse($provision->starts_at)->diffForHumans() }})</span>
                        </div>
                        <div class="mb-4">
                            <strong>Ends At:</strong> {{ \Carbon\Carbon::parse($provision->ends_at)->format('F j, Y') }}
                            <span class="text-gray-500 text-sm">({{ \Carbon\Carbon::parse($provision->ends_at)->diffForHumans() }})</span>
                        </div>
                        <div class="mb-4">
                            <strong>Recurring Schedule:</strong>
                            @if($provision->schedules->isEmpty())
                                <p class="text-gray-500">No schedule defined.</p>
                            @else
                                <ul class="list-disc list-inside mt-2">
                                    @foreach($provision->schedules as $schedule)
                                        <li>
                                            {{ \Carbon\Carbon::parse("next sunday")->addDays($schedule->day_of_week)->format('l') }}
                                            @ {{ $schedule->start_time->format('g:i A') }}
                                            (Week {{ $schedule->week_type }})
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                        <div class="mt-6">
                            <a href="{{ route('provisions.edit', $provision) }}"
                               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                Edit Provision
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
