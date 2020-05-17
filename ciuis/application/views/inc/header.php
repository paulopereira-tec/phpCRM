<!DOCTYPE html>
<html ng-app="Ciuis" lang="<?php echo lang('language_datetime'); ?>">
<head>
   	<script src="<?php echo base_url('assets/lib/angular/angular.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/angular-animate.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/angular-aria.min.js'); ?>"></script>
   	<script src="<?php echo base_url('assets/lib/angular/i18n/angular-locale_en-us.js'); ?>"></script>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="description" content="With Ciuis CRM you can easily manage your customer relationships and save time on your business.">
	<link rel="shortcut icon" href="<?php echo base_url(); ?>assets/img/logo-fav.png">
	<title><?php echo $title; ?></title>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/perfect-scrollbar/css/perfect-scrollbar.min.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/material-design-icons/css/material-design-iconic-font.min.css'); ?>"/>
	<!--[if lt IE 9]>
	<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
	<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/datetimepicker/css/bootstrap-datetimepicker.min.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/angular-datepicker/src/css/angular-datepicker.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/jquery.gritter/css/jquery.gritter.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/select2/css/select2.min.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/ciuis.css'); ?>" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/material/angular-material.min.css'); ?>"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/animate/animate.css'); ?>" type="text/css"/>
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/ionicons/css/ionicons.min.css'); ?>" rel="stylesheet">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/lib/bootstrap-slider/css/bootstrap-slider.css'); ?>"/>
	<script>
      var BASE_URL = "<?php echo base_url(); ?>";
      var ACTIVESTAFF = "<?php echo $this->session->userdata('logged_in_staff_id'); ?>";
      var HAS_MENU_PERMISSION = "<?php if (!if_admin) {echo "0";}?>";
      var SHOW_ONLY_ADMIN = "<?php if (!if_admin) {echo 'true';} else echo 'false';?>";
    </script>
</head>
<?php $settings = $this->Settings_Model->get_settings_ciuis(); ?>
<body ng-controller="Ciuis_Controller">
	<div id="ciuisloader"></div>
	<div class="ciuis-body-wrapper ciuis-body-fixed-sidebar">
		<nav class="navbar navbar-default navbar-fixed-top ciuis-body-top-header">
			<div class="container-fluid" style="margin-left: 60px">
				<div class="ciuis-body-right-navbar">
					<ul class="nav navbar-nav navbar-right ciuis-body-user-nav">
						<li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"> 
						<img src="<?php echo base_url('uploads/images/'); ?>{{user.staffavatar}}"><span class="user-name" ng-bind="user.staffname"></span></a>
							<ul role="menu" class="dropdown-menu animated fadeIn">
								<li><div class="user-info"><div class="user-name" ng-bind="user.staffname"></div></div></li>
								<li><a href="<?php echo base_url(); ?>staff/staffmember/{{user.id}}"><span class="icon ion-android-person"></span> <?php echo lang('profile')?></a></li>
								<li><a href="<?php echo base_url(); ?>staff/edit/{{user.id}}"><span class="icon ion-gear-a"></span> <?php echo lang('settings')?></a></li>
								<li><a href="<?php echo base_url();?>login/logout"><span class="icon ion-power"></span><?php echo lang('logout')?></a></li>
							</ul>
						</li>
					</ul>
					<div class="crm-name"><span ng-bind="settings.crm_name"></span></div>
					<ul class="ciuis-v3-menu hidden-xs">
					<li ng-repeat="nav in navbar  | orderBy:'order_id'"><a href="{{nav.url}}" ng-bind="nav.name"></a>
					  <ul ng-show="nav.sub_menu.length">
						<li ng-repeat="submenu in nav.sub_menu | orderBy:'order_id'">
						  <a ng-href="{{submenu.url}}">
						  <i class="icon {{submenu.icon}}"></i>
						  <span class="title" ng-bind="submenu.name"></span>
						  <span class="descr" ng-bind="submenu.description"></span>
						  </a>
						</li>
					  </ul>
					</li>
				  	</ul>
					<ul class="nav navbar-nav navbar-right ciuis-body-icons-nav">
						<li class="dropdown hidden-md hidden-lg open-menu"><a href=""><span class="ion-navicon-round"></span></a></li>
						<li ng-hide="ONLYADMIN != 'true'" class="dropdown"><a href="<?php echo base_url('settings/edit/ciuis') ?>"><span class="ion-ios-gear-outline"></span></a></li>
						<li class="dropdown">
							<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="ion-ios-paper-outline"></span></a>
							<ul class="dropdown-menu ciuis-body-connections animated fadeIn">
								<li>
									<div class="title"><?php echo lang('todo')?></div>
									<div class="list">
										<div class="ciuis-body-scroller">
											<div class="content ciuis-todo">
												<div class="row">
													<div class="input-group xs-mb-15">
														<input ng-model="tododetail" required name="tododet" type="text" class="form-control tododetail" placeholder="<?php echo lang('newtodo')?>">
														<span class="input-group-btn">
														<button ng-click="AddTodo()" type="button" class="btn btn-default ion-plus-round"></button>
														</span>
													</div>
												</div>
												<ul class="todo-item">
													<li ng-repeat="todo in todos | orderBy:'-id'" class="todo-alt-item todo">
														<div class="todo-c" style="display: grid;margin-top: 10px;">
															<div class="todo-item-header">
																<div class="btn-group-sm btn-space pull-right">
																	<button data-id='{{todo.id}}' ng-click='TodoAsDone($index)' class="btn btn-default btn-sm ion-checkmark"></button>
																	<button data-id='{{todo.id}}' ng-click='DeleteTodo($index)' class="btn btn-default btn-sm ion-trash-a"></button>
																</div>
																<span style="padding:5px;" class="pull-left label label-default" ng-bind="todo.date"></span>
															</div>
															<label ng-bind="todo.description"></label>
														</div>
													</li>
												</ul>
											</div>
											<div class="title"><?php echo lang('donetodo')?></div>
											<div class="content ciuis-todo">
												<ul class="todo-item-done">
													<li ng-class="{ 'donetodo-x' : todo.done }" ng-repeat="done in tododone | orderBy:'-id'" class="todo-alt-item-done todo">
														<div class="todo-c" style="display: grid;margin-top: 10px;">
															<div class="todo-item-header">
																<div class="btn-group-sm btn-space pull-right">
																	<button data-id='{{todo.id}}' ng-click='TodoAsUnDone($index)' class="btn btn-default btn-sm ion-refresh"></button>
																</div>
																<span style="padding:5px;" class="pull-left label label-success" ng-bind="done.date"></span>
															</div>
															<label ng-bind="done.description"></label>
														</div>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="footer"><a ng-click='AddEvent()' class="modaleventadd"><b><i class="ion-plus-round"> </i><?php echo lang('addevent')?></b></a></div>
								</li>
							</ul>
						</li>
						<li class="dropdown">
						<a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
						<span class="ion-ios-bell-outline"></span><span class="{{stats.newnotification}}"></span>
						</a>
							<ul class="dropdown-menu ciuis-body-notifications animated fadeIn">
								<li>
									<div class="title"><?php echo lang('notifications')?><span class="badge" ng-bind="stats.tbs"></span></div>
									<div class="list">
										<div class="ciuis-body-scroller">
											<div class="content">
												<ul>
													<li ng-repeat="ntf in notifications" class="notification notification{{ntf.biloku}}">
														<a ng-click='NotificationRead($index)' href="{{ntf.target}}">
															<div class="image"><img src="<?php echo base_url('uploads/images/'); ?>{{ntf.perres}}"></div>
															<div class="notification-info"><span ng-bind="ntf.detail"></span><span class="date" ng-bind="ntf.date"></span></div>
														</a>
													</li>
												</ul>
											</div>
										</div>
									</div>
									<div class="footer"><a href="#"><?php echo lang('close')?></a></div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</nav>
	<div class="ciuis-body-left-sidebar">
	<div class="vertical-nav-new-ciuis narrow hover">
		<div class="branding">
		  <div class="symbol">
			<a id="ciuis-logo-donder" href="{{appurl}}panel"><img width="34px" height="34px" src="<?php echo base_url('uploads/ciuis_settings/') ?>{{settings.logo}}" alt=""></a>
		  </div>
		  <div class="text ciuis-ver-menu-brand" ng-bind="settings.crm_name"></div>
		</div>
		<div class="primary-nav">
			<div class="slide one navigation">
				<div class="nav-top">   
					<div class="nav-list">
						<a ng-repeat="menu in menu" href="{{menu.url}}" class="nav-item" ng-if="menu.show_staff == '0'">
							<div class="icon"><i class="material-icons {{menu.icon}}"></i></div>
							<div class="text" ng-bind="menu.title"></div>
						</a> 
					</div>
				</div>
				<div class="nav-bottom">
					<div class="nav-list">
						<a href="{{appurl}}tasks" class="nav-item active">
							<div class="icon"><i class="material-icons ico-ciuis-tasks"></i></div>
							<div class="text text-uppercase"><?php echo lang('tasks');?></div>
						</a> 
					</div>
					<div ng-repeat="pinned in projects | limitTo:1" class="profile-util">
						<div class="chart">
						 <div class="donut">
							<desc><progress max="100" value="{{pinned.progress}}"></progress></desc>
						 </div>
						</div>
						<div class="text"><a href="<?php echo base_url('projects/project/')?>{{pinned.id}}" ng-bind="pinned.name"></a></div>
					 </div>
				</div>
			</div>
			<div class="slide two apps inactive">
			</div>
		</div>
	</div>
	</div>
	<div id="addevent" tabindex="-1" role="content" class="modal fade colored-header colored-header-success">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title"><?php echo lang('addevent')?></h3>
				</div>
				<div class="col-md-12">
					<div class="col-md-12 md-mt-20">
						<div class="form-group">
							<label for="title"><?php echo lang('title'); ?></label>
							<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
								<input ng-model="title" required type="text" name="title" value="" class="form-control" id="title" placeholder="Event Title"/>
							</div>
						</div>
					</div>
					<div class="col-md-12 md-pt-0">
						<div class="col-md-6 md-pl-0">
							<div class="form-group">
								<label for="start"><?php echo lang('start'); ?></label>
								<div data-start-view="3" data-date-format="yyyy-mm-dd - HH:ii" data-link-field="dtp_input1" class="input-group date datetimepicker">
								<span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
									<input ng-model="eventstart" required size="16" type="text" value="" class="form-control" placeholder="<?php echo date(" d.m.Y "); ?>">
								</div>
							</div>
						</div>
						<div class="col-md-6 md-pr-0">
							<div class="form-group">
								<label for="end"><?php echo lang('end'); ?></label>
								<div data-start-view="3" data-date-format="yyyy-mm-dd - HH:ii" data-link-field="dtp_input1" class="input-group date datetimepicker">
								<span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
									<input ng-model="eventend" required size="16" type="text" value="" class="form-control" placeholder="<?php echo date(" d.m.Y "); ?>">
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12 md-pt-0">
					<div class="col-md-12">
						<div class="form-group">
							<label for="description"><?php echo lang('description'); ?></label>
							<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
								<textarea ng-model="detail" required name="eventdetail" class="form-control" id="description" placeholder="Description"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<div class="ciuis-body-checkbox has-primary pull-left">
							<input ng-model="public" name="public" class="ci-public-check" id="public" type="checkbox" value="1">
							<label for="public"><?php echo lang('publicevent');?></label>
						</div>
						<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
						<button ng-click="PostEventForm()" class="btn btn-default postevent"><?php echo lang('save'); ?></button>
					</div>
				</div>
			</div>
		</div>
	</div>