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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'App\Http\Controllers\HomeController@index')->name('home');
Route::get('/privacy', 'App\Http\Controllers\HomeController@privacy')->name('privacy-policy');
Route::get('/terms', 'App\Http\Controllers\HomeController@terms')->name('terms-of-service');
Route::get('/dashboard', 'App\Http\Controllers\AppController@dashboard')->name('dashboard');
