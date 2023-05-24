<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::post('articles/save', 'ArticlesController@save')->name('articles.save');
Route::get('articles/new', 'ArticlesController@new')->name('articles.new');
Route::get('articles/{article}', 'ArticlesController@detail')->name('articles.detail');
Route::get('articles', 'ArticlesController@list')->name('articles.list');

Route::post('subscriptions/{subscription}/processPay', 'SubscriptionsController@processPay')->name('subscriptions.processPay');
Route::get('subscriptions/{subscription}/buy', 'SubscriptionsController@buyPage')->name('subscriptions.buy');
Route::get('subscriptions', 'SubscriptionsController@list')->name('subscriptions.list');