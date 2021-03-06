<?php include_once(APPPATH . 'views/area/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Invoices_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div style="border-bottom-left-radius: 10px;border-bottom-right-radius: 10px;" class="panel-default panel-table">
			<div class="panel-heading md-mb-20" style="height: 70px; padding: 12px; margin: 0px;">
				<div class="pull-left">
					<strong><?php echo lang('invoices') ?></strong>
				</div>
				<div class="pull-right">
					<!-- Filter Area -->
					<div class="btn-group btn-hspace pull-right">
					  <button type="button" data-toggle="dropdown" class="dropdown-toggle btn-xl filter-button"><i class="icon-left ion-funnel"></i></button>
					  <ul class="dropdown-menu ciuis-body-connections pull-right ciuis-custom-filter">
					   <div ng-repeat="(prop, ignoredValue) in invoices[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'prefix' && prop != 'longid' && prop != 'created' && prop != 'duedate' && prop != 'customer' && prop != 'total' && prop != 'status' && prop != 'color' && prop != 'customer_id'">
						  <div class="filter">
							<span class="md-pl-20 text-muted"><strong>{{prop}}</strong></span>
							<li class="divider"></li>
							<div class="col-md-12">
							<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)" ng-if="prop!='<?php echo lang('filterbycustomer') ?>'">
							  <div class="ciuis-body-checkbox has-warning">
								  <input id="{{[opt]}}" type="checkbox" ng-model="filter[prop][opt]">
								  <label for="{{[opt]}}">{{opt}}</label>
							  </div>
							</div>
							<div ng-if="prop=='<?php echo lang('filterbycustomer') ?>'">
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
					<div class="ciuis-external-search-in-table">
					  <input ng-model="search.customer" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
					  <i class="ion-ios-search"></i>
					</div>
				</div>
			</div>
			<ul class="custom-ciuis-list-body" style="padding: 0px;">
				<li ng-repeat="invoice in invoices | filter: { customer_id: '<?php echo $_SESSION[ 'customer' ] ?>' } | filter: FilteredData |  filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item">
					<ul class="list-item-for-custom-list">
						<li class="ciuis-custom-list-item-item col-md-12">
						<div class="assigned-staff-for-this-lead user-avatar"><i class="ico-ciuis-invoices" style="font-size: 32px"></i></div>
							<div class="pull-left col-md-3">
							<strong>
							<a class="ciuis_expense_receipt_number" href="<?php echo base_url('area/invoice/'); ?>{{invoice.id}}"><span ng-bind="invoice.prefix + '-' + invoice.longid"></span></a>
							</strong><br><small ng-bind="invoice.customer"></small>
							</div>
							<div class="col-md-9">
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('billeddate'); ?></small><br><strong><span class="badge" ng-bind="invoice.created"></span></strong></span>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('invoiceduedate'); ?></small><br><strong><span class="badge" ng-bind="invoice.duedate"></span></strong></span>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('status'); ?></small><br><strong class="text-{{invoice.color}}" ng-bind="invoice.status"></strong>
								</div>
								<div class="col-md-3 text-right">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('amount'); ?></small><br><strong><b class="money-area" ng-bind="invoice.total"></b></strong></span>
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
		
	</div>
<?php include_once(APPPATH . 'views/area/inc/sidebar.php'); ?>

</div>
<?php include_once(APPPATH . 'views/area/inc/footer.php');?>
