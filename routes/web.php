<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});




    Route::get('/admin/register', [AdminController::class, 'register'])->name('admin.register');
    Route::post('/admin/register', [AdminController::class, 'registerPost'])->name('admin.registerPost');
    Route::get('/admin/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/admin/login', [AdminController::class, 'loginPost'])->name('admin.loginPost');


    Route::get('/admin/logout', [App\Http\Controllers\IsAdminController::class, 'AdminLogout'])->name('admin.logout');
    Route::get('/user/logout', [App\Http\Controllers\UserController::class, 'UserLogout'])->name('user.logout');

    Route::get('/admin/dashboard', [App\Http\Controllers\IsAdminController::class, 'Admindashboard'])->name('admin.dashboard');
    Route::get('/user/userdashboard', [App\Http\Controllers\UserController::class, 'Userdashboard'])->name('user.userdashboard');



   
