<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('articles/save', 'App\Http\Controllers\ArticlesController@save')->name('articles.save');
Route::get('articles/new', 'App\Http\Controllers\ArticlesController@new')->name('articles.new');
Route::get('articles/{article}', 'App\Http\Controllers\ArticlesController@detail')->name('articles.detail');
Route::get('articles', 'App\Http\Controllers\ArticlesController@list')->name('articles.list');


Route::post('subscriptions/{subscription}/processPay', 'App\Http\Controllers\SubscriptionsController@processPay')->name('subscriptions.processPay');
Route::get('subscriptions/{subscription}/buy', 'App\Http\Controllers\SubscriptionsController@buyPage')->name('subscriptions.buy');
Route::get('subscriptions', 'App\Http\Controllers\SubscriptionsController@list')->name('subscriptions.list');