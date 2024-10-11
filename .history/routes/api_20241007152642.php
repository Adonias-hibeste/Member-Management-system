<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\profilecontroller;
use App\Http\Controllers\CatagoryController;
use App\Http\Controllers\MembershipController;
use App\Http\Controllers\ProfilepicController;
use App\Http\Controllers\EventRegisterController;

     Route::get('memberships', [MembershipController::class, 'getMemberships']);
     Route::post('register', [AdminController::class, 'registerapp']);
     Route::post('login', [AdminController::class, 'loginapp']);

     Route::post('/upload-profile-image', [ProfilepicController::class, 'uploadProfileImage']);

     Route::middleware('api')->group(function () {
        Route::get('/categories', [CatagoryController::class, 'index']);
        Route::get('/products', [ProductController::class, 'index']);
    });


    Route::get('blogs', [PostController::class, 'index']);
    Route::get('blogs/{id}', [PostController::class, 'show']);
    Route::get('news', [NewsController::class, 'index1']);
    Route::get('news/{id}', [NewsController::class, 'show1']);
    Route::get('events', [EventsController::class, 'index2']);
    Route::get('events/{id}', [EventsController::class, 'show2']);
    Route::get('eventsapp', [EventsController::class, 'index']);
    Route::post('registereventsapp', [EventRegisterController::class, 'store']);
    Route::post('comments', [CommentController::class, 'store']);
    Route::get('comments', [CommentController::class, 'index']);
