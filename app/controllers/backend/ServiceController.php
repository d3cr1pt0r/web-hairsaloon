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

	public function getAdd()
	{
		$view = View::make('backend.services.edit');
		$view->title = $this->title;
		$view->controller = $this->controller;

		return $this->render($view);
	}

	public function getEdit($id)
	{
		$service = Service::find($id);
		if($service == null)
			return Redirect::to('/admin/services')->with('error', 'Zahtevana storitev ne obstaja!');

		// Change service time so input can later display it
		$service->time = date('H:i', $service->time);

		$view = View::make('backend.services.edit');
		$view->service = $service;
		$view->title = $this->title;
		$view->controller = $this->controller;

		return $this->render($view);
	}

	public function getDelete($id)
	{
		if($this->delete(Service::find($id)))
			return Redirect::to('admin/services')->with('success', 'Podatko so bili izbrisani!');
		return Redirect::to('/admin/services')->with('error', 'Zahtevana storitev ne obstaja!');
	}

	public function postSave()
	{
		$fields = array('name' => 'required', 'price' => 'required', 'time' => 'required');

		// Extreme case where input value has to be modified (in this case, time)
		$input = Input::only(array_keys($fields));
		$input['time'] = explode(':', $input['time'])[0]*60*60 + explode(':', $input['time'])[1]*60;

		if($this->save(new Service, $input, $fields))
			return Redirect::to('admin/services')->with('success', 'Storitev je bila dodana v sistem!');
		return Redirect::to('admin/services')->with('error', 'Prišlo je do napake pri shranjevanju!');
	}

	public function postUpdate()
	{
		$fields = array('name' => 'required', 'price' => 'required', 'time' => 'required');

		// Extreme case where input value has to be modified (in this case, time)
		$input = Input::only(array_keys($fields));
		$input['time'] = explode(':', $input['time'])[0]*60*60 + explode(':', $input['time'])[1]*60;

		if($this->save(Service::findOrFail(Input::get('id')), $input, $fields))
			return Redirect::to('admin/services')->with('success', 'Storitev shranjena!');
		return Redirect::to('admin/services')->with('error', 'Prišlo je do napake pri shranjevanju!');
	}
}

?>