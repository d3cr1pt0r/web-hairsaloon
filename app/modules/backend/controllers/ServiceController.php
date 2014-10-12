<?php

namespace App\Modules\Backend\Controllers;

use View, User, Auth, Input, Redirect, TimePeriod, Service;

class ServiceController extends BaseAdminController
{
	protected $controller = 'services';

	public function getIndex()
	{
		$view = View::make('backend::table');
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
		$view = View::make('backend::table');
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
		$view = View::make('backend::services.edit');
		$view->title = $this->title;
		$view->controller = $this->controller;
		$view->time_periods = array();

		return $this->render($view);
	}

	public function getEdit($id)
	{
		$service = Service::find($id);
		if($service == null)
			return Redirect::to('/admin/services')->with('error', 'Zahtevana storitev ne obstaja!');

		// Change service time so input can later display it
		$service->time = date('H:i', $service->time);

		$view = View::make('backend::services.edit');
		$view->service = $service;
		$view->title = $this->title;
		$view->controller = $this->controller;
		$view->time_periods = $service->timePeriods;

		return $this->render($view);
	}

	public function getDelete($id)
	{
		if($this->delete(Service::find($id)))
			return Redirect::to('admin/services')->with('success', 'Podatki so bili izbrisani!');
		return Redirect::to('/admin/services')->with('error', 'Zahtevana storitev ne obstaja!');
	}

	public function postSave()
	{
		$fields = array('name' => 'required', 'price' => 'required');
		$fields_intervals = array('desc' => '', 'time' => 'required', 'active_time' => '');
		$input = Input::only(array_keys($fields));

		$service_id = $this->save(new Service, $input, $fields);

		if($service_id) 
		{
			$descs = Input::get('desc');
			$times = Input::get('time');
			$actives = Input::get("active_time");

			foreach($times as $key => $val) {
				$val= explode(':', $val)[0]*60*60 + explode(':', $val)[1]*60;
				$this->save(new TimePeriod, array("service_id" => $service_id,  "desc" => $descs[$key], "time" => $val, "active_time" => $actives[$key]), $fields_intervals);
			}
			return Redirect::to('admin/services')->with('success', 'Storitev shranjena!');
		}
		return Redirect::to('admin/services')->with('error', 'Prišlo je do napake pri shranjevanju!');
	}

	public function postUpdate()
	{
		$fields = array('name' => 'required', 'price' => 'required');
		$fields_intervals = array('time' => 'required', 'active_time' => '');

		$input = Input::only(array_keys($fields));

		if($this->save(Service::findOrFail(Input::get('id')), $input, $fields)) 
		{
			$ids = Input::get('interval-id');
			$descs = Input::get('desc');
			$times = Input::get('time');
			$actives = Input::get("active_time");

			foreach($times as $key => $val) {
				$val= explode(':', $val)[0]*60*60 + explode(':', $val)[1]*60;
				if(isset($ids[$key]))
					$this->save(TimePeriod::findOrFail($ids[$key]), array("service_id" => Input::get('id'), "desc" => $descs[$key], "time" => $val, "active_time" => $actives[$key]), $fields_intervals);
				else
					$this->save(new TimePeriod, array("service_id" => Input::get('id'), "desc" => $descs[$key], "time" => $val, "active_time" => $actives[$key]), $fields_intervals);
			}
			return Redirect::to('admin/services')->with('success', 'Storitev shranjena!');
		}
		return Redirect::to('admin/services')->with('error', 'Prišlo je do napake pri shranjevanju!');
	}
}

?>