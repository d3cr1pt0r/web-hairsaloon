<?php

<<<<<<< HEAD
class BaseController extends Controller {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */
	protected function setupLayout()
	{
		if ( ! is_null($this->layout))
		{
			$this->layout = View::make($this->layout);
		}
	}
=======
class BaseController extends Controller
{


>>>>>>> a9952179ee9574bad1615d0fec2b1dad3dbce625

}
