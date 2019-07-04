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

	public $numero;

	private $table_provider = 'proveedor';
	private $table_provider_phone = 'telefono_proveedor';

	function __construct(){
		parent::__construct();
	}

	function getProviders($service){

		try{
			$response = array(
				'status' => 1,
				'message' => 'success'
			);
			$connection = $this->db->connect();
			
    		if ($service == TRUE)
    			$condition = " WHERE motivo IS NULL AND fecha_retiro IS NULL ";
    		else
    			$condition = " WHERE motivo IS NOT NULL AND fecha_retiro IS NOT NULL ";

			$nRows = $this->countRows($connection, $this->table_provider, $condition);

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

    		if ($service == TRUE)
    			$condition = " AND prov.motivo IS NULL AND prov.fecha_retiro IS NULL ";
    		else
    			$condition = " AND prov.motivo IS NOT NULL AND prov.fecha_retiro IS NOT NULL ";
			
			$query = "SELECT prov.*, tel_prov.numero  FROM " . $this->table_provider . " AS prov";
			$query .= " JOIN " . $this->table_provider_phone . " AS tel_prov";
			$query .= " ON tel_prov.id_proveedor = prov.id";
			$query .= "$condition LIMIT $start_point, $this->ndata";

			$result_data = $connection->query($query); 

		    if($result_data->rowCount() > 0) { 
		        while($row = $result_data->fetch()) {
					$provider = new ProviderModel();
					$provider->id = $row['id'];
					$provider->nombre_contacto = $row['nombre_contacto'];
					$provider->razon_social = $row['razon_social'];
					$provider->numero = $row['numero'];
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
			return $e;
		}
	}

	function deleteRow($row_id, $service){
		try{
			$sql_query = "DELETE FROM " . $this->table_provider . " WHERE id = :id";
			$connection = $this->db->connect();
			$query = $connection->prepare($sql_query);
			$query->execute(array(
				'id' => $row_id
			));

  		if ($service == TRUE)
  			$condition = " WHERE motivo IS NULL AND fecha_retiro IS NULL ";
  		else
  			$condition = " WHERE motivo IS NOT NULL AND fecha_retiro IS NOT NULL ";

			$nRows = $this->countRows($connection, $this->table_provider, $condition);
			$response['status'] = 1;
			$response['data'] = array(
				'nAvailable' => ceil($nRows/$this->ndata)
			);
			return $response;
		}catch(PDOException $e){
			$response['status'] = 0;
		}
	}

	function UpdateRow($params){
		try{
			$current_date = date("Y-n-d");
			$sql_query = "UPDATE proveedor SET motivo = :reazon, fecha_retiro = :currentdate WHERE id = :id";
			$query = $this->db->connect()->prepare($sql_query);
			$query->execute(array(
				'id' => $params['id']['value'],
				'reazon' => $params['reazon']['value'],
				'currentdate' => $current_date
			));
			return TRUE;
		}catch(PDOException $e){
			return FALSE;
		}
	}

	function getAllProviders(){
		try{

			$connection = $this->db->connect();
			$query = "SELECT * FROM active_providers";

			$result_data = $connection->query($query); 
			$response = array(
				'status' => 1,
				'message' => 'success'
			);

	    if($result_data->rowCount() > 0) { 
	      while($row = $result_data->fetch()) {
					$provider = new ProviderModel();
					$provider->id = $row['id'];
					$provider->nombre_contacto = $row['nombre_contacto'];
					$response['data'][] = $provider;
	      }
	    } else { 
	      $response['status'] = 0;
	      $response['available'] = 0;
	      $response['message'] = 'No records matching are found';
	    }
	    return $response;
		}catch(PDOException $e){
			return FALSE;
		}
	}

	function addProvider($params){
		try{
			// Insert into proveedor.
			$sql_query = 'INSERT INTO proveedor (nombre_contacto,razon_social) VALUES (:name,:social_name)';
			$connect = $this->db->connect();
			$query = $connect->prepare($sql_query);
			$query->execute(array(
				'name' => $params['name']['value'],
				'social_name' => $params['social_name']['value']
			));

			$id = $connect->lastInsertId();
			// Insert into telefono_proveedor.
			$sql_query = 'INSERT INTO telefono_proveedor (numero,id_proveedor) VALUES (:ntel,:provider_id)';
			$query = $connect->prepare($sql_query);
			$query->execute(array(
				'ntel' => $params['number']['value'],
				'provider_id' => $id
			));

			return TRUE;
		}catch(PDOException $e){
			return false;
		}
	}	
}