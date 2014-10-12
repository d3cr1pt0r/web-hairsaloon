<?php

namespace App\Modules\Backend\Controllers;

use View, User, Auth, Input, Redirect;

class ProfileController extends BaseAdminController
{
	private $table = 'users';
	private $controller = 'profile';
	private $title = 'Moj profil';

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
		$fields = array('name', 'lastname', 'email','phone','birthdate','address','post_code','city','country','password');
		$fields_v = array('name' => 'required',
						 'lastname' => 'required',
						  'email' => 'required');

		if(Input::has("password")) 
		{
			if(Input::get("password") == Input::get("check-password"))
			{
				$input = Input::only($fields);
				$input["password"] = sha1(Input::get("password"));
				if($this->save(User::findOrFail(Auth::id()), $input, $fields_v))
				{
					return Redirect::to('admin/profile')->with('success', 'Podatki shranjeni!');
				}
				else
				{
					return Redirect::to('admin/profile')->with('error', 'Prišlo je do napake pri shranjevanju!');
				}
			}
			else
			{
				return Redirect::to('admin/profile')->with('error', 'Gesli se ne ujemata!');
			}
		}
		else
		{
			$input = Input::only($fields);
			$input["password"] = sha1(Input::get("password"));
			if($this->save(User::findOrFail(Auth::id()), $input, $fields_v))
			{
				return Redirect::to('admin/profile')->with('success', 'Podatki shranjeni!');
			}
			else
			{
				return Redirect::to('admin/profile')->with('error', 'Prišlo je do napake pri shranjevanju!');
			}
		}
	}
}

?>