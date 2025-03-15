<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\Product\CategoryController;
use App\Http\Controllers\Backend\Uncat\AdminViewController;

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
    Route::resources([
        'categories' => CategoryController::class,
    ]);
});
