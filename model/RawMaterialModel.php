<?php

/**
 * 
 */
class RawMaterialModel extends ModelBase{
	
	public $nombre;

	public $id;

	public $precio;

	public $unidad;

	public $cantidad;

	public $fecha;

	public $razon_social;

	private $table_categoria = 'categoria';
	private $table_materia_prima = 'materia_prima';
	private $table_inventario_m = 'inventario_m';
	private $table_mp_proveedor = 'mp_proveedor';
	private $table_proveedor = 'proveedor';

	function __construct(){
		parent::__construct();
	}

	function getMaterials(){

		try{
			$response = array(
				'status' => 1,
				'message' => 'success'
			);
			$connection = $this->db->connect();
			
			$nRows = $this->countRows($connection, $this->table_materia_prima);

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
			
			$query = "SELECT matp.*, cat.nombre, inv.cantidad, inv.fecha, prov.razon_social FROM " . $this->table_materia_prima . " AS matp";
			$query .= " JOIN " . $this->table_categoria . " AS cat";
			$query .= " ON matp.id_categoria = cat.id_categoria";
			$query .= " JOIN " . $this->table_inventario_m . " AS inv";
			$query .= " ON inv.id_materia_prima = matp.id";
			$query .= " JOIN " . $this->table_mp_proveedor . " AS mp_prov";
			$query .= " ON mp_prov.id_materiap = matp.id";
			$query .= " JOIN " . $this->table_proveedor . " AS prov";
			$query .= " ON mp_prov.id_proveedor = prov.id";
			$query .= " LIMIT $start_point, $this->ndata";

			$result_data = $connection->query($query); 

	    if($result_data->rowCount() > 0) { 
        while($row = $result_data->fetch()) {
					$material = new RawMaterialModel();
					$material->id = $row['id'];
					$material->nombre = $row['nombre'];
					$material->precio = $row['precio'];
					$material->unidad = $row['unidad'];
					$material->cantidad = $row['cantidad'];
					$material->fecha = $row['fecha'];
					$material->razon_social = $row['razon_social'];
					$response['data'][] = $material;
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

/*	function deleteRow($row_id, $service){
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
			$curremt_date = date("Y-m-d");
			$sql_query = "UPDATE proveedor SET motivo = :reazon, fecha_retiro = :currentdate WHERE id = :id";
			$query = $this->db->connect()->prepare($sql_query);
			$query->execute(array(
				'id' => $params['id']['value'],
				'reazon' => $params['reazon']['value'],
				'currentdate' => $curremt_date
			));
			return TRUE;
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
	}	*/
}