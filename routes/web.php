<?php

use Illuminate\Support\Facades\Auth;
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

Route::group(['namespace' => 'App\Http\Controllers'], function()
{ 


    Route::get('/dashboard', 'HomeController@index')->name('dashboard');
    Route::get('/user', 'UserController@index')->name('manage-user');
    Route::get('/users/create', 'UserController@create')->name('create-user');
    Route::post('/users/create', 'UserController@store')->name('store-user');
    Route::get('/edit/{id}', 'UserController@edit')->name('edit-user');
    Route::post('/edit/{id}', 'UserController@update')->name('update-user');
    Route::delete('/destroy/{id}', 'UserController@destroy')->name('user-destroy');

    Route::group(['middleware' => ['guest']], function() {

        /**
         * Register Routes
         */
        Route::get('/register', 'RegisterController@show')->name('register.show');
        Route::post('/register', 'RegisterController@register')->name('register.perform');

        /**
         * Login Routes
         */
        Route::get('/login', 'LoginController@show')->name('login.show');
        Route::post('/login', 'LoginController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {
        /**
         * Logout Routes
         */
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });

});
