<?php

class users extends user{
	

	private $connection;

	public function __construct($genConnection=true){
		if($genConnection){
			$bdd = new bdd();
			$this->connection = $bdd->getConnection();
		}

		$query = "CREATE TABLE IF NOT EXISTS users (id INT PRIMARY KEY NOT NULL auto_increment,
			nom VARCHAR(100),
			prenom VARCHAR(100),
			adresse VARCHAR(100),
			ville VARCHAR(50),
			codePostal VARCHAR(5),
			email VARCHAR(100),
			telephone VARCHAR(100),
			dateNaissance DATETIME,
			picture VARCHAR(300),
			type VARCHAR(20),
			created DATETIME DEFAULT CURRENT_TIMESTAMP,
			updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";

		if($rep = $this->connection->query($query))
			return $this;
		else
			return false;
	}



	private function isInBdd($user){
		$stmt = $this->connection->prepare("SELECT * FROM users WHERE nom=:nom AND prenom=:prenom AND email=:email LIMIT 1");
		$stmt->bindValue(":nom", $user->getNom());
		$stmt->bindValue(":prenom", $user->getPrenom());
		$stmt->bindValue(":email", $user->getEmail());

		if($rep = $stmt->execute()){
			if($stmt->fetchColumn() > 0)
				return true;
			else
				return false;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}


	private function getUser($user){

		$stmt = $this->connection->prepare("SELECT * FROM users WHERE nom=:nom AND prenom=:prenom LIMIT 1");
		$stmt->bindValue(":nom", $user->getNom());
		$stmt->bindValue(":prenom", $user->getPrenom());

		if($rep = $stmt->execute()){
			return $this->fromBdd($stmt->fetch());
		}else
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
			
	}




	public function addUser($user){
		$user->setType("user");

		if($this->isInBdd($user))
			return $this->modifUser($user);


		$stmt = $this->connection->prepare("INSERT INTO users (nom, prenom, adresse, ville, codePostal, email, telephone, dateNaissance, picture, type) 
			VALUES (:nom, :prenom, :adresse, :ville, :codePostal, :email, :telephone, :dateNaissance, :picture, :type)");

		$stmt->bindValue(":nom", $user->getNom());
		$stmt->bindValue(":prenom", $user->getPrenom());
		$stmt->bindValue(":adresse", $user->getAdresse());
		$stmt->bindValue(":ville", $user->getVille());
		$stmt->bindValue(":codePostal", $user->getCodePostal());
		$stmt->bindValue(":email", $user->getEmail());
		$stmt->bindValue(":telephone", $user->getTelephone());
		$stmt->bindValue(":dateNaissance", $user->getDateNaissance());
		$stmt->bindValue(":picture", $user->getPicture());
		$stmt->bindValue(":type", $user->getType());


		if($rep = $stmt->execute()){
			return $this->getUser($user);
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	

	}


	public function delUser($user){
		if(!$this->isInBdd($user))
			throw new Exception("Utilisateur non présent", 1);
			
		$stmt2 = $this->connection->prepare("DELETE FROM users WHERE id=:id AND nom=:nom AND prenom=:prenom");
		$stmt2->bindValue(":id", $user->getId());
		$stmt2->bindValue(":nom", $user->getNom());
		$stmt2->bindValue(":prenom", $user->getPrenom());

		$stmt = $this->connection->prepare("DELETE FROM events_users WHERE id_user=:idUser");
		$stmt->bindValue(":idUser", $user->getId());

		if($rep = $stmt->execute()){
			if($rep = $stmt2->execute())
				return true;
			else
				throw new Exception("Erreur SQL (".$stmt2->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}else
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);

	}


	public function modifUser($user){
		if(!$this->isInBdd($user))
			return $this->addUser($user);
		
		$userPrev = $this->getUser($user);

		$stmt = $this->connection->prepare("UPDATE users SET nom=:nom, 
				prenom=:prenom, adresse=:adresse, ville=:ville, codePostal=:codePostal, 
				email=:email, telephone=:telephone, dateNaissance=:dateNaissance, type=:type, picture=:picture WHERE id=:id");
		$stmt->bindValue(":nom", $user->getNom());
		$stmt->bindValue(":prenom", $user->getPrenom());
		$stmt->bindValue(":adresse", $user->getAdresse());
		$stmt->bindValue(":ville", $user->getVille());
		$stmt->bindValue(":codePostal", $user->getCodePostal());
		$stmt->bindValue(":email", $user->getEmail());
		$stmt->bindValue(":telephone", $user->getTelephone());
		$stmt->bindValue(":dateNaissance", $user->getDateNaissance());
		$stmt->bindValue(":type", $user->getType());
		$stmt->bindValue(":picture", $user->getPicture());
		$stmt->bindValue(":id", $userPrev->getId());


		if($rep = $stmt->execute()){
			return $this->getUser($user);
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}




	public function find($text){
		$query = "SELECT * FROM users WHERE nom LIKE :name OR prenom LIKE :name LIMIT 20";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":name", "%".$text."%");
		if($rep = $stmt->execute()){
			$users = array();
			while($row = $stmt->fetch()){
				$u = new user();
				$u->fromBdd($row);
				$users[] = $u->toData();
			}
			return $users;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}






	// All Users


	public function countAll(){
		$query = "SELECT COUNT(id) AS nb from users";
		$stmt = $this->connection->prepare($query);
		if($rep = $stmt->execute()){
			$d = $stmt->fetch();
			return $d['nb'];
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}



	public function getAll($min=0, $max=0){
		$query = "SELECT * from users";
		$stmt = $this->connection->prepare($query);
		if($rep = $stmt->execute()){
			$users = array();
			while($row = $stmt->fetch()){
				$u = new user();
				$u->fromBdd($row);
				$users[] = $u->toData();
			}
			return $users;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}
}

?>