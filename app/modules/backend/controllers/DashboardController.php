<?php

namespace App\Modules\Backend\Controllers;

use View;

class DashboardController extends BaseAdminController
{

	public function getIndex()
	{
		$view = View::make('backend::dashboard.view');
		$view->title = "Admin - Dashboard";
		return $this->render($view);
	}

}