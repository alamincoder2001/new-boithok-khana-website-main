<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\Api\ApiController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::get('/category', [ApiController::class, 'index']);

// Route::post('/category/post', [ApiController::class, 'store']);

Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return 'DONE'; //Return anything
});

Route::get('/slider', [ApiController::class, 'banner']);
// category
Route::get('/category-with-subcategory', [ApiController::class, 'getCategory']);
Route::get('/category', [ApiController::class, 'getCategoryOnly']);
// product
Route::get('/recent-home', [ApiController::class, 'recentProduct']);
Route::get('/recent-inner', [ApiController::class, 'recentProductInner']);
// popular product
Route::get('/popular-inner', [ApiController::class, 'popularInner']);

Route::get('/newarrival', [ApiController::class, 'newArrival']);
// search
Route::get('search/{name}',[ApiController::class, 'search']);

Route::get('category-wise-product/{id}',[ApiController::class, 'categoryWiseProduct']);
Route::get('subcategory-wise-product/{id}',[ApiController::class, 'subcategoryWiseProduct']);

Route::post('customer-store', [ApiController::class, 'CustomerStore']);
Route::post('verify-otp', [ApiController::class, 'otpMatch']);


// order store
Route::get('get-thana', [ApiController::class, 'getThana']);
Route::post('get-area', [ApiController::class, 'getArea']);

Route::post('order-store', [ApiController::class, 'orderStore']);

Route::group([

    'middleware' => 'api',
    'namespace' => 'App\Http\Controllers\Api',
    // 'prefix' => 'auth'

], function ($router) {
    Route::post('login', [AuthController::class, 'login']);
});
 
