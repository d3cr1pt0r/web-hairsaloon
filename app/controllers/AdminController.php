<?php

class AdminController extends BaseAdminController
{
	public function __construct()
	{
		$this->beforeFilter('auth.admin', array('except' => array('getLogin', 'postLogin')));
		$this->beforeFilter('csrf', array('only' => array('postLogin')));
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
		// Process user input
		$email = Input::get('email');
		$password = Input::get('password');
		
		// Validate user input
		$validator = Validator::make(
		    array(
		        'email' => $email,
		        'password' => $password
		    ),
		    array(
		        'email' => 'required|email',
		        'password' => 'required'
		    )
		);

		if ($validator->fails())
			return Redirect::to('admin/login')->with('error', 'Validation error!');
		else
		{
			// Try to authenticate user
			if (Auth::attempt(array('email' => $email, 'password' => $password)))
				return Redirect::to('admin')->with('success', 'Login successful!');
			else
				return Redirect::to('admin/login')->with('error', 'Invalid credentials!');
		}
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('admin')->with('success', 'You have been logged out!');
	}

}