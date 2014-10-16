<?php

namespace App\Modules\Backend\Controllers;

use View, User, Auth, Input, Redirect;

class ProfileController extends BaseAdminController
{
	protected $controller = 'profile';

	public function getIndex() 
	{
		$view = View::make('backend::profile.view');
		$view->title = $this->title;
		$view->user = User::find(Auth::id());

		return $this->render($view);
	}

	public function getEdit()
	{
		$view = View::make('backend::profile.edit');
		$view->title = $this->title;
		$view->user = User::find(Auth::id());

		return $this->render($view);
	}

	public function postUpdate()
	{
		$fields = array('name', 'lastname', 'email','phone','birthdate','address','post_code','city','country');
		$fields_v = array('name' => 'required',
						 'lastname' => 'required',
						  'email' => 'required');

		if(Input::has("password")) 
		{
			$fields_v["check-password"] = "required";
			$fields_v["password"] = "required|same:check-password";
			$input = Input::only($fields);
			$input["password"] = sha1(Input::get("password"));
			$response = $this->save(User::findOrFail(Auth::id()), $input, $fields_v);
			if($response->status)
			{
				return Redirect::to('admin/profile')->with('success', 'Podatki shranjeni!');
			}
			else
			{
				return Redirect::to('admin/profile/edit')->withInput()->with('error', $response->validator->messages()->first());
			}
		}
		else
		{
			$input = Input::only($fields);
			$response = $this->save(User::findOrFail(Auth::id()), $input, $fields_v);
			if($response->status)
			{
				return Redirect::to('admin/profile')->with('success', 'Podatki shranjeni!');
			}
			else
			{
				return Redirect::to('admin/profile/edit')->withInput()->with('error', $response->validator->messages()->first());
			}
		}
	}
}

?>