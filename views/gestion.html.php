<div ng-cloak>
	<md-content>
		<md-tabs md-dynamic-height md-border-bottom>
			<md-tab label="Adhérents">
				<md-content class="md-padding">

					<section layout="row" layout-align="end center" layout-wrap>
						<md-button class="md-raised md-primary material-cust-medium-button" ng-csv="usersCsv" csv-header="usersCsvHeader" field-separator=";" filename="adherents.csv">Télécharger</md-button>
						<form>
							<input type="file" name="fileUsers" id="fileUsers" ng-hide="true" accept=".csv, application/vnd.ms-excel" onchange="angular.element(this).scope().loadFile()" />
							<button type="reset" id="resetInput" ng-hide="true"></button>
							<md-button class="md-raised md-warn material-cust-medium-button " ng-click="clickUpload('fileUsers')">Transferer</md-button>
						</form>
					</section>

					<div style="visibility: hidden">
						<div class="md-dialog-container" id="userCsvDialog">
							<md-dialog aria-label="Données du fichier" layout-padding>
								<md-dialog-content>
									<md-table-container flex>
										<table md-table>
											<thead md-head md-order="queryUsersUpload.order">
												<th md-column md-order-by="nom">Nom</th>
												<th md-column md-order-by="prenom">Prenom</th>
												<th md-column md-order-by="age">Date de naissance</th>
												<th md-column>Adresse</th>
												<th md-column>Code postal</th>
												<th md-column>Ville</th>
												<th md-column ng-show="$mdMedia('gt-md')">Email</th>
												<th md-column ng-show="$mdMedia('gt-md')">Téléphone</th>
											</thead>

											<tbody md-body>
												<tr md-row md-select="user" md-select-id="nom" md-auto-select ng-repeat="user in usersCsvUp | orderBy: queryUsersUpload.order | limitTo: queryUsersUpload.limit: (queryUsersUpload.page - 1) * queryUsersUpload.limit">
													<td md-cell>{{ user.nom }}</td>
													<td md-cell>{{ user.prenom }}</td>
													<td md-cell>{{ user.dateNaissance }}</td>
													<td md-cell>{{ user.adresse.name }}</td>
													<td md-cell>{{ user.adresse.codePostal }}</td>
													<td md-cell>{{ user.adresse.ville }}</td>
													<td md-cell ng-show="$mdMedia('gt-md')">{{ user.email }}</td>
													<td md-cell ng-show="$mdMedia('gt-md')">{{ user.telephone }}</td>
												</tr>
											</tbody>
										</table>
									</md-table-container>
									<md-table-pagination md-limit="queryUsersUpload.limit" md-limit-options="[5, 10, 15, 20, 30, 50]" md-page="queryUsersUpload.page" md-total="{{usersCsvUp.length}}" md-page-select></md-table-pagination>
								</md-dialog-content>

								<md-dialog-actions>
									<md-button ng-click="closeDialog()" class="md-accent">Annuler</md-button>
									<md-button ng-click="saveNewUsers($event)" class="md-raised md-primary">Transferer</md-button>
								</md-dialog-actions>
							</md-dialog>
						</div>
					</div>



					<md-table-container ng-init="loadUsers()" flex>
						<table md-table>
							<thead md-head md-order="queryUser.order">
								<th md-column>Pict</th>
								<th md-column md-order-by="nom">Nom</th>
								<th md-column md-order-by="prenom">Prenom</th>
								<th md-column md-numeric md-order-by="age">Age</th>
								<th md-column>Adresse</th>
								<th md-column>Ville</th>
								<th md-column ng-show="$mdMedia('gt-md')">Email</th>
								<th md-column ng-show="$mdMedia('gt-md')">Téléphone</th>
								<th md-column>Supprimer</th>
							</thead>

							<tbody md-body>
								<tr md-row md-select="user" md-select-id="nom" md-auto-select ng-repeat="user in users | orderBy: queryUser.order | limitTo: queryUser.limit: (queryUser.page - 1) * queryUser.limit">
									<td md-cell><img ng-src="{{ user.picture }}" class="logo-image" style="width: 24px; height: 24px;"/></td>
									<td md-cell>{{ user.nom }}</td>
									<td md-cell>{{ user.prenom }}</td>
									<td md-cell>{{ user.age }}</td>
									<td md-cell>{{ user.adresse.name }}</td>
									<td md-cell>{{ user.adresse.codePostal }} - {{ user.adresse.ville }}</td>
									<td md-cell ng-show="$mdMedia('gt-md')">{{ user.email }}</td>
									<td md-cell ng-show="$mdMedia('gt-md')">{{ user.telephone }}</td>
									<td md-cell><ng-md-icon size="32" icon="clear" ng-click="delUser(user)" style="cursor:pointer"></ng-md-icon></td>
								</tr>
							</tbody>
						</table>
					</md-table-container>
					<md-table-pagination md-limit="queryUser.limit" md-limit-options="[5, 10, 15, 20, 30, 50]" md-page="queryUser.page" md-total="{{users.length}}" md-page-select></md-table-pagination>





				</md-content>
			</md-tab>

			<md-tab label="Evénements">
				<md-content class="md-padding">

					<section layout="row" layout-align="end center" layout-wrap>
						<md-button class="md-raised md-primary material-cust-medium-button " ng-csv="eventsCsv" csv-header="eventsCsvHeader" field-separator=";" filename="evenements.csv">Télécharger</md-button>
<!-- 						<input type="file" name="fileEvents" id="fileEvents" ng-hide="true" accept=".csv, application/vnd.ms-excel" />
						<md-button class="md-raised md-warn" ng-click="clickUpload('fileEvents')">Transferer</md-button>
 -->				</section>



 					<div style="visibility: hidden">
						<div class="md-dialog-container" id="usersEventDialog">
							<md-dialog aria-label="Adhérents à cet événement" layout-padding>
								<md-dialog-content>
									<md-table-container flex>
										<table md-table>
											<thead md-head md-order="queryEventUsers.order">
												<th md-column md-order-by="nouveau">Nouveau</th>
												<th md-column md-order-by="name">Nom</th>
												<th md-column>Prenom</th>
												<th md-column>Date de naissance</th>
												<th md-column>Adresse</th>
												<th md-column>Code postal</th>
												<th md-column>Ville</th>
												<th md-column ng-show="$mdMedia('gt-md')">Email</th>
												<th md-column ng-show="$mdMedia('gt-md')">Téléphone</th>
											</thead>

											<tbody md-body>
												<tr md-row md-select="user" md-select-id="nom" md-auto-select ng-repeat="user in usersEvent | orderBy: queryEventUsers.order | limitTo: queryEventUsers.limit: (queryEventUsers.page - 1) * queryEventUsers.limit">
													<td md-cell>{{ user.nouveau }}</td>
													<td md-cell>{{ user.nom }}</td>
													<td md-cell>{{ user.prenom }}</td>
													<td md-cell>{{ user.dateNaissance | amDateFormat:'DD MMM YYYY' }}</td>
													<td md-cell>{{ user.adresse.name }}</td>
													<td md-cell>{{ user.adresse.codePostal }}</td>
													<td md-cell>{{ user.adresse.ville }}</td>
													<td md-cell ng-show="$mdMedia('gt-md')">{{ user.email }}</td>
													<td md-cell ng-show="$mdMedia('gt-md')">{{ user.telephone }}</td>
												</tr>
											</tbody>
										</table>
									</md-table-container>
									<md-table-pagination md-limit="queryEventUsers.limit" md-limit-options="[5, 10, 15, 20, 30, 50]" md-page="queryEventUsers.page" md-total="{{usersEvent.length}}" md-page-select></md-table-pagination>

								</md-dialog-content>

								<md-dialog-actions>
									<md-button  class="md-raised md-warn" ng-csv="usersEventCsv" csv-header="usersCsvHeader" field-separator=";" filename="evenement.csv">Télécharger</md-button>
									<md-button ng-click="closeDialog()" class="md-raised md-primary">Fermer</md-button>
								</md-dialog-actions>
							</md-dialog>
						</div>
					</div>



					<md-table-container ng-init="loadEvents()" flex>
						<table md-table>
							<thead md-head md-order="queryEvent.order">
								<th md-column>Pict</th>
								<th md-column md-order-by="name">Nom</th>
								<th md-column md-order-by="date">Date</th>
								<th md-column>Description</th>
								<th md-column>Anciens adhérents</th>
								<th md-column>Nouveaux adhérents</th>
								<th md-column>Supprimer</th>
							</thead>

							<tbody md-body>
								<tr md-row md-select="event" md-select-id="name" md-auto-select ng-repeat="event in events | orderBy: queryEvent.order | limitTo: queryEvent.limit: (queryEvent.page - 1) * queryEvent.limit"
									style="cursor:pointer;" ng-click="getUsersEvent(event);">
									<td md-cell><img ng-src="{{ event.picture }}" class="logo-image" style="width: 24px; height: 24px;"/></td>
									<td md-cell>{{ event.name }}</td>
									<td md-cell>{{ event.date | amDateFormat:'dddd DD MMM YYYY à HH:mm' }}</td>
									<td md-cell>{{ event.description }}</td>
									<td md-cell>{{ event.nbAnciens }}</td>
									<td md-cell>{{ event.nbNouveaux }}</td>
									<td md-cell><ng-md-icon size="32" icon="clear" ng-click="delEvent(event)" style="cursor:pointer"></ng-md-icon></td>
								</tr>
							</tbody>
						</table>
					</md-table-container>
					<md-table-pagination md-limit="queryEvent.limit" md-limit-options="[5, 10, 15, 20, 30, 50]" md-page="queryEvent.page" md-total="{{events.length}}" md-page-select></md-table-pagination>


				</md-content>
			</md-tab>



			<md-tab label="Purger la BDD">
				<md-content class="md-padding" layout="row" layout-align="center center">
					<md-button class="md-raised md-accent material-cust-large-button" ng-click="openValidPurgeEvents($event)">Purger les événements</md-button>
					<md-button class="md-raised md-accent material-cust-large-button" ng-click="openValidPurgeUsers($event)">Purger les adhérents</md-button>
				</md-content>
			</md-tab>


			<div style="visibility: hidden">
				<div class="md-dialog-container" id="validPurgeEvents">
					<md-dialog aria-label="Purge des évenements" layout-padding>
						<md-dialog-content>
							<h3>Etes vous sur de vouloir supprimer tout les événements et leurs adhérents associés ?</h3>
						</md-dialog-content>
						<md-dialog-actions>
							<md-button  class="md-raised md-warn" ng-click="clearEvents()">Purger les événement</md-button>
							<md-button ng-click="closeDialog()" class="md-raised md-primary">Fermer</md-button>
						</md-dialog-actions>
					</md-dialog>
				</div>
			</div>


			<div style="visibility: hidden">
				<div class="md-dialog-container" id="validPurgeUsers">
					<md-dialog aria-label="Purge des adhérents" layout-padding>
						<md-dialog-content>
							<h3>Etes vpus sur de vouloir supprimer tout les adhérents et leurs événements associés ?</h3>
						</md-dialog-content>
						<md-dialog-actions>
							<md-button  class="md-raised md-warn" ng-click="clearUsers()">Purger les adhérents</md-button>
							<md-button ng-click="closeDialog()" class="md-raised md-primary">Fermer</md-button>
						</md-dialog-actions>
					</md-dialog>
				</div>
			</div>


		</md-tabs>