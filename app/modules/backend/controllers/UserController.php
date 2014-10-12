<?php

namespace App\Modules\Backend\Controllers;

use View, Input, Redirect, User, GenericHelper;

class UserController extends BaseAdminController
{
	protected $controller = 'users';

	public function getIndex($access_type = 1)
	{
		$view = View::make('backend::table');
		$view->title = "Uporabniki - ".GenericHelper::getAccesTypeString($access_type);
		$view->controller = $this->controller;
		$view->table = $this->table;

		// Data
		$data["access_type"] = $access_type;	
		$users = $this->filterData($this->table, $data);

		$view->access_type = $access_type;
		$view->filters = $this->filters;
		$view->headers = $this->headers;
		$view->data = $users;

		return $this->render($view);
	}

	public function postIndex($access_type = 1)
	{
		$view = View::make('backend::table');
		$view->title = "Uporabniki - ".GenericHelper::getAccesTypeString($access_type);
		$view->controller = $this->controller;
		$view->table = $this->table;

		$data["access_type"] = $access_type;
		foreach(Input::all() as $key=>$val) 
			if(!empty($val)) 
				$data[$key] = $val;

		$users = $this->filterData($this->table, $data);

		$view->access_type = $access_type;
		$view->filters = $this->filters;
		$view->headers = $this->headers;
		$view->data = $users;

		return $this->render($view);
	}

	public function getAdd($access_type = 1) 
	{
		$view = View::make('backend::users.edit');
		$view->title = "Dodaj uporabnika - ".GenericHelper::getAccesTypeString($access_type);
		$view->controller = $this->controller;
		$view->add = true;
		$view->access_type = $access_type;

		return $this->render($view);
	}

	public function getEdit($access_type = 1, $id)
	{
		$user = User::find($id);
		if($user == null)
			return Redirect::to('/admin/users')->with('error', 'Zahtevan uporabnik ne obstaja!');

		$view = View::make('backend::users.edit');
		$view->user = $user;
		$view->title = "Uredi uporabnika - ".GenericHelper::getAccesTypeString($access_type);
		$view->controller = $this->controller;
		$view->add = false;
		$view->access_type = $access_type;

		return $this->render($view);
	}

	public function getDelete($id)
	{
		$user = User::find($id);
		if($user == null)
			return Redirect::to('/admin/users')->with('error', 'Zahtevan uporabnik ne obstaja!');

		$user->delete();
		return Redirect::to('admin/users')->with('success', 'Uporabnik je bil izbrisan!');
	}

	public function postSave()
	{
		$fields = array(
			'access_type' => 'required',
			'name' => 'required',
			'lastname' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'birthdate' => 'required',
			'password' => 'required'
		);

		$input = Input::only(array_keys($fields));

		$password = Input::get("password");
		$password_check = Input::get("check_password");

		if($password == $password_check)
		{
			$input['password'] = sha1($input['password']);
			if($this->save(new User, $input, $fields))
				return Redirect::to('/admin/users/'.Input::get('access_type'))->with('success', 'Uporabnik dodan!');
			return Redirect::to('/admin/users/add/'.Input::get('access_type'))->with('error', 'Prišlo je do napake pri shranjevanju!');
		}

		return Redirect::to('/admin/users/add/'.Input::get('access_type'))->with('error', 'Gesli se ne ujemata!');
	}

	public function postUpdate()
	{
		$fields = array(
			'access_type' => 'required',
			'name' => 'required',
			'lastname' => 'required',
			'email' => 'required',
			'phone' => 'required',
			'birthdate' => 'required'
		);
		$password = Input::get("password");
		$password_check = Input::get("check_password");

		if(!empty($password))
		{
			if($password != $password_check)
				return Redirect::to('/admin/users/add/'.Input::get('access_type'))->with('error', 'Gesli se ne ujemata!');

			$fields['password'] = 'required';
		}

		$input = Input::only(array_keys($fields));
		$input['password'] = sha1($input['password']);

		if($this->save(User::findOrFail(Input::get('id')), $input, $fields))
			return Redirect::to('/admin/users/'.Input::get('access_type'))->with('success', 'Uporabnik shranjen!');
		return Redirect::to('/admin/users/add/'.Input::get('access_type'))->with('error', 'Prišlo je do napake pri shranjevanju!');
	}
}

?>