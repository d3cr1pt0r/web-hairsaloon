<?php

	class TimePeriod extends Eloquent 
	{

		protected $table = 'time_periods';
		public $timestamps = false;

		public function service()
		{
			return $this->belongsTo('Service');
		}
	}
	
?>