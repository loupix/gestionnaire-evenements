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