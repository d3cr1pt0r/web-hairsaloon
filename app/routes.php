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

Route::controller('/', 'HomeController');

/*
Route::get('drek/salama', function() {
	$view = View::make('frontend.');
	$view->title = 'This is a title';
	$view->list = array('drek' => 'salama', 'penis' => 'phallus');

	return $view;
});
*/