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
    return view('auth.login');
});

Route::middleware(['auth'])->group(function () {
Route::get('/subscription', 'App\Http\Controllers\SubscriptionController@view')->name('view');
Route::get('/subscription-create/{id}', 'App\Http\Controllers\SubscriptionController@create')->name('create');
Route::post('/subscription-post', 'App\Http\Controllers\SubscriptionController@post')->name('create_submit');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
