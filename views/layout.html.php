<!DOCTYPE html>
<html>
<head>
	<base href="/">
	<meta name="author" content="loic.daniel" />

	<title>Gestion clientelle - Chateau 404</title>
	<meta name="description" content="Suivez toutes les inscriptions aux événements de votre association" />

	<meta property="og:type" content="website" />
	<meta property="og:title" content="Gestion clientelle - Chateau 404" />
	<meta property="og:description" content="Suivez toutes les inscriptions aux événements de votre association" />
	<meta property="og:image" content="/public/img/website.png" />
	<meta property="og:url" content="https://gestion.loicdaniel.fr" />
	<meta property="og:locale" content="fr_FR" />
	<meta property="og:site_name" content="loicdaniel.fr" />

	<meta name="twitter:card" content="website" />
	<meta name="twitter:title" content="Gestion clientelle - Chateau 404" />
	<meta name="twitter:description" content="Suivez toutes les inscriptions aux événements de votre association" />
	<meta name="twitter:site" content="loicdaniel.fr" />
	<meta name="twitter:creator" content="@loic5488" />
	<meta name="twitter:creator:id" content="465672416" />

	<meta property="profile:first_name" content="loic" />
	<meta property="profile:last_name" content="daniel" />
	<meta property="profile:username" content="loic.daniel" />
	<meta property="profile:gender" content="male" />

	<link rel="icon" href="public/icons/favicon.png">
	<link rel="stylesheet" type="text/css" href="public/css/style.css">
	<!--
	<link rel="stylesheet" type="text/css" href="bower_components/ng-dialog/css/ngDialog.min.css">
	<link rel="stylesheet" type="text/css" href="bower_components/ng-dialog/css/ngDialog-theme-default.min.css">
	<link rel="stylesheet" type="text/css" href="bower_components/angular-material/angular-material.min.css">
	<link rel="stylesheet" href="bower_components/angular-material-icons/angular-material-icons.min.css">
	<link rel="stylesheet" type="text/css" href="bower_components/angular-toastr/dist/angular-toastr.min.css">
	<link rel="stylesheet" type="text/css" href="bower_components/angular-moment-picker/dist/angular-moment-picker.min.css">
	<link rel="stylesheet" type="text/css" href="bower_components/angular-material-data-table/dist/md-data-table.min.css">


	<script type="text/javascript" src="bower_components/angular/angular.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-animate/angular-animate.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-aria/angular-aria.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-resource/angular-resource.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-route/angular-route.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-touch/angular-touch.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-cookies/angular-cookies.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-messages/angular-messages.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-sanitize/angular-sanitize.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-material/angular-material.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-material-icons/angular-material-icons.min.js"></script>
	<script type="text/javascript" src="bower_components/svg-morpheus/compile/minified/svg-morpheus.js"></script>
	<script type="text/javascript" src="bower_components/ng-dialog/js/ngDialog.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-toastr/dist/angular-toastr.tpls.js"></script>
	<script type="text/javascript" src="bower_components/moment/moment.js"></script>
	<script type="text/javascript" src="bower_components/moment/min/moment-with-locales.js"></script>
	<script type="text/javascript" src="bower_components/moment/locale/fr.js"></script>
	<script type="text/javascript" src="bower_components/angular-moment/angular-moment.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-moment-picker/dist/angular-moment-picker.min.js"></script>
	<script type="text/javascript" src="bower_components/angular-material-data-table/dist/md-data-table.min.js"></script>
	<script type="text/javascript" src="bower_components/ng-csv/build/ng-csv.min.js"></script>

	<script type="text/javascript" src="public/dtis/all.min.js"></script>
	-->


	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ng-dialog/1.4.0/css/ngDialog.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/ng-dialog/1.4.0/css/ngDialog-theme-default.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.1.14/angular-material.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/angular-toastr/2.1.1/angular-toastr.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/angular-moment-picker/0.10.2/angular-moment-picker.min.css">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/angular-material-data-table/0.10.10/md-data-table.min.css">

	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-animate.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-aria.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-resource.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-route.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-touch.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-cookies.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-messages.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular.js/1.7.8/angular-sanitize.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-material/1.1.14/angular-material.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-material-icons/0.7.1/angular-material-icons.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/SVG-Morpheus/0.3.2/svg-morpheus.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ng-dialog/1.4.0/js/ngDialog.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-toastr/2.1.1/angular-toastr.tpls.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/fr.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-moment/1.3.0/angular-moment.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-moment-picker/0.10.2/angular-moment-picker.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/angular-material-data-table/0.10.10/md-data-table.min.js"></script>	
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/ng-csv/0.3.6/ng-csv.min.js"></script>	


	<script type="text/javascript" src="public/js/appConfig.js"></script>
	<script type="text/javascript" src="public/js/controller/clientCtrl.js"></script>
	<script type="text/javascript" src="public/js/services/userService.js"></script>
	<script type="text/javascript" src="public/js/services/eventService.js"></script>
	<script type="text/javascript" src="public/js/services/villeService.js"></script>
</head>
<body ng-app="chateau404" bgcolor="#E6E6FA">
	<md-toolbar class="md-hue-2">
		<div class="md-toolbar-tools">
			<h2 flex md-truncate>Gestion des adhérents - Chateau 404</h2>

			<md-button class="md-icon-button" aria-label="Home" ng-click="go('/accueil')">
				<ng-md-icon size="28" icon="home" ng-style="{'fill':(next=='#/accueil') ? 'white' : ''}"></ng-md-icon>
			</md-button>
			
			<md-button class="md-icon-button" aria-label="Users" ng-click="go('/user')">
				<ng-md-icon size="28" icon="person_add" ng-style="{'fill':(next=='#/user') ? 'white' : ''}"></ng-md-icon>
			</md-button>

			<md-button class="md-icon-button" aria-label="Events" ng-click="go('/event')">
				<ng-md-icon size="28" icon="event" ng-style="{'fill':(next=='#/event') ? 'white' : ''}"></ng-md-icon>
			</md-button>

			<md-button class="md-icon-button" aria-label="Gestion" ng-click="go('/gestion')">
				<ng-md-icon size="28" icon="account_balance" ng-style="{'fill':(next=='#/gestion') ? 'white' : ''}"></ng-md-icon>
			</md-button>

		</div>
	</md-toolbar>

	<section ng-hide="!loading" layout="row" layout-sm="column" layout-align="center center" layout-wrap>
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<br /><br /><br /><br /><br /><br /><br /><br /><br /><br /><br />
		<div><img src="public/img/loader.gif" width="100%" height="100%" /></div>
	</section>
	<ng-view ng-hide="loading || msie" />
</body>


</html>