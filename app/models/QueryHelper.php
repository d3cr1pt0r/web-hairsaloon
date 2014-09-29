<?php

class QueryHelper {

	public static function andWhere($table, $data) {
		$object = DB::table($table)->where(function($query) use($data) {
			foreach($data as $key=>$value) {
				$query->where($key, $value);
			}
		})->get();

		return $object;
	}

}

?>