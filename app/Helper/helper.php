<?php

if (!function_exists('getFile')) {

    function getFile($path)
    {

        if(!$path){
            return asset('defaults/default.jpg');
        }
        if (is_link($path)) {
            return $path;
        } elseif (\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return asset('storage/' . $path);
        } else {

            return asset('defaults/default.jpg');
        }

    }
}
