<?php

namespace App\Modules\Backend\Controllers;

use View, User, Auth, Shift, Input, Redirect;

class ShiftController extends BaseAdminController
{
	protected $controller = 'shifts';

	public function getIndex()
	{
		$view = View::make('backend::table');
		$view->title = $this->title;
		$view->controller = $this->controller;
		$view->table = $this->table;

		// Data
		$shifts = Shift::all();

		$view->headers = $this->headers;
		$view->data = $shifts;
		return $this->render($view);
	}

	public function getAdd()
	{
		$view = View::make('backend::shifts.edit');
		$view->title = $this->title;
		$view->controller = $this->controller;

		return $this->render($view);
	}

	public function postSave()
	{
		$fields = array('name' => 'required', 'from' => 'required', 'to' => 'required', 'color' => 'required');

		// Extreme case where input value has to be modified (in this case, from and to)
		$input = Input::only(array_keys($fields));
		$input['from'] = explode(':', $input['from'])[0]*60*60 + explode(':', $input['from'])[1]*60;
		$input['to'] = explode(':', $input['to'])[0]*60*60 + explode(':', $input['to'])[1]*60;

		if($this->save(new Shift, $input, $fields))
			return Redirect::to('admin/shifts')->with('success', 'Izmena je bila dodana v sistem!');
		return Redirect::to('admin/shifts')->with('error', 'Prišlo je do napake pri shranjevanju!');
	}

	public function postUpdate()
	{
		$fields = array('name' => 'required', 'from' => 'required', 'to' => 'required', 'color' => 'required');

		// Extreme case where input value has to be modified (in this case, from and to)
		$input = Input::only(array_keys($fields));
		$input['from'] = explode(':', $input['from'])[0]*60*60 + explode(':', $input['from'])[1]*60;
		$input['to'] = explode(':', $input['to'])[0]*60*60 + explode(':', $input['to'])[1]*60;

		if($this->save(Shift::findOrFail(Input::get('id')), $input, $fields))
			return Redirect::to('admin/shifts')->with('success', 'Izmena shranjena!');
		return Redirect::to('admin/shifts')->with('error', 'Prišlo je do napake pri shranjevanju!');
	}

	public function getEdit($id)
	{
		$shift = Shift::find($id);
		if($shift == null)
			return Redirect::to('/admin/shifts')->with('error', 'Zahtevana izmena ne obstaja!');

		// Change service time so input can later display it
		$shift->from = date('H:i', $shift->from);
		$shift->to = date('H:i', $shift->to);

		$view = View::make('backend::shifts.edit');
		$view->shift = $shift;
		$view->title = $this->title;
		$view->controller = $this->controller;

		return $this->render($view);
	}

	public function getDelete($id)
	{
		$shift = Shift::find($id);
		if($shift == null)
			return Redirect::to('/admin/shifts')->with('error', 'Zahtevana izmena ne obstaja!');

		$shift->delete();
		return Redirect::to('admin/shifts')->with('success', 'Izmena je bila zbrisana!');
	}
}

?>