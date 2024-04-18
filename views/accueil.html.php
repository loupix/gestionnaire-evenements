<div ng-controller="accueilCtrl" flex ng-cloak>
	<div ng-show="$mdMedia('gt-sm')">
		<md-grid-list class="md-padding"
	        md-cols="4" md-gutter="1em" md-gutter-gt-sm="3em" md-row-height="1:1" >

	<!--         <md-grid-tile md-colspan="4" md-rowspan="1"></md-grid-tile>
	 -->        
	 		<md-grid-tile md-colspan="1" md-rowspan="1"></md-grid-tile>

	        <md-grid-tile class="blue" ng-click="go('/user')" style="cursor:pointer">
	        	<ng-md-icon size="128" icon="person_add"></ng-md-icon>
		      <md-grid-tile-footer>
		        <h3>Utilisateurs</h3>
		      </md-grid-tile-footer>
		    </md-grid-tile>


		    <md-grid-tile class="pink" ng-click="go('/event')" style="cursor:pointer">
		    	<ng-md-icon size="128" icon="event"></ng-md-icon>
		      <md-grid-tile-footer>
		        <h3>Events</h3>
		      </md-grid-tile-footer>
		    </md-grid-tile>

		    <md-grid-tile md-colspan="2" md-rowspan="1" ng-hide="$mdMedia('gt-sm')"></md-grid-tile>


		    <md-grid-tile class="purple" ng-click="go('/gestion')" style="cursor:pointer">
		    	<ng-md-icon size="128" icon="account_balance"></ng-md-icon>
		      <md-grid-tile-footer>
		        <h3>Gestion</h3>
		      </md-grid-tile-footer>
		    </md-grid-tile>

		</md-grid-list>
	</div>



	<div ng-hide="$mdMedia('gt-sm')">
		<md-grid-list class="md-padding"
	        md-cols="1" md-gutter="1em" md-gutter-gt-sm="3em" md-row-height="2:1">


	        <md-grid-tile class="blue" ng-click="go('/user')" style="cursor:pointer">
	        	<ng-md-icon size="128" icon="person_add"></ng-md-icon>
		      <md-grid-tile-footer>
		        <h3>Utilisateurs</h3>
		      </md-grid-tile-footer>
		    </md-grid-tile>


		    <md-grid-tile class="pink" ng-click="go('/event')" style="cursor:pointer">
		    	<ng-md-icon size="128" icon="event"></ng-md-icon>
		      <md-grid-tile-footer>
		        <h3>Events</h3>
		      </md-grid-tile-footer>
		    </md-grid-tile>


		    <md-grid-tile class="purple" ng-click="go('/gestion')" style="cursor:pointer">
		    	<ng-md-icon size="128" icon="account_balance"></ng-md-icon>
		      <md-grid-tile-footer>
		        <h3>Gestion</h3>
		      </md-grid-tile-footer>
		    </md-grid-tile>

		</md-grid-list>
	</div>



</div>