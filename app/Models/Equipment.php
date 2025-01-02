<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Departments;
use App\Models\User;

class Equipment extends Model
{
    use HasFactory;
    protected $table = 'equipments';
    protected $fillable = ['title', 'user_id', 'department_id', 'image', 'description'];

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
