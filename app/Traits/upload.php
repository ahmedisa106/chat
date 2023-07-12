<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait upload
{
    public function upload($file, $dir)
    {
        $name = Str::random(5) . '_' . $file->getClientOriginalName();
        return $file->storeAs('/' . $dir, $name, 'public');

    }
}
