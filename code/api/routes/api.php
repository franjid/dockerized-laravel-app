<?php

use Illuminate\Support\Facades\Route;

Route::get('users', 'UserController@index');
Route::get('users/{id}', 'UserController@getUserId');
Route::get('users/{id}/posts', 'UserController@getUserPosts');
