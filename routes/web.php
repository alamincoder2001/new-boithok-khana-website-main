<?php

use GuzzleHttp\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;

// optimiZe
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return 'DONE'; //Return anything
});

Route::get('/',[HomeController::class,'index'])->name('home');
Route::get('/categorywise/{slug}',[HomeController::class,'categoryWise'])->name('categorywise');
Route::get('/fetch-upazila/{id}',[HomeController::class,'fetchUpazila'])->name('fetch-upazila');
Route::get('/wishcount',[HomeController::class,'wishCount'])->name('wishcount');
Route::get('/wish-list/{id}',[HomeController::class,'customerWishList'])->name('wishlist.customer');
Route::get('/wish-list-delete/{id}',[HomeController::class,'deleteWishList'])->name('delete.wishlist');
// serarch route
Route::get('/get_suggestions/{k}', [HomeController::class, 'getSearchSuggestions'])->name('searh.product');
Route::get('/search', [HomeController::class, 'productSearch'])->name('search');

Route::get('/our-shape', [HomeController::class, 'shapeWebsite'])->name('shape.website');
Route::get('/photo-gallery', [HomeController::class, 'imagesWebsite'])->name('images.website');

/*footer*/
Route::get('/about-us', [HomeController::class, 'aboutWebsite'])->name('about.website');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact.website');
Route::get('/faq-and-help', [HomeController::class, 'faq'])->name('faq.website');
Route::post('/contact-store', [HomeController::class, 'contactStore'])->name('contact-store.website');
/*close footer*/

Route::post('/addtocart',[CartController::class,'addtocart'])->name('add.cart');
Route::get('/cart-list',[CartController::class,'cartList'])->name('cart-details');
Route::get('/cart-remove/{id}',[CartController::class,'cartRemove'])->name('cart-remove');
Route::get('/cart-details',[CartController::class,'cartDetails'])->name('cart.alldata');
Route::get('/cart-fetch',[CartController::class,'cartShipping'])->name('cartShipping.alldata');
Route::get('/cart/increment/{id}',[CartController::class,'cartIncrement'])->name('cart.increment');
Route::get('/cart/decrement/{id}',[CartController::class,'cartDecrement'])->name('cart.decrement');
Route::get('/wishlist/{id}',[CartController::class,'wishlist'])->name('wishlist');
Route::get('/add-to-cart/{id}',[CartController::class,'cartAjax'])->name('add-to-cart');
Route::get('/cart-selected-remove',[CartController::class,'cartRemoveSelected'])->name('cart-selected-remove');
//product details
Route::get('/product-details/{slug}',[HomeController::class,'productDetails'])->name('productDetails');

Route::post('/order/delete/{id}',[HomeController::class,'destroy'])->name('product.order.delete');
// customer all route
require __DIR__ . '/customer.php';

