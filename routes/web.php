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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/api', 'ApiController@index')->name('api');

Route::get('/api/show/{id}', 'ApiController@show');

Route::get('/api/post', 'ApiController@store');

Route::get('/api/delete/{id}', 'ApiController@destroy');

Route::get('/api/saved', 'ApiController@saved');



