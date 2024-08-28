<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventRegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AdminForgotPasswordController;
use App\Http\Controllers\SettingController;

Route::get('/', function () {
    return redirect()->route('admin.login');
});

    Route::get('/admin/register', [App\Http\Controllers\AdminController::class, 'register'])->name('admin.register');
    Route::post('/admin/register', [App\Http\Controllers\AdminController::class, 'registerPost'])->name('admin.registerPost');
    Route::get('/admin/login', [App\Http\Controllers\AdminController::class, 'login'])->name('admin.login');
    Route::post('/admin/login', [App\Http\Controllers\AdminController::class, 'loginPost'])->name('admin.loginPost');
    Route::get('/admin/forgot', [App\Http\Controllers\AdminForgotPasswordController::class, 'showForgotPasswordForm'])->name('admin.forgot');
    Route::post('/admin/forgot', [AdminForgotPasswordController::class, 'sendResetLink'])->name('admin.sendResetLink');

    Route::get('/admin/logout', [App\Http\Controllers\IsAdminController::class, 'AdminLogout'])->name('admin.logout');

    Route::get('/admin/dashboard', [App\Http\Controllers\IsAdminController::class, 'Admindashboard'])->name('admin.dashboard')->middleware('admin');





    Route::get('/admin/post', [App\Http\Controllers\PostController::class, 'Post'])->name('admin.post');
    Route::get('/admin/createpost', [App\Http\Controllers\PostController::class, 'Create'])->name('admin.createpost');
    Route::post('/admin/createpost', [App\Http\Controllers\PostController::class, 'Store'])->name('admin.createpost-post');
    Route::get('/admin/post/{post_id}', [App\Http\Controllers\PostController::class, 'Edit'])->name('admin.edit');
    Route::put('/admin/updatePost/{post_id}', [App\Http\Controllers\PostController::class, 'Update']);
    Route::get('admin/deletePost/{post_id}', [App\Http\Controllers\PostController::class, 'Destroy']);



    Route::get('/admin/news', [App\Http\Controllers\NewsController::class, 'News'])->name('admin.news');
    Route::get('/admin/createnews', [App\Http\Controllers\NewsController::class, 'Create'])->name('admin.createnews');
    Route::post('/admin/createnews', [App\Http\Controllers\NewsController::class, 'Store'])->name('admin.createnews-post');
    Route::get('/admin/news/{news_id}', [App\Http\Controllers\NewsController::class, 'Edit'])->name('admin.editnews');
    Route::put('/admin/updatenews/{news_id}', [App\Http\Controllers\NewsController::class, 'Update']);
    Route::get('admin/deletenews/{news_id}', [App\Http\Controllers\NewsController::class, 'Destroy']);



    Route::get('/admin/events', [App\Http\Controllers\EventsController::class, 'Events'])->name('admin.events');
    Route::get('/admin/createevents', [App\Http\Controllers\EventsController::class, 'Create'])->name('admin.createevents');
    Route::post('/admin/createevents', [App\Http\Controllers\EventsController::class, 'Store'])->name('admin.createevents-post');
    Route::get('/admin/events/{events_id}', [App\Http\Controllers\EventsController::class, 'Edit'])->name('admin.editevents');
    Route::put('/admin/updateevents/{events_id}', [App\Http\Controllers\EventsController::class, 'Update']);
    Route::get('admin/deleteevents/{events_id}', [App\Http\Controllers\EventsController::class, 'Destroy']);

    Route::get('/admin/registeredusers', [App\Http\Controllers\RegUserController::class, 'Users'])->name('admin.registeredusers');
    Route::get('/admin/registeredusers/{user_id}', [App\Http\Controllers\RegUserController::class, 'EditUser'])->name('admin.edituser');
    Route::put('/admin/updateuser/{user_id}', [App\Http\Controllers\RegUserController::class, 'Update']);

    Route::get('/admin/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings', [App\Http\Controllers\SettingController::class, 'savedata'])->name('admin.settings.addsettings');




    Route::get('/user/userdashboard', [App\Http\Controllers\UserController::class, 'Userdashboard'])->name('user.userdashboard')->middleware('admin');

    Route::get('/user/logout', [App\Http\Controllers\UserController::class, 'UserLogout'])->name('user.logout');


    Route::get('/user/register', [App\Http\Controllers\MemberController::class, 'showRegistrationForm'])->name('user.register');
    Route::post('/user/register', [App\Http\Controllers\MemberController::class, 'register'])->name('user.register.submit');




    Route::get('/user/profile', [App\Http\Controllers\MemberController::class, 'profile'])->name('user.profile');
    Route::get('/user/createprofile', [App\Http\Controllers\MemberController::class, 'Create'])->name('user.createprofile');
    Route::post('/user/createprofile', [App\Http\Controllers\MemberController::class, 'Store'])->name('user.createprofile-profile');
    Route::get('/user/profile/{profile_id}', [App\Http\Controllers\MemberController::class, 'Edit'])->name('user.edit');
    Route::put('/user/updateprofile/{profile_id}', [App\Http\Controllers\MemberController::class, 'Update']);
    Route::get('user/deleteprofile/{profile_id}', [App\Http\Controllers\MemberController::class, 'Destroy']);


    Route::get('/user/payment', [PaymentController::class, 'showPaymentForm'])->name('user.payment.form');
    Route::post('/user/payment/process', [PaymentController::class, 'processPayment'])->name('user.payment.process');
    Route::get('/user/generate-pdf/{paymentId}', [PDFController::class, 'generatePdf'])->name('user.payment.generate-pdf');


    Route::get('/user/eventRegister', [App\Http\Controllers\EventRegisterController::class, 'showForm'])->name('user.eventRegister');
    Route::post('/user/eventRegister', [App\Http\Controllers\EventRegisterController::class, 'register'])->name('user.eventRegister.register');

    Route::get('/admin/events-list', [App\Http\Controllers\EventsController::class, 'getEvents'])->name('admin.events.list');


