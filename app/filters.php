<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

// Admin filter
Route::filter('auth.admin', function(){
	if(!Auth::check() || Auth::user()->access_type >= 5)
	{
		return Redirect::to('admin/login');
	}
});

// Frontend filter
/*
Route::filter('guest', function()
{
	if (Auth::check()) return Redirect::to('/');
});
*/

// CSRF Protection Filter
Route::filter('csrf', function()
{
	if (Session::token() != Input::get('_token'))
	{
		throw new Illuminate\Session\TokenMismatchException;
	}
});