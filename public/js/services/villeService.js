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