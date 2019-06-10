<?php

/**
 * 
 */
class SetTestModel extends ModelBase {
	
	function __construct(){
		parent::__construct();
	}

	function insertData(array $data){
		try{
			$sql_query = 'INSERT INTO prueba (name,lastname,number) VALUES (:name,:lastname,:number)';
			$query = $this->db->connect()->prepare($sql_query);
			$query->execute(array(
				'name' => $data['name'],
				'lastname' => $data['lastname'],
				'number' => $data['number']
			));
			return true;
		}catch(PDOException $e){
			return false;
		}

	}
}