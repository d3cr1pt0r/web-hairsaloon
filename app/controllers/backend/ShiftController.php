<?php

class ShiftController extends BaseAdminController
{
	private $title = 'Izmene';
	private $table = 'shifts';
	private $controller = 'shifts';

	private $headers = array(array("db" => "name", "header" => 'Ime izmene', 'type' => "normal"),
							array("db" => "from", "header" => 'Od', 'type' => "time"),
							array("db" => "to", "header" => 'Do', 'type' => "time"),
							array("db" => "active", "header" => 'Aktiven', 'type' => "checkbox")
						);

	public function getIndex()
	{
		$view = View::make('backend.table');
		$view->title = $this->title;
		$view->controller = $this->controller;
		$view->table = $this->table;

		// Data
		$shifts = Shift::all();

		$view->headers = $this->headers;
		$view->data = $shifts;
		return $this->render($view);
	}

	public function postIndex()
	{
		
	}

	public function getAdd()
	{

	}

	public function getEdit($id)
	{

	}

	public function getDelete($id)
	{

	}

	public function postSave()
	{
		
	}
}

?>