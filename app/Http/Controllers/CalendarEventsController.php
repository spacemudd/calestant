<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;

use App\Models\CalendarEvent;

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
        $events = CalendarEvent::where('created_by_id', auth()->id())->get();
        return response()->json($events);
    }
}
