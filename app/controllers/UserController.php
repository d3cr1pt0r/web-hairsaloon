<?php

class UserController extends BaseAdminController
{
	
	public function getIndex()
	{
		$view = View::make('backend.users.home');
		$view->title = "Users";
		return $this->render($view);
	}

}

?>