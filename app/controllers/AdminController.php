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
		$login_type = Input::get('login_type');
		
		// Validate user input
		$validator = Validator::make(
		    array(
		        'email' => $email,
		        'password' => $password,
		        'login_type' => $login_type
		    ),
		    array(
		        'email' => 'required|email',
		        'password' => 'required',
		        'login_type' => 'required'
		    )
		);

		if ($validator->fails())
			return Redirect::to('admin/login')->with('error', 'Validation error!');
		else
		{
			// Try to authenticate user
			if($login_type == 'admin')
			{
				if(User::AuthenticateAdmin($email, $password))
					return Redirect::to('admin')->with('success', 'Login successful!');
				else
					return Redirect::to('admin/login')->with('error', 'Invalid credentials!');
			}
			if($login_type == 'user')
			{
				if(User::AuthenticateUser($email, $password))
					return Redirect::to('/')->with('success', 'Login successful!');
				else
					return Redirect::to('/login')->with('error', 'Invalid credentials!');
			}
		}
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('admin')->with('success', 'You have been logged out!');
	}

}