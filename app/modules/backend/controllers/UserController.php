<?php

namespace App\Modules\Backend\Controllers;

use View, Input, Redirect, User, GenericHelper, UsersGroup;

class UserController extends BaseAdminController
{
	protected $controller = 'users';

	public function getIndex($access_type = null)
	{
		$view = View::make('backend::table');
		$view->title = "Uporabniki";
		$view->controller = $this->controller;
		$view->table = $this->table;

		// Data
		if($access_type != null) 
		{
			$group = UsersGroup::find($access_type);
			$users = UsersGroup::find($access_type)->users;
			$view->title .= ' - '.$group->name;
		}
		else	
			$users = User::all();

		$view->filters = $this->filters;
		$view->headers = $this->headers;
		$view->data = $users;

		return $this->render($view);
	}

	public function postIndex($access_type = null)
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

	public function getAdd()
	{
		$view = View::make('backend::users.edit');
		$view->title = "Dodaj uporabnika";
		$view->controller = $this->controller;
		$view->add = true;

		//SKUPINE UPORABNIKOV
		$view->usersGroups = UsersGroup::all();
		$view->checkedUsersGroups = array();
		
		return $this->render($view);
	}

	public function getEdit($id)
	{
		$user = User::find($id);
		if($user == null)
			return Redirect::to('/admin/users')->with('error', 'Zahtevan uporabnik ne obstaja!');

		$view = View::make('backend::users.edit');
		$view->user = $user;
		$view->title = "Uredi uporabnika";
		$view->controller = $this->controller;
		$view->add = false;

		//SKUPINE UPORABNIKOV
		$view->usersGroups = UsersGroup::all();
		$checkedGroups = $user->groups->toArray();
		$view->checkedUsersGroups = array();
		foreach($checkedGroups as $g)
		{
			array_push($view->checkedUsersGroups, $g["id"]);
		}
		 
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
			'name' => 'required',
			'lastname' => 'required',
			'email' => 'required|unique:users,email',
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
			$response = $this->save(new User, $input, $fields);
			if($response->status)
			{
				$group_ids = Input::get("group_id");
				if(!empty($group_ids))
				{
					$group = UsersGroup::whereIn("id", $group_ids)->get();
					foreach($group as $g) 
					{
						$user = $response->model;
						if (!$user->groups->contains($g->id))
							$user->groups()->attach($g->id);
					}
				}
				else
					$group_ids = array();

				//delete unchecked groups
				$user_groups = $user->groups->toArray();
				foreach($user_groups as $ug)
				{
					if(!in_array($ug["id"], $group_ids))
						$user->groups()->detach($ug["id"]);
				}

				return Redirect::back()->with('success', 'Uporabnik dodan!');
			}
			
			return Redirect::back()->withInput()->with('error', $response->validator->messages()->first());
		}

		return Redirect::back()->withInput()->with('error', 'Gesli se ne ujemata!');
	}

	public function postUpdate()
	{
		$fields = array(
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
			$input = Input::only(array_keys($fields));
			$input['password'] = sha1($input['password']);
		}
		else
			$input = Input::only(array_keys($fields));

		$response = $this->save(User::findOrFail(Input::get('id')), $input, $fields);
		if($response->status) 
		{
			$group_ids = Input::get("group_id");
			if(!empty($group_ids))
			{
				$group = UsersGroup::whereIn("id", $group_ids)->get();
				foreach($group as $g) 
				{
					$user = $response->model;
					if (!$user->groups->contains($g->id))
						$user->groups()->attach($g->id);
				}
			}
			else
				$group_ids = array();

			//delete unchecked groups
			$user_groups = $user->groups->toArray();
			foreach($user_groups as $ug)
			{
				if(!in_array($ug["id"], $group_ids))
					$user->groups()->detach($ug["id"]);
			}
			
			return Redirect::back()->with('success', 'Uporabnik shranjen!');
		}
		return Redirect::back()->withInput()->with('error', $response->validator->messages()->first());
	}
}

?>