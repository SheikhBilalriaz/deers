<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departments;


class Appointment extends Model
{
    use HasFactory;

    protected $fillable = [
        'department_id',
        'user_id',
        'date',
        'start_time',
        'end_time',
        'status',
    ];

    /**
     * Get the department that owns the appointment.
     */
    public function department()
    {
        return $this->belongsTo(Departments::class);
    }

    /**
     * Get the user that owns the appointment.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
