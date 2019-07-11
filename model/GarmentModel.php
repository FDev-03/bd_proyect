<?php

/**
 *
 */
class GarmentModel extends ModelBase{

	public $nombre;

	public $id;

	public $precio;

	public $talla;

	public $tipo;

	private $table_prenda = 'prenda';

	function __construct(){
		parent::__construct();
	}

	function getGarment(){

		try{
			$response = array(
				'status' => 1,
				'message' => 'success'
			);
			$connection = $this->db->connect();

			$nRows = $this->countRows($connection, $this->table_prenda);

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

			$query = "SELECT * FROM " . $this->table_prenda;
			$query .= " LIMIT $start_point, $this->ndata";

			$result_data = $connection->query($query);

	    if($result_data->rowCount() > 0) {
        while($row = $result_data->fetch()) {
					$Garment = new GarmentModel();
					$Garment->id = $row['id'];
					$Garment->nombre = $row['nombre'];
					$Garment->precio = $row['precio'];
					$Garment->talla = $row['talla'];
					$Garment->tipo = $row['tipo'];
					$response['data'][] = $Garment;
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


	function addGarment($params){
		try{
			// Insert into materia_prima.
			$current_date = strval(date("Y-n-d"));
			$sql_query = 'INSERT INTO ' . $this->table_prenda . ' (precio,nombre,talla,tipo) VALUES (:precio,:nombre,:talla,:tipo)';
			$connect = $this->db->connect();
			$query = $connect->prepare($sql_query);
			$query->execute(array(
				'precio' => $params['prenda_precio']['value'],
				'nombre' => $params['prenda_nombre']['value'],
				'talla' => $params['prenda_talla']['value'],
				'tipo' => $params['prenda_tipo']['value']
			));

			return TRUE;
		}catch(PDOException $e){
			return false;
		}
	}
}
