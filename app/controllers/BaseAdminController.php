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
		$view->controller = 'users';
		return $view;
	}

	public function filterData($table, $data = array()) {
		return QueryHelper::andWhere($table,$data);
	}
}