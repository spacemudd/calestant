<?php

namespace App\Http\Controllers;

use App\Models\ProvisionLog;
use Illuminate\Http\Request;

class ProvisionLogController extends Controller
{
    public function create(Request $request)
    {
        $title = $request->query('title');
        $start = $request->query('start');
        $end = $request->query('end');
        $provisionId = $request->query('provision_id');

        return view('logs.create', compact('title', 'start', 'end', 'provisionId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'provision_id' => 'required|exists:provisions,id',
            'entry' => 'required|string',
            'start_time' => 'nullable|date',
        ]);

        ProvisionLog::create([
            'provision_id' => $validated['provision_id'],
            'entry' => $validated['entry'],
            'start_time' => $request->input('start_time'),
            'created_by_id' => auth()->id(),
        ]);

        return redirect()->route('provisions.show', $validated['provision_id'])
                         ->with('success', 'Log entry created successfully.');
    }
}
