<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Leads_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
		<div class="col-md-12 borderten md-p-0">
			<div class="main-content container-fluid col-xs-12 col-md-3 col-lg-3 md-pl-0 lead-left-bar">
				<div class="panel-default panel-table borderten lead-manager-head">
					<div class="col-md-12 col-xs-12 border-right" style="margin-bottom: 10px;border-bottom: 2px dashed #cecece;padding-bottom: 20px;">
						<div class="tasks-status-stat">
							<h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number"><?php echo $tcl ?></span><span class="task-stat-all"> / <?php echo $tlh ?> <?php echo lang('lead') ?></span></h3>
							<span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: 40%;"></span> </span>
						</div>
						<span style="color:#989898"><?php echo lang('leadconverted') ?></span>
					</div>
					<div class="widget-chart-container" style="border-bottom: 2px dashed #e8e8e8; margin-bottom: 20px; padding-bottom: 20px;">
						<div class="widget-counter-group widget-counter-group-right">
							<div style="width: auto" class="pull-left">
								<i style="font-size: 38px;color: #bfc2c6;margin-right: 10px" class="ion-stats-bars pull-left"></i>
								<div class="pull-right" style="text-align: left;margin-top: 10px;line-height: 10px;">
									<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('leadsbyleadsource') ?></b></h4>
									<small><?php echo lang('leadstatsbysource') ?></small>
								</div>
							</div>
						</div>
						<div class="my-2">
							<div class="chart-wrapper">
								<canvas id="leads_by_leadsource"></canvas>
							</div>
						</div>
					</div>
					<div class="col-md-12 text-center">
						<a data-target="#addlead" data-toggle="modal" type="button" class="btn create-lead"><i class="ion-ios-personadd-outline"></i><br><?php echo lang('create') ?><br><?php echo lang('lead') ?></a>
					</div>
				</div>
			</div>
			<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0 lead-right-bar" style="display: none">
				<div class="panel panel-default panel-table lead-manager-head">
					<div class="panel-heading">
						<div class="btn-group col-md-12 md-pr-0 md-pl-0 md-pb-10">
							<button data-target="#addlead" data-toggle="modal" class="btn  btn-default btn-big col-md-4"><i class="icon ion-ios-personadd-outline"></i> <?php echo lang('lead')?> </button>
							<button data-target="#add_status" data-toggle="modal" class="btn  btn-default btn-big col-md-4"><i class="icon ion-ios-plus-outline"></i> <?php echo lang('status')?> </button>
							<button data-target="#add_source" data-toggle="modal" class="btn  btn-default btn-big col-md-4"><i class="icon ion-ios-plus-outline"></i> <?php echo lang('source')?> </button>
						</div>&nbsp;
						<a href="<?php echo base_url('leads/kanban')?>" class="btn btn-lg btn-default show-kanban col-md-12 hidden">
							<?php echo lang('showkanban');?>
						</a>
					</div>
					<div class="panel-body lead-manager">
						<table id="table" class="table table-striped table-hover table-fw-widget">
							<thead>
								<tr class="text-muted">
									<th>
										<?php echo lang('leadssources')?>
									</th>
									<th class="text-right"></th>
								</tr>
							</thead>
							<?php foreach($leadssources as $source){ ?>
							<tr>
								<td>
									<b class="text-muted">
										<?php echo $source['name']; ?>
									</b>
								</td>
								<td class="pull-right" style="padding-top:7px;">
									<button type="button" data-target="#update_source<?php echo $source['id']; ?>" data-toggle="modal" data-placement="left" title="" class="btn btn-default" data-original-title="Update Source"><i class="ion-ios-compose"></i></button>
									<a href="<?php echo site_url('leads/removesource/'.$source['id']); ?>"><button class="btn btn-default"><i class="ion-ios-trash"></i></button></a>
								</td>
							</tr>
							<?php } ?>
						</table>
						<table id="table" class="table table-striped table-hover table-fw-widget">
							<thead>
								<tr class="text-muted">
									<th>
										<?php echo lang('leadsstatuses')?>
									</th>
									<th class="text-right"></th>
								</tr>
							</thead>
							<?php foreach($leadsstatuses as $status){ ?>
							<tr>
								<td>
									<b class="text-muted">
										<?php echo $status['name']; ?>
									</b>
								</td>
								<td class="pull-right" style="padding-top:7px;">
									<button type="button" data-target="#update_status<?php echo $status['id']; ?>" data-toggle="modal" data-placement="left" title="" class="btn btn-default" data-original-title="Update Expense Category"><i class="ion-ios-compose"></i></button>
									<a href="<?php echo site_url('leads/removestatus/'.$status['id']); ?>"><button class="btn btn-default"><i class="ion-ios-trash"></i></button></a>
								</td>
							</tr>
							<?php } ?>
						</table>
						<br>
					</div>
					<div class="hide-lead-settings ion-ios-arrow-forward"></div>
				</div>
			</div>
			<div class="main-content container-fluid col-xs-12 col-md-9 col-lg-9 md-p-0 lead-table">
				<div style="border-radius: 10px;" class="panel-default panel-table">
					<div class="panel-heading">
						<strong><?php echo lang('leads'); ?></strong>
						<div class="pull-right">
							<!-- Filter Area -->
							<div class="btn-group btn-hspace pull-right">
							  <button type="button" data-toggle="dropdown" class="dropdown-toggle btn-xl filter-button"><i class="icon-left ion-funnel"></i></button>
							  <ul class="dropdown-menu ciuis-body-connections pull-right ciuis-custom-filter">
							   <div ng-repeat="(prop, ignoredValue) in leads[0]" ng-init="filter[prop]={}" ng-if="prop != 'name' && prop != 'id' && prop != 'company' && prop != 'phone' && prop != 'color' && prop != 'status' && prop != 'source' && prop != 'assigned' && prop != 'avatar' && prop != 'staff' && prop != 'createddate' && prop != 'statusname' && prop != 'sourcename'">
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
							<div class="lead-settings md-mr-5"><span><i class="ion-ios-gear"></i> <?php echo lang('settings') ?></span></div>
							<div class="counter counter-big pull-right md-mr-10 label md-p-10 label-default label-lead-area-stat">
								<div class="value">
									<span class="text-danger">
										<?php echo $tll ?>
									</span>
								</div>
								<div class="desc text-uppercase"><?php echo lang('lost') ?></div>
							</div>
							<div class="counter counter-big pull-right md-mr-10 label md-p-10 label-default label-lead-area-stat">
								<div class="value">
									<span class="text-success">
										<?php echo $tjl ?>
									</span>
								</div>
								<div class="desc text-uppercase"><?php echo lang('junk') ?></div>
							</div>
							<div class="ciuis-external-search-in-table">
								<input ng-model="search.name" class="search-table-external" id="search" name="search" type="text" placeholder="<?php echo lang('searchword')?>">
								<i class="ion-ios-search"></i>
							</div>
						</div>
						<span class="panel-subtitle">
							<?php echo lang('leaddesc'); ?>
						</span>
					</div>
					<div class="panel-body">
						<ul class="custom-ciuis-list-body" style="padding: 0px;">
							<li ng-repeat="lead in leads | filter: FilteredData | filter:search | pagination : currentPage*itemsPerPage | limitTo: 5" class="ciuis-custom-list-item ciuis-special-list-item">
								<ul class="list-item-for-custom-list">
									<li class="ciuis-custom-list-item-item col-md-12">
										<div data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="Assigned: {{lead.assigned}}" class="assigned-staff-for-this-lead user-avatar"><img src="<?php echo base_url('uploads/images/{{lead.avatar}}')?>" alt="{{lead.assigned}}">
										</div>
										<div class="pull-left col-md-6"><a ng-href="<?php echo base_url('leads/lead/')?>{{lead.id}}"><strong ng-bind="lead.name"></strong></a><br>
										<small ng-bind="lead.company"></small>
										</div>
										<div class="col-md-6">
											<div class="col-md-5"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('phone') ?> <i class="ion-ios-stopwatch-outline"></i></small><br><strong ng-bind="lead.phone"></strong></span>
											</div>
											<div class="col-md-4"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('status') ?> <i class="ion-ios-circle-filled"></i></small><br><strong><span class="badge" style="border-color: #fff;background-color: {{lead.color}};" ng-bind="lead.statusname"></span></strong></span>
											</div>
											<div class="col-md-3"><span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('source') ?> <i class="ion-ios-circle-filled"></i></small><br><strong><span class="badge" ng-bind="lead.sourcename"></span></strong></span>
											</div>
										</div>
									</li>
								</ul>
							</li>
						</ul>
						<?php if (empty( $leads)) { echo '<img src="'.base_url('assets/img/no_lead.png').'" alt="">';}?>
						
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
				<div data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="Import Leads" class="btn-group btn-space pull-right">
					<div type="button" class="ion-ios-cloud-upload-outline import-lead" data-target="#import-lead" data-toggle="modal"></div>
				</div>
			</div>
		</div>
	</div>
	<div id="add_status" tabindex="-1" role="content" class="modal fade colored-header colored-header-success">
		<div class="modal-dialog">
			<?php echo form_open('leads/add_status'); ?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title">
						<?php echo lang('addstatus')?>
					</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">
							<?php echo lang('name'); ?>
						</label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-navicon"></i></span>
							<input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="name" placeholder="name"/>
						</div>
					</div>
					<div class="form-group">
						<label for="name">
							<?php echo lang('color'); ?>
						</label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-navicon"></i></span>
							<input type="text" name="color" value="<?php echo $this->input->post('color'); ?>" class="form-control" id="color" placeholder="color"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
						<?php echo lang('cancel'); ?>
					</button>
					<button type="submit" class="btn btn-default">
						<?php echo lang('save'); ?>
					</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<div id="import-lead" tabindex="-1" role="content" class="modal fade">
		<div class="modal-dialog">
			<?php echo form_open_multipart('leads/importcsv'); ?>
			<div class="modal-content">
				<div class="modal-header" style="border: 0; padding: 19px; border-bottom: 1px solid #e4e4e4; background: white;">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title">
						<?php echo lang('importleads')?>
					</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">
							<?php echo lang('choosecsvfile'); ?>
						</label>
						<div class="file-upload">
							<div class="file-select">
								<div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span>
									<?php echo lang('attachment')?>
								</div>
								<div class="file-select-name" id="noFile">
									<?php echo lang('notchoise')?>
								</div>
								<input type="file" name="userfile" id="chooseFile">
							</div>
						</div>
					</div>
					<div class="col-md-12 form-group md-p-0">

						<div class="col-md-6 md-p-0">
							<label for="importsource">
								<?php echo lang('source');?>
							</label>
							<select required name="importsource" class="select2">
								<option>
									<?php echo lang('source');?>
								</option>
								<?php
								foreach ( $leadssources as $source ) {
									$selected = ( $source[ 'id' ] == $this->input->post( 'importsource' ) ) ? ' selected="selected"' : null;
									echo '<option value="' . $source[ 'id' ] . '" ' . $selected . '>' . $source[ 'name' ] . '</option>';
								}
								?>
							</select>
						</div>
						<div class="col-md-6 md-pr-0">
							<label for="importstatus">
								<?php echo lang('status');?>
							</label>
							<select required name="importstatus" class="select2">
								<option>
									<?php echo lang('status');?>
								</option>
								<?php
								foreach ( $leadsstatuses as $status ) {
									$selected = ( $status[ 'id' ] == $this->input->post( 'importstatus' ) ) ? ' selected="selected"' : null;
									echo '<option value="' . $status[ 'id' ] . '" ' . $selected . '>' . $status[ 'name' ] . '</option>';
								}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="importassigned">
							<?php echo lang('assignedstaff');?>
						</label>
						<select required name="importassigned" class="select2">
						<option value="<?php echo $this->session->userdata('logged_in_staff_id'); ?>"><?php echo lang('me');?></option>
						<?php
						foreach ( $all_staff as $staff ) {
							$selected = ( $staff[ 'id' ] == $this->input->post( 'importassigned' ) ) ? ' selected="selected"' : null;
							echo '<option value="' . $staff[ 'id' ] . '" ' . $selected . '>' . $staff[ 'staffname' ] . '</option>';
						}
						?>
					</select>
					

					</div>
					<div class="well well-sm">
						<?php echo lang('importcustomerinfo'); ?>
					</div>
				</div>
				<div class="modal-footer">
					<a href="<?php echo base_url('uploads/samples/leadimport.csv')?>" class="btn btn-success pull-left">
						<?php echo lang('downloadsample'); ?>
					</a>
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
						<?php echo lang('cancel'); ?>
					</button>
					<button type="submit" class="btn btn-default">
						<?php echo lang('save'); ?>
					</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<div id="add_source" tabindex="-1" role="content" class="modal fade colored-header colored-header-success">
		<div class="modal-dialog">
			<?php echo form_open('leads/add_source'); ?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title">
						<?php echo lang('addsource')?>
					</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">
							<?php echo lang('name'); ?>
						</label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-navicon"></i></span>
							<input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="name" placeholder="name"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
						<?php echo lang('cancel'); ?>
					</button>
					<button type="submit" class="btn btn-default">
						<?php echo lang('save'); ?>
					</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<div id="addlead" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-success">
		<?php echo form_open('leads/add',array("class"=>"form-vertical")); ?>
		<div style="width: 70%;" class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title">
						<?php echo lang('newlead');?>
					</h3>
					<span>
						<?php echo lang('newleaddesc');?>
					</span>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-md-6 col-lg-4">
							<div id="" class="form-group company">
								<label class="">
									<?php echo lang('name')?>
								</label>
								<div class="input-group"><span class="input-group-addon"><i class="mdi ion-information"></i></span>
									<input type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="name"/>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="title">
									<?php echo lang('title');?>
								</label>
								<div class="input-group"><span class="input-group-addon"><i class="mdi ion-information"></i></span>
									<input type="text" name="title" value="<?php echo $this->input->post('title'); ?>" class="form-control" id="title"/>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-4">
							<div id="" class="form-group company">
								<label for="company">
									<?php echo lang('company');?>
								</label>
								<div class="input-group"><span class="input-group-addon"><i class="mdi ion-briefcase"></i></span>
									<input type="text" name="company" value="<?php echo $this->input->post('company'); ?>" class="form-control" id="company"/>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="description">
									<?php echo lang('description');?>
								</label>
								<div class="input-group"><span class="input-group-addon"><i class="mdi ion-navicon-round"></i></span>
									<input type="text" name="description" value="<?php echo $this->input->post('description'); ?>" class="form-control" id="description"/>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="assigned">
									<?php echo lang('assignedstaff');?>
								</label>
								<select required name="assigned" class="select2">
								<option value="<?php echo $this->session->userdata('logged_in_staff_id'); ?>"><?php echo lang('me');?></option>
								<?php
								foreach ( $all_staff as $staff ) {
									$selected = ( $staff[ 'id' ] == $this->input->post( 'assigned' ) ) ? ' selected="selected"' : null;
									echo '<option value="' . $staff[ 'id' ] . '" ' . $selected . '>' . $staff[ 'staffname' ] . '</option>';
								}
								?>
							</select>
							

							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="phone">
									<?php echo lang('phone');?>
								</label>
								<div class="input-group "><span class="input-group-addon"><i class="mdi mdi-phone"></i></span>
									<input type="text" name="phone" value="<?php echo $this->input->post('phone'); ?>" class="form-control" id="phone"/>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6 col-lg-4 md-p-0">
							<div class="form-group">
								<div class="col-md-6 md-pr-0">
									<label for="source">
										<?php echo lang('source');?>
									</label>
									<select required name="source" class="select2">
										<option>
											<?php echo lang('source');?>
										</option>
										<?php
										foreach ( $leadssources as $source ) {
											$selected = ( $source[ 'id' ] == $this->input->post( 'source' ) ) ? ' selected="selected"' : null;
											echo '<option value="' . $source[ 'id' ] . '" ' . $selected . '>' . $source[ 'name' ] . '</option>';
										}
										?>
									</select>
								</div>
								<div class="col-md-6">
									<label for="status">
										<?php echo lang('status');?>
									</label>
									<select required name="status" class="select2">
										<option>
											<?php echo lang('status');?>
										</option>
										<?php
										foreach ( $leadsstatuses as $status ) {
											$selected = ( $status[ 'id' ] == $this->input->post( 'status' ) ) ? ' selected="selected"' : null;
											echo '<option value="' . $status[ 'id' ] . '" ' . $selected . '>' . $status[ 'name' ] . '</option>';
										}
										?>
									</select>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="email">
									<?php echo lang('email');?>
								</label>
								<div class="input-group"><span class="input-group-addon">@</span>
									<input required type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control" id="email"/>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-4">
							<div class="form-group">
								<label for="website">
									<?php echo lang('website');?>
								</label>
								<div class="input-group"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
									<input type="text" name="website" value="<?php echo $this->input->post('website'); ?>" class="form-control" id="website"/>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label for="address">
									<?php echo lang('address');?>
								</label>
								<textarea name="address" class="form-control">
									<?php echo $this->input->post('address'); ?>
								</textarea>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-xs-12 col-md-6 col-lg-3">
							<div class="form-group">
								<label for="country">
									<?php echo lang('country');?>
								</label>
								<select required name="country" class="select2">
									<option>
										<?php echo lang('country');?>
									</option>
									<option ng-repeat="country in countries" value="{{country.id}}">{{country.shortname}}</option>
								</select>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-3">
							<div class="form-group">
								<label for="state">
									<?php echo lang('state');?>
								</label>
								<div class="input-group"><span class="input-group-addon"><i class="mdi ion-location"></i></span>
									<input type="text" name="state" value="<?php echo $this->input->post('state'); ?>" class="form-control" id="state"/>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-3">
							<div class="form-group">
								<label for="city">
									<?php echo lang('city');?>
								</label>
								<div class="input-group"><span class="input-group-addon"><i class="mdi ion-location"></i></span>
									<input type="text" name="city" value="<?php echo $this->input->post('city'); ?>" class="form-control" id="city"/>
								</div>
							</div>
						</div>
						<div class="col-xs-12 col-md-6 col-lg-3">
							<div class="form-group">
								<label for="zip">
									<?php echo lang('zip');?>
								</label>
								<div class="input-group"><span class="input-group-addon"><i class="mdi ion-pound"></i></span>
									<input type="text" name="zip" value="<?php echo $this->input->post('zip'); ?>" class="form-control" id="zip"/>
								</div>
							</div>
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
						<input name="type" class="primary-check" id="type" type="checkbox" value="1">
						<label for="type">
							<?php echo lang('individuallead');?>
						</label>
					</div>
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
	<?php foreach($leadssources as $source){ ?>
	<div id="update_source<?php echo $source['id']; ?>" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
		<div class="modal-dialog">
			<?php echo form_open('leads/update_source/'.$source['id']); ?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title">
						<?php echo lang('updatesource'); ?>
					</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">
							<?php echo lang('name'); ?>
						</label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-navicon"></i></span>
							<input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $source['name']); ?>" class="form-control" id="name" placeholder="name"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
						<?php echo lang('cancel'); ?>
					</button>
					<button type="submit" class="btn btn-default">
						<?php echo lang('save'); ?>
					</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<?php } ?>
	<?php foreach($leadsstatuses as $status){ ?>
	<div id="update_status<?php echo $status['id']; ?>" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
		<div class="modal-dialog">
			<?php echo form_open('leads/update_status/'.$status['id']); ?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title">
						<?php echo lang('updatestatus'); ?>
					</h3>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<label for="name">
							<?php echo lang('name'); ?>
						</label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-navicon"></i></span>
							<input type="text" name="name" value="<?php echo ($this->input->post('name') ? $this->input->post('name') : $status['name']); ?>" class="form-control" id="name" placeholder="name"/>
						</div>
					</div>
					<div class="form-group">
						<label for="color">
							<?php echo lang('color'); ?>
						</label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-navicon"></i></span>
							<input type="text" name="color" value="<?php echo ($this->input->post('color') ? $this->input->post('color') : $status['color']); ?>" class="form-control" id="color" placeholder="color"/>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
						<?php echo lang('cancel'); ?>
					</button>
					<button type="submit" class="btn btn-default">
						<?php echo lang('save'); ?>
					</button>
				</div>
			</div>
			<?php echo form_close(); ?>
		</div>
	</div>
	<?php } ?>
	
</div>
	
	<?php include_once( APPPATH . 'views/inc/footer.php' );?>

	<script>
		new Chart( $( '#leads_by_leadsource' ), {
			type: 'horizontalBar',
			data: <?php echo $leads_by_leadsource; ?>,
			options: {
				legend: {
					display: false,
				}
			}
		} );
	</script>