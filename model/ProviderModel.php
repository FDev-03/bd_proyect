<?php

/**
 * 
 */
class ProviderModel extends ModelBase{
	
	public $id;

	public $nombre_contacto;

	public $razon_social;

	public $motivo;

	public $fecha_retiro;

	private $table_name = 'proveedor';

	function __construct(){
		parent::__construct();
	}

	function getProviders($service){

		try{
			
			$connection = $this->db->connect();
			
    		if ($service == TRUE)
    			$condition = " WHERE motivo IS NULL AND fecha_retiro IS NULL ";
    		else
    			$condition = " WHERE motivo IS NOT NULL AND fecha_retiro IS NOT NULL ";

			$nRows = $this->countRows($connection, $this->table_name, $condition);
			$nAvailable = ceil($nRows/$this->ndata);
			$npage = $_GET['npage'];
		
			if (!is_numeric($npage) || $npage<1 || $npage > $nAvailable) {
				return FALSE;
			}

			$start_point = ($npage * $this->ndata) - $this->ndata;
			
			$query = "SELECT * FROM " . $this->table_name . " $condition LIMIT $start_point, $this->ndata";

			$response = array(
				'status' => 1,
				'message' => 'success'
			);
			$result_data = $connection->query($query); 

		    if($result_data->rowCount() > 0) { 
		        while($row = $result_data->fetch()) {
					$provider = new ProviderModel();
					$provider->id = $row['id'];
					$provider->nombre_contacto = $row['nombre_contacto'];
					$provider->razon_social = $row['razon_social'];
					if ($service == FALSE){
						$provider->motivo = $row['motivo'];
						$provider->fecha_retiro = $row['fecha_retiro'];
					}
					$response['data'][] = $provider;
		        }
		        $response['available'] = range(1, $nAvailable);
		    } else { 
		        $response['status'] = 0;
		        $response['available'] = 0;
		        $response['message'] = 'No records matching are found';
		    } 
			return $response;
		}catch(PDOException $e){
			echo "Error!";
		}
	}

	function deleteRow($row_id, $service){
		try{
			$sql_query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
			$connection = $this->db->connect();
			$query = $connection->prepare($sql_query);
			$query->execute(array(
				'id' => $row_id
			));

    		if ($service == TRUE)
    			$condition = " WHERE motivo IS NULL AND fecha_retiro IS NULL ";
    		else
    			$condition = " WHERE motivo IS NOT NULL AND fecha_retiro IS NOT NULL ";

			$nRows = $this->countRows($connection, $this->table_name, $condition);
			$response['status'] = 1;
			$response['data'] = array(
				'nAvailable' => ceil($nRows/$this->ndata)
			);
			return $response;
		}catch(PDOException $e){
			$response['status'] = 0;
		}
	}
}