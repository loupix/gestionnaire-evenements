<?php

class villes{
	

	private $connection;

	public function __construct($genConnection=true){
		if($genConnection){
			$bdd = new bdd();
			$this->connection = $bdd->getConnection();
		}
	}

	public function findByName($name){
		$query = "SELECT ville_nom, ville_nom_simple, ville_nom_reel, ville_slug, ville_nom_soundex, ville_code_postal FROM villes_france_free 
			WHERE ville_nom LIKE :name 
			OR ville_slug LIKE :name 
			OR ville_nom_simple LIKE :name 
			OR ville_nom_reel LIKE :name 
			OR ville_nom_soundex LIKE :nameSoundex
			LIMIT 10";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":name", $name."%");
		$stmt->bindValue(":nameSoundex", soundex($name));
		if($rep = $stmt->execute()){
			$villes = array();
			while($row = $stmt->fetch()){
				$v = array(
					"ville_slug"=>$row['ville_slug'],
					"ville_nom"=>$row['ville_nom'],
					"ville_nom_simple"=>$row['ville_nom_simple'],
					"ville_nom_reel"=>$row['ville_nom_reel'],
					"ville_code_postal"=>$row['ville_code_postal'],
				);
				$villes[] = $v;
			}
			return $villes;
		}else{
			print_r($stmt->errorInfo());
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}



	public function findByPostalCode($postalcode){
		if(strlen($postalcode)<=3)
			return array();

		$query = "SELECT ville_nom, ville_nom_simple, ville_nom_reel, ville_slug, ville_nom_soundex, ville_code_postal FROM villes_france_free WHERE ville_code_postal LIKE :codePostal LIMIT 10";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":codePostal", $postalcode."%");
		if($rep = $stmt->execute()){
			$villes = array();
			while($row = $stmt->fetch()){
				$v = array(
					"ville_slug"=>$row['ville_slug'],
					"ville_nom"=>$row['ville_nom'],
					"ville_nom_simple"=>$row['ville_nom_simple'],
					"ville_nom_reel"=>$row['ville_nom_reel'],
					"ville_code_postal"=>$row['ville_code_postal'],
				);
				$villes[] = $v;
			}
			return $villes;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}
}