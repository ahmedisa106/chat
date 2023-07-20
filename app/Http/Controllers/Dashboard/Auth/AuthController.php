<?php

namespace App\Http\Controllers\Dashboard\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\AuthRequest;
use App\Models\AdminMessage;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin')->except(['loginForm', 'doLogin']);
    }

    public function loginForm()
    {
        return view('dashboard.auth.login');
    }

    public function doLogin(AuthRequest $request)
    {
        $credentials = $request->only(['email', 'password']);

        if (auth('admin')->attempt($credentials)) {
            \auth('admin')->user()->update(['status' => 1]);
            AdminMessage::query()->where('receiver_id', \auth('admin')->id())->where('delivered_status', 0)->update(['delivered_status' => 1]);
            return response()->json(auth('admin')->user());
        } else {

            return response()->json(['message' => 'Invalid Data'], 400);

        }

    }

    public function logout()
    {
        \auth('admin')->user()->update(['status' => 0]);
        Auth::guard('admin')->logout();
        return to_route('dashboard.index');
    }
}
