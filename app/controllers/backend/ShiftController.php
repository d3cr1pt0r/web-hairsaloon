<?php

class ShiftController extends BaseAdminController
{
	private $title = 'Izmene';
	private $table = 'shifts';
	private $controller = 'shifts';

	private $headers = array(array("db" => "name", "header" => 'Ime izmene', 'type' => "normal"),
							array("db" => "from", "header" => 'Od', 'type' => "time"),
							array("db" => "to", "header" => 'Do', 'type' => "time"),
							array("db" => "color", "header" => "Barva", "type" => "color"),
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

	public function getAdd()
	{
		$view = View::make('backend.shifts.edit');
		$view->title = $this->title;
		$view->controller = $this->controller;

		return $this->render($view);
	}

	public function postSave()
	{
		// Validate user input
		$validator = Validator::make(
		    Input::all(),
		    array(
		        'name' => 'required',
		        'from' => 'required',
		        'to' => 'required',
		        'color' => 'required'
		    )
		);

		if ($validator->fails())
			return Redirect::to('admin/services/add')->with('error', 'Validation error!');
		else
		{
			$from = explode(':', Input::get('from'))[0]*60*60 + explode(':', Input::get('from'))[1]*60;
			$to = explode(':', Input::get('to'))[0]*60*60 + explode(':', Input::get('to'))[1]*60;

			if(!Input::has('id'))
			{
				$shift = new Shift;
				$shift->name = Input::get('name');
				$shift->from = $from;
				$shift->to = $to;
				$shift->color = Input::get('color');

				$shift->save();

				return Redirect::to('admin/shifts')->with('success', 'Izmena je bila dodana v sistem!');
			}
			else
			{
				$shift = Shift::find(Input::get('id'));
				if($shift == null)
					return Redirect::to('admin/shifts')->with('error', 'Zahtevana izmena ne obstaja!');

				$shift->name = Input::get('name');
				$shift->from = $from;
				$shift->to = $to;
				$shift->color = Input::get('color');
				$shift->save();

				return Redirect::to('admin/shifts')->with('success', 'Izmena uspešno shranjena!');
			}
		}
	}

	public function getEdit($id)
	{
		$shift = Shift::find($id);
		if($shift == null)
			return Redirect::to('/admin/shifts')->with('error', 'Zahtevana izmena ne obstaja!');

		// Change service time so input can later display it
		$shift->from = date('H:i', $shift->from);
		$shift->to = date('H:i', $shift->to);

		$view = View::make('backend.shifts.edit');
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