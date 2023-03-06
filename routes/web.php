<?php

use App\Models\User;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('dashboard.index');
});
Route::group(['namespace' => '\App\Http\Controllers'], function () {
    Route::any('/', [
        'uses' => "HomeController@index",
        'as' => 'dashboard'
    ]);
    Route::get('products', [
        'uses' => "ProductController@index",
        'as' => 'products.index'
    ]);

    Route::get('categories', [
        'uses' => "CategoryController@index",
        'as' => 'categories.index'
    ]);
    Route::get('product/{slug}', [
        'uses' => "ProductController@show",
        'as' => 'product.show'
    ]);
    Route::get('category/{slug}', [
        'uses' => "CategoryController@show",
        'as' => 'category.show'
    ]);
    Route::get('search', [
        'uses' => "SearchController@handleQuery",
        'as' => 'search'
    ]);

    Route::get('forgot-password-form', [
        'uses' => "UserController@customerForgotPasswordForm",
        'as' => 'forgot.password.form'
    ]);
    Route::post('forgot-password', [
        'uses' => "UserController@forgotPassword",
        'as' => 'forgot.password'
    ]);

    Route::get('registeration-form', [
        'uses' => "UserController@customerRegistrationForm",
        'as' => 'registration.form'
    ]);

    Route::get('login/form', [
        'uses' => "UserController@loginForm",
        'as' => 'login.form'
    ]);
    Route::post('login', [
        'uses' => "UserController@login",
        'as' => 'login'
    ]);
    Route::post('logout', [
        'uses' => "UserController@logout",
        'as' => 'logout'
    ]);



    Route::post('customer/store', [
        'uses' => "UserController@customerStore",
        'as' => 'customer.store'
    ]);


    Route::get('email', function () {
        $user = User::first();
        return view('email.forgot_password', compact('user'));
    });
    Route::get('confirm/{user}', [
        'uses' => "UserController@confirm",
        'as' => 'user.confirm'
    ]);
    Route::get('reset/password/form/{token}', [
        'uses' => "UserController@resetPasswordForm",
        'as' => 'reset.password.form'
    ]);
    Route::post('reset/password/{token}', [
        'uses' => "UserController@resetPassword",
        'as' => 'reset.password'
    ]);

    //Auth Routes
    Route::post('whishlist/{product}', [
        'uses' => "UserWishlistController@toggleProduct",
        'as' => 'toggle.wishlist.product'
    ]);
    Route::post('cart/{product}', [
        'uses' => "UserCartController@toggleProduct",
        'as' => 'toggle.cart.product'
    ]);
    Route::get('wishlist', [
        'uses' => "UserWishlistController@index",
        'as' => 'wishlist.index'
    ]);
    Route::get('cart', [
        'uses' => "UserCartController@index",
        'as' => 'cart.index'
    ]);
    Route::get('cart_and_wishlist_counts', [
        'uses' => "UserController@cartAndWishlistCounts",
        'as' => 'cart.wishlist.counts'
    ]);
    Route::get('cart_items', [
        'uses' => "UserCartController@cartItems",
        'as' => 'cart.items'
    ]);
});
