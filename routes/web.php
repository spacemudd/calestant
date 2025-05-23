<?php

use App\Http\Controllers\CalendarEventsController;
use App\Http\Controllers\MyTimetableController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProvisionController;
use App\Http\Controllers\ProvisionLogController;

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

    // Provisions routes
    Route::get('/provisions', [ProvisionController::class, 'index'])->name('provisions.index');
    Route::get('/provisions/create', [ProvisionController::class, 'create'])->name('provisions.create');
    Route::post('/provisions', [ProvisionController::class, 'store'])->name('provisions.store');
    Route::get('/provisions/{provision}', [ProvisionController::class, 'show'])->name('provisions.show');
    Route::get('/provisions/{provision}/edit', [ProvisionController::class, 'edit'])->name('provisions.edit');
    Route::put('/provisions/{provision}', [ProvisionController::class, 'update'])->name('provisions.update');
    Route::delete('/provisions/{provision}', [ProvisionController::class, 'destroy'])->name('provisions.destroy');

    Route::get('/logs/create', [ProvisionLogController::class, 'create'])->name('provision-logs.create');
    Route::post('/logs', [ProvisionLogController::class, 'store'])->name('provision-logs.store');
});

require __DIR__.'/auth.php';
