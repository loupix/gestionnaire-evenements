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