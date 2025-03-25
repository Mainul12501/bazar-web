<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Product\CategoryController;
use App\Http\Controllers\Backend\Uncat\AdminViewController;
use App\Http\Controllers\Backend\Users\UserController;
use App\Http\Controllers\AreaController;
use App\Http\Controllers\Backend\Product\ProductController;
use App\Http\Controllers\SmsOfferController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\Product\OrderController;
use App\Http\Controllers\BasicSettingController;
//frontend routes
Route::get('/', function () {
    return view('welcome');
});

Route::any('/send-otp', [AdminViewController::class, 'sendOtp'])->name('send-otp');
Route::post('/custom-register', [AdminViewController::class, 'register'])->name('custom-register');
Route::post('/custom-login', [AdminViewController::class, 'login'])->name('custom-login');


//auth routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [AdminViewController::class, 'dashboard'])->name('dashboard');
    Route::get('/send-offers-to-users/{sms_offer}', [SmsOfferController::class, 'sendOfferToUsers'])->name('sms-offers.send-offers-to-users');
    Route::get('/get-areas-by-district-id/{district}', [AreaController::class, 'getAreasByDistrictId'])->name('get-areas-by-district-id');
    Route::resources([
        'categories' => CategoryController::class,
        'users' => UserController::class,
        'areas' => AreaController::class,
        'products' => ProductController::class,
        'sms-offers'    => SmsOfferController::class,
        'districts'     => DistrictController::class,
        'orders'    => OrderController::class,
        'basic-settings'    => BasicSettingController::class,

    ]);
    Route::prefix('orders')->as('orders')->group(function (){
//        Route::get('/', [OrderController::class, 'index']);
    });
});
