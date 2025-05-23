<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\CalendarEvent;
use App\Helpers\AcademicCalendarHelper;

class CalendarEventsController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'start' => 'required|date',
            'end' => 'nullable|date',
            'allDay' => 'boolean',
        ]);

        $start = Carbon::parse($validated['start'])->timezone('Asia/Riyadh');
        $end = isset($validated['end']) ? Carbon::parse($validated['end'])->timezone('Asia/Riyadh') : $start;

        $event = CalendarEvent::create([
            'title' => $validated['title'],
            'start' => $start,
            'end' => $end,
            'all_day' => $validated['allDay'] ?? false,
            'created_by_id' => auth()->id(),
        ]);

        return response()->json($event);
    }

    public function index(Request $request)
    {
        $startOfWeek = Carbon::parse($request->query('start', now()))->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::parse($request->query('end', now()->endOfWeek()));

        $events = [];

        $provisionSchedules = \App\Models\ProvisionSchedule::with('provision')->get();

        $currentDate = $startOfWeek->copy();
        while ($currentDate->lte($endOfWeek)) {
            foreach ($provisionSchedules as $schedule) {
                if ($currentDate->dayOfWeek == $schedule->day_of_week) {
                    $weekType = AcademicCalendarHelper::getWeekType($currentDate);

                    if ($schedule->week_type === 'both' || $schedule->week_type === $weekType) {
                        $startDateTime = $currentDate->copy()->setTimeFromTimeString($schedule->start_time);
                        $endDateTime = $schedule->end_time
                            ? $currentDate->copy()->setTimeFromTimeString($schedule->end_time)
                            : $startDateTime->copy()->addHour();

                        $events[] = [
                            'title' => $schedule->provision->title,
                            'start' => $startDateTime->toIso8601String(),
                            'end' => $endDateTime->toIso8601String(),
                            'allDay' => false,
                        ];
                    }
                }
            }

            $currentDate->addDay();
        }

        return response()->json($events);
    }
}
