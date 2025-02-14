<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MessageParticipant
 * Represents users who are part of a conversation.
 */
class MessageParticipant extends Model
{
    use HasFactory;

    protected $table = 'conversation_participants';

    // Fields that can be mass assigned
    protected $fillable = ['conversation_id', 'user_id'];

    /**
     * Get the conversation that this participant belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    /**
     * Get the user associated with this participant.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
