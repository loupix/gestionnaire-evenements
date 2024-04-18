<?php

class bdd{
	private $host;
	private $user;
	private $password;
	private $database;

	private $connection;

	public function __construct($file="./mysql.ini"){
		if(!file_exists($file))
			throw new Exception("Pas de fichier ".$file, 1);
			
		$ini_array = parse_ini_file($file, true);

		$host = $ini_array['mysql']['host'];
		$user = $ini_array['mysql']['user'];
		$password = $ini_array['mysql']['password'];
		$database = $ini_array['mysql']['database'];

		$this->connection = new PDO("mysql:host=".$host.";dbname=".$database, $user, $password, 
			array(PDO::ATTR_PERSISTENT => true)
		);
		// $this->connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	}


	public function getConnection(){
		return $this->connection;
	}
}