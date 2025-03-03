<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConversationParticipant extends Model
{
    use HasFactory;
    protected $table = 'conversation_participants';
    protected $fillable = [
        'conversation_id',
        'user_id'
    ];
    public function conversation()
    {
        return $this->belongsTo(Conversation::class, 'conversation_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
