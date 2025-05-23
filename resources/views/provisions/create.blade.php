<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('New Provision') }}
        </h2>
    </x-slot>

    <div class="main">
        <div class="container max-w-7xl mx-auto">
            <div class="grid grid-cols-12 p-10 justify-center">
                <div class="col-span-12">

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6 text-gray-900">
                            <form method="POST" action="{{ route('provisions.store') }}">
                                @csrf
                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Title</label>
                                    <input type="text" name="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300" required>
                                    @error('title')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Type</label>
                                    <select name="type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                                        <option value="">Select type</option>
                                        <option value="pull-out">Pull-out</option>
                                        <option value="push-in">Push-in</option>
                                        <option value="reduced-curriculum">Reduced Curriculum</option>
                                    </select>
                                    @error('type')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Length</label>
                                    <select name="length" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                                        <option value="">Select length</option>
                                        <option value="3-weeks">3 weeks</option>
                                        <option value="6-weeks">6 weeks</option>
                                        <option value="one-term">One term</option>
                                        <option value="year-round">Year-round</option>
                                    </select>
                                    @error('length')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Support Level</label>
                                    <select name="support_level" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300">
                                        <option value="">Select level</option>
                                        <option value="low">Low</option>
                                        <option value="moderate">Moderate</option>
                                        <option value="intensive">Intensive</option>
                                    </select>
                                    @error('support_level')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Number of Students</label>
                                    <input type="number" name="students_count" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300" min="0">
                                    @error('students_count')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="inline-flex items-center">
                                        <input type="checkbox" name="includes_with_plans" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500">
                                        <span class="ml-2 text-sm text-gray-700">Includes students with formal learning plans</span>
                                    </label>
                                    @error('includes_with_plans')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Provision Starts At</label>
                                    <input type="date" name="starts_at" id="starts_at" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300" required>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700">Provision Ends At</label>
                                    <input type="date" name="ends_at" id="ends_at" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring focus:ring-indigo-200 focus:border-indigo-300" readonly>
                                </div>

                                <div class="mb-4">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Recurring Schedule</label>
                                    <div id="schedule-container">
                                        <div class="schedule-entry flex space-x-2 mb-2 gap-2">
                                            <select name="schedules[0][week_type]" class="w-1/4 border-gray-300 rounded-md">
                                                <option value="both">Both Weeks</option>
                                                <option value="A">Week A</option>
                                                <option value="B">Week B</option>
                                            </select>
                                            <select name="schedules[0][day]" class="w-1/4 border-gray-300 rounded-md">
                                                <option value="">Day</option>
                                                <option value="0">Sunday</option>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                            </select>
                                            <input type="time" name="schedules[0][start_time]" class="w-1/4 border-gray-300 rounded-md" min="07:00" max="16:00">
                                            <input type="time" name="schedules[0][end_time]" class="w-1/4 border-gray-300 rounded-md" min="07:00" max="16:00">
                                        </div>
                                    </div>
                                    <button type="button" onclick="addScheduleEntry()" class="mt-2 text-sm text-blue-600 hover:underline">+ Add another</button>
                                </div>

                                <script>
                                    let scheduleIndex = 1;
                                    function addScheduleEntry() {
                                        const container = document.getElementById('schedule-container');
                                        const div = document.createElement('div');
                                        div.className = 'schedule-entry flex space-x-2 mb-2 gap-2';
                                        div.innerHTML = `
                                            <select name="schedules[${scheduleIndex}][week_type]" class="w-1/4 border-gray-300 rounded-md">
                                                <option value="both">Both Weeks</option>
                                                <option value="A">Week A</option>
                                                <option value="B">Week B</option>
                                            </select>
                                            <select name="schedules[${scheduleIndex}][day]" class="w-1/4 border-gray-300 rounded-md">
                                                <option value="">Day</option>
                                                <option value="0">Sunday</option>
                                                <option value="1">Monday</option>
                                                <option value="2">Tuesday</option>
                                                <option value="3">Wednesday</option>
                                                <option value="4">Thursday</option>
                                            </select>
                                            <input type="time" name="schedules[${scheduleIndex}][start_time]" class="w-1/4 border-gray-300 rounded-md" min="07:00" max="16:00">
                                            <input type="time" name="schedules[${scheduleIndex}][end_time]" class="w-1/4 border-gray-300 rounded-md" min="07:00" max="16:00">
                                        `;
                                        container.appendChild(div);
                                        scheduleIndex++;
                                    }
                                    document.querySelector('[name="length"]').addEventListener('change', function () {
                                        const startDate = document.getElementById('starts_at').value;
                                        const endInput = document.getElementById('ends_at');
                                        if (!startDate) return;

                                        const date = new Date(startDate);
                                        switch (this.value) {
                                            case '3-weeks':
                                                date.setDate(date.getDate() + 21);
                                                break;
                                            case '6-weeks':
                                                date.setDate(date.getDate() + 42);
                                                break;
                                            case 'one-term':
                                                date.setDate(date.getDate() + 84);
                                                break;
                                            case 'year-round':
                                                date.setFullYear(date.getFullYear() + 1);
                                                break;
                                            default:
                                                endInput.value = '';
                                                return;
                                        }
                                        endInput.valueAsDate = date;
                                    });
                                </script>

                                <div class="mt-6">
                                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                                        Save Provision
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
