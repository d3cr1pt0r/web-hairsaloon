<?php

class UserHasShift extends Eloquent
{
	protected $table = 'user_has_shifts';

	public function shift()
	{
		return $this->hasOne('Shift', 'id', 'id_shifts');
	}
}