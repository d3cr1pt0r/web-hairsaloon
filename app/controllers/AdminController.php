<?php

class AdminController extends BaseAdminController
{
	public function __construct()
	{
		$this->beforeFilter('auth.admin', array('except' => array('getLogin', 'postLogin')));
	}

	public function getIndex()
	{
		$view = View::make('backend.home');
		$view->title = "Admin -> Home";

		return $view;
	}

	public function getLogin()
	{
		// Show login form
		$view = View::make('backend.login');
		$view->title = "Admin -> Login";

		return $view;
	}

	public function postLogin()
	{
		// Process user input and try to authenticate
		return Input::all();
	}

}