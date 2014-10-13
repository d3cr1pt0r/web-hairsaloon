<?php

namespace App\Modules\Backend\Controllers;

use View, User, Auth, CalendarHelper, Schedule, Shift, Input, UserHasShift;

class ScheduleController extends BaseAdminController
{
	protected $controller = 'schedules';

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
		$view->controller = $this->controller;

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
		$fields = array('day-from' => 'required', 'day-to' => 'required', 'slider' => 'required', 'user-id' => 'required', 'shift-id' => 'required', 'shift-active' => 'required');
		$input = Input::only(array_keys($fields));

		// Calculate date diff
		$day_from = intval($input['day-from']);
		$day_to = intval($input['day-to']);
		$date_diff = 1 + ($day_to - $day_from) / 60 / 60 / 24;
		$day_in_seconds = 86400;

		// Restructure input array
		$user_array = array();
		foreach($input['user-id'] as $key=>$val)
			if($input['shift-active'][$key] == '1')
				$user_array[$val][] = array($input['shift-id'][$key], $input['slider'][$key]);

		for($i=0;$i<$date_diff;$i++)
		{
			foreach($user_array as $key=>$user)
			{
				
			}
		}

		/*
		for($i=0;$i<$date_diff;$i++)
		{
			foreach($input['shift-active'] as $key=>$val)
			{
				if($val == "1")
				{
					$schedule = new Schedule;
					$schedule->date = $day_from + $i * $day_in_seconds;
					//$schedule->save();

					$schedule->id_user = $input['user-id'][$i];

					$user_has_shift = new UserHasShift();
					$user_has_shift->$input['shift-id'][$i];
					$user_has_shift->from = explode(':', $input['slider'][$i])[0];
					$user_has_shift->to = explode(':', $input['slider'][$i])[1];

					$schedule->save();
					$schedule->userShifts()->save($user_has_shift);
				}
			}
			//$schedule->save();
		}
		*/
	}
}

?>