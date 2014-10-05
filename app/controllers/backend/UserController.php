<?php

class UserController extends BaseAdminController
{
	private $table = 'users';
	private $controller = 'users';
	private $filters = array(array("type" => "text",
							   "name" => "name",
							   "label" => "Name"),
						 array("type" => "text",
							   "name" => "lastname",
							   "label" => "Lastname"),
						 array("type" => "text",
							   "name" => "email",
							   "label" => "Email"));

	private $headers = array(array("db" => "name", "header" => 'Ime', 'type' => "normal"),
							array("db" => "lastname", "header" => 'Priimek', 'type' => "normal"),
							array("db" => "email", "header" => 'Email', 'type' => "mail_url"),
							array("db" => "active", "header" => 'Aktiven', "type" => "checkbox"));

	public function getIndex()
	{
		$view = View::make('backend.table');
		$view->title = "Users";
		$view->controller = $this->controller;
		$view->table = "users";

		// Data		
		$users = User::all();

		$view->filters = $this->filters;
		$view->headers = $this->headers;
		$view->data = $users;
		return $this->render($view);
	}

	public function postIndex()
	{
		$view = View::make('backend.table');
		$view->title = "Uporabniki";
		$view->controller = $this->controller;
		$view->table = "users";

		$data = array();
		foreach(Input::all() as $key=>$val) 
			if(!empty($val)) 
				$data[$key] = $val;

		$users = $this->filterData($this->table, $data);


		$view->filters = $this->filters;
		$view->headers = $this->headers;
		$view->data = $users;

		return $this->render($view);
	}

	public function getAdd() 
	{
		$view = View::make('backend.users.edit');
		$view->title = "Dodaj uporabnika";
		$view->controller = $this->controller;
		$view->add = true;

		return $this->render($view);
	}

	public function getEdit($id)
	{
		$user = User::find($id);
		if($user == null)
			return Redirect::to('/admin/users')->with('error', 'Zahtevan uporabnik ne obstaja!');

		$view = View::make('backend.users.edit');
		$view->user = $user;
		$view->title = "Uredi uporabnika";
		$view->controller = $this->controller;
		$view->add = false;

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
		if(Input::has("id")) {
			$user = User::find(Input::get("id"));
			$user->access_type = Input::get("access_type");
			$user->name = Input::get("name");
			$user->lastname = Input::get("lastname");
			$user->email = Input::get("email");
			$user->phone = Input::get("phone");
			$user->birthdate = Input::get("birthdate");

			if(Input::has("password")) 
			{
				$user->password = sha1(Input::get("password"));
				$check_password = sha1(Input::get("check_password"));
				if($user->password == $check_password) 
				{
					if($user->save()) 
					{
						$id = $user->id;
						return Redirect::to('/admin/users')->with('success', 'Podatki shranjeni!');
					}
					else 
					{
						return Redirect::to('/admin/users')->with('error', 'Gesli se ne ujemata!');
					}
				}
			}
			else if($user->save()) 
			{
				$id = $user->id;
				return Redirect::to('/admin/users')->with('success', 'Podatki shranjeni!');
			}
		}
		else {
			$user = new User;
			$user->access_type = Input::get("access_type");
			$user->name = Input::get("name");
			$user->lastname = Input::get("lastname");
			$user->email = Input::get("email");
			$user->phone = Input::get("phone");
			$user->birthdate = Input::get("birthdate");
			$user->password = sha1(Input::get("password"));
			$check_password = sha1(Input::get("check_password"));

			if($user->password == $check_password) 
			{
				if($user->save()) 
				{
					$id = $user->id;
					return Redirect::to('/admin/users')->with('success', 'Uporabnik dodan!');
				}
			}
		}
		
		
	}
}

?>