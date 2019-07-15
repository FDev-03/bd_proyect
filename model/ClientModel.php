<?php

/**
 * 
 */
class ClientModel extends ModelBase{
	
	public $nombre_contacto;

	public $id;

	public $telefono;

	private $table_cliente = 'cliente';

	function __construct(){
		parent::__construct();
	}

	function getClient(){

		try{
			$response = array(
				'status' => 1,
				'message' => 'success'
			);
			$connection = $this->db->connect();
			
			$nRows = $this->countRows($connection, $this->table_cliente);

			if ($nRows < 1){
	      $response['status'] = 0;
	      $response['available'] = 0;
	      $response['message'] = 'No records matching are found';
	      return $response;
			}
			$nAvailable = ceil($nRows/$this->ndata);
			$npage = $_GET['npage'];
		
			if (!is_numeric($npage) || $npage<1 || $npage > $nAvailable) {
				return FALSE;
			}

			$start_point = ($npage * $this->ndata) - $this->ndata;
			
			$query = "SELECT * FROM " . $this->table_cliente ;
			$query .= " LIMIT $start_point, $this->ndata";

			$result_data = $connection->query($query); 

	    if($result_data->rowCount() > 0) { 
        while($row = $result_data->fetch()) {
					$Client = new ClientModel();
					$Client->id = $row['id'];
					$Client->nombre_contacto = $row['nombre_contacto'];
										
					$response['data'][] = $Client;
        }
	      $response['available'] = range(1, $nAvailable);
	    } else { 
        $response['status'] = 0;
        $response['available'] = 0;
        $response['message'] = 'No records matching are found';
	    } 
			return $response;
		}catch(PDOException $e){
			return $e;
		}
	}
	
}