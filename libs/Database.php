<?php

/**
 *
 */
class Database {

	private $host;
	private $user;
	private $db;
	private $port;
	private $password;
	private $charset;

	function __construct(){
		$this->host = constant('HOST');
		$this->user = constant('USER');
		$this->password = constant('PASSWORD');
		$this->db = constant('DB');
		$this->port = constant('PORT');
		$this->charset = constant('CHARSET');
	}

	public function connect(){
		try{
			$connection = "mysql:host=" . $this->host . ";";
			if ($this->port != '') {
				$connection .= "port=" . $this->db . ";";
			}
			$connection .= "dbname=" . $this->db . ";";
			$connection .= "charset=" . $this->charset . ";";

			$options = [
				PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
				PDO::ATTR_EMULATE_PREPARES => false,
			];

			$pdo = new PDO($connection, $this->user, $this->password, $options);

			return $pdo;

		}catch(PDOException $e){
			print_r('Error connection' . $e->getMessage());
		}
	}
}
