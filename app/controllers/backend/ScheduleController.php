<?php

class ScheduleController extends BaseAdminController
{
	private $title = 'Urniki';

	public function getIndex()
	{
		$view = View::make('backend.schedules.view');
		$view->title = $this->title;

		$schedules = Schedule::all();

		$view->schedules = $schedules;
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