<?php

use App\Http\Controllers\Dashboard\AdminController;
use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\ChatController;
use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:admin'], 'as' => 'dashboard.'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('/admins', [AdminController::class, 'index'])->name('admins.index');
    Route::get('admins/data', [AdminController::class, 'data'])->name('admins.data');
    Route::post('admins', [AdminController::class, 'store'])->name('admins.store');
    Route::post('admins/{admin}', [AdminController::class, 'update'])->name('admins.update');
    Route::get('admins/get-admins', [AdminController::class, 'getSortedAdmins'])->name('admins.getAdmins');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/get-conversation', [ChatController::class, 'getConversation'])->name('chat.getConversation');
    Route::post('chat/send-message', [ChatController::class, 'sendMessage'])->name('chat.sendMessage');
    Route::post('chat/make-messages-read', [ChatController::class, 'makeMessagesRead'])->name('chat.makeMessagesRead');
    Route::post('chat/updateDelivery', [ChatController::class, 'updateDelivery'])->name('chat.updateDelivery');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

});

Route::group(['prefix' => 'dashboard', 'middleware' => ['guest:admin'], 'as' => 'dashboard.'], function () {

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');

});
