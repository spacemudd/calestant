<?php

namespace App\Helpers;

use Carbon\Carbon;
use App\Models\Holiday;

class AcademicCalendarHelper
{
    public static function getWeekType(Carbon $date): string
    {
        $start = Carbon::parse('2025-06-01'); // Reference date: Week A
        $current = $start->copy();
        $weekType = 'A';

        while ($current->lt($date)) {
            $weekHasClass = false;
            for ($i = 0; $i < 7; $i++) {
                $day = $current->copy()->addDays($i);
                if (!Holiday::whereDate('date', $day)->exists()) {
                    $weekHasClass = true;
                    break;
                }
            }

            if ($weekHasClass) {
                $weekType = $weekType === 'A' ? 'B' : 'A';
            }

            $current->addWeek();
        }

        return $weekType;
    }
}
