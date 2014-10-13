<?php

class GenericHelper
{

	public static function getTable($controller)
	{
		$table = null;

		switch ($controller)
		{
			case 'users':
				$table = 'users';
				break;
			case 'users-groups':
				$table = 'user_groups';
				break;
			case 'shifts':
				$table = 'shifts';
				break;
			case 'schedules':
				$table = 'schedules';
				break;
			case 'services':
				$table = 'services';
				break;
			case 'profile':
				$table = 'profile';
				break;
			default:
				break;
		}

		return $table;
	}

	public static function getTitle($controller)
	{
		$title = null;

		switch ($controller)
		{
			case 'users':
				$title = 'Uporabniki';
				break;
			case 'users-groups':
				$title = 'Skupine uporabnikov';
				break;
			case 'services':
				$title = 'Storitve';
				break;
			case 'shifts':
				$title = 'Izmene';
				break;
			case 'profile':
				$title = 'Moj profil';
				break;
			case 'schedules':
				$title = 'Urniki';
			default:
				break;
		}

		return $title;
	}

	public static function getFilters($controller)
	{
		$filters = null;

		switch($controller)
		{
			case 'users':
				$filters = array(
					array(
						"type" => "text",
						"name" => "name",
						"label" => "Name"
					),
					array(
						"type" => "text",
						"name" => "lastname",
						"label" => "Lastname"
					),
					array(
						"type" => "text",
						"name" => "email",
						"label" => "Email"
					)
				);
				break;
			case 'services':
				$filters = array(
					array(
						"type" => "text",
						"name" => "name",
						"label" => "Ime storitve"
					),
					array(
						"type" => "text",
						"name" => "price",
						"label" => "Cena storitve"
					)
				);
				break;
			default:
				break;
		}

		return $filters;
	}

	public static function getHeaders($controller)
	{
		$headers = array();

		switch ($controller)
		{
			case 'users':
				$headers = array(
					array(
						"db" => "name",
						"header" => 'Ime',
						'type' => "normal"
					),
					array(
						"db" => "lastname",
						"header" => 'Priimek',
						'type' => "normal"
					),
					array(
						"db" => "email",
						"header" => 'Email',
						'type' => "mail_url"
					),
					array(
						"db" => "active",
						"header" => 'Aktiven',
						"type" => "checkbox"
					)
				);
				break;
			case 'users-groups':
				$headers = array(
					array(
						"db" => "name",
						"header" => 'Ime',
						'type' => "normal"
					),
					array(
						"db" => "active",
						"header" => 'Aktiven',
						"type" => "checkbox"
					)
				);
				break;
			case 'shifts':
				$headers = array(
					array(
						"db" => "name",
						"header" => 'Ime izmene',
						'type' => "normal"
					),
					array(
						"db" => "from",
						"header" => 'Od',
						'type' => "time"
					),
					array(
						"db" => "to",
						"header" => 'Do',
						'type' => "time"
					),
					array(
						"db" => "color",
						"header" => "Barva",
						"type" => "color"
					),
					array(
						"db" => "active",
						"header" => 'Aktiven',
						'type' => "checkbox"
					)
				);
				break;
			case 'services':
				$headers = array(
					array(
						"db" => "name",
						"header" => 'Ime storitve',
						'type' => "normal"
					),
					array(
						"db" => "price",
						"header" => 'Cena',
						'type' => "price"
					),
					array(
						"db" => "time",
						"header" => 'Čas',
						'type' => "timeperiod"
					),
					array("db" => "active",
						"header" => 'Aktiven',
						'type' => "checkbox"
					)
				);
				break;
			default:
				break;
		}

		return $headers;
	}
	
	public static function getAccesTypeString($access_type)
	{
		$access_type_string = null;

		switch($access_type) {
			case 1:
				$access_type_string = "super administratorji";
				break;
			case 2:
				$access_type_string = "administratorji";
				break;
			case 3:
				$access_type_string = "frizerji";
				break;
			case 5:
				$access_type_string = "stranke";
				break;
		}

		return $access_type_string;
	}

}

?>