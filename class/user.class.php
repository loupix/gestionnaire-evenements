<?php


class user{
	
	private $id=0;
	private $nom="";
	private $prenom="";
	private $adresse="";
	private $ville="";
	private $codePostal="";
	private $email="";
	private $telephone="";
	private $dateNaissance="";
	private $picture="";

	private $type="user";
	private $created;
	private $updated;

	public function fromPost($userArray){
		$this->setId($userArray['id']);
		$this->setNom($userArray['nom']);
		$this->setPrenom($userArray['prenom']);

		if(isset($userArray['adresse']['name']))
			$this->setAdresse($userArray['adresse']['name']);

		if(isset($userArray['adresse']['ville']))
			$this->setVille($userArray['adresse']['ville']);

		if(isset($userArray['adresse']['codePostal']))
			$this->setCodePostal($userArray['adresse']['codePostal']);

		$this->setEmail($userArray['email']);
		$this->setTelephone($userArray['telephone']);
		$this->setDateNaissance($userArray['dateNaissance']);

		$arr = array("orange","bleu","bleuclair","noir", "darkred","tomato","salmon","darkorange","darkgolden","darkkhaki","olivedrab","darkgreen","palegreen","turquoise","darkslategray","indigo","darkorchid");
		$picture = "image.php?text=".strtoupper(substr($this->getNom(), 0, 1))."&color=".$arr[array_rand($arr)];
		$this->setPicture($picture);

		return $this;
	}



	public function fromBdd($userArray){
		$this->setId($userArray['id']);
		$this->setNom($userArray['nom']);
		$this->setPrenom($userArray['prenom']);

		$this->setAdresse($userArray['adresse']);

		$this->setVille($userArray['ville']);

		$this->setCodePostal($userArray['codePostal']);

		$this->setEmail($userArray['email']);
		$this->setTelephone($userArray['telephone']);
		$this->setDateNaissance($userArray['dateNaissance']);
		$this->setPicture($userArray['picture']);

		$this->setCreated($userArray['created']);
		$this->setUpdated($userArray['updated']);

		return $this;
	}


	public function toData(){
		return array(
			"id"=>intval($this->getId()), 
			"nom"=>$this->getNom(), 
			"prenom"=>$this->getPrenom(), 
			"adresse"=>Array(
				"name"=>$this->getAdresse(), 
				"ville"=>$this->getVille(), 
				"codePostal"=>$this->getCodePostal()),
			"email"=>$this->getEmail(), 
			"telephone"=>$this->getTelephone(), 
			"dateNaissance"=>$this->getDateNaissance(),
			"age"=>$this->getAge(),
			"picture"=>$this->getPicture(),
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



	public function getNom(){
		return $this->nom;
	}

	public function setNom($nom){
		$this->nom = $nom;
		return true;
	}



	public function getPrenom(){
		return $this->prenom;
	}

	public function setPrenom($prenom){
		$this->prenom = $prenom;
		return true;
	}



	public function getAdresse(){
		return $this->adresse;
	}

	public function setAdresse($adresse){
		$this->adresse = $adresse;
		return true;
	}



	public function getVille(){
		return $this->ville;
	}

	public function setVille($ville){
		$this->ville = $ville;
		return true;
	}



	public function getCodePostal(){
		return $this->codePostal;
	}

	public function setCodePostal($codePostal){
		$this->codePostal = $codePostal;
		return true;
	}



	public function getEmail(){
		return $this->email;
	}

	public function setEmail($email){
		$this->email = $email;
		return true;
	}



	public function getTelephone(){
		return $this->telephone;
	}

	public function setTelephone($telephone){
		$this->telephone = $telephone;
		return true;
	}




	public function getType(){
		return $this->type;
	}

	public function setType($type){
		$this->type = $type;
		return true;
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




	public function getPicture(){
		return $this->picture;
	}

	public function setPicture($picture){
		$this->picture = $picture;
		return true;
	}






	public function getDateNaissance(){
		return $this->dateNaissance;
	}

	public function setDateNaissance($dateNaissance){
		$date = new DateTime($dateNaissance);
		$this->dateNaissance = $date->format('Y-m-d H:i:s');
		return true;
	}


	public function getAge(){
		$date = new DateTime($this->dateNaissance);
		$now = new DateTime();
		$interval = $now->diff($date);
		return $interval->y;
	}
}