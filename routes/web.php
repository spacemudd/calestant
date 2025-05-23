<?php

use App\Http\Controllers\CalendarEventsController;
use App\Http\Controllers\MyTimetableController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/my-timetable', [MyTimetableController::class, 'index'])->name('my-timetable.index');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/events', [CalendarEventsController::class, 'store'])->name('events.store');
    Route::get('/events', [CalendarEventsController::class, 'index'])->name('events.index');
});

require __DIR__.'/auth.php';
