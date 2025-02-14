<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Message
 * Represents an individual chat message sent within a conversation.
 */
class Message extends Model
{
    use HasFactory;

    protected $table = 'messages';

    // Fields that can be mass assigned
    protected $fillable = ['conversation_id', 'sender_id', 'message'];

    /**
     * Get the conversation this message belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the sender of this message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id')->withDefault();
    }

    /**
     * Get all files attached to this message.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function files()
    {
        return $this->hasMany(MessageFile::class);
    }
}
