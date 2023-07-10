<?php

namespace App\Models;

use App\Enums\AdminStatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $guarded = [];

    protected $hidden = ['password'];

    public function getStatusAttribute($attribute)
    {
        return $attribute == 1 ? AdminStatusEnum::Online : AdminStatusEnum::Offline;

    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'admin_messages', 'sender_id', 'message_id');
    }

    public function lastMessageFromMe()
    {
        return $this->hasOne(AdminMessage::class, 'sender_id')->latest('id');
    }
    public function lastMessage()
    {
        return $this->hasOne(AdminMessage::class, 'receiver_id')->latest('id');
    }


}
