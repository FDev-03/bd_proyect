<?php

/**
 * 
 */
class ModelBase {

	public $ndata = 10;
	
	function __construct(){
		$this->db = new Database();
	}

	public function countRows($connection, $table_name, $condition = ''){
		$query = "SELECT count(*) FROM $table_name $condition";

		if ($res = $connection->query($query)) {
			return $res->fetchColumn();
		}
		return 1;
	}

}