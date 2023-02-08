<?php

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

    Route::get('registeration-form', [
        'uses' => "UserController@customerRegistrationForm",
        'as' => 'registration.form'
    ]);

    Route::post('customer/store', [
        'uses' => "UserController@customerStore",
        'as' => 'customer.store'
    ]);
});
