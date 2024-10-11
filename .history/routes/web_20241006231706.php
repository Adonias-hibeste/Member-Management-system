<?php

use App\Http\Controllers\MembershipController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\EventRegisterController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\AdminForgotPasswordController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\AdminPaymentController;
use App\Http\Controllers\AdminPDFController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CatagoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RoleController;
use App\Models\Catagory;

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
    Route::get('/admin/registeredusers/{user_id}', [App\Http\Controllers\RegUserController::class, 'EditUser'])->name('admin.edituser');//is it nessary for the admin to edit users info
    Route::put('/admin/updateuser/{user_id}', [App\Http\Controllers\RegUserController::class, 'Update']);

    Route::get('/admin/addrole',[RoleController::class,'addRole'])->name('admin.addRole');

    Route::get('/admin/settings', [App\Http\Controllers\SettingController::class, 'index'])->name('admin.settings');
    Route::post('/admin/settings', [App\Http\Controllers\SettingController::class, 'savedata'])->name('admin.settings.addsettings');


    Route::get('/admin/payment', [App\Http\Controllers\AdminPaymentController::class, 'showPaymentForm'])->name('admin.payment.form');
    Route::post('/admin/payment/process', [App\Http\Controllers\AdminPaymentController::class, 'processPayment'])->name('admin.payment.process');
    Route::get('/admin/generate-pdf/{paymentId}', [App\Http\Controllers\AdminPDFController::class, 'generatePdf'])->name('admin.payment.generate-pdf');


    Route::get('/user/userdashboard', [App\Http\Controllers\UserController::class, 'Userdashboard'])->name('user.userdashboard');//->middleware('admin')

    Route::get('/user/logout', [App\Http\Controllers\UserController::class, 'UserLogout'])->name('user.logout');



    Route::get('/user/payment', [PaymentController::class, 'showPaymentForm'])->name('user.payment.form');
    Route::post('/user/payment/process', [PaymentController::class, 'processPayment'])->name('user.payment.process');
    Route::get('/user/generate-pdf/{paymentId}', [PDFController::class, 'generatePdf'])->name('user.payment.generate-pdf');


    Route::get('/user/eventRegister', [App\Http\Controllers\EventRegisterController::class, 'showForm'])->name('user.eventRegister');
    Route::post('/user/eventRegister', [App\Http\Controllers\EventRegisterController::class, 'register'])->name('user.eventRegister.register');
    Route::get('/user/make_order',[OrderController::class,'make_order'])->name('user.makeOrder');

    Route::get('/admin/events-list', [App\Http\Controllers\EventsController::class, 'getEvents'])->name('admin.events.list');

    Route::get('/admin/membership',[MembershipController::class,'index'])->name('admin.membership.index');
    Route::get('/admin/membership/create',[MembershipController::class,'create'])->name('admin.membership.create');
    Route::post('/admin/membership/store',[MembershipController::class,'store'])->name('admin.membership.store');

    Route::get('/admin/catagories',[CatagoryController::class,'index'])->name('admin.catagories');
    Route::get('/admin/catagories/addCatagory',[CatagoryController::class,'create'])->name('admin.catagory.create');
    Route::post('/admin/catagory/create',[CatagoryController::class,'store'])->name('admin.catagory.store');

    Route::get('/admin/productlist',[ProductController::class,'index'])->name('admin.viewProducts');
    Route::get('/admin/products/{id}',[ProductController::class,'show'])->name('admin.viewProducts.details');

    Route::get('/admin/product/addProducts',[ProductController::class,'create'])->name('admin.createProduct');
    Route::post('/admin/product/store',[ProductController::class,'store'])->name('admin.product.store');


    Route::get('/admin/orders',[OrderController::class,'index'])->name('admin.order.view');
    Route::put('/admin/orders/{id}', [OrderController::class, 'update'])->name('admin.orders.update');
    Route::get('/admin/orders/{id}', [OrderController::class, 'show'])->name('admin.orders.show');
    Route::delete('/admin/orders/{id}/delete', [OrderController::class, 'destroy'])->name('admin.orders.delete');



    Route::get('/admin/cart', [CartController::class, 'show'])->name('admin.cart.show');
    Route::post('/admin/cart/add', [CartController::class, 'add'])->name('admin.cart.add');
    Route::post('/admin/cart/update', [CartController::class, 'update'])->name('admin.cart.update');
    Route::post('/admin/cart/remove', [CartController::class, 'remove'])->name('admin.cart.remove');
    Route::post('/admin/checkout', [OrderController::class, 'checkout'])->name('checkout');


