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
    return redirect()->to('/login/page');
});

/* Auth::routes(); */
Route::get('/login/page','my_login@login_page');
Route::post('/login','my_login@login')->name('login');
ROute::post('/logout','my_login@logout')->name('logout');
Route::get('/reset/password','my_login@password_change_page')->name('reset');
Route::post('/reset','my_login@password_change')->name('password.reset');

Route::get('/home', 'HomeController@index')->name('home');

Route::middleware('auth')->group(function () {
    Route::resource('product-variant', 'VariantController');
    Route::resource('product', 'ProductController');
    Route::resource('blog', 'BlogController');
    Route::resource('blog-category', 'BlogCategoryController');
    
});
//Route::get('/product/list','Controller@listofdata');
