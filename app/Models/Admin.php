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

    public function unreadMessages()
    {
        return $this->hasMany(AdminMessage::class, 'receiver_id')->where('seen_status', 0);
    }

    public function setPasswordAttribute($password)
    {
        if (!is_null($password)) {
            $this->attributes['password'] = bcrypt($password);
        } else {
            $this->attributes['password'] = $password;
        }
    }


}
