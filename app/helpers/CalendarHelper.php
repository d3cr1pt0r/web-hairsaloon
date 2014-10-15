<?php

class CalendarHelper
{
	
	public static function getCalendar($month = false, $year = false)
	{
		if($month == false && $year == false)
		{
			$month = date('n');
			$year = date('Y');
		}

		$days = cal_days_in_month(CAL_GREGORIAN, $month, $year);
		$num_rows = ceil($days / 7);
		$first_day_info = getdate(strtotime('1.'.$month.'.'.$year));
		$counter = 1;

		for($i=0;$i<$num_rows;$i++)
		{
			for($j=1;$j<=7;$j++)
			{
				$real_pos = $counter - ($first_day_info['wday'] - 1);
				if($real_pos < 1 || $real_pos > $days)
					$calendar_array[$i][] = 0;
				else
					$calendar_array[$i][] = getdate(strtotime($real_pos.'.'.$month.'.'.$year));
				$counter++;
			}
		}

		return $calendar_array;
	}

	public static function populateCalendar($calendar, $user)
	{
		$schedules = $user->schedules;
		
		foreach($calendar as $key1=>$week)
		{
			foreach($week as $key2=>$day) {
				foreach($schedules as $schedule) {
					if($day[0] == $schedule->date) {
						foreach($schedule->userShifts as $shift) {
							$s = $shift->shift;
							$workTime = $shift->to - $shift->from;
							$shiftTime = $s->to - $s->from;
							$percent = $workTime * 100 / $shiftTime;
							$calendar[$key1][$key2]['data'][] = array('name' => $s->name, 'total' => floor($percent), 'color' => $s->color);
						}
					}
				}
			}
		}

		return $calendar;
	}

}