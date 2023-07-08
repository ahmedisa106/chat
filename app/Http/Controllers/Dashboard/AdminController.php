<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admins = Admin::all(['id','name','email','status']);
        return view('dashboard.pages.admins.index',compact('admins'));
    }
}
