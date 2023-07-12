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

    protected $appends = ['last_message'];

    public function getStatusAttribute($attribute)
    {
        return $attribute == 1 ? AdminStatusEnum::Online : AdminStatusEnum::Offline;

    }

    public function messages()
    {
        return $this->belongsToMany(Message::class, 'admin_messages', 'sender_id', 'message_id');
    }

    public function receivedMessages()
    {
        return $this->belongsToMany(Message::class, 'admin_messages', 'receiver_id', 'message_id');
    }

    public function getLastMessageAttribute()
    {
        $messages = $this->messages()->get()->toArray();
        $received = $this->receivedMessages()->get()->toArray();
        $messages = array_merge($received, $messages);
        return $this->attributes['last_message'] = collect($messages)->sortBy('created_at', 4, true)->first()['message'] ?? null;
    }

  


}
