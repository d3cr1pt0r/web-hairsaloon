<?php

namespace App\Modules\Backend\Controllers;

use QueryHelper, Validator, Input, GenericHelper;

class BaseAdminController extends \Controller
{
	protected $page_title;

	public function __construct()
	{
		$this->beforeFilter('auth.admin', array('except' => array('getLogin', 'postLogin')));
		$this->beforeFilter('csrf', array('only' => array('postLogin')));
		$this->page_title = "Admin";

		$this->table = GenericHelper::getTable($this->controller);
		$this->title = GenericHelper::getTitle($this->controller);
		$this->filters = GenericHelper::getFilters($this->controller);
		$this->headers = GenericHelper::getHeaders($this->controller);
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

		$model->delete();
		return true;
	}
}