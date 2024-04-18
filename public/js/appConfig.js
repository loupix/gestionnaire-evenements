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

		$rootScope.next = $rootScope.next == "" ? "#/accueil" : $rootScope.next;
		$rootScope.current = $rootScope.current == "" ? "#/accueil" : $rootScope.current;

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


	$locationProvider.hashPrefix('');
	$locationProvider.html5Mode({
		enabled: false,
		requireBase: true
	});

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