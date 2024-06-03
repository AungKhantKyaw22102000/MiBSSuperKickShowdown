<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PlayerController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\FootballMatchController;

// Public routes
Route::get('/', [UserController::class, 'home'])->name('user#homePage');

// gallery routes
Route::get('/blog', [UserController::class, 'blogList'])->name('user#blogPage');
Route::get('/blog/detail/{id}', [UserController::class, 'blogDetail'])->name('user#blogDetail');

// club routes
Route::get('/club', [UserController::class, 'clubList'])->name('user#clubList');
Route::get('/club/detail/{id}', [UserController::class, 'clubDetail'])->name('user#clubDetail');

// contact route
Route::get('/contact', [UserController::class, 'contact'])->name('user#contactPage');

// match routes
Route::get('/match', [UserController::class, 'matchList'])->name('user#matchPage');

// players routes
Route::get('/player', [UserController::class, 'playerList'])->name('user#playerPage');

// result routes
Route::get('/result', [UserController::class, 'resultList'])->name('user#resultPage');

// statistic routes
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
            Route::post('update', [ClubController::class, 'clubUpdate'])->name('admin#clubUpdate');
        });

        // Match Routes
        Route::prefix('footballMatch')->group(function(){
            Route::get('list', [FootballMatchController::class, 'footballMatchList'])->name('admin#footballMatchList');
            Route::get('createPage', [FootballMatchController::class, 'footballMatchCreatePage'])->name('admin#footballMatchCreatePage');
            Route::post('create', [FootballMatchController::class, 'footballMatchCreate'])->name('admin#footballMatchCreate');
            Route::get('delete/{id}', [FootballMatchController::class, 'footballMatchDelete'])->name('admin#footballMatchDelete');
            Route::get('update/{id}', [FootballMatchController::class, 'footballMatchUpdatePage'])->name('admin#footballMatchUpdatePage');
            Route::post('update', [FootballMatchController::class, 'footballMatchUpdate'])->name('admin#footballMatchUpdate');
            Route::get('result', [FootballMatchController::class, 'footballMatchResultList'])->name('admin#footballMatchResultList');
        });

        // Player Routes
        Route::prefix('player')->group(function(){
            Route::get('list', [PlayerController::class, 'playerList'])->name('admin#playerList');
            Route::get('createPage', [PlayerController::class, 'playerCreatePage'])->name('admin#playerCreatePage');
            Route::post('create', [PlayerController::class, 'playerCreate'])->name('admin#playerCreate');
            Route::get('detail/{id}', [PlayerController::class, 'playerDetail'])->name('admin#playerDetail');
            Route::get('delte/{id}', [PlayerController::class, 'playerDelete'])->name('admin#playerDelete');
            Route::get('update/{id}', [PlayerController::class, 'playerUpdatePage'])->name('admin#playerUpdatePage');
            Route::post('update', [PlayerController::class, 'playerUpdate'])->name('admin#playerUpdate');
            Route::get('stats', [PlayerController::class, 'playerStats'])->name('admin#playerStats');
        });

        // Gallery Routes
        Route::prefix('gallery')->group(function(){
            Route::get('list', [GalleryController::class, 'galleryList'])->name('admin#galleryList');
            Route::get('createPage', [GalleryController::class, 'galleryCreatePage'])->name('admin#galleryCreatePage');
            Route::post('create', [GalleryController::class, 'galleryCreate'])->name('admin#galleryCreate');
            Route::get('detail/{id}', [GalleryController::class, 'galleryDetail'])->name('admin#galleryDetail');
            Route::get('delete/{id}', [GalleryController::class, 'deleteGallery'])->name('admin#deleteGallery');
            Route::get('update/{id}', [GalleryController::class, 'galleryUpdatePage'])->name('admin#galleryUpdatePage');
            Route::post('update', [GalleryController::class, 'galleryUpdate'])->name('admin#galleryUpdate');
        });

        // Users Routes
        Route::prefix('users')->group(function(){
            Route::get('list', [AdminController::class, 'userList'])->name('admin#userList');
            Route::get('delete/{id}', [AdminController::class, 'userDelete'])->name('admin#userDelete');
            Route::get('change/role', [AdminController::class, 'changeRole'])->name('admin#changeRole');
            Route::get('detail/{id}', [AdminController::class, 'userDetail'])->name('admin#userDetail');
        });

        // profile routes
        Route::prefix('profile')->group(function(){
            Route::get('adminProfile', [AdminController::class, 'adminProfile'])->name('admin#adminProfile');
            Route::post('adminUpdate/{id}', [AdminController::class, 'adminUpdate'])->name('admin#update');
            Route::get('adminChangePasswordPage', [AdminController::class, 'adminChangePasswordPage'])->name('admin#changePasswordPage');
            Route::post('adminChangePassword', [AdminController::class, 'adminChangePassword'])->name('admin#changePassword');
        });

        // comment
        Route::prefix('comment')->group(function(){
            Route::get('comment',[GalleryController::class, 'comment'])->name('admin#comment');
            Route::post('createComment',[GalleryController::class, 'createComment'])->name('admin#createComment');
        });
    });

    // User-specific routes
    Route::prefix('user')->group(function(){
        Route::get('profile', [UserController::class, 'profile'])->name('user#profile');
        Route::post('updateProfile', [UserController::class, 'updateProfile'])->name('user#updateProfile');
    });
});

