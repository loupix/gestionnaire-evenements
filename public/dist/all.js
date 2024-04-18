'use strict';



var myApp = angular.module("chateau404", ['ngAnimate', 'ngAria', 'toastr', 'ngResource', 'ngRoute', 'ngDialog', 'ngCookies', 'ngMaterial', 'ngMdIcons', 
	'moment-picker', 'md.data.table','angularMoment','ngSanitize', 'ngCsv',
	'user.services','event.services','ville.services']);


myApp.config(['$httpProvider', function($httpProvider) {
	$httpProvider.defaults.headers.common["X-Requested-With"] =  'XMLHttpRequest';
	$httpProvider.defaults.headers.common["Content-Type"] =  'application/json';

	if (!$httpProvider.defaults.headers.get)
        $httpProvider.defaults.headers.get = {};

	$httpProvider.defaults.headers.get['If-Modified-Since'] = '0';
	$httpProvider.defaults.headers.get['Cache-Control'] = 'no-cache';
    $httpProvider.defaults.headers.get['Pragma'] = 'no-cache';


}]);




myApp.config(function(toastrConfig) {
	angular.extend(toastrConfig, {
		allowHtml: false,
	    closeButton: true,
	    extendedTimeOut: 500,

		autoDismiss: true,
		containerId: 'toast-container',
		maxOpened: 0,    
		newestOnTop: true,
		positionClass: 'toast-top-right',
		preventDuplicates: false,
		preventOpenDuplicates: false,
		progressBar: true,
		target: 'body',
		templates: {
			toast: 'page/toastr/toast',
			progressbar: 'page/toastr/progressbar'
		}
	});
});



myApp.config(['$mdAriaProvider', function($mdAriaProvider) {
   // Globally disables all ARIA warnings.
   $mdAriaProvider.disableWarnings();
}]);



myApp.run(function($rootScope, $templateCache, $location, $document, $mdMedia){

	$rootScope.loading =  false;
	$rootScope.current =  false;
	$rootScope.next =  false;
	$rootScope.msie=false;
	$rootScope.$mdMedia = $mdMedia;


	$rootScope.$on("$locationChangeStart", function(event, next, current) {
		$rootScope.loading = true;
		var hostName = $location.protocol()+"://"+$location.host()+"/";

		$rootScope.next = next.replace(hostName, "");
		$rootScope.current = current.replace(hostName, "");

		$rootScope.next = $rootScope.next == "" ? "accueil" : $rootScope.next;
		$rootScope.current = $rootScope.current == "" ? "accueil" : $rootScope.current;


	});



	$rootScope.$on('$viewContentLoaded', function() {
		$templateCache.removeAll();
		$rootScope.loading = false;
	});


	$rootScope.go = function (path) {
		$location.path(path);
	};



	// Detection IE
    var ua = navigator.userAgent;
    var is_ie = ua.indexOf("MSIE ") > -1 || ua.indexOf("Trident/") > -1;
    if(is_ie)
    	$rootScope.msie=true;

});


myApp.config(function($routeProvider, $locationProvider) {
	$routeProvider
		.when("/accueil", {
			templateUrl:"/page/accueil",
			controller:"accueilCtrl",
			cache: true
		})
		.when("/user", {
			templateUrl:"/page/user",
			controller:"userCtrl",
			cache: true
		})
		.when("/event", {
			templateUrl:"/page/event",
			controller:"eventCtrl",
			cache: true
		})
		.when("/gestion", {
			templateUrl:"/page/gestion",
			controller:"gestionCtrl",
			cache: true
		})
		.otherwise({
			redirectTo: "/accueil"
		});


	$locationProvider
		.html5Mode(true)
		.hashPrefix('!');

});



myApp.config(function($mdThemingProvider) {

	$mdThemingProvider.theme('docs-dark', 'default')
	  .primaryPalette('yellow')
	  .dark();

});





myApp.directive('fileReader', function() {
  return {
    scope: {
      fileReader:"="
    },
    link: function(scope, element) {
      $(element).on('change', function(changeEvent) {
        var files = changeEvent.target.files;
        if (files.length) {
          var r = new FileReader();
          r.onload = function(e) {
              var contents = e.target.result;
              scope.$apply(function () {
                scope.fileReader = contents;
                scope.testing = contents;
              });
          };
          
          r.readAsText(files[0]);
        }
      });
    }
  };
});
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




























myApp.controller("gestionCtrl", ['$q', '$scope','$rootScope','$mdDialog', 'eventService', 'userService', 'toastr', function($q, $scope, $rootScope, $mdDialog, $eventService, $userService, toastr){

	$scope.users = new Array();
	$scope.usersCsv = new Array();
	$scope.usersCsvUp = new Array();

	$scope.events = new Array();
	$scope.usersEvent = new Array();
	$scope.usersEventCsv = new Array();


	$scope.query = {
		order: 'nom',
		limit: 15,
		page: 1
	};



	$scope.loadUsers = function(){
		return $userService.getAll().then(function(rep){
			$scope.users = rep.users;
			$scope.usersCsv = rep.users.map(function(u){
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
				};
			});
			$scope.usersCsvHeader = ['Nom','Prenom','Adresse','Code postal','Ville','Date de naissance','Email','Telephone','Date enregistrement'];

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
				};
			});


			$scope.usersEvent = rep.users;
			$mdDialog.show({
				contentElement: '#usersEventDialog',
				parent: angular.element(document.body),
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
			clickOutsideToClose:true
		});
	}


	$scope.saveNewUsers = function($event){
		var elt = $event.target;
		elt.value = "En cours ..";
		var proms = $scope.usersCsvUp.map(function(user){
			return $userService.add(user);
		});
		return $q.all(proms).then(function(users){

			elt.value = "Transferer";

			var nbNew = users.filter(function(u){
				return u.user.created === u.user.updated;
			}).length;

			if(nbNew==0)
				nbNew="Aucuns";

			toastr.success(nbNew+" nouveaux adhérents", "Succes");
			$scope.loadUsers();
			$scope.closeDialog();
			
			return true;
		}, function(err){
			elt.value = "Transferer";
			toastr.error(err, "Erreur interne");
			$scope.loadUsers();
			$scope.closeDialog();
			return false;
		});

	}


}]);
'use strict';

angular.module('event.services', [])
	.service("eventService", ['$q', '$http', function($q, $http){

		return{
			get:function(event){
				return $http.post("/api/event/get", {event:event}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},


			add:function(event){
				return $http.post("/api/event/add", {event:event}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},

			delete:function(event){
				return $http.post("/api/event/delete", {event:event}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},

			update:function(event){
				return $http.post("/api/event/update", {event:event}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},


			find:function(text){
				return $http.post("/api/event/find", {text:text}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},


			nombre:function(event){
				return $http.post("/api/event/nombre", {event:event}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},


			addUser:function(event, user){
				return $http.post("/api/event/addUser", {event:event, user:user}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},



			delUser:function(event, user){
				return $http.post("/api/event/delUser", {event:event, user:user}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},



			getUsers:function(event){
				return $http.post("/api/event/users", {event:event}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},



			getAll:function(){
				return $http.get("/api/event/getAll").then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			}

		}
}]);
'use strict';

angular.module('user.services', [])
	.service("userService", ['$q', '$http', function($q, $http){

		return{
			get:function(user){
				return $http.post("/api/user/get", {user:user}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},


			find:function(text){
				return $http.post("/api/user/find", {text:text}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},

			add:function(user){
				return $http.post("/api/user/add", {user:user}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},

			delete:function(user){
				return $http.post("/api/user/delete", {user:user}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},

			update:function(user){
				return $http.post("/api/user/update", {user:user}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},



			getAll:function(){
				return $http.get("/api/user/getAll").then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			}

		}
}]);
'use strict';


/// Pas utilisé !!!!

angular.module('ville.services', [])
	.service("villeService", ['$q', '$http', function($q, $http){

		return{
			findByName:function(name){
				return $http.post("/api/ville/findByName", {name:name}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			},


			findBypostalCode:function(codePostal){
				return $http.post("/api/ville/findByCodePostal", {codePostal:codePostal}).then(function(response){
					if(response.data.error)
						return $q.reject(response.data.error);
					return $q.when(response.data);
				}, function(err){
					if(err.status==404)
						return $q.reject("non trouvé");
					return $q.reject("Status "+err.status+" - "+err.statusText);
				})
			}
		}
}]);