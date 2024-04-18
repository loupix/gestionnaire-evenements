<div>
	<section layout="row" layout-wrap>
		<md-sidenav
			flex
	        class="md-sidenav-left"
	        md-component-id="left"
	        md-is-locked-open="$mdMedia('gt-md')">
		    <md-toolbar class="md-hue-2">
		    	<h1 class="md-toolbar-tools">Inscription Event</h1>
		    </md-toolbar>
		    <md-content>
		    	<md-autocomplete flex required
		    		id="custom-template"

		    		md-input-name="autocompleteEvent"
		    		md-input-maxlength="6"
		    		md-no-cache="false"

		    		md-floating-label="Rechercher un événement"
		    		placeholder="Ex. Soirée .."

		    		md-selected-item-change="selectedEvent(item)"
		    		md-search-text="searchEvent"
		    		md-items="item in eventSearch(searchEvent)"
		    		md-item-text="item.name"


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
		    				<span><strong>{{ item.date }}</strong></span>
		    			</span>
		    		</md-item-template>
		    	</md-autocomplete>

		    	<strong ng-show="evenement.id==0">Aucuns événements associés.</strong>
		    	<md-card ng-hide="evenement.id==0" md-theme="default" md-theme-watch>
		    		<md-card-title>
		    			<md-card-title-text>
		    				<span class="md-headline">{{ evenement.name }}</span>
		    				<span class="md-subhead">{{ evenement.date | amDateFormat:'ddd DD MMM YYYY à HH:mm' }}</span>
		    			</md-card-title-text>
		    			<md-card-title-media>
		    				<img ng-src="{{ evenement.picture }}" class="md-media-sm" alt="{{ evenement.name }}">
		    			</md-card-title-media>
		    		</md-card-title>
	    			<md-card-content>
	    				<p>{{ evenement.descripton}}</p>
	    			</md-card-content>
	    		</md-card>


		    </md-content>
		</md-sidenav>




		<md-content md-theme="docs-dark" flex layout-padding ng-hide="$mdMedia('gt-md')">
			<div>
				<md-autocomplete flex required
		    		id="custom-template"

		    		md-input-name="autocompleteEvent2"
		    		md-input-maxlength="6"
		    		md-no-cache="false"

		    		md-floating-label="Rechercher un événement"
		    		placeholder="Ex. Soirée .."

		    		md-selected-item-change="selectedEvent(item)"
		    		md-search-text="searchEvent2"
		    		md-items="item in eventSearch(searchEvent2)"
		    		md-item-text="item.name"


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
		    				<span><strong>{{ item.date }}</strong></span>
		    			</span>
		    		</md-item-template>
		    	</md-autocomplete>

		    	<strong ng-show="evenement.id==0">Aucuns événements associés.</strong>
		    	<md-card ng-hide="evenement.id==0" md-theme="docs-dark" md-theme-watch>
		    		<md-card-title>
		    			<md-card-title-text>
		    				<span class="md-headline">{{ evenement.name }}</span>
		    				<span class="md-subhead">{{ evenement.date | amDateFormat:'ddd DD MMM YYYY à HH:mm' }}</span>
		    			</md-card-title-text>
		    			<md-card-title-media>
		    				<img ng-src="{{ evenement.picture }}" class="md-media-sm" alt="{{ evenement.name }}">
		    			</md-card-title-media>
		    		</md-card-title>
	    			<md-card-content>
	    				<p>{{ evenement.descripton}}</p>
	    			</md-card-content>
	    		</md-card>
	    	</div>
		</md-content>



		<div flex-gt-md="75" flex="100">
			<md-content layout-padding>
				<div>
					<form name="userForm" ng-submit="saveUser()">
						<div layout-gt-md="row" layout="column">
							<md-autocomplete required
					    		id="custom-template-name"
					    		md-input-name="autocompleteName"
					    		md-input-maxlength="6"
					    		md-no-cache="false"

					    		md-floating-label="Nom de famille"

					    		md-selected-item-change="selectedUser(item)"
					    		md-search-text="searchName"
					    		md-items="item in userSearch(searchName)"
					    		md-item-text="item.nom"

					    		md-search-text-change="user.nom=searchName"
					    		md-require-match="true"

					    		md-menu-class="autocomplete-custom-template"
					    		md-menu-container-class="custom-container">
					    		<md-item-template>
					    			<span class="item-title">
					    				<md-button class="md-icon-button logo">
					    					<img ng-src="{{ item.picture }}" class="logo-image">
					    				</md-button>
					    				<strong>{{ item.nom}} {{ item.prenom}}</strong>
					    			</span>
					    			<span class="item-metadata">
					    				<span>{{ item.adresse.name }}</span>
					    				<span>{{ item.adresse.codePostal }} {{ item.adresse.ville }}</span>
					    			</span>
					    		</md-item-template>
					    	</md-autocomplete>

							<md-autocomplete
					    		id="custom-template-prenom"
					    		md-input-name="autocompletePrenom"
					    		md-input-maxlength="6"
					    		md-no-cache="false"

					    		md-floating-label="Prenom"

					    		md-selected-item-change="selectedUser(item)"
					    		md-search-text="searchPrenom"
					    		md-items="item in userSearch(searchPrenom)"
					    		md-item-text="item.prenom"

					    		md-search-text-change="user.prenom=searchPrenom"
					    		md-require-match="true"

					    		md-menu-class="autocomplete-custom-template"
					    		md-menu-container-class="custom-container">
					    		<md-item-template>
					    			<span class="item-title">
					    				<md-button class="md-icon-button logo">
					    					<img ng-src="{{ item.picture }}" class="logo-image">
					    				</md-button>
					    				<strong>{{ item.nom}} {{ item.prenom}}</strong>
					    			</span>
					    			<span class="item-metadata">
					    				<span>{{ item.adresse.name }}</span>
					    				<span>{{ item.adresse.codePostal }} {{ item.adresse.ville }}</span>
					    			</span>
					    		</md-item-template>
					    	</md-autocomplete>


					    	<md-input-container moment-picker="dateNaissance"
					    		format="DD MMM YYYY"
					    		locale="fr"
					    		change="onChangeDate(oldValue, newValue)"
					    		class="md-block" flex-gt-md>
								<label>Date de naissance</label>
								<input name="dateNaissanceInput" ng-model="dateNaissance" required>
							</md-input-container>
						</div>

						<md-input-container class="md-block" flex-gt-md>
							<label>Adresse</label>
							<input ng-model="user.adresse.name">
						</md-input-container>

						<div layout-gt-md="row" layout="column">
							<md-input-container class="md-block" flex-gt-md>


								<label>Code postal</label>
								<input name="postalCode" ng-model="user.adresse.codePostal" ng-pattern="/^[0-9]{5}$/">

								<div ng-messages="userForm.postalCode.$error" role="alert" multiple>
									<div ng-message="required" class="my-message">You must supply a postal code.</div>
									<div ng-message="pattern" class="my-message">That doesn't look like a valid postal code.</div>
									<div ng-message="md-maxlength" class="my-message">Don't use the long version silly...we don't need to be that specific...</div>
								</div>
							</md-input-container>

							<md-input-container class="md-block" flex-gt-md>
								<label>Ville</label>
								<input ng-model="user.adresse.ville">
							</md-input-container>
						</div>

						<div layout-gt-md="row" layout="column">
							<md-input-container class="md-block" flex-gt-md>
								<label>Email</label>
								<input type="email" ng-model="user.email">
							</md-input-container>

							<md-input-container class="md-block" flex-gt-md>
								<label>Téléphone</label>
								<input type="tel" ng-model="user.telephone">
							</md-input-container>
						</div>

						<md-button class="md-warn material-cust-large-button" type="reset">&nbsp;&nbsp;Effacer&nbsp;&nbsp;</md-button>
						<md-button class="md-raised md-primary material-cust-large-button" type="submit">&nbsp;&nbsp;Inscription&nbsp;&nbsp;</md-button>
					</form>
				</div>
			</md-content>
		</div>
	</section>
</div>
