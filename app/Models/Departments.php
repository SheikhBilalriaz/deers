<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Departments extends Model
{
    use HasFactory;

    protected $table = 'departsments';
    protected $fillable = [
        'name',
        'city',
        'address',
        'phone',
        'email',
        'status',
        'user_role',
        'user_id',
        'latitude',
        'longitude',
    ];

    public function members()
    {
        return $this->hasMany(User::class, 'department_id');
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function timeSlots()
    {
        return $this->hasMany(TimeSlot::class);
    }
}
