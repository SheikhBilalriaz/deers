<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'first_name',
        'last_name',
        'name',
        'email',
        'password',
        'role',
        'department_id',
        'status',
        'phone_number',
        'years_of_experience',
        'rank',
        'branch',
        'is_verified',
        'email_verified_at'
    ];
    protected $hidden = [
        'password',
        'remember_token',
    ];
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];
    public function department()
    {
        return $this->belongsTo(Departments::class, 'department_id');
    }
    public function documents()
    {
        return $this->hasMany(Document::class);
    }
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function userSubscriptions()
    {
        return $this->hasMany(UserSubscription::class);
    }
    public function getJWTCustomClaims()
    {
        return [];
    }
}
