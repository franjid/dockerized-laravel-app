<?php

use Illuminate\Support\Facades\Route;

Route::get('users', 'UserController@index');
Route::get('users/{id}', 'UserController@getUserId');
