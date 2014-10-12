<?php

namespace App\Modules\Backend\Controllers;

use View, User, Auth, CalendarHelper, Schedule, Shift;

class ScheduleController extends BaseAdminController
{
	private $title = 'Urniki';

	public function getIndex()
	{
		$view = View::make('backend::schedules.view');
		$view->title = $this->title;
		$view->calendar = CalendarHelper::getCalendar();

		$schedules = Schedule::all();
		$users = User::where('access_type', '>', '1')->where('access_type', '<', '4')->get();
		$shifts = Shift::all();

		$view->schedules = $schedules;
		$view->shifts = $shifts;
		$view->users = $users;

		foreach($shifts as $shift)
		{
			$from = $shift->from;
			$to = $shift->to;
			$range = $to - $from;

			$shift->from_str = date('H:i', $from);
			$shift->to_str = date('H:i', $to);
			$shift->range = $range;
			$shift->range_str = date('H:i', $range);
		}

		return $this->render($view);
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