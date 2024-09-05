<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\EventsController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\EventRegisterController;

       Route::post('register', [MemberController::class, 'Registerapp']);
       Route::post('login', [MemberController::class, 'Loginapp']);

    Route::get('viewprofile', [MemberController::class, 'getProfile']);
    Route::post('logout', [MemberController::class, 'Logout']);
    Route::get('viewprofile', [MemberController::class, 'getProfile']);
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
