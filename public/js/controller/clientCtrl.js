'use strict';

myApp.controller("accueilCtrl", ['$scope', '$rootScope','$timeout', 'toastr', function($scope, $location, $rootScope, toastr){


}]);








myApp.controller("userCtrl", ['$scope', '$rootScope', '$mdSidenav', 'userService', 'eventService', 'villeService','toastr', function($scope, $rootScope, $mdSidenav, $userService, $eventService, $villeService, toastr){
	

	var minDate = new Date();
	minDate.setFullYear(minDate.getFullYear()-18);
	$scope.dateNaissance = moment(minDate).format("DD MMM YYYY");

	$scope.user = {
		id:0,
		nom:"",
		prenom:"",
		adresse:{
			name:"",
			codePostal:57000,
			ville:"Metz"
		},
		email:"",
		telephone:"",
		dateNaissance:minDate
	};


	$scope.evenement = {
		id:0,
		name:"",
		description:"",
		picture:"",
		date:""
	};


	$scope.reloadUser = function(){
		$scope.user = {
			id:0,
			nom:"",
			prenom:"",
			adresse:{
				name:"",
				codePostal:57000,
				ville:"Metz"
			},
			email:"",
			telephone:"",
			dateNaissance:new Date()
		};
	};

	$scope.onChangeDate = function(oldValue, newValue){
		if(newValue !== undefined)
			$scope.user.dateNaissance = moment(newValue).format("YYYY-MM-DD");
	}



	$scope.saveUser = function(){
		if($scope.user.id!=0){
			$userService.update($scope.user).then(function(rep){
				if(rep.user.created==rep.user.updated)
					toastr.success("Utilisateur rajouté", "Succes");
				else
					toastr.success("Utilisateur modifié", "Succes");
				if(rep.user.age<18)
					toastr.warning(" Personne Mineur !", " * Attention * ")
				$scope.user = rep.user;
				$scope.dateNaissance = moment(rep.user.dateNaissance);
				$scope.addUser();
			}, function(err){
				toastr.error(err, 'Erreur interne');
			});
		}else{
			$userService.add($scope.user).then(function(rep){
				toastr.success("Utilisateur rajouté", "Succes");
				$scope.user = rep.user;
				$scope.dateNaissance = moment(rep.user.dateNaissance);
				$scope.addUser();
			}, function(err){
				toastr.error(err, 'Erreur interne');
			});
		}
		return false;

	};



	$scope.addUser = function(){
		if($scope.evenement.id==0){
			toastr.warning("Pas dévénement associé.", "Alerte");
			return false;
		}
		$eventService.addUser($scope.evenement, $scope.user).then(function(rep){
			if(rep.result)
				toastr.success("Utilisateur inscrit", "Succces")
			else
				toastr.warning("Utilisateur déjà nscrit", "Alerte")
		}, function(err){
			toastr.error(err, 'Erreur interne');
		});
		return false;
	}



	$scope.eventSearch = function(text){
		$scope.evenement.id=0;
		if(text=="" || text===undefined)
			return;
		return $eventService.find(text).then(function(rep){
			return rep.events;
		}, function(err){
			toastr.error(err, "Erreur interne");
		});
	}



	$scope.userSearch = function(text){
		if(text=="" || text===undefined)
			return;
		return $userService.find(text).then(function(rep){
			return rep.users;
		}, function(err){
			toastr.error(err, "Erreur interne");
		});
	}




	$scope.villeSearchByCP = function(code){
		if(code=="" || code===undefined)
			return;

		return $villeService.findBypostalCode(code).then(function(rep){
			return rep.villes;
		}, function(err){
			toastr.error(err, "Erreur interne");
		});
	}



	$scope.villeSearchByName = function(name){
		if(name=="" || name===undefined)
			return;

		return $villeService.findByName(name).then(function(rep){
			return rep.villes;
		}, function(err){
			toastr.error(err, "Erreur interne");
		});
	}



	$scope.selectedEvent = function(item){
		if(item!==undefined){
			$scope.searchEvent="";
			$scope.evenement = item;
		}
	}


	$scope.selectedUser = function(item){
		if(item!==undefined){
			$scope.user = item;
			$scope.dateNaissance = moment($scope.user.dateNaissance).format("DD MMM YYYY");
			$scope.searchPrenom = item.prenom
			$scope.searchName = item.nom
		}
	}


	$scope.selectedVille = function(item){
		if(item!==undefined){
			$scope.user.adresse.ville = item.ville_nom;
			$scope.user.adresse.codePostal = item.ville_code_postal;
		}
	}


	
}]);





























myApp.controller("eventCtrl", ['$scope','$rootScope','eventService', 'userService', 'toastr', function($scope, $rootScope, $eventService, $userService, toastr){
	
	var d = new Date();
	$scope.dateEvent = moment(d).format("DD MMM YYYY à HH:mm");

	$scope.evenement = {
		id:0,
		name:"",
		description:"",
		date:new Date()
	};


	$scope.users = new Array();


	$scope.onChangeDate = function(oldValue, newValue){
		if(newValue !== undefined)
			$scope.evenement.date = moment(newValue).format("YYYY-MM-DD HH:mm:ss");
	}

	$scope.saveEvent = function(){
		if($scope.evenement.id!=0){
			$eventService.update($scope.evenement).then(function(rep){
				$scope.evenement = rep.event;
				$scope.dateEvent = moment(rep.event.date).format("DD MMM YYYY à HH:mm");

				if(rep.event.created==rep.event.updated)
					toastr.success("Evenement rajouté", "Succes");
				else
					toastr.success("Evenement modifié", "Succes");
				$scope.loadUsers();
			}, function(err){
				toastr.error(err, 'Erreur interne');
			});
		}else{
			$eventService.add($scope.evenement).then(function(rep){
				$scope.evenement = rep.event;
				$scope.dateEvent = moment(rep.event.date).format("DD MMM YYYY à HH:mm");

				if(rep.event.created==rep.event.updated)
					toastr.success("Evenement rajouté", "Succes");
				else
					toastr.success("Evenement modifié", "Succes");

				$scope.loadUsers();
			}, function(err){
				toastr.error(err, 'Erreur interne');
			});
		}
	};



	$scope.loadUsers = function(){
		$eventService.getUsers($scope.evenement).then(function(rep){
			$scope.users = rep.users;
		}, function(err){
			toastr.error(err, 'Erreur interne');
		});
	}



	$scope.addUser = function(user){
		return $eventService.addUser($scope.evenement, user).then(function(rep){
			if(rep.result)
				toastr.success("Adhérent inscrit", "Succes");
			else
				toastr.warning("Adhérent non inscrit", "Alerte");
			return rep.result;
		}, function(err){
			toastr.error(err, 'Erreur interne');
			return false;
		});
	}



	$scope.delUser = function(user){
		return $eventService.delUser($scope.evenement, user).then(function(rep){
			if(rep.result){
				var idx = $scope.users.indexOf(user);
				$scope.users.splice(idx, 1);
				toastr.success("Adhérent désinscrit", "Succes");
			}else
				toastr.warning("Adhérent toujours inscrit", "Alerte");
			return rep.result;
		}, function(err){
			toastr.error(err, 'Erreur interne');
			return false;
		});
	}



	$scope.userSearch = function(text){
		if(text=="" || text===undefined)
			return;
		return $userService.find(text).then(function(rep){
			return rep.users;
		}, function(err){
			toastr.error(err, "Erreur interne");
		});
	}


	$scope.eventSearch = function(text){
		$scope.evenement.id=0;
		if(text=="" || text===undefined)
			return;
		return $eventService.find(text).then(function(rep){
			return rep.events;
		}, function(err){
			toastr.error(err, "Erreur interne");
		});
	}




	$scope.selectedUser = function(item){
		if(item!==undefined){
			$scope.searchUser="";
			if($scope.users.indexOf(item)!==-1)
				return;
			$scope.addUser(item).then(function(e){
				if(e)
					$scope.users.push(item);
			}, function(err){
				toastr.error(err, "Erreur interne");
			});
		}
	}


	$scope.selectedEvent = function(item){
		if(item!==undefined){
			$scope.evenement = item;
			$scope.dateEvent = moment($scope.evenement.date).format("DD MMM YYYY à HH:mm");
			$scope.loadUsers();
		}
	}
	
}]);




























myApp.controller("gestionCtrl", ['$q', '$scope','$rootScope','$timeout', '$mdDialog', 'eventService', 'userService', 'toastr', function($q, $scope, $rootScope, $timeout, $mdDialog, $eventService, $userService, toastr){

	$scope.users = new Array();
	$scope.usersPag = new Array();
	$scope.usersCsv = new Array();
	$scope.usersCsvUp = new Array();

	$scope.events = new Array();
	$scope.usersEvent = new Array();
	$scope.usersEventCsv = new Array();


	$scope.queryUser = {
		order: 'nom',
		limit: 10,
		page: 1
	};


	$scope.queryEvent = {
		order: 'name',
		limit: 10,
		page: 1
	};


	$scope.queryEventUsers = {
		order: 'nom',
		limit: 5,
		page: 1
	};

	$scope.queryUsersUpload = {
		order: 'nom',
		limit: 5,
		page: 1
	};


	$scope.pagUsers = function(){
		$scope.promise = $scope.users.get($scope.query, function(users){
			$scope.usersPag = users;
		}).$promise;
	}


	$scope.loadUsers = function(){
		return $userService.getAll().then(function(rep){
			$scope.users = rep.users;
			$scope.usersCsv = rep.users.map(function(u){
				var nouveau = "";
				if(u.created==u.updated)
					nouveau="oui";
				else
					nouveau="non";

				return {
					"Nom":u.nom,
					"Prenom":u.prenom,
					"Adresse":u.adresse.name,
					"Code postal":u.adresse.codePostal,
					"Ville":u.adresse.ville,
					"Date de naissance":moment(u.dateNaissance).format("YYYY-MM-DD"),
					"Email":u.email,
					"Telephone":u.telephone,
					"Date enregistrement":moment(u.created).format("dddd DD MMMM YYYY à HH:mm"),
					"Nouvelle adhérent":nouveau
				};
			});
			$scope.usersCsvHeader = ['Nom','Prenom','Adresse','Code postal','Ville','Date de naissance','Email','Telephone','Date enregistrement','Nouvelle adhérent'];

		}, function(err){
			toastr.error(err, "Erreur interne");
			return false;
		});
	}



	$scope.loadEvents = function(){
		return $eventService.getAll().then(function(rep){
			$scope.events = rep.events;
			$scope.eventsCsv = rep.events.map(function(e){
				return {
					"Nom":e.name,
					"Description":e.description,
					"Nombre adherents":e.nbUsers,
					"Date":moment(e.date).format("dddd DD MMMM YYYY à HH:mm"),
					"Date de création":moment(e.created).format("dddd DD MMMM YYYY à HH:mm")
				};
			});
			$scope.eventsCsvHeader = ["Nom","Description","Nombre adhérents","Date","Date de création"];
			return true;
		}, function(err){
			toastr.error(err, "Erreur interne");
			return false;
		});
	}




	$scope.delUser = function(user){
		return $userService.delete(user).then(function(rep){
			if(rep.result)
				$scope.loadUsers();
			return rep.result;
		}, function(err){
			toastr.error(err, "Erreur interne");
			return false;
		})
	}



	$scope.delEvent = function(event){
		return $eventService.delete(event).then(function(rep){
			if(rep.result)
				$scope.loadEvents();
			return rep.result;
		}, function(err){
			toastr.error(err, "Erreur interne");
			return false;
		})
	};



	$scope.getUsersEvent = function(event){
		return $eventService.getUsers(event).then(function(rep){

			$scope.usersEventCsv = rep.users.map(function(u){
				var nouveau = "";
				if(u.created==u.updated)
					nouveau="oui";
				else
					nouveau="non";

				return {
					"Nom":u.nom,
					"Prenom":u.prenom,
					"Adresse":u.adresse.name,
					"Code postal":u.adresse.codePostal,
					"Ville":u.adresse.ville,
					"Date de naissance":moment(u.dateNaissance).format("YYYY-MM-DD"),
					"Email":u.email,
					"Telephone":u.telephone,
					"Date enregistrement":moment(u.created).format("dddd DD MMMM YYYY à HH:mm"),
					"Nouvelle achérent":nouveau
				};
			});


			$scope.usersEvent = rep.users.map(function(u){
				u.nouveau = "";
				if(u.created==u.updated)
					u.nouveau="oui";
				else
					u.nouveau="non";
				return u;
			});

			$mdDialog.show({
				contentElement: '#usersEventDialog',
				parent: angular.element(document.body),
				title:"Adhérents à cet événement",
				clickOutsideToClose:true
			});
		}, function(err){
			toastr.error(err, "Erreur interne");
			return false;
		})
	}

	// Import CSV Users


	$scope.clickUpload=function(id){
		document.getElementById(id).click();
	}


	$scope.closeDialog = function(){
		$mdDialog.cancel();
	}


	$scope.loadFile = function($event){
		var files = event.target.files;
		var reader = new FileReader();
		reader.readAsText(files[0]);
		document.getElementById("resetInput").click();

		reader.onload = $scope.readFile;
		reader.onerror = $scope.readFileError;
	}

	$scope.readFileError = function(evt){
		if(evt.target.error.name == "NotReadableError")
			toastr.error("Impossible de lire le fichier","Erreur");
		else
			toastr.error("Erreur de lecture "+evt.target.error.name,"Erreur");
	}

	$scope.readFile = function(evt){
		var csv = evt.target.result;
		$scope.fileName="Fichier CSV";
		var allTextLines = csv.split(/\r\n|\n/);
		var lines = [];
		for (var i=0; i<allTextLines.length; i++) {
			var data = allTextLines[i].split(';');
			var tarr = [];
			for (var j=0; j<data.length; j++)
				tarr.push(data[j]);
			lines.push(tarr);
		}
		if(lines.length==0)
			toastr.warning("Fichier Vide", "Alerte");
		$scope.readLines(lines);
	}


	$scope.readLines = function(lines){
		$scope.usersCsvUp = lines.map(function(line){
			return {
				"nom":line[0],
				"prenom":line[1],
				"adresse":{
					"name":line[2],
					"codePostal":line[3],
					"ville":line[4]
				},
				"dateNaissance":line[5],
				"email":line[6],
				"telephone":line[7],
			};
		}).filter(function(u){
			return (u.nom!='Nom' && u.prenom!='Prenom' && u.nom!='' && u.prenom!='');
		});

		$mdDialog.show({
			contentElement: '#userCsvDialog',
			parent: angular.element(document.body),
			title:"Contenu du fichier",
			clickOutsideToClose:true
		});
	}


	$scope.saveNewUsers = function($event){
		var elt = angular.element($event.target);
		elt.html("... En cours ...");
		console.log($scope.usersCsvUp.length);
		$userService.addMulti($scope.usersCsvUp).then(function(rep){
			toastr.success(rep.users.length+" nouveaux adhérents", "Succes");
			$scope.closeDialog();
			$scope.loadUsers();
			elt.html("Transferer");
			return true;

		}, function(err){
			toastr.error(err, "Erreur interne");
			$scope.closeDialog();
			$scope.loadUsers();
			elt.html("Erreur : "+err);
			return false;
		})
	};









	// PURGE


	$scope.openValidPurgeEvents = function($event){
		$mdDialog.show({
			contentElement: '#validPurgeEvents',
			parent: angular.element(document.body),
			title:"Purge des évenements",
			clickOutsideToClose:true
		});
	}



	$scope.openValidPurgeUsers = function($event){
		$mdDialog.show({
			contentElement: '#validPurgeUsers',
			parent: angular.element(document.body),
			title:"Purge des évenements",
			clickOutsideToClose:true
		});
	}


	$scope.clearEvents = function($event){
		$eventService.trashDb().then(function(rep){
			if(rep.events.length!=0)
				toastr.warning("BDD non effacer", "Alerte");
			else
				toastr.success("BDD entierement effacer", "Succes");
			$scope.loadEvents();
			$scope.closeDialog();
		}, function(err){
			toastr.error(err, "Erreur interne");
			$scope.closeDialog();
		})
	}


	$scope.clearUsers = function($event){
		$userService.trashDb().then(function(rep){
			if(rep.users.length!=0)
				toastr.warning("BDD non effacer", "Alerte");
			else
				toastr.success("BDD entierement effacer", "Succes");
			$scope.loadUsers();
			$scope.closeDialog();
		}, function(err){
			toastr.error(err, "Erreur interne");
			$scope.closeDialog();
		})
	}

}]);