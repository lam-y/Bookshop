<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Index
Route::get('/', 'BookController@index')->name('home');

// About
Route::get('about', function(){
    return view('pages.about');
});

// Books
Route::resource('book', 'BookController');
Route::get('search', 'BookController@search');

// Categories
Route::resource('category','CategoryController');
Route::get('books-of-category/{category_id}', 'BookController@getBooksOfCategory')->name('books.category');

// Cart
Route::resource('cart','CartController');
Route::post('cart/switchToSaveForLater/{book}', 'CartController@switchToSaveForLater')->name('cart.switchToSaveForLater');
Route::get('empty',function(){
    Cart::destroy();
});

// Save for later
Route::resource('saveForLater', 'SaveForLaterController');
Route::post('saveForLater/moveToCart/{book}', 'SaveForLaterController@moveToCart')->name('saveForLater.moveToCart');
Route::get('emptySaveForLater',function(){
    Cart::instance('savedForLater')->destroy();
});

// Checkout
Route::resource('checkout', 'CheckoutController');
Route::get('/checkout', 'CheckoutController@index')->name('checkout.index')->middleware('auth');        //أضفنا هالسطر او الراوت بس مشان حطله middleware
Route::get('/guestCheckout', 'CheckoutController@index')->name('guestCheckout.index');              // أضفنا واحد تاني لنسمح للشخص يتمم عملية الشراء بدون ما يسجل حساب يعني للـ guests
Route::post('charge', 'CheckoutController@charge')->name('checkout.charge');

Route::group(['prefix' => 'admin'], function () {
    Voyager::routes();
});

// Confirmation
Route::get('thankyou', 'ConfirmationController@index')->name('confirmation.index');
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Coupons
Route::post('coupon', 'CouponsController@store')->name('coupon.store');
Route::delete('coupon', 'CouponsController@destroy')->name('coupon.destroy');

// User Dashboard
Route::middleware('auth')->group(function (){
    // edit profile
    Route::get('profile', 'UserController@index')->name('users.index');
    Route::patch('profile', 'UserController@update')->name('users.update');

    // order details
    Route::get('order-details/{order}', 'OrderController@show' )->name('order.show');

});


// Mailable - just to test the mail
Route::get('/mailable', function(){
    $order = App\Order::find(1);

    return new App\Mail\OrderPlaced($order);
});
