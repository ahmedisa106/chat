<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'messages';

    public function admin_messages()
    {
        return $this->hasMany(AdminMessage::class);
    }

    public function admins()
    {
        return $this->belongsToMany(Admin::class, 'admin_messages', 'message_id', 'sender_id')->withTimestamps();
    }
}
