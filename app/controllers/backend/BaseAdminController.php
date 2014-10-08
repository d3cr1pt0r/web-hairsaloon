<?php

class BaseAdminController extends Controller
{
	protected $page_title;

	public function __construct()
	{
		$this->beforeFilter('auth.admin', array('except' => array('getLogin', 'postLogin')));
		$this->beforeFilter('csrf', array('only' => array('postLogin')));

		$this->page_title = "Admin";
	}

	protected function render($view)
	{
		$view->page_title = $this->page_title;
		return $view;
	}

	public function filterData($table, $data = array()) {
		return QueryHelper::andWhere($table,$data);
	}

	public function save($model, $input, $fields)
	{
		$validator = Validator::make(Input::only(array_keys($fields)), $fields);

		if($validator->fails())
			return false;

		foreach($input as $key=>$value)
			$model->$key = $value;
		
		$model->save();
		return $model->id;
	}

	public function delete($model)
	{
		if($model == null)
			return false;

		$service->delete();
		return true;
	}
}