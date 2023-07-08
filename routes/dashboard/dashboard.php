<?php

use App\Http\Controllers\Dashboard\Auth\AuthController;
use App\Http\Controllers\Dashboard\HomeController;
use Illuminate\Support\Facades\Route;


Route::group(['prefix' => 'dashboard', 'middleware' => ['auth:admin'], 'as' => 'dashboard.'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');

    Route::get('/admins',[\App\Http\Controllers\Dashboard\AdminController::class,'index'])->name('admins.index');
    Route::post('/logout',[AuthController::class,'logout'])->name('logout');

});

Route::group(['prefix' => 'dashboard', 'middleware' => ['guest:admin'], 'as' => 'dashboard.'], function () {

    Route::get('/login', [AuthController::class, 'loginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'doLogin'])->name('doLogin');

});
