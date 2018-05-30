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




// Static pages
Route::get('about', 'StaticPageController@showAbout')->name('about');
Route::get('contentpolicy', 'StaticPageController@showContentPolicy')->name('contentpolicy');
Route::get('faq', 'StaticPageController@showFaq')->name('faq');
Route::get('contact', 'StaticPageController@showContact')->name('contact');



/*
// Cards
Route::get('cards', 'CardController@list');
Route::get('cards/{id}', 'CardController@show');

// API
Route::put('api/cards', 'CardController@create');
Route::put('api/cards/{card_id}/', 'ItemController@create');
Route::post('api/item/{id}', 'ItemController@update');
Route::delete('api/item/{id}', 'ItemController@delete');

*/
Route::delete('api/cards/{card_id}', 'CardController@delete');


// Administration
Route::get('admin', 'AdminController@showPage');
Route::get('user/{id}/verify', 'AdminController@verifyUser');
Route::get('user/{id}/moderator', 'AdminController@moderatorUser');
Route::get('user/{id}/ban', 'AdminController@banUser');
Route::get('user/{id}/admin/delete', 'AdminController@deleteUser');

Route::get('admin-users', 'AdminController@showUsersPage');

Route::get('admin-posts', 'AdminController@showPostsPage');

Route::get('admin-reports', 'AdminController@showReportsPage');


// Authentication

Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
Route::post('login', 'Auth\LoginController@login');
Route::get('logout', 'Auth\LoginController@logout')->name('logout');
Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
Route::post('register', 'Auth\RegisterController@register');

//User Profile

Route::get('user/edit', 'UserController@edit');
Route::get('user/{user}', 'UserController@show')->name('user.profile');
Route::patch('user/{user}/updateProfile', 'UserController@updateProfile')->name('users.update.profile');
Route::patch('user/{user}/updateEmail', 'UserController@updateEmail')->name('users.update.email');
Route::patch('user/{user}/updatePassword', 'UserController@updatePassword')->name('users.update.password');
Route::delete('user/{user}/delete', 'UserController@delete')->name('user.delete');



// Posts
Route::post('/searchpost', 'ContentController@searchByName')->name('searchpost');
Route::get('/', 'ContentController@indexPosts')->name('trending');
Route::get('/latest', 'ContentController@indexPostsByDate')->name('postsByDate');
Route::get('/tag/{tag}', 'ContentController@indexPostsByTag')->name('postsByTag');


// show the post

Route::get('/post/{post}', 'ContentController@showPost')->name('post.show');

//comment
Route::post('/post/{post}/comments', 'ContentController@addComment');


// API
Route::get('/api/content/up/{content}', 'ContentController@putupvote'); //<----
Route::get('/api/content/down/{content}', 'ContentController@putdownvote'); //<----
Route::put('/api/content/report/{content}', 'ContentController@report');
Route::put('/api/content/save/{content}', 'ContentController@save');

Route::post('/api/user/search/{username}', 'UserController@searchByUsername');






Route::get('/api/post/create', 'ContentController@showPostForm')->name('post.create');
Route::post('/api/post/create', 'ContentController@createPost');
