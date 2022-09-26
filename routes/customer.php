<?php

use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\Customer\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/customer-login',[CustomerController::class,'customer'])->name('customer.login');

Route::post('/customer-login-store',[CustomerController::class,'AuthCheck'])->name('customer.login.store');
Route::get('/customer-register-form',[CustomerController::class,'customerForm'])->name('customer.register.form');
Route::post('/customer-register',[CustomerController::class,'customerStore'])->name('customer.register');


Route::post('/quick-order', [CustomerController::class, 'quickOrder'])->name('quickOrder.website');
Route::post('/send-otp', [CustomerController::class, 'sendOTP'])->name('customer.sendotp');

Route::get('/send-otp-pin', [CustomerController::class, 'otpPage'])->name('send-otp-pin');
Route::post('/otp-verify', [CustomerController::class, 'otpVerify'])->name('customer.otpverify');
Route::get('/enter-phone', [CustomerController::class, 'enterPhone'])->name('enter-phone.website');

Route::get('/customer-logout',[CustomerController::class, 'logout'])->name('customer.logout');
Route::get('/customer-dashboard',[DashboardController::class,'dashboard'])->name('customer.dashboard');
Route::post('/customer-update',[DashboardController::class,'customerUpdate'])->name('auth.customer.update');
Route::post('/customer-address',[DashboardController::class,'addressChange'])->name('auth.customer.address');
Route::get('/chekcout',[CheckoutController::class,'checkout'])->name('checkout');
Route::post('/chekcout-store',[CheckoutController::class,'checkoutStore'])->name('checkout.store');
Route::get('/customer-invoice/{id}',[CustomerController::class,'customerInvoice'])->name('customer-invoice');