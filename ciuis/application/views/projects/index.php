<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Projects_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="col-md-12 md-p-0 md-mb-10">
			<div class="btn-group">
				<button type="button" class="active pbtn btn btn-xl btn-default" id="all"><img height="28" src="{{IMAGESURL}}all_projects.png">  <?php echo lang('showall'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default" id="notstarted"><img height="28" src="{{IMAGESURL}}notstarted.png">  <?php echo lang('notstarted'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default" id="started"><img height="28" src="{{IMAGESURL}}started.png">  <?php echo lang('started'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default" id="percentage"><img height="28" src="{{IMAGESURL}}percentage.png">  <?php echo lang('percentage'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default" id="cancelled"><img height="28" src="{{IMAGESURL}}cancelled.png">  <?php echo lang('cancelled'); ?></button>
				<button type="button" class="btn btn-xl pbtn btn-default text-success" id="complete"><img height="28" src="{{IMAGESURL}}complete.png">  <?php echo lang('complete'); ?></button>
			</div>
			<div class="btn-group btn-hspace pull-right">
			<button data-target="#createnew" data-toggle="modal" type="button" class="btn btn-default btn-xl"><?php echo lang('create'); ?> <span class="ion-plus-round"></span></button>
			</div>
		</div>
		<div class="row">
			<div id="ciuisprojectcard" style="padding-left: 15px;padding-right: 5px;">
				<div ng-repeat="project in projects | pagination : currentPage*itemsPerPage | limitTo: 6" class="col-md-4 {{project.status_class}}" style="padding-left: 0px;padding-right: 10px;">
					<div id="project-card" class="ciuis-project-card">
						<div class="ciuis-project-content">
							<div class="ciuis-content-header">
								<div class="pull-left">
									<p class="md-m-0" style="font-size: 14px;font-weight: 900">
										<a href="<?php echo base_url('/projects/project/') ?>{{project.id}}" ng-bind="project.name"></a>
									</p>
									<small ng-bind="project.customer"></small>
								</div>
								<div class="pull-right md-pr-10">
									<i ng-click='CheckPinned($index)' data-toggle="tooltip" data-placement="bottom" data-container="body" title="" data-original-title="Pin Project" class="ciuis-project-badge pull-right ion-pin"></i>
									<img data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{project.status}}" class="pull-right md-mr-5" height="32" src="{{IMAGESURL}}{{project.status_icon}}">
								</div>
							</div>
							<div class="ciuis-project-dates">
								<div class="ciuis-project-start text-uppercase"><strong><?php echo lang('start'); ?></strong><b ng-bind="project.startdate"></b></div>
								<div class="ciuis-project-end text-uppercase"><strong><?php echo lang('deadline'); ?></strong><b ng-bind="project.leftdays"></b></div>
							</div>
							<div class="ciuis-project-stat col-md-12">
								<div class="col-md-6 bottom-left">
									<div class="progress-widget">
										<div class="progress-data text-left"><span class="progress-value" ng-bind="project.progress+'%'"></span>
										<span class="name" ng-bind="project.status"></span>
										</div>
										<div class="progress" style="height: 7px">
											<div style="width: {{project.progress}}%;" class="progress-bar progress-bar-primary"></div>
										</div>
									</div>
								</div>
								<div class="col-md-6 md-p-0 bottom-right text-right">
									<ul class="more-avatar">
										<li ng-repeat="member in project.members" data-toggle="tooltip" data-placement="left" data-container="body" title="" data-original-title="{{member.staffname}}">
											<div style=" background: lightgray url({{UPIMGURL}}{{member.staffavatar}}) no-repeat center / cover;"></div>
										</li>
										<div class="assigned-more-pro hidden"><i class="ion-plus-round"></i>2</div>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div>
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
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0">
		<div class="projects-graph">
			<div class="col-md-12" style="padding: 0px;">
				<div class="panel-default">
					<div class="panel-heading panel-heading-divider xs-pb-15 text-center text-bold" style="margin: 0px;"><?php echo lang('completions'); ?></div>
					<div class="panel-body" style="padding: 0px;">
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.not_started_percent+'%'"></span>
								<span class="project-name"><?php echo lang('notstarted'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.not_started_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.started_percent+'%'"></span>
								<span class="project-name"><?php echo lang('started'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.started_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.percentage_percent+'%'"></span>
								<span class="project-name"><?php echo lang('percentage'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.percentage_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.cancelled_percent+'%'"></span>
								<span class="project-name"><?php echo lang('cancelled'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.cancelled_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
						<div class="project-stats-body pull-left">
							<div class="project-progress-data">
								<span class="project-progress-value pull-right" ng-bind="stats.complete_percent+'%'"></span>
								<span class="project-name"><?php echo lang('complete'); ?></span>
							</div>
							<div class="progress" style="height: 5px">
								<div style="width: {{stats.complete_percent}}%;" class="progress-bar progress-bar-success"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 pinnedprojects">
			<div class="panel-default">
				<div class="pinned-projects-header">
					<span><i class="ion-pin"></i> <?php echo lang('pinnedprojects'); ?></span>
					<span class="pull-right hide-pinned-projects"><a data-toggle="collapse" data-parent="#pinned-projects" href="#pinned-projects"><i class="icon mdi ion-minus-circled"></i></a></span>
				</div>
				<div id="pinned-projects" class="panel-collapse collapse in">
					<div class="pinned-projects">
						<div ng-repeat="project_pinned in pinnedprojects | filter: { pinned: '1' }" class="pinned-project-widget">
							<div class="pinned-project-body pull-left">
								<div class="project-progress-data">
									<span class="project-progress-value pull-right" ng-bind="project_pinned.progress+'%'"></span>
									<span class="project-name" ng-bind="project_pinned.name"></span>
								</div>
								<div class="progress" style="height: 5px">
									<div style="width:{{project_pinned.progress}}%;" class="progress-bar progress-bar-info"></div>
								</div>
							</div>
							<a ng-click='UnPinned($index)' class="pinned-project-action pull-right"><i class="ion-close-round"></i></a>
							<a href="<?php echo base_url('projects/project/')?>{{project_pinned.id}}" class="pinned-project-action pull-right"><i class="ion-android-open"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="createnew" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title"><?php echo lang('createproject'); ?></h3>
			</div>
			<div class="col-md-6 md-pr-0">
				<div class="modal-body md-pr-5">
					<div class="form-group">
						<label for="title"><?php echo lang('name'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
							<input ng-model="pname" type="text" name="pname" value="" class="form-control pname" placeholder="<?php echo lang('name'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('startdate'); ?></label>
						<datepicker date-format="yyyy-MM-dd" selector="form-control">
							<div class="input-group">
								<input required ng-model="pstart" class="form-control" placeholder="<?php echo lang('chooseadate')?>"/>
								<span class="input-group-addon" style="cursor: pointer">
								<i class="icon-th mdi mdi-calendar"></i>
								</span>
							</div>
						</datepicker>
					</div>
				</div>
			</div>
			<div class="col-md-6 md-pl-0">
				<div class="modal-body md-pl-5">
					<div class="form-group">
						<label for="customer"><?php echo lang('choisecustomer'); ?></label>
						<div class="add-on-edit">
							<select required id="pcustomer" ng-model="pcustomer" class="form-control pcustomer">
								<option value=""><?php echo lang('choisecustomer'); ?></option>
								<option ng-repeat="customer in all_customers" value="{{customer.id}}" ng-bind="customer.name"></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('deadline'); ?></label>
						<datepicker date-format="yyyy-MM-dd" selector="form-control">
							<div class="input-group">
								<input required ng-model="pdeadline" class="form-control" placeholder="<?php echo lang('chooseadate')?>"/>
								<span class="input-group-addon" style="cursor: pointer">
								<i class="icon-th mdi mdi-calendar"></i>
								</span>
							</div>
						</datepicker>
					</div>
				</div>
			</div>
			<div class="col-md-12 md-pt-0">
				<div class="modal-body">
					<div class="form-group">
					<label for="description"><?php echo lang('description'); ?></label>
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
							<textarea ng-model="pdescription" name="description" class="form-control pdesc" id="description" placeholder="Description"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
					<button ng-click="AddProject()" class="btn btn-default"><?php echo lang('save'); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>