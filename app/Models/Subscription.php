<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'can_look_at_records',
        'can_book_appointments',
        'can_store_documents',
        'can_make_appointments',
        'can_upload_documents',
    ];

    public function subscription()
    {
        return $this->hasOne(Subscription::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

}
