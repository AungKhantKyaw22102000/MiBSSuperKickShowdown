<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\FootballMatchController;

// Public routes
Route::get('/', [UserController::class, 'home'])->name('user#homePage');
Route::get('/blog', [UserController::class, 'blogList'])->name('user#blogPage');
Route::get('/club', [UserController::class, 'clubList'])->name('user#clubList');
Route::get('/contact', [UserController::class, 'contact'])->name('user#contactPage');
Route::get('/match', [UserController::class, 'matchList'])->name('user#matchPage');
Route::get('/player', [UserController::class, 'playerList'])->name('user#playerPage');
Route::get('/result', [UserController::class, 'resultList'])->name('user#resultPage');
Route::get('/stats', [UserController::class, 'statList'])->name('user#statsPage');

// Login and register routes
Route::middleware(['guest'])->group(function(){
    Route::get('loginPage', [AuthController::class, 'loginPage'])->name('auth#loginPage');
    Route::get('registerPage', [AuthController::class, 'registerPage'])->name('auth#registerPage');
});

// Routes for authenticated users
Route::middleware(['auth'])->group(function () {
    // Admin dashboard
    Route::get('dashboard', [AuthController::class, 'adminDashboard'])->name('admin#dashboard');

    Route::prefix('admin')->middleware(['admin_auth'])->group(function(){

        // Club routes
        Route::prefix('club')->group(function(){
            Route::get('list', [ClubController::class, 'clubList'])->name('admin#clubList');
            Route::get('createPage', [ClubController::class, 'clubCreatePage'])->name('admin#clubCreatePage');
            Route::post('create', [ClubController::class, 'clubCreate'])->name('admin#clubCreate');
            Route::get('detail/{id}', [ClubController::class, 'clubDetail'])->name('admin#clubDetail');
            Route::get('delete/{id}', [ClubController::class, 'clubDelete'])->name('admin#clubDelete');
            Route::get('update/{id}', [ClubController::class, 'clubUpdatePage'])->name('admin#clubUpdatePage');
            Route::post('udpate', [ClubController::class, 'clubUpdate'])->name('admin#clubUpdate');
        });

        // Match routes
        Route::prefix('footballMatch')->group(function(){
            Route::get('list', [FootballMatchController::class, 'footballMatchList'])->name('admin#footballMatchList');
        });

        // Player Routes
        Route::prefix('player')->group(function(){
            Route::get('list', [PlayerController::class, 'playerList'])->name('admin#playerList');
        });

        // Gallery Routes
        Route::prefix('gallery')->group(function(){
            Route::get('list', [GalleryController::class, 'galleryList'])->name('admin#galleryList');
        });
    });

    // User-specific routes
    Route::prefix('user')->group(function(){
        Route::get('profile', [UserController::class, 'profile'])->name('user#profile');
        Route::post('updateProfile', [UserController::class, 'updateProfile'])->name('user#updateProfile');
    });
});

