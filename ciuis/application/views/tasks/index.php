<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Tasks_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3">
	<div class="panel-heading">
	<strong><?php echo lang('tasksituation'); ?></strong>
	<span class="panel-subtitle"><?php echo lang('tasksituationsdesc'); ?></span>
	</div>
	<div class="row" style="padding: 0px 20px 0px 20px;">
		<div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'1'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'1'}).length * 100 / tasks.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('open'); ?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'2'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'2'}).length * 100 / tasks.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('inprogress'); ?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'3'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'3'}).length * 100 / tasks.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('waiting'); ?></span>
		</div>
		<div class="col-md-6 col-xs-6 border-right text-uppercase">
			<div class="tasks-status-stat">
				<h3 class="text-bold ciuis-task-stat-title">
				<span class="task-stat-number" ng-bind="(tasks | filter:{status_id:'4'}).length"></span>
				<span class="task-stat-all" ng-bind="'/'+' '+tasks.length+' '+'<?php echo lang('task') ?>'"></span>
				</h3>
				<span class="ciuis-task-percent-bg">
				<span class="ciuis-task-percent-fg" style="width: {{(tasks | filter:{status_id:'4'}).length * 100 / tasks.length }}%;"></span>
				</span>
			</div>
			<span style="color:#989898"><?php echo lang('complete'); ?></span>
		</div>
	</div>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0">
		<div style="border-radius: 10px;" class="panel-default">
		<div class="panel-heading">
			<strong class="text-uppercase"><?php echo lang('tasks'); ?></strong>
				<div class="pull-right">
					<!-- Filter Area -->
					<div class="btn-group btn-hspace pull-right">
					  <button type="button" data-toggle="dropdown" class="dropdown-toggle btn-xl filter-button"><i class="icon-left ion-funnel"></i></button>
					  <ul class="dropdown-menu ciuis-body-connections pull-right ciuis-custom-filter">
					   <div ng-repeat="(prop, ignoredValue) in tasks[0]" ng-init="filter[prop]={}" ng-if="prop != 'id'  && prop != 'name' && prop != 'relationtype' && prop != 'duedate' && prop != 'startdate' && prop != 'status' && prop != 'done' && prop != 'status_id'">
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
					<!-- Filter Area -->
					<div class="ciuis-external-search-in-table">
						<input ng-model="search.name" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
						<i class="ion-ios-search"></i>
					</div>
					<button data-target="#newtask" data-toggle="modal" type="button" class="btn btn-default btn-xl"><?php echo lang('createnewtask'); ?> <span class="ion-plus-round"></span></button>
				</div>
				<span class="panel-subtitle"><?php echo lang('organizeyourtasks'); ?></span>
			</div>
			<div class="panel-body md-pl-0">
				<ul class="custom-ciuis-list-body" style="padding: 0px;">
					<li ng-repeat="task in tasks | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="milestone-todos-list ciuis-custom-list-item ciuis-special-list-item paginationclass">
						<ul class="all-milestone-todos">
							<li class="milestone-todos-list-item col-md-12  {{task.done}}">
								<span class="pull-left col-md-5"><a href="<?php echo base_url('tasks/task/')?>{{task.id}}"><strong ng-bind="task.name"></strong></a><br><small ng-bind="task.relationtype"></small></span>
								<div class="col-md-7">
									<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('startdate'); ?> <i class="ion-ios-stopwatch-outline"></i></small><br><strong ng-bind="task.startdate"></strong></span>
									</div>
									<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('duedate'); ?> <i class="ion-ios-timer-outline"></i></small><br><strong ng-bind="task.duedate"></strong></span>
									</div>
									<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('status'); ?> <i class="ion-ios-circle-outline"></i></small><br><strong ng-bind="task.status"></strong></span>
									</div>
									<div class="col-md-3 text-right">
										<a ng-href="<?php echo base_url('tasks/task/') ?>{{task.id}}" class="edit-task pull-right"><i class="ion-compose"></i></a>
									</div>
								</div>
							</li>
						</ul>
					</li>
					<div ng-show="!tasks.length" class="text-center"><img width="50%" src="<?php echo base_url('assets/img/noresult.png') ?>" alt=""></div>
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
	</div>
<div id="newtask" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog modal-lg">
	<?php echo form_open_multipart('tasks/create',array()); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title"><?php echo lang('createnewtask'); ?></h3>
			</div>
			<div class="col-md-6 md-pr-0">
				<div class="modal-body md-pr-5">
					<div class="form-group">
						<label for="title"><?php echo lang('title'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
							<input ng-model="name" required type="text" name="name" value="" class="form-control name" placeholder="<?php echo lang('title'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="title"><?php echo lang('hourlyrate'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-social-usd"></i></span>
							<input ng-model="hourly_rate" required type="text" name="hourly_rate" value="" class="form-control hourly_rate input-money-format" placeholder="Hourly Rate like $23"/>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('startdate'); ?></label>
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input ng-model="startdate" placeholder="<?php echo date(" d.m.Y "); ?>" required type='input' name="startdate" value="" class="form-control startdate" name="start_date"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 md-pl-0">
				<div class="modal-body md-pl-5">
					<div class="form-group">
						<label for="customer"><?php echo lang('assigned'); ?></label>
						<div class="add-on-edit">
							<select required name="assigned" ng-model="assigned" class="form-control select2 assigned">
								<option value=""><?php echo lang('staff'); ?></option>
								<option ng-repeat="staff in staff" value="{{staff.id}}" ng-bind="staff.name"></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="customer"><?php echo lang('priority'); ?></label>
						<div class="add-on-edit">
							<select name="priority" ng-model="priority" class="form-control select2 priority">
								<option value=""><?php echo lang('select'); ?></option>
								<option value="2"><?php echo lang('high'); ?></option>
								<option value="1"><?php echo lang('medium'); ?></option>
								<option value="0"><?php echo lang('low'); ?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('duedate'); ?></label>
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input ng-model="duedate" placeholder="<?php echo date(" d.m.Y "); ?>" required type='input' name="duedate" value="1" class="form-control duedate" id="date"/>
						</div>
					</div>
					
				</div>
			</div>
			<div class="col-md-12 md-pt-0">
				<div class="form-group col-md-3">
					<label for="customer"><?php echo lang('relationtype'); ?></label>
					<div class="add-on-edit">
						<select disabled ng-model="relation_type" class="form-control select2 relation_type">
							<option selected value=""><?php echo lang('project'); ?></option>
						</select>
					</div>
					<input type="hidden" name="relation_type" value="project">
				</div>
				<div class="form-group col-md-5">
					<label for="project"><?php echo lang('selectproject'); ?></label>
					<div class="add-on-edit">
						<select required name="relation" class="form-control relation" class="form-control" ng-model="projects[$index]" ng-options="project as project.name for project in projects track by project.id"></select>
					</div>
				</div>
				<div class="form-group col-md-4">
					<label for="project"><?php echo lang('selectmilestone'); ?></label>
					<div class="add-on-edit">
						<select name="milestone" class="form-control milestone" class="form-control" ng-model="milestones[$index]" ng-options="milestone as milestone.name for milestone in projects[$index].milestones track by milestone.id"></select>
					</div>
				</div>
			</div>
			<div class="col-md-12 md-pt-0">
				<div class="modal-body md-pt-0">
					<div class="form-group">
					<label for="description"><?php echo lang('description'); ?></label>
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
							<textarea ng-model="description" name="description" class="form-control pdesc" id="description" placeholder="Description"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				<div class="ciuis-body-checkbox has-success pull-left">
						<input name="public" class="success-check" id="publivs" type="checkbox" value="1">
						<label for="publivs">
							<?php echo lang('public');?>
						</label>
					</div>
					<div class="ciuis-body-checkbox has-primary pull-left md-ml-20">
						<input name="billable" class="primary-check" id="billable" type="checkbox" value="1">
						<label for="billable"><?php echo lang('billable'); ?></label>
					</div>
					<div class="ciuis-body-checkbox has-primary pull-left md-ml-20">
						<input name="visible" class="primary-check" id="visible" type="checkbox" value="1">
						<label for="visible"><?php echo lang('visiblecustomer'); ?></label>
					</div>
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
					<button type="submit" class="btn btn-default"><?php echo lang('save'); ?></button>
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>
	</div>
</div>
</div>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>