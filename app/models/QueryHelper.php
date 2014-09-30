<?php

class QueryHelper {

	public static function andWhere($table, $data) {
		return DB::table($table)->where(function($query) use($data) {
			foreach($data as $key=>$value) {
				if(!is_numeric($value))
					$query->where($key, 'LIKE', '%'.$value.'%');
				else
					$query->where($key, '=', intval($value));
			}
		})->get();
	}
}

?>