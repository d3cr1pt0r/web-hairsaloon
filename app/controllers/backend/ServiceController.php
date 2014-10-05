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
		$service = Service::find($id);
		if($service == null)
			return Redirect::to('/admin/services')->with('error', 'Zahtevana storitev ne obstaja!');

		$service->delete();
		return Redirect::to('admin/services')->with('success', 'Storitev je bila zbrisana!');
	}

	public function postSave()
	{
		// Validate user input
		$validator = Validator::make(
		    Input::all(),
		    array(
		        'name' => 'required',
		        'price' => 'required',
		        'time' => 'required'
		    )
		);

		if ($validator->fails())
			return Redirect::to('admin/services/add')->with('error', 'Validation error!');
		else
		{
			// Process user input
			$time = Input::get('time');
			$time = explode(':', $time)[0]*60*60 + explode(':', $time)[1]*60;

			if(!Input::has('id'))
			{
				$service = new Service;
				$service->name = Input::get('name');
				$service->price = Input::get('price');
				$service->time = $time;
				$service->save();

				return Redirect::to('admin/services')->with('success', 'Storitev je bila dodana v sistem!');
			}
			else
			{
				$service = Service::find(Input::get('id'));
				if($service == null)
					return Redirect::to('admin/services')->with('error', 'Zahtevana storitev ne obstaja!');

				$service->name = Input::get('name');
				$service->price = Input::get('price');
				$service->time = $time;
				$service->save();

				return Redirect::to('admin/services')->with('success', 'Storetev uspešno shranjena!');
			}
		}
	}
}

?>