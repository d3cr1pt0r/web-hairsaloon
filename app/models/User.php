<?php

use Illuminate\Auth\UserTrait;
use Illuminate\Auth\UserInterface;
use Illuminate\Auth\Reminders\RemindableTrait;
use Illuminate\Auth\Reminders\RemindableInterface;

class User extends Eloquent implements UserInterface, RemindableInterface {

	use UserTrait, RemindableTrait;

	protected $table = 'users';

	protected $hidden = array('remember_token');

	public function groups()
	{
		return $this->belongsToMany('UsersGroup', 'groups_has_users');
	}

	public static function AuthenticateAdmin($email, $password)
	{
		$user = User::where('email', '=', $email)->first();
		if($user == null) return false;
		if(sha1($password) == $user->password && $user->access_level < 5)
		{
			Auth::login($user);
			return true;
		}
		return false;
	}

	public static function AuthenticateUser($email, $password)
	{
		$user = User::where('email', '=', $email)->first();
		if($user == null) return false;
		if(sha1($password) == $user->password)
		{
			Auth::login($user);
			return true;
		}
		return false;
	}

	public function schedules()
	{
		return $this->hasMany('Schedules', 'id_user');
	}
}