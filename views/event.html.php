<div>
	<section layout="row" layout-wrap>
		<md-sidenav
			flex
	        class="md-sidenav-left"
	        md-component-id="left"
	        md-is-locked-open="$mdMedia('gt-md')">
		    <md-toolbar class="md-hue-2">
		    	<h1 class="md-toolbar-tools">Liste des inscrits</h1>
		    </md-toolbar>
		    <md-content layout-padding>
		    	<md-autocomplete flex required 
		    		id="custom-template-user"
		    		md-input-name="autocompleteUser"
		    		md-input-maxlength="6"
		    		md-no-cache="false"

		    		md-floating-label="Ajouter un adhérent"

		    		md-selected-item-change="selectedUser(item)"
		    		md-search-text="searchUser"
		    		md-items="item in userSearch(searchUser)"
		    		md-item-text="item.nom"

		    		md-require-match="true"

		    		md-menu-class="autocomplete-custom-template"
		    		md-menu-container-class="custom-container">
		    		<md-item-template>
		    			<span class="item-title">
		    				<md-button class="md-icon-button logo">
		    					<img ng-src="{{ item.picture }}" class="logo-image">
		    				</md-button>
		    				<span>{{ item.nom}} {{ item.prenom }}</span>
		    			</span>	
		    			<span class="item-metadata">
		    				<span>{{ item.codePostal }}<strong>{{ item.ville }}</strong></span>
		    			</span>
		    		</md-item-template>
		    	</md-autocomplete>

		    	
	    		<md-list class="md-dense" ng-hide="users.length==0" flex>
	    			<md-subheader class="md-no-sticky">{{ users.length }} Adhérents</md-subheader>
	    			<md-list-item class="md-3-line" ng-repeat="user in users">
	    				<img ng-src="{{ user.picture }}" class="md-avatar" alt="{{user.prenom}}" />
	    				<div class="md-list-item-text" layout="column">
	    					<h3>{{ user.nom }} {{ user.prenom }}</h3>
	    					<h4>{{ user.age }} ans</h4>
	    					<p>{{ user.adresse.codePostal }} {{ user.adresse.ville }}</p>
	    				</div>
	    				<ng-md-icon size="16" icon="clear" ng-click="delUser(user)" style="cursor:pointer"></ng-md-icon>
	    				<md-divider ></md-divider>
	    			</md-list-item>
	    		</md-list>

	    		<strong ng-show="users.length==0">Aucuns adhérents.</strong>

		</md-sidenav>


		



		<div flex-gt-md="75" flex="100">
			<md-content layout-padding>
				<div>
					<form name="eventForm" ng-submit="saveEvent()">

						<div layout-gt-md="row" layout="column"	>
							<md-autocomplete flex required 
					    		id="custom-template-name"
					    		md-input-name="autocompleteName"
					    		md-input-maxlength="6"
					    		md-no-cache="false"

					    		md-floating-label="Nom"

					    		md-selected-item-change="selectedEvent(item)"
					    		md-search-text="searchEvent"
					    		md-items="item in eventSearch(searchEvent)"
					    		md-item-text="item.name"

					    		md-search-text-change="evenement.name=searchEvent"
					    		md-require-match="true"

					    		md-menu-class="autocomplete-custom-template"
					    		md-menu-container-class="custom-container">
					    		<md-item-template>
					    			<span class="item-title">
					    				<md-button class="md-icon-button logo">
					    					<img ng-src="{{ item.picture }}" class="logo-image">
					    				</md-button>
					    				<span>{{ item.name}}</span>
					    			</span>	
					    			<span class="item-metadata">
					    				<span>{{ item.date | amDateFormat:'dddd DD MMM YYYY à HH:mm'  }}</span>
					    			</span>
					    		</md-item-template>
					    	</md-autocomplete>

							<md-input-container moment-picker="dateEvent" 
								format="DD MMM YYYY à HH:mm" 
								locale="fr"
								change="onChangeDate(oldValue, newValue)"
								class="md-block" flex-gt-md>
								<label>Date & Heure</label>
								<input name="dateEvent" ng-model="dateEvent" required>
							</md-input-container>
						</div>

						<md-input-container class="md-block" flex-gt-md>
							<label>Description</label>
							<textarea name="description" ng-model="evenement.description" required></textarea>
						</md-input-container>
						<md-button class="md-warn material-cust-large-button" type="reset">&nbsp;&nbsp;Effacer&nbsp;&nbsp;</md-button>
						<md-button class="md-raised md-primary material-cust-large-button" type="submit">Enregistrer</md-button>
					</form>
				</div>
			</md-content>
		</div>



		<md-content md-theme="docs-dark" flex layout-padding ng-hide="$mdMedia('gt-md')">
			<div>
				<md-autocomplete flex required 
		    		id="custom-template-user"
		    		md-input-name="autocompleteUser2"
		    		md-input-maxlength="6"
		    		md-no-cache="false"

		    		md-floating-label="Ajouter un adhérent"

		    		md-selected-item-change="selectedUser(item)"
		    		md-search-text="searchUser2"
		    		md-items="item in userSearch(searchUser2)"
		    		md-item-text="item.nom"

		    		md-require-match="true"

		    		md-menu-class="autocomplete-custom-template"
		    		md-menu-container-class="custom-container">
		    		<md-item-template>
		    			<span class="item-title">
		    				<md-button class="md-icon-button logo">
		    					<img ng-src="{{ item.picture }}" class="logo-image">
		    				</md-button>
		    				<span>{{ item.nom}} {{ item.prenom }}</span>
		    			</span>	
		    			<span class="item-metadata">
		    				<span>{{ item.codePostal }}<strong>{{ item.ville }}</strong></span>
		    			</span>
		    		</md-item-template>
		    	</md-autocomplete>


		    	<md-list class="md-dense" ng-hide="users.length==0" flex>
	    			<md-subheader class="md-no-sticky">{{ users.length }} Adhérents</md-subheader>
	    			<md-list-item class="md-3-line" ng-repeat="user in users">
	    				<img ng-src="{{ user.picture }}" class="md-avatar" alt="{{user.prenom}}" />
	    				<div class="md-list-item-text" layout="column">
	    					<h3>{{ user.nom }} {{ user.prenom }}</h3>
	    					<h4>{{ user.age }} ans</h4>
	    					<p>{{ user.adresse.codePostal }} {{ user.adresse.ville }}</p>
	    				</div>
	    				<ng-md-icon size="16" icon="clear" ng-click="delUser(user)" style="cursor:pointer"></ng-md-icon>
	    				<md-divider ></md-divider>
	    			</md-list-item>
	    		</md-list>

	    		<strong ng-show="users.length==0">Aucuns adhérents.</strong>
	    	</div>
	    </md-content>



	</section>
</div>
