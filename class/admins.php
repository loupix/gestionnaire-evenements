<?php

class admin extends user{
	// $this->setType("admin");

	static function isAdmin($user){
		if($user->getType()=="user")
			return false;
		else if($user->getType()=="admin")
			return true;
		return false;
	}
}

?>