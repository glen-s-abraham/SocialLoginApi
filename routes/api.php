<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('user/register','User\UserController@register');
Route::post('user/login','User\UserController@login');
Route::post('user/register','User\UserController@register');

Route::get('user/login/github','Social\SocialAuthController@github');
Route::get('user/login/github/redirect','Social\SocialAuthController@githubRedirect');

Route::group(['middleware'=>['auth:api']],function(){
    Route::get('user/profile','User\UserController@profile');
    Route::get('user/logout','User\UserController@logout');
});