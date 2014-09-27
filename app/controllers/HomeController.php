<?php

class HomeController extends BaseController
{

	public function getIndex()
	{
		$view = View::make('frontend.home');
		$view->title = 'Title';
		return $view;		
	}

}
