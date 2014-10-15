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

		$schedules = Schedule::all();
		$users = User::where('access_type', '>', '1')->where('access_type', '<', '4')->get();
		$shifts = Shift::all();

		$view->calendar = CalendarHelper::populateCalendar(CalendarHelper::getCalendar(), $users[0]);
		$view->schedules = $schedules;
		$view->shifts = $shifts;
		$view->users = $users;
		$view->controller = $this->controller;

		//return var_dump($view->calendar[1][0][1]->userShifts->toArray());

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
				$user_array[$val][$input['shift-id'][$key]] = $input['slider'][$key];

		//return var_dump($user_array);

		for($i=0;$i<$date_diff;$i++)
		{
			foreach($user_array as $id_user=>$user)
			{
				$schedule = new Schedule;
				$schedule->id_user = $id_user;
				$schedule->date = $day_from + $i * $day_in_seconds;
				$schedule->save();

				foreach($user_array[$id_user] as $id_shift=>$shift)
				{
					$user_has_shift = new UserHasShift();
					$user_has_shift->id_shifts = $id_shift;
					$user_has_shift->from = explode(':', $shift)[0];
					$user_has_shift->to = explode(':', $shift)[1];

					$schedule->userShifts()->save($user_has_shift);
				}
			}
		}
	}
}

?>