<?php

Route::get('admin/users/{id}', ['uses' => 'App\Modules\Backend\Controllers\UserController@getIndex'])->where('id', '[0-9]+');
Route::post('admin/users/{id}', ['uses' => 'App\Modules\Backend\Controllers\UserController@postIndex'])->where('id', '[0-9]+');

Route::controller('admin/profile', 'App\Modules\Backend\Controllers\ProfileController');
Route::controller('admin/services', 'App\Modules\Backend\Controllers\ServiceController');
Route::controller('admin/shifts', 'App\Modules\Backend\Controllers\ShiftController');
Route::controller('admin/schedules', 'App\Modules\Backend\Controllers\ScheduleController');
Route::controller('admin/users', 'App\Modules\Backend\Controllers\UserController');
Route::controller('admin', 'App\Modules\Backend\Controllers\DashboardController');

?>