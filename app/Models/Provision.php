<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Provision extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'type',
        'length',
        'support_level',
        'students_count',
        'includes_with_plans',
        'starts_at',
        'ends_at',
        'created_by_id',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }

    public function schedules()
    {
        return $this->hasMany(ProvisionSchedule::class);
    }

    public function logs()
    {
        return $this->hasMany(ProvisionLog::class);
    }
}
