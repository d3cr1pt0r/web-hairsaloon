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
		$view->captcha = false;

		if(FailedLoginAttempts::where("ip", $_SERVER["REMOTE_ADDR"])->count() >= 3)
		{
			$view->captcha = true;
		}

		return $this->render($view);
	}

	public function postLogin()
	{		
		// Validate user input
		$fields = array(
	        'email' => 'required|email',
	        'password' => 'required'
	    );
		if(FailedLoginAttempts::where("ip", $_SERVER["REMOTE_ADDR"])->count() >= 3)
			$fields['captcha'] = 'required|captcha';
		
		$validator = Validator::make(Input::all(), $fields);

		if ($validator->fails())
			return Redirect::to('admin/login')->with('error', 'Validation error!');
		else
		{
			// Try to authenticate user
			if(User::AuthenticateAdmin(Input::get('email'), Input::get('password')))
			{
				FailedLoginAttempts::where("ip", $_SERVER["REMOTE_ADDR"])->delete();
				return Redirect::to('admin')->with('success', 'Login successful!');
			}
			else
			{
				$FailedAttempt = new FailedLoginAttempts;
				$FailedAttempt->ip = $_SERVER["REMOTE_ADDR"];
				$FailedAttempt->user_agent = $_SERVER["HTTP_USER_AGENT"];
				$FailedAttempt->save();

				return Redirect::to('admin/login')->with('error', 'Invalid credentials!');
			}
		}
	}

	public function getLogout()
	{
		Auth::logout();
		return Redirect::to('admin')->with('success', 'You have been logged out!');
	}

}