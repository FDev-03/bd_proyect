<?php

/**
 * 
 */
class GetTestModel extends ModelBase {

	public $id;

	public $name;

	public $lastname;

	public $number;

	private $ndata = 10;
	
	function __construct() {
		parent::__construct();
	}

	private function countRows($connection){
		$query = "SELECT count(*) FROM prueba";

		if ($res = $connection->query($query)) {
			return $res->fetchColumn();
		}
		return 1;
	}

	function getData() {

		try{
			
			$connection = $this->db->connect();
			$nRows = $this->countRows($connection);
			$nAvailable = ceil($nRows/$this->ndata);
			$npage = $_GET['npage'];
		
			if (!is_numeric($npage) || $npage<1 || $npage > $nAvailable) {
				return FALSE;
			}
			
			$start_point = ($npage * $this->ndata) - $this->ndata;
			$query = "SELECT * FROM prueba LIMIT $start_point, $this->ndata";
			
			$response = [];
			foreach ($connection->query($query) as $row) {
				$get = new GetTestModel();
				$get->id = $row['id'];
				$get->name = $row['name'];
				$get->lastname = $row['lastname'];
				$get->number = $row['number'];
				$response['data'][] = $get;
			}
			$response['available'] = range(1, $nAvailable);
			return $response;
		}catch(PDOException $e){
			echo "Error!";
		}
	}

	function getSpecific($id){
		try{

			$sql_query = "SELECT name, lastname, number FROM prueba WHERE id = :id";
			$query = $this->db->connect()->prepare($sql_query);
			$query->execute(array(
				'id' => $id
			));
			$result = $query->fetch();
			return $result;
		}catch(PDOException $e){
			return FALSE;
		}
	}

	function deleteRow($row_id){
		try{
			$sql_query = "DELETE FROM prueba WHERE id = :id";
			$query = $this->db->connect()->prepare($sql_query);
			$query->execute(array(
				'id' => $row_id
			));
			return TRUE;
		}catch(PDOException $e){
			return FALSE;
		}
	}
}