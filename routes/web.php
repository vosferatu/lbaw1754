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


Route::get('/', 'PostController@list');


// Static pages
Route::get('about', 'StaticPageController@showAbout');
Route::get('contentpolicy', 'StaticPageController@showContentPolicy')->name('contentpolicy');
Route::get('faq', 'StaticPageController@showFaq');
Route::get('contact', 'StaticPageController@showContact');



/*
// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::delete('api/cards/{card_id}', 'CardController@delete');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');
*/


// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//User Profile

Route::get('user/edit', 'UserController@edit');
Route::get('user/{user}', 'UserController@show')->name('user.profile');
Route::patch('user/{user}/update', 'UserController@update')->name('users.update');

