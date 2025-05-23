<?php

namespace App\Http\Controllers;

use App\Models\Provision;
use Illuminate\Http\Request;

class ProvisionController extends Controller
{
    public function index()
    {
        $provisions = Provision::where('created_by_id', auth()->id())->get();
        return view('provisions.index', compact('provisions'));
    }

    public function create()
    {
        return view('provisions.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'nullable|in:pull-out,push-in,reduced-curriculum',
            'length' => 'nullable|in:3-weeks,6-weeks,one-term,year-round',
            'support_level' => 'nullable|in:low,moderate,intensive',
            'students_count' => 'nullable|integer|min:0',
            'includes_with_plans' => 'nullable',
            'starts_at' => 'required|date',
            'ends_at' => 'required|date|after_or_equal:starts_at',
            'schedules' => 'nullable|array',
            'schedules.*.day' => 'required|integer|between:0,6',
            'schedules.*.start_time' => 'required|date_format:H:i',
            'schedules.*.end_time' => 'nullable|date_format:H:i',
            'schedules.*.week_type' => 'required|in:A,B,both',
        ]);

        $provision = Provision::create([
            'title' => $validated['title'],
            'type' => $validated['type'] ?? null,
            'length' => $validated['length'] ?? null,
            'support_level' => $validated['support_level'] ?? null,
            'students_count' => $validated['students_count'] ?? 0,
            'includes_with_plans' => $request->has('includes_with_plans'),
            'starts_at' => $validated['starts_at'],
            'ends_at' => $validated['ends_at'],
            'created_by_id' => auth()->id(),
        ]);

        if (!empty($validated['schedules'])) {
            foreach ($validated['schedules'] as $schedule) {
                $provision->schedules()->create([
                    'day_of_week' => $schedule['day'],
                    'start_time' => $schedule['start_time'],
                    'end_time' => $schedule['end_time'] ?? null,
                    'week_type' => $schedule['week_type'],
                ]);
            }
        }

        return redirect()->route('provisions.show', $provision);
    }

    public function show(Provision $provision)
    {
        //$this->authorize('view', $provision);

        $provision->load('schedules');
        return view('provisions.show', compact('provision'));
    }

    public function edit(Provision $provision)
    {
        //$this->authorize('update', $provision);
        return view('provisions.edit', compact('provision'));
    }

    public function update(Request $request, Provision $provision)
    {
        //$this->authorize('update', $provision);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
        ]);

        $provision->update($validated);

        return redirect()->route('provisions.show', $provision);
    }

    public function destroy(Provision $provision)
    {
        //$this->authorize('delete', $provision);
        $provision->delete();

        return redirect()->route('provisions.index');
    }
}
