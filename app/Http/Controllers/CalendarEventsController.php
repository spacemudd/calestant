<?php

namespace App\Http\Controllers;

use App\Models\ProvisionSchedule;
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
        $referenceDate = Carbon::parse($request->query('start', now()));
        if ($referenceDate->isFriday() || $referenceDate->isSaturday()) {
            $referenceDate->subWeek();
        }
        $startOfWeek = $referenceDate->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = $referenceDate->copy()->endOfWeek(Carbon::THURSDAY);

        $events = [];

        $provisionSchedules = ProvisionSchedule::with('provision')->get();

        $currentDate = $startOfWeek->copy();
        while ($currentDate->lte($endOfWeek)) {
            foreach ($provisionSchedules as $schedule) {
                if ($currentDate->dayOfWeek == $schedule->day_of_week) {
                    $weekType = AcademicCalendarHelper::getWeekType($currentDate);

                    if (
                        ($schedule->week_type === 'both' || $schedule->week_type === $weekType) &&
                        $currentDate->gte(Carbon::parse($schedule->provision->starts_at)) &&
                        $currentDate->lte(Carbon::parse($schedule->provision->ends_at)->addDay()->endOfDay())
                    ) {
                        $startTimeHour = $schedule->start_time->hour;
                        $startTimeMinutes = $schedule->start_time->minute;

                        $startDateTime = $currentDate->copy()->setTime($startTimeHour, $startTimeMinutes);

                        if ($schedule->end_time) {
                            $endTimeHour = $schedule->end_time->hour;
                            $endTimeMinutes = $schedule->end_time->minute;
                            $endDateTime = $currentDate->copy()->setTime($endTimeHour, $endTimeMinutes);
                        } else {
                            $endDateTime = $startDateTime->copy()->addHour();
                        }

                        $existingLog = $schedule->provision->logs()
                            ->whereDate('start_time', $startDateTime->toDateString())
                            ->whereTime('start_time', $startDateTime->toTimeString())
                            ->first();

                        $events[] = [
                            'title' => $schedule->provision->title,
                            'start' => $startDateTime->toIso8601String(),
                            'end' => $endDateTime->toIso8601String(),
                            'allDay' => false,
                            'provision_id' => $schedule->provision->id,
                            'logged' => (bool) $existingLog,
                            'log_entry' => $existingLog?->entry,
                        ];
                    }
                }
            }

            $currentDate->addDay();
        }

        return response()->json($events);
    }
}
