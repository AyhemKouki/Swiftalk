<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{

    protected $fillable = [
        'sender_id',
        'receiver_id',
        'group_id',
        'message',
        'message_type',
        'attachment_path',
        'attachment_name',
        'attachment_type'

    ];
    public function group(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Group::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }

    public function hasAttachment()
    {
        return !empty($this->attachment_path);
    }

    public function getAttachmentUrl()
    {
        return $this->attachment_path ? asset('storage/' . $this->attachment_path) : null;
    }


}
