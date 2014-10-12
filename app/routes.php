<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::controller('actions', 'ActionController');

/*
Route::get('admin/users/{id}', ['uses' => 'UserController@getIndex'])->where('id', '[0-9]+');
Route::post('admin/users/{id}', ['uses' => 'UserController@postIndex'])->where('id', '[0-9]+');

Route::controller('admin/profile', 'ProfileController');
Route::controller('admin/shifts', 'ShiftController');
Route::controller('admin/schedules', 'ScheduleController');
Route::controller('admin/services', 'ServiceController');
Route::controller('admin/users', 'UserController');
Route::controller('admin', 'AdminController');
Route::controller('actions', 'ActionController');
*/