<?php

class AdminController extends BaseAdminController
{

	public function getIndex()
	{
		$view = View::make('backend.home');
		$view->page_title = $this->page_title;
		$view->title = "Home";

		return $this->render($view);
	}

	public function getLogin()
	{
		// Show login form
		$view = View::make('backend.login');
		$view->title = "Login";

		return $this->render($view);
	}

	public function postLogin()
	{		
		// Validate user input
		$validator = Validator::make(
		    Input::all(),
		    array(
		        'email' => 'required|email',
		        'password' => 'required',
		        'captcha' => 'required|captcha'
		    )
		);

		if ($validator->fails())
			return Redirect::to('admin/login')->with('error', 'Validation error!');
		else
		{
			// Try to authenticate user
			if(User::AuthenticateAdmin(Input::get('email'), Input::get('password')))
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