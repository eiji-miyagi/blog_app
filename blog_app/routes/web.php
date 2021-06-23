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

// resouceでコントローラ全体onlyでその一部の操作を意味する
Route::resouce('posts','PostController',['only' => ['index','show', 'create', 'store','destroy']]);

Route::get('posts/edit/{id}','PostController@edit');
Route::get('posts/edit/{id}','PostController@updete');