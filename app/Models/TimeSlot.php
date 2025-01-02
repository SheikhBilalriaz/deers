<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimeSlot extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'start_time',
        'end_time',
        'day',
    ];

    /**
     * Get the department that owns the time slot.
     */
    public function department()
    {
        return $this->belongsTo(Departments::class);
    }
}
