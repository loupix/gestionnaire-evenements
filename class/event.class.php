<?php

class event{
	private $id;
	private $name;
	private $descripton;
	private $picture;
	private $dateEvent;
	private $personnes = array();

	private $created;
	private $updated;



	public function fromPost($eventData){
		$this->setId($eventData['id']);
		$this->setName($eventData['name']);
		$this->setDescription($eventData['description']);
		$this->setDateEvent($eventData['date']);

		$arr = array("orange","bleu","bleuclair","noir", "darkred","tomato","salmon","darkorange","darkgolden","darkkhaki","olivedrab","darkgreen","palegreen","turquoise","darkslategray","indigo","darkorchid");
		$picture = "image.php?text=".strtoupper(substr($this->getName(), 0, 1))."&color=".$arr[array_rand($arr)];
		$this->setPicture($picture);
		return $this;
	}



	public function fromBdd($eventData){
		$this->setId($eventData['id']);
		$this->setName($eventData['name']);
		$this->setDescription($eventData['description']);
		$this->setPicture($eventData['picture']);
		$this->setDateEvent($eventData['dateEvent']);
		$this->setCreated($eventData['created']);
		$this->setUpdated($eventData['updated']);
		return $this;
	}


	public function toData(){
		return array(
			"id"=>intval($this->getId()),
			"name"=>$this->getName(),
			"date"=>$this->getDateEvent(),
			"picture"=>$this->getPicture(),
			"description"=>$this->getDescription(),
			"created"=>$this->getCreated(),
			"updated"=>$this->getUpdated()
		);
	}



	public function getId(){
		return $this->id;
	}

	public function setId($id){
		$this->id = $id;
		return true;
	}




	public function getName(){
		return $this->name;
	}

	public function setName($name){
		$this->name = $name;
		return true;
	}




	public function getDescription(){
		return $this->description;
	}

	public function setDescription($description){
		$this->description = $description;
		return true;
	}




	public function getPicture(){
		return $this->picture;
	}

	public function setPicture($picture){
		$this->picture = $picture;
		return true;
	}





	public function getDateEvent(){
		return $this->dateEvent;
	}

	public function setDateEvent($dateEvent){
		$date = new DateTime($dateEvent);
		$this->dateEvent = $date->format('Y-m-d H:i:s');
		return true;
	}




	public function getPersonnes(){
		return $this->personnes;
	}

	public function setPersonnes($personnes){
		$this->personnes = $personnes;
		return true;
	}

	public function addUser($user){
		$this->personnes[] = $user;
	}




	public function getCreated(){
		return $this->created;
	}

	public function setCreated($created){
		$this->created = $created;
		return true;
	}




	public function getUpdated(){
		return $this->updated;
	}

	public function setUpdated($updated){
		$this->updated = $updated;
		return true;
	}

	
}