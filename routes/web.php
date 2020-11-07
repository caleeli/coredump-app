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

use App\Http\Controllers\Auth\LoginOAuthController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Socialite routes
Route::get('login/{provider}', [LoginOAuthController::class, 'redirectToProvider']);
Route::get('login/{provider}/callback', [LoginOAuthController::class, 'handleProviderCallback']);

Route::get('oauth/userinfo', [LoginOAuthController::class, 'userinfo'])->middleware('auth:api');


