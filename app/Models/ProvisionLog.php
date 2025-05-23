<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProvisionLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'provision_id',
        'created_by_id',
        'start_time',
        'end_time',
        'entry',
    ];

    public function provision()
    {
        return $this->belongsTo(Provision::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by_id');
    }
}
