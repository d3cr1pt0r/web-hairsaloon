<?php

class HomeController extends BaseController
{

	public function getIndex()
	{
		$view = View::make('frontend.home');
		return $view;
	}

}