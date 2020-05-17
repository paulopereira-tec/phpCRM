<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Customers_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class='ciuis-customer-panel-xs'>
			<div class='ciuis-customer-panel-xs-icerik'>
				<header class='header_customer-xs'>
					<div class='main-header_customer-xs'>
						<div class='container-fluid'>
							<div class='top-header_customer-xs'>
								<div class='row'>
									<div class='col-md-6'>
										<ol class='breadcrumb-xs-customer'>
											<button data-target="#addcustomer" data-toggle="modal" style="margin-right:10px;" type="button" class="pull-left btn btn-warning"><i class="icon icon-left mdi mdi mdi-plus"></i><?php echo lang('newcustomer'); ?></button>
											<li><a href='<?php echo base_url('customers')?>'><?php echo lang('customers'); ?></a></li>
											<li><a href='#'><i class="ion-ios-arrow-right"></i></a></li>
											<li class='active'><a href='#'><?php echo $title ?></a></li>
										</ol>
									</div>
									<div style="padding-right: 20px;" class='col-md-5 hidden-xs'>
										<div class="searchcustomer-container">
											<div class="searchcustomer-box">
												<div class="searchcustomer-icon"><i class="ion-person-stalker"></i>
												</div>
												<input ng-model="search.name" name="q" value="" x-webkit-speech='x-webkit-speech' class="searchcustomer-input" id="searchcustomer" type="text" placeholder="<?php echo lang('searchcustomer'); ?>"/>
												<i style="position: absolute; margin-top: 5px; right: 10px; font-size: 18px;" onclick="startDictation()" class="ion-ios-mic"></i>
												<ul class="searchcustomer-results" id="results"></ul>
											</div>
										</div>
									</div>
									<div class="col-md-1" style="margin-top: 5px;">
									<!-- Filter Area -->
									<div class="btn-group btn-hspace pull-right">
									  <button type="button" data-toggle="dropdown" class="dropdown-toggle btn-xl filter-button"><i class="icon-left ion-funnel"></i></button>
									  <ul class="dropdown-menu ciuis-body-connections pull-right ciuis-custom-filter">
									   <div ng-repeat="(prop, ignoredValue) in customers[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'name' && prop != 'address' && prop != 'email' && prop != 'phone' && prop != 'balance' && prop != 'customer_id' && prop != 'contacts'">
										  <div class="filter">
											<span class="md-pl-20 text-muted"><strong>{{prop}}</strong></span>
											<li class="divider"></li>
											<div class="col-md-12">
											<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycountry') ?>'">
											  <div class="ciuis-body-checkbox has-warning">
												  <input id="{{[opt]}}" type="checkbox" ng-model="filter[prop][opt]">
												  <label for="{{[opt]}}">{{opt}}</label>
											  </div>
											</div>
											<div ng-if="prop=='<?php echo lang('filterbycountry') ?>'">
												<select class="form-control" ng-model="filter_select" ng-init="filter_select='all'" ng-change="updateDropdown(prop)">
												  <option value="all">{{prop}}</option>
												  <option ng-repeat="opt in getOptionsFor(prop) | orderBy:'':true" value="{{opt}}" >{{opt}}</option>
												</select>
											</div>
											</div>
											<hr style="margin-bottom: 8px; border-top: 1px solid #fdfdfd;">
										  </div>
										</div>
									  </ul>
									</div>
									<!-- Filter Area -->
									</div>
								</div>
							</div>
						</div>
					</div>
				</header>
			</div>
		</div>
		<ul class="custom-ciuis-list-body" style="padding: 0px;">
			<li ng-repeat="customer in customers | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item lead-name">
				<ul class="list-item-for-custom-list">
					<li class="ciuis-custom-list-item-item col-md-12">
					<div class="assigned-staff-for-this-lead user-avatar"><i class="ico-ciuis-staffdetail" style="font-size: 32px"></i></div>
						<div class="pull-left col-md-4">
						<a href="<?php echo base_url('customers/customer/')?>{{customer.id}}"><strong ng-bind="customer.name"></strong></a><br>
						<a href="mailto:{{customer.email}}"><small ng-bind="customer.email"></small></a>
						</div>
						<div class="col-md-8">
							<div class="col-md-9">
							<span class="date-start-task"><small class="text-muted text-uppercase" ng-bind="customer.address"></small><br>
							<strong ng-bind="customer.phone"></strong></span>
							</div>
							<div class="col-md-3 text-center">
							<div class="hellociuislan">
							<div ng-show="customer.balance !== null">
								<strong style="font-size: 20px;"><span class="money-area" ng-bind="customer.balance"></span></strong><br><span style="font-size:10px"><?php echo lang( 'currentdebt' ) ?></span>
							</div>
							<div ng-show="customer.balance === null">
								<strong style="font-size: 22px;"><i class="text-success ion-android-checkmark-circle"></i></strong><br><span class="text-success" style="font-size:10px">No Balance</span>
							</div>
							</div>
							</div>
						</div>
					</li>
				</ul>
			</li>
		</ul>
		<div class="pagination-div">
			<ul class="pagination">
				<li ng-class="DisablePrevPage()">
					<a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a>
				</li>
				<li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
					<a href="#" ng-bind="n+1"></a>
				</li>
				<li ng-class="DisableNextPage()">
					<a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a>
				</li>
			</ul>
		</div>
	</div>
	<div id="addcustomer" tabindex="-1" role="dialog" class="modal  fade colored-header colored-header-warning">
	<?php echo form_open('customers/add',array("class"=>"form-vertical")); ?>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title">
					<?php echo lang('newcustomertitle');?>
					<div class="col-md-4 xs-pt-10 pull-right">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-xl btn-default btn-reverse active">
								<input name="type" type="radio" checked value="0"><?php echo lang('company')?>
								</label>
								<label class="btn btn-xl btn-default btn-reverse">
								<input name="type" type="radio" value="1"><?php echo lang('individual')?>
								</label>
							</div>
					</div>
				</h3>
				<span>
					<?php echo lang('newcustomerdescription');?>
				</span>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div id="" class="form-group company">
						<label class=""><?php echo lang('updatecustomercompany')?></label>
						<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-collection-item-1"></i></span>
						<input type="text" name="company" value="<?php echo $this->input->post('company'); ?>" class="form-control" id="taxnumber"/>
						</div>
						</div>
						<div style="display: none" id="" class="form-group individual">
						<label class=""><?php echo lang('updatecustomerindividualname')?></label>
						<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-collection-item-1"></i></span>
						<input type="text" name="namesurname" value="<?php echo $this->input->post('namesurname'); ?>" class="form-control" id="namesurname"/ placeholder="Customer Name Surname">
						</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="taxoffice">
								<?php echo lang('taxofficeedit');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-local-atm"></i></span>
								<input type="text" name="taxoffice" value="<?php echo $this->input->post('taxoffice'); ?>" class="form-control" id="taxoffice"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div id="" class="form-group company">
						<label for="taxnumber">
								<?php echo lang('taxnumberedit');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-collection-item-1"></i></span>
								<input type="text" name="taxnumber" value="<?php echo $this->input->post('taxnumber'); ?>" class="form-control" id="taxnumber"/>
							</div>
						</div>
						<div style="display: none" id="" class="form-group individual">
						<label for="ssn">
								<?php echo lang('ssnedit');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-collection-item-1"></i></span>
								<input type="text" name="ssn" value="<?php echo $this->input->post('ssn'); ?>" class="form-control" id="ssn"/ placeholder="<?php echo lang('ssnedit');?>">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="executive">
								<?php echo lang('executiveupdate');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-account"></i></span>
								<input type="text" name="executive" value="<?php echo $this->input->post('executive'); ?>" class="form-control" id="executive"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="zipcode">
								<?php echo lang('zipcode');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="ion-paper-airplane"></i></span>
								<input type="text" name="zipcode" value="<?php echo $this->input->post('zipcode'); ?>" class="form-control" id="zipcode"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="phone">
								<?php echo lang('customerphoneupdate');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-phone"></i></span>
								<input type="text" name="phone" value="<?php echo $this->input->post('phone'); ?>" class="form-control" id="phone"/>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="fax">
								<?php echo lang('customerfaxupdate');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-scanner"></i></span>
								<input type="text" name="fax" value="<?php echo $this->input->post('fax'); ?>" class="form-control" id="fax"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="email">
								<?php echo lang('emailedit');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon">@</span>
								<input required type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control" id="email"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="web">
								<?php echo lang('customerwebupdate');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
								<input type="text" name="web" value="<?php echo $this->input->post('web'); ?>" class="form-control" id="web"/>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="address">
								<?php echo lang('customeraddressupdate');?>
							</label>
							<textarea name="address" class="form-control"><?php echo $this->input->post('address'); ?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-3">
						<div class="form-group">
							<label for="email">
								<?php echo lang('customercountryupdate');?>
							</label>
							<select required name="country_id" class="select2">
								<option><?php echo lang('country');?></option>
								<option ng-repeat="country in countries" value="{{country.id}}">{{country.shortname}}</option>
							</select>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="form-group">
							<label for="state">
								<?php echo lang('stateupdate');?>
							</label>
							<div class="input-group"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
								<input type="text" name="state" value="<?php echo $this->input->post('state'); ?>" class="form-control" id="state"/>
							</div>
						</div></div>
					<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="form-group">
							<label for="city">
								<?php echo lang('cityupdate');?>
							</label>
							<div class="input-group"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
								<input type="text" name="city" value="<?php echo $this->input->post('city'); ?>" class="form-control" id="city"/>
							</div>
						</div></div>
				<div class="col-xs-12 col-md-6 col-lg-3">
					<div class="form-group">
							<label for="town">
								<?php echo lang('townupdate');?>
							</label>
							<div class="input-group"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
								<input type="text" name="town" value="<?php echo $this->input->post('town'); ?>" class="form-control" id="town"/>
							</div>
						</div></div>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
					<?php echo lang('cancel');?>
				</button>
				<button type="submit" class="btn btn-default modal-close">
					<?php echo lang('add');?>
				</button>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
	
</div>
	<?php include_once( APPPATH . 'views/inc/footer.php' );?>
	
<script>
	( function () {
		var displayResults, findAll, maxResults, names, resultsOutput, searchcustomerInput;
		names = [ 
			<?php foreach($customers as $f){ ?>
			"<a href='<?php echo base_url('customers/customer/'.$f['id'].'');?>'><?php if($f['type']==0){echo $f['company'];}else echo $f['namesurname']; ?></a>", 
			<?php }?>
			""
		];
		findAll = ( function ( _this ) {
			return function ( wordList, collection ) {
				return collection.filter( function ( word ) {
					word = word.toLowerCase();
					return wordList.some( function ( name ) {
						return ~word.indexOf( name );
					} );
				} );
			};
		} )( this );
		displayResults = function ( resultsEl, wordList ) {
			return resultsEl.innerHTML = ( wordList.map( function ( name ) {
				return '<li>' + name + '</li>';
			} ) ).join( '' );
		};
		searchcustomerInput = document.getElementById( 'searchcustomer' );
		resultsOutput = document.getElementById( 'results' );
		maxResults = 20;
		searchcustomerInput.addEventListener( 'keyup', ( function ( _this ) {
			return function ( e ) {
				var suggested, value;
				value = searchcustomerInput.value.toLowerCase().split( ' ' );
				suggested = ( value[ 0 ].length ? findAll( value, names ) : [] );
				return displayResults( resultsOutput, suggested );
			};
		} )( this ) );
	} ).call( this );
	function startDictation() {
		if ( window.hasOwnProperty( 'webkitSpeechRecognition' ) ) {
			var recognition = new webkitSpeechRecognition();
			recognition.continuous = false;
			recognition.interimResults = false;
			recognition.lang = "<?php echo lang('language_datetime')?>";
			recognition.start();
			recognition.onresult = function ( e ) {
				document.getElementById( 'searchcustomer' ).value = e.results[ 0 ][ 0 ].transcript;
				recognition.stop();
				$('.searchcustomer-input').value = e.results[ 0 ][ 0 ].transcript;
				$('.searchcustomer-input').focus();
				$('.searchcustomer-input').keyup();

			};
			recognition.onerror = function ( e ) {
				recognition.stop();
			}
		}
	}
</script>