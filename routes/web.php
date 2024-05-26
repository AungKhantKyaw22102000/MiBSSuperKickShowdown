<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\User\UserController;

// login , register
Route::redirect('/', 'loginPage');
Route::middleware(['admin_auth'])->group(function(){
    Route::get('loginPage',[AuthController::class,'loginPage'])->name('auth#loginPage');
    Route::get('registerPage',[AuthController::class, 'registerPage'])->name('auth#registerPage');
});

Route::middleware(['auth'])->group(function () {

    // dashboard
    Route::get('dashboard',[AuthController::class,'adminDashboard'])->name('admin#dashboard');

    Route::middleware(['admin_auth'])->group(function(){
        // club
        Route::prefix('club')->group((function(){
            Route::get('list',[ClubController::class,'clubList'])->name('admin#clubList');
        }));
    });

    // dashboard
    Route::get('dashboard',[AuthController::class,'adminDashboard'])->name('admin#dashboard');

    // user
    Route::prefix('user')->middleware(('user_auth'))->group(function(){
    });
});
Route::get('homePage',[UserController::class,'home'])->name('user#home');
