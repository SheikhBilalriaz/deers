<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageFile extends Model
{
    use HasFactory;
    protected $table = 'message_files';
    protected $fillable = [
        'message_id',
        'file_path',
        'file_name',
        'file_type'
    ];
    public function message()
    {
        return $this->belongsTo(Message::class, 'message_id');
    }
}
