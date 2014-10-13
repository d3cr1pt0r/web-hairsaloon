<?php

class Schedule extends Eloquent
{
	protected $table = 'schedules';

	public function userShifts()
	{
		return $this->hasMany('UserHasShift', 'id_schedules');
	}
}