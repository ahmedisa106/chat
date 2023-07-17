<?php

namespace App\Observers;

use App\Models\Admin;
use App\Traits\upload;
use Illuminate\Http\Request;

class AdminObserver
{
    use upload;

    public function creating(Admin $admin)
    {
        if (request()->hasFile('photo')) {
            $admin->photo = $this->upload(request('photo'), 'admins');
        }
    }
}
