<?php

	class UsersGroup extends Eloquent 
	{

		protected $table = 'user_groups';

		public function users()
		{
			return $this->belongsToMany('User', 'groups_has_users', 'group_id', 'user_id');
		}
	}
	
?>