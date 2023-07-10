<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminMessage extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $table = 'admin_messages';

    public function message()
    {
         return $this->belongsTo(Message::class,'message_id');
    }


}
