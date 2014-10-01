<?php

class ServiceController extends BaseAdminController
{
	private $title = 'Storitve';
	private $table = 'services';
	private $controller = 'services';
	private $filters = array(array("type" => "text",
							       "name" => "name",
							       "label" => "Ime storitve"),
						 	 array("type" => "text",
						           "name" => "price",
							       "label" => "Cena storitve")
						);

	private $headers = array(array("db" => "name", "header" => 'Ime storitve', 'type' => "normal"),
							array("db" => "price", "header" => 'Cena', 'type' => "price"),
							array("db" => "time", "header" => 'Čas', 'type' => "timeperiod"),
							array("db" => "active", "header" => 'Aktiven', 'type' => "checkbox")
						);

	public function getIndex()
	{
		$view = View::make('backend.table');
		$view->title = $this->title;
		$view->controller = $this->controller;
		$view->table = $this->table;

		// Data		
		$users = Service::all();

		$view->filters = $this->filters;
		$view->headers = $this->headers;
		$view->data = $users;
		return $this->render($view);
	}

	public function postIndex()
	{
		$view = View::make('backend.table');
		$view->title = $this->title;
		$view->controller = $this->controller;
		$view->table = $this->table;

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