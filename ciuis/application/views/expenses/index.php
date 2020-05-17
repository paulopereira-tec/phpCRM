<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Expenses_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="row">
			<div class="col-md-4 md-pr-0">
				<div class="panel-default panel-table borderten">
					<div class="panel-heading"><b><?php echo lang('expensescategories'); ?></b>
						<button type="button" data-target="#newcategory" data-toggle="modal" data-placement="left" title="" class="btn btn-space btn-default md-trigger pull-right" data-original-title="Add Expense Category"><i class="ion-plus-round"></i></button>
						<span class="panel-subtitle"><?php echo lang('expensescategoriessub'); ?>
					</div>
        		</div>
        		<div class="row"> 
				  <div ng-repeat="category in expensescategories" class="col-md-12 col-sm-6">
					<div class="widget widget-stats red-bg margin-top-0">
					  <div class="stats-icon stats-icon-lg"><i style="margin-right: 10px" data-target="#updatecategory{{category.id}}" data-toggle="modal" data-placement="left" title="" data-original-title="Update Expense Category" class="ion-ios-gear-outline"></i><a style="color:#a9b1c2" class="ion-ios-trash" href="expenses/removecategory/{{category.id}}"></a></div>
					  <div class="stats-title text-uppercase" ng-bind="category.name"></div>
					  <div class="stats-number"><span class="money-area" ng-bind="category.amountby"></span></div>
					  <div class="stats-progress progress">
						<div style="width: {{category.percent}}%;" class="progress-bar"></div>
					  </div>
					  <div class="stats-desc"><?php echo lang('categorypercent') ?> (<span ng-bind="category.percent+'%'"></span>)</div>
					</div>
					<div id="updatecategory{{category.id}}" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
					 <div class="modal-dialog">
					 <div class="modal-content">
					 <div class="modal-header">
						<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
							<h3 class="modal-title"><?php echo lang('updateexpensecategory'); ?></h3>
							</div>
							<div class="modal-body">
							<div class="form-group">
								<label for="name"><?php echo lang('name'); ?></label>
								<div class="input-group"><span class="input-group-addon"><i class="ion-navicon"></i></span>
									<input ng-model="category.name" type="text" name="name" class="form-control"/>
								</div>
							</div>
							<div class="form-group">
							<label for="name"><?php echo lang('description'); ?></label>
								<div class="input-group"><span class="input-group-addon"><i class="ion-ios-list-outline"></i></span>
									<textarea ng-model="category.description" name="description" class="form-control"></textarea>
								</div>
							</div>
							</div>
							<div class="modal-footer">
								<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
								<button ng-click="UpdateExpenseCategory($index)" type="submit" class="btn btn-default"><?php echo lang('save'); ?></button>
							</div>
						</div>
					</div>
					</div>
				  </div>
           		 </div>
			</div>
		<div class="col-md-8">
			<div style="border-radius: 10px;" class="panel-default panel-table">
				<div class="panel-heading" style="padding-bottom: 0px;">
					<strong><?php echo lang('expensestitle'); ?></strong>
					<div class="btn-group btn-hspace pull-right">
					  <button type="button" data-toggle="dropdown" class="dropdown-toggle btn-xl filter-button"><i class="icon-left ion-funnel"></i></button>
					  <ul class="dropdown-menu ciuis-body-connections pull-right ciuis-custom-filter">
					   <div ng-repeat="(prop, ignoredValue) in expenses[0]" ng-init="filter[prop]={}" ng-if="prop != 'id' && prop != 'title' && prop != 'prefix' && prop != 'longid' && prop != 'amount' && prop != 'staff' && prop != 'color' && prop != 'displayinvoice' && prop != 'date' && prop != 'category' && prop != 'billstatus' && prop != 'billable'">
						  <div class="filter">
							<span class="md-pl-20 text-muted"><strong>{{prop}}</strong></span>
							<li class="divider"></li>
							<div class="col-md-12">
							<div class="labelContainer" ng-repeat="opt in getOptionsFor(prop)">
							  <div class="ciuis-body-checkbox has-warning">
								  <input id="{{[opt]}}" type="checkbox" ng-model="filter[prop][opt]">
								  <label for="{{[opt]}}">{{opt}}</label>
							  </div>
							</div>
							</div>
							<hr style="margin-bottom: 8px; border-top: 1px solid #fdfdfd;">
						  </div>
						</div>
					  </ul>
					</div>
					<button type="button" data-target="#newexpense" data-toggle="modal" data-placement="left" title="" class="btn btn-space btn-default md-trigger btn-lg pull-right" data-original-title="Add Expense"><i class="ion-plus-round"></i> <?php echo lang('newexpense'); ?></button>
					<span class="panel-subtitle"><?php echo lang('expensesdescription'); ?></span>
				</div>
				<div class="panel-body">
				<ul class="custom-ciuis-list-body" style="padding: 0px;">
				<li ng-repeat="expense in expenses | filter: FilteredData| pagination : currentPage*itemsPerPage | limitTo: 5"i class="ciuis-custom-list-item ciuis-special-list-item lead-name">
					<ul class="list-item-for-custom-list">
						<li class="ciuis-custom-list-item-item col-md-12">
						<div data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="<?php echo lang('addedby'); ?> {{expense.staff}}" class="assigned-staff-for-this-lead user-avatar"><i class="ion-document" style="font-size: 32px"></i></div>
							<div class="pull-left col-md-4">
							<a class="ciuis_expense_receipt_number" href="<?php echo base_url('expenses/receipt/') ?>{{expense.id}}"><strong ng-bind="expense.prefix + '-' + expense.longid"></strong></a><br>
							<small ng-bind="expense.title"></small>
							</div>
							<div class="col-md-8">
								<div class="col-md-5">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('amount'); ?></small><br><strong><b class="money-area" ng-bind="expense.amount"></b><span>
								<span ng-show="expense.billable != 'false'" class="label label-{{expense.color}}" ng-bind="expense.billstatus"></span>
								</span></strong></span>
								</div>
								<div class="col-md-4">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('category'); ?></small><br><strong ng-bind="expense.category"></strong>
								</div>
								<div class="col-md-3">
								<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('date'); ?></small><br><strong><span class="badge" ng-bind="expense.date"></span></strong></span>
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
				<?php if (empty( $expenses)) { echo '<img src="'.base_url('assets/img/no_lead.png').'" alt="">';}?>	
				</div>
			</div>
		</div>
	</div>
</div>
<div id="newexpense" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog">
		<?php echo form_open('expenses/add'); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title"><?php echo lang('addexpense')?></h3>
			</div>
			<div class="col-md-6 md-pr-0">
				<div class="modal-body md-pr-5">
					<div class="form-group">
						<label for="title"><?php echo lang('title'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
							<input required type="text" name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control" id="title" placeholder="<?php echo lang('title'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="amount"><?php echo lang('amount'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-social-usd"></i></span>
							<input required type="text" name="amount" value="<?php echo $this->input->post('amount'); ?>" class="input-money-format form-control" id="amount" placeholder="0.00"/>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('date'); ?></label>
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input placeholder="<?php echo date(" d.m.Y "); ?>" required type='input' name="date" value="<?php echo $this->input->post('date'); ?>" class="form-control" id="date"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 md-pl-0">
				<div class="modal-body md-pl-5">
					<div class="form-group">
						<label for="category"><?php echo lang('category'); ?></label>
						<div class="add-on-edit">
							<select name="category" class="form-control select2">
								<option ng-repeat="category in expensescategories" value="{{category.id}}">{{category.name}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="account"><?php echo lang('choiseaccount'); ?></label>
						<div class="add-on-edit">
							<select name="account" class="form-control select2">
								<option ng-repeat="account in accounts" value="{{account.id}}">{{account.name}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="customer"><?php echo lang('choisecustomer'); ?></label>
						<div class="add-on-edit">
							<select name="customer" class="form-control select2">
								<option value=""><?php echo lang('choisecustomer'); ?></option>
								<option ng-repeat="customer in all_customers" value="{{customer.id}}">{{customer.name}}</option>
							</select>
						</div>
					</div>
				</div>
			</div>
			<input hidden="" type="text" name="created" value="<?php echo date("Y-m-d H:i:s"); ?>"/>
			<input type="hidden" name="staff" value="<?php echo $this->session->userdata('logged_in_staff_id'); ?>">
			<div class="col-md-12 md-pt-0">
				<div class="modal-body md-pt-0">
					<div class="form-group">
					<label for="description"><?php echo lang('description'); ?></label>
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
							<textarea name="description" class="form-control" id="description" placeholder="Description"><?php echo $this->input->post('description'); ?></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
					<button type="submit" class="btn btn-default"><?php echo lang('save'); ?></button>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div id="newcategory" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	 <div class="modal-dialog">
	 <?php echo form_open('expenses/addcategory'); ?>
	 <div class="modal-content">
	  <div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
			<h3 class="modal-title"><?php echo lang('addexpensecategory')?></h3>
			</div>
			<div class="modal-body">
			<div class="form-group">
				<label for="name"><?php echo lang('name'); ?></label>
				<div class="input-group"><span class="input-group-addon"><i class="ion-navicon"></i></span>
					<input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="name" placeholder="<?php echo lang('name'); ?>"/>
				</div>
			</div>
			<div class="form-group">
			<label for="name"><?php echo lang('description'); ?></label>
				<div class="input-group"><span class="input-group-addon"><i class="ion-ios-list-outline"></i></span>
					<textarea name="description" class="form-control" id="description" placeholder="<?php echo lang('description');?>"><?php echo $this->input->post('description'); ?></textarea>
				</div>
			</div>

			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
				<button type="submit" class="btn btn-default"><?php echo lang('save'); ?></button>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>

</div>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>