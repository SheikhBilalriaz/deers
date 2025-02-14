<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class MessageFile
 * Represents files (attachments) sent with a message.
 */
class MessageFile extends Model
{
    use HasFactory;

    protected $table = 'message_files';

    // Fields that can be mass assigned
    protected $fillable = ['message_id', 'file_path', 'file_name', 'file_type'];

    /**
     * Get the message this file is associated with.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function message()
    {
        return $this->belongsTo(Message::class);
    }
}
