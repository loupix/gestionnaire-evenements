<?php

class events extends event{

	private $connection;

	public function __construct($genConnection=true){
		if($genConnection){
			$bdd = new bdd();
			$this->connection = $bdd->getConnection();
		}

		$query = "CREATE TABLE IF NOT EXISTS events (id INT PRIMARY KEY NOT NULL auto_increment,
			name VARCHAR(100),
			description TEXT,
			picture TEXT,
			dateEvent DATETIME,
			created DATETIME DEFAULT CURRENT_TIMESTAMP,
			updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";


		$query_join = "CREATE TABLE IF NOT EXISTS events_users (
			id_event INT NOT NULL,
			id_user INT NOT NULL,
			created DATETIME DEFAULT CURRENT_TIMESTAMP,
			updated DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
			FOREIGN KEY (id_user) REFERENCES users(id),
			FOREIGN KEY (id_event) REFERENCES events(id))";

		if($rep = $this->connection->query($query)){
			if($rep = $this->connection->query($query_join))
				return $this;
			else
				return false;
		}else
			return false;

	}




	private function getEvent($event){
		$stmt = $this->connection->prepare("SELECT * FROM events WHERE name=:name AND dateEvent=:dateEvent LIMIT 1");
		$stmt->bindValue(":name", $event->getName());
		$stmt->bindValue(":dateEvent", $event->getDateEvent());

		if($rep = $stmt->execute()){
			return $this->fromBdd($stmt->fetch());
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}





	private function isInBdd($event){
		$stmt = $this->connection->prepare("SELECT * FROM events WHERE name=:name AND dateEvent=:dateEvent LIMIT 1");
		$stmt->bindValue(":name", $event->getName());
		$stmt->bindValue(":dateEvent", $event->getDateEvent());

		if($rep = $stmt->execute()){
			if($stmt->fetchColumn() > 0)
				return true;
			else
				return false;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}




	public function addEvent($event){

		if($this->isInBdd($event))
			return $this->modifEvent($event);

		$query = "INSERT INTO events (name, description, picture, dateEvent) VALUES (:name, :description, :picture, :dateEvent)";

		$stmt = $this->connection->prepare($query);

		$stmt->bindValue(":name", $event->getName());
		$stmt->bindValue(":description", $event->getDescription());
		$stmt->bindValue(":picture", $event->getPicture());
		$stmt->bindValue(":dateEvent", $event->getDateEvent());


		if($rep = $stmt->execute()){
			return $this->getEvent($event);
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}



	public function delEvent($event){
		if(!$this->isInBdd($event))
			throw new Exception("Evenement non présent", 1);

		$stmt2 = $this->connection->prepare("DELETE FROM events WHERE id=:idEvent LIMIT 1");
		$stmt2->bindValue(":idEvent", $event->getId());

		$stmt = $this->connection->prepare("DELETE FROM events_users WHERE id_event=:idEvent");
		$stmt->bindValue(":idEvent", $event->getId());


		if($rep = $stmt->execute()){
			if($rep = $stmt2->execute())
				return true;
			else
				throw new Exception("Erreur SQL (".$stmt2->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}else
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		
	}



	public function modifEvent($event){
		if(!$this->isInBdd($event))
			return $this->addEvent($event);

		$eventPrev = $this->getEvent($event);

		$query = "UPDATE events SET name=:name, description=:description, picture=:picture, dateEvent=:dateEvent WHERE id=:id";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":name", $event->getName());
		$stmt->bindValue(":description", $event->getDescription());
		$stmt->bindValue(":picture", $event->getPicture());
		$stmt->bindValue(":dateEvent", $event->getDateEvent());
		$stmt->bindParam(":id", $eventPrev->getId());

		if($rep = $stmt->execute()){
			return $this->getEvent($event);
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}




	// divers fonctions

	public function find($text){
		$query = "SELECT * FROM events WHERE name LIKE :name OR description LIKE :name LIMIT 20";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":name", "%".$text."%");
		if($rep = $stmt->execute()){
			$events = array();
			while($row = $stmt->fetch()){
				$e = new event();
				$e->fromBdd($row);
				$events[] = $e->toData();
			}
			return $events;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}


	public function nbUser($event){
		$query = "SELECT COUNT(u.id) AS nb FROM users AS u
			LEFT OUTER JOIN events_users AS eu ON (u.id=eu.id_user) 
			LEFT OUTER JOIN events as e ON (e.id=eu.id_event) 
			WHERE e.id=:id_event";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":id_event", $event->getId());
		if($rep = $stmt->execute()){
			$res = $stmt->fetch();
			return $res['nb'];
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}



	// jointure BDD event & user



	public function getUsers($event){
		$query = "SELECT u.id, u.nom, u.prenom, u.picture, u.dateNaissance, u.adresse, u.codePostal, u.ville, u.email, u.telephone, u.type, u.created, u.updated FROM users AS u 
			LEFT OUTER JOIN events_users AS eu ON (u.id=eu.id_user) 
			LEFT OUTER JOIN events as e ON (e.id=eu.id_event) 
			WHERE e.id=:id_event";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":id_event", $event->getId());
		if($rep = $stmt->execute()){
			$users = array();
			while( $row = $stmt->fetch() ) {
				$user = new user();
				$user->fromBdd($row);
				$users[] = $user->toData();
			}
			return $users;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}







	private function userInEvent($event, $user){
		$stmt = $this->connection->prepare("SELECT * FROM events_users WHERE id_event=:id_event AND id_user=:id_user");
		$stmt->bindValue(":id_user", $user->getId());
		$stmt->bindValue(":id_event", $event->getId());

		if($rep = $stmt->execute()){
			if($stmt->fetchColumn() > 0)
				return true;
			else
				return false;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}




	public function addUsers($event, $user){

		if($this->userInEvent($event, $user))
			return false;

		$query = "INSERT INTO events_users (id_event, id_user) VALUES (:id_event, :id_user)";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":id_event", $event->getId());
		$stmt->bindValue(":id_user", $user->getId());

		if($rep = $stmt->execute()){
			return true;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}



	public function removeUser($event, $user){

		if(!$this->userInEvent($event, $user))
			return false;

		$query = "DELETE FROM events_users WHERE id_event=:id_event AND id_user=:id_user LIMIT 1";
		$stmt = $this->connection->prepare($query);
		$stmt->bindValue(":id_event", $event->getId());
		$stmt->bindValue(":id_user", $user->getId());

		if($rep = $stmt->execute()){
			return true;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}

	}







	public function getAll($min=0, $max=0){
		$query = "SELECT * from events";
		$stmt = $this->connection->prepare($query);
		if($rep = $stmt->execute()){
			$events = array();
			while($row = $stmt->fetch()){
				$e = new event();
				$e->fromBdd($row);
				$data = $e->toData();
				$data['nbUsers']=$this->nbUser($e);
				$events[] = $data;
			}
			return $events;
		}else{
			throw new Exception("Erreur SQL (".$stmt->errorInfo()[2].")  ".__CLASS__." ".__FUNCTION__);
		}
	}


}