<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\ChatController;
use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:admin'], 'as' => 'dashboard.'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/get-conversation', [ChatController::class, 'getConversation'])->name('chat.getConversation');
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::group(['prefix' => 'dashboard', 'middleware' => ['guest:admin'], 'as' => 'dashboard.'], function () {

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');

});
