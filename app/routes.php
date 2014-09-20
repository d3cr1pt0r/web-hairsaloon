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

<<<<<<< HEAD
Route::get('/', function()
{
	return View::make('hello');
});
=======
Route::controller('/', 'HomeController');
>>>>>>> a9952179ee9574bad1615d0fec2b1dad3dbce625
