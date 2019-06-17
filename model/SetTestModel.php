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

	function UpdateRow($params){
		try{
			$sql_query = "UPDATE prueba SET number = :number, name = :name, lastname = :lastname WHERE id = :id";
			$query = $this->db->connect()->prepare($sql_query);
			$query->execute(array(
				'number' => $params['number']['value'],
				'name' => $params['name']['value'],
				'lastname' => $params['lastname']['value'],
				'id' => $params['id']['value']
			));
			return TRUE;
		}catch(PDOException $e){
			return FALSE;
		}
	}	
}