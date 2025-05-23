<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProvisionSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'provision_id',
        'day_of_week',
        'start_time',
        'end_time',
        'week_type',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];

    public function provision()
    {
        return $this->belongsTo(Provision::class);
    }
}
