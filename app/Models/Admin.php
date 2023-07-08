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


}
