<?php

namespace App\Modules\Backend\Controllers;

use View, Input, Redirect, User, GenericHelper, UsersGroup;

class UsersGroupController extends BaseAdminController
{
	protected $controller = 'users-groups';

	public function getIndex()
	{
		$view = View::make('backend::table');
		$view->title = "Skupine uporabnikov";
		$view->controller = $this->controller;
		$view->table = $this->table;

		$userGroups = UsersGroup::all();

		$view->headers = $this->headers;
		$view->data = $userGroups;

		return $this->render($view);
	}

	public function getAdd()
	{
		$view = View::make('backend::users_groups.edit');
		$view->title = "Dodaj skupino";
		$view->controller = $this->controller;
		
		return $this->render($view);
	}

	public function getEdit($id)
	{
		$usersGroup = UsersGroup::find($id);
		if($usersGroup == null)
			return Redirect::to('/admin/users-groups')->with('error', 'Zahtevana skupina ne obstaja!');

		$view = View::make('backend::users_groups.edit');
		$view->usersGroup = $usersGroup;
		$view->title = "Uredi skupino";
		$view->controller = $this->controller;

		return $this->render($view);
	}

	public function getDelete($id)
	{
		$usersGroup = UsersGroup::find($id);
		if($usersGroup == null)
			return Redirect::to('/admin/users-groups')->with('error', 'Zahtevana skupina ne obstaja!');

		$usersGroup->delete();
		return Redirect::to('admin/users-groups')->with('success', 'Skupina je bila izbrisana!');
	}

	public function postSave()
	{
		$fields = array('name' => 'required');

		// Extreme case where input value has to be modified (in this case, from and to)
		$input = Input::only(array_keys($fields));

		$response = $this->save(new UsersGroup, $input, $fields);
		if($response->status)
			return Redirect::to('admin/users-groups')->with('success', 'Skupina je bila dodana v sistem!');
		return Redirect::to('admin/users-groups')->with('error', $response->validator->messages()->first());
	}

	public function postUpdate()
	{
		$fields = array('name' => 'required');

		// Extreme case where input value has to be modified (in this case, from and to)
		$input = Input::only(array_keys($fields));

		$response = $this->save(UsersGroup::findOrFail(Input::get('id')), $input, $fields);
		if($response->status)
			return Redirect::to('admin/users-groups')->with('success', 'Skupina shranjena!');
		return Redirect::to('admin/users-groups')->with('error', $response->validator->messages()->first());
	}
}