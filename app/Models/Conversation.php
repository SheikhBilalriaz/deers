<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Conversation extends Model
{
    use HasFactory;
    protected $table = 'conversations';
    protected $fillable = [
        'type',
        'created_by'
    ];
    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function participants()
    {
        return $this->hasMany(MessageParticipant::class, 'conversation_id');
    }
    public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }
    public function unreadMessages()
    {
        return $this->hasMany(Message::class)->whereNull('read_at')->where('sender_id', '!=', Auth::id());
    }
}
