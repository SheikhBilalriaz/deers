<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Class Conversation
 * Represents a chat conversation between multiple users.
 */
class Conversation extends Model
{
    use HasFactory;

    protected $table = 'conversations';

    // Fields that can be mass assigned
    protected $fillable = ['type', 'created_by'];

    protected $casts = [
        'created_at' => 'datetime:Y-m-d H:i:s',
    ];

    /**
     * Get the user who created the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by')->withDefault();
    }

    /**
     * Get all messages in the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    /**
     * Get all participants in the conversation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
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
