<?php

class UserController extends BaseAdminController
{
	private $table = 'users';
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
		$view = View::make('backend.home');
		$view->title = "Users";
		$view->controller = 'users';
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
		$view = View::make('backend.home');
		$view->title = "Users";
		$view->controller = 'users';
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

}

?>