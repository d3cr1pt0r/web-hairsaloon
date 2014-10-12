<?php

class ActionController extends Controller
{

	public function __construct()
	{
		$this->beforeFilter('auth.admin', array('only' => array('postToggleValue')));
	}

	public function postToggleValue()
	{
		$id = Input::get("id");
		$field = Input::get("field");
		$table = Input::get("table");

		$old_val = (array) DB::table($table)->select($field)->where("id", $id)->first();
		if($old_val[$field] == 1)
			$val = 0;
		else
			$val = 1;

		DB::table($table)->where("id", $id)->update(array($field => $val));
	}

}