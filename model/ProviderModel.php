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

	function __construct(){
		parent::__construct();
	}

	function getProviders(){

		try{
			
			$connection = $this->db->connect();
			$nRows = $this->countRows($connection, 'proveedor');
			$nAvailable = ceil($nRows/$this->ndata);
			$npage = $_GET['npage'];
		
			if (!is_numeric($npage) || $npage<1 || $npage > $nAvailable) {
				return FALSE;
			}
			
			$start_point = ($npage * $this->ndata) - $this->ndata;
			$condition = "WHERE "
			$query = "SELECT * FROM proveedor LIMIT $start_point, $this->ndata";
			
			$response = [];
			foreach ($connection->query($query) as $row) {
				$get = new ProviderModel();
				$get->id = $row['id'];
				$get->nombre_contacto = $row['nombre_contacto'];
				$get->razon_social = $row['razon_social'];
				$response['data'][] = $get;
			}
			$response['available'] = range(1, $nAvailable);
			return $response;
		}catch(PDOException $e){
			echo "Error!";
		}
	}
}