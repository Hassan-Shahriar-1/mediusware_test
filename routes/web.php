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
    return redirect()->to('/login');
});
/* Auth::routes(); */

Route::get('/login','my_login@page');
Route::post('/check/login','my_login@login')->name('login');
Route::get('/reset/password','my_login@reset')->name('password.request');
Route::get('/reset','my_login@register')->name('register');
Route::post('/logout','my_login@logout')->name('logout');
Route::post('/change/password','my_login@reset_password')->name('password.update');

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('product-variant', 'VariantController');
    Route::resource('product', 'ProductController');
    Route::resource('blog', 'BlogController');
    Route::resource('blog-category', 'BlogCategoryController');
    Route::get('/allproduct','ProductController@all');
});
