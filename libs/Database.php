<?php

/**
 * 
 */
class Database {

	private $host;
	private $user;
	private $db;
	private $password;
	private $charset;

	function __construct(){
		$this->host = constant('HOST');
		$this->user = constant('USER');
		$this->password = constant('PASSWORD');
		$this->db = constant('DB');
		$this->charset = constant('CHARSET');
	}

	public function connect(){
		try{
			$connection = "mysql:host=" . $this->host . ";";
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