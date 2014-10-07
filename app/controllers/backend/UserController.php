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

	public function getIndex($access_type = 1)
	{
		$view = View::make('backend.table');
		$view->title = "Uporabniki";
		$view->controller = $this->controller;
		$view->table = "users";

		switch($access_type) {
			case 1:
				$view->title .= " - super administratorji";
				break;
			case 2:
				$view->title .= " - administratorji";
				break;
			case 3:
				$view->title .= " - frizerji";
				break;
			case 5:
				$view->title .= " - stranke";
				break;
		}

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
		$view = View::make('backend.table');
		$view->title = "Uporabniki";
		$view->controller = $this->controller;
		$view->table = "users";

		switch($access_type) {
			case 1:
				$view->title .= " - super administratorji";
				break;
			case 2:
				$view->title .= " - administratorji";
				break;
			case 3:
				$view->title .= " - frizerji";
				break;
			case 5:
				$view->title .= " - stranke";
				break;
		}

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
		$view = View::make('backend.users.edit');
		$view->title = "Dodaj uporabnika";
		$view->controller = $this->controller;
		$view->add = true;
		$view->access_type = $access_type;

		switch($access_type) {
			case 1:
				$view->title .= " - super administrator";
				break;
			case 2:
				$view->title .= " - administrator";
				break;
			case 3:
				$view->title .= " - frizer";
				break;
			case 5:
				$view->title .= " - stranka";
				break;
		}

		return $this->render($view);
	}

	public function getEdit($access_type = 1, $id)
	{
		$user = User::find($id);
		if($user == null)
			return Redirect::to('/admin/users')->with('error', 'Zahtevan uporabnik ne obstaja!');

		$view = View::make('backend.users.edit');
		$view->user = $user;
		$view->title = "Uredi uporabnika";
		$view->controller = $this->controller;
		$view->add = false;
		$view->access_type = $access_type;

		switch($access_type) {
			case 1:
				$view->title .= " - super administrator";
				break;
			case 2:
				$view->title .= " - administrator";
				break;
			case 3:
				$view->title .= " - frizer";
				break;
			case 5:
				$view->title .= " - stranka";
				break;
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
						return Redirect::to('/admin/users/'.$user->access_type)->with('success', 'Podatki shranjeni!');
					}
					else 
					{
						return Redirect::to('/admin/users/add/'.$user->access_type)->with('error', 'Gesli se ne ujemata!');
					}
				}
			}
			else if($user->save()) 
			{
				$id = $user->id;
				return Redirect::to('/admin/users/'.$user->access_type)->with('success', 'Podatki shranjeni!');
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
					return Redirect::to('/admin/users/'.$user->access_type)->with('success', 'Uporabnik dodan!');
				}
			}
		}
		
		
	}
}

?>