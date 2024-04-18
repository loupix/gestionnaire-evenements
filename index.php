<?php 

function ob_html_compress($buf){
    return str_replace(array("\n","\r","\t"),'',$buf);
}

ob_start();
session_start(); 
// Vas  nous servir de routeur


require_once "class/bdd.php";
require_once "class/villes.php";
require_once "class/user.class.php";
require_once "class/event.class.php";
require_once "class/users.php";
require_once "class/events.php";
require_once "class/admins.php";

try{

	// Session User ; a voir plus tard ???


	if(isset($_SESSION['me'])){
		$me = $_SESSION['me'];
	}else{
		$me = new user();
		$_SESSION['me'] = $me;
	}

	// Gestion des pages


	if(isset($_GET['type']) && isset($_GET['page']) && $_GET['type']=="page"){
		try {
			include("views/".$_GET['page'].".html.php");
		} catch (Exception $e) {
			echo json_encode(array("error"=>$e->getMessage()));
		}



	// Gestion API


	}else if(isset($_GET['type']) && isset($_GET['class']) && isset($_GET['method']) && $_GET['type']=="api"){
		try {
			if(isset($_GET['class']) && $_GET['class'] =="user"){
				$user = new user();
				$users = new users();


				// Add User




				if(isset($_GET['method']) && $_GET['method'] =="add"){

					$postdata = file_get_contents("php://input");
					$request = json_decode($postdata, 1);
					$user->fromPost($request['user']);

					try{
						if($u = $users->addUser($user)){
							echo json_encode(array("user"=>$u->toData()));
						}else{
							echo json_encode(array("error"=>"impossible de rajouter cet personne"));
						}
					} catch(Exception $e) {
						echo json_encode(array("error"=>$e->getMessage()));
					}



				// Update User



				}else if(isset($_GET['method']) && $_GET['method'] =="update"){

					$postdata = file_get_contents("php://input");
					$request = json_decode($postdata, 1);
					$user->fromPost($request['user']);

					try{
						if($u = $users->modifUser($user)){
							echo json_encode(array("user"=>$u->toData()));
						}else{
							echo json_encode(array("error"=>"impossible de modifier cet personne"));
						}
					} catch(Exception $e) {
						echo json_encode(array("error"=>$e->getMessage()));
					}




				// Delete User



				}else if(isset($_GET['method']) && $_GET['method'] =="delete"){

					$postdata = file_get_contents("php://input");
					$request = json_decode($postdata, 1);
					$user->fromPost($request['user']);

					try{
						if($u = $users->delUser($user)){
							echo json_encode(array("result"=>$u));
						}else{
							echo json_encode(array("error"=>"impossible de supprimer cet personne"));
						}
					} catch(Exception $e) {
						echo json_encode(array("error"=>$e->getMessage()));
					}




				// Find User



				}else if(isset($_GET['method']) && $_GET['method'] =="find"){

						$postdata = file_get_contents("php://input");
						$request = json_decode($postdata, 1);
						$text = $request['text'];

						try{
							$users = $users->find($text);
							echo json_encode(array("users"=>$users));
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}

				}else if(isset($_GET['method']) && $_GET['method'] =="getAll"){

					try{
							$users = $users->getAll();
							echo json_encode(array("users"=>$users));
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}

				}else{
					echo json_encode(array("error"=>"methode inconnus"));
				}



			}else if(isset($_GET['class']) && $_GET['class'] =="event"){

				$event = new event();
				$user = new user();
				$events = new events();


				// Add Event



				if(isset($_GET['method']) && $_GET['method'] =="add"){

					$postdata = file_get_contents("php://input");
					$request = json_decode($postdata, 1);
					$event->fromPost($request['event']);

					try{
						if($e = $events->addEvent($event)){
							echo json_encode(array("event"=>$e->toData()));
						}else{
							echo json_encode(array("error"=>"impossible de rajouter cet événement"));
						}
					} catch(Exception $e) {
						echo json_encode(array("error"=>$e->getMessage()));
					}




				// Update Event



				}else if(isset($_GET['method']) && $_GET['method'] =="update"){

						$postdata = file_get_contents("php://input");
						$request = json_decode($postdata, 1);
						$event->fromPost($request['event']);

						try{
							if($e = $events->modifEvent($event)){
								echo json_encode(array("event"=>$e->toData()));
							}else{
								echo json_encode(array("error"=>"impossible de modifier cet événement"));
							}
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}




				// Delete Event



				}else if(isset($_GET['method']) && $_GET['method'] =="delete"){

						$postdata = file_get_contents("php://input");
						$request = json_decode($postdata, 1);
						$event->fromPost($request['event']);

						try{
							if($e = $events->delEvent($event)){
								echo json_encode(array("result"=>$e));
							}else{
								echo json_encode(array("error"=>"impossible de supprimer cet événement"));
							}
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}




				// Find Event



				}else if(isset($_GET['method']) && $_GET['method'] =="find"){

						$postdata = file_get_contents("php://input");
						$request = json_decode($postdata, 1);
						$text = $request['text'];

						try{
							$events = $events->find($text);
							echo json_encode(array("events"=>$events));
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}




				// Add Users Event


				}else if(isset($_GET['method']) && $_GET['method'] =="addUser"){

						$postdata = file_get_contents("php://input");
						$request = json_decode($postdata, 1);
						$user->fromPost($request['user']);
						$event->fromPost($request['event']);

						try{
							$result = $events->addUsers($event, $user);
							echo json_encode(array("result"=>$result));
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}




				// Remove Users Event


				}else if(isset($_GET['method']) && $_GET['method'] =="delUser"){

						$postdata = file_get_contents("php://input");
						$request = json_decode($postdata, 1);
						$user->fromPost($request['user']);
						$event->fromPost($request['event']);

						try{
							$result = $events->removeUser($event, $user);
							echo json_encode(array("result"=>$result));
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}




				// Get Users Event


				}else if(isset($_GET['method']) && $_GET['method'] =="users"){

						$postdata = file_get_contents("php://input");
						$request = json_decode($postdata, 1);
						$event->fromPost($request['event']);

						try{
							$users = $events->getUsers($event);
							echo json_encode(array("users"=>$users));
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}



				}else if(isset($_GET['method']) && $_GET['method'] =="getAll"){

					try{
							$events = $events->getAll();
							echo json_encode(array("events"=>$events));
						} catch(Exception $e) {
							echo json_encode(array("error"=>$e->getMessage()));
						}




				}else{
					echo json_encode(array("error"=>"methode inconnus"));
				}


			}else if(isset($_GET['class']) && $_GET['class'] =="ville"){
				$villeObj = new villes();

				if(isset($_GET['method']) && $_GET['method'] =="findByCodePostal"){

					$postdata = file_get_contents("php://input");
					$request = json_decode($postdata, 1);
					$codePostal = $request['codePostal'];

					try{
						$villes = $villeObj->findByPostalCode($codePostal);
						echo json_encode(array("villes"=>$villes));
					} catch(Exception $e) {
						echo json_encode(array("error"=>$e->getMessage()));
					}

				}else if(isset($_GET['method']) && $_GET['method'] =="findByName"){

					$postdata = file_get_contents("php://input");
					$request = json_decode($postdata, 1);
					$name = $request['name'];

					try{
						$villes = $villeObj->findByName($name);
						echo json_encode(array("villes"=>$villes));
					} catch(Exception $e) {
						echo json_encode(array("error"=>$e->getMessage()));
					}

				}else{
					echo json_encode(array("error"=>"methode inconnus"));
				}



			}else{
				echo json_encode(array("error"=>"methode inconnus"));
			}





		// Gestion des Erreurs Globaux

			
		} catch (Exception $e) {
			echo json_encode(array("error"=>$e->getMessage()));
		}
	}else{
		include("views/layout.html.php");
	}
} catch (Exception $e) {
	echo json_encode(array("error"=>$e->getMessage()));
}

ob_end_flush();
?>
