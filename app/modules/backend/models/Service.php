<?php

class Service extends Eloquent
{

	protected $table = 'services';

	public function timePeriods()
    {
        return $this->hasMany('TimePeriod');
    }

}