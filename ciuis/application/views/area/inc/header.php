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
      var ACTIVESTAFF = "<?php echo $_SESSION[ 'logged_in' ] ?>";
	  var HAS_MENU_PERMISSION = "false";
	  var SHOW_ONLY_ADMIN = "false";
    </script>
</head>
<?php $settings = $this->Settings_Model->get_settings_ciuis(); ?>
<?php $newnotification = $this->Area_Model->newnotification(); ?>
<body ng-controller="Area_Controller">
	<div id="ciuisloader"></div>
	<div class="ciuis-body-wrapper ciuis-body-fixed-sidebar">
		<nav class="navbar navbar-default navbar-fixed-top ciuis-body-top-header">
			<div class="container-fluid" style="margin-left: 60px">
				<div class="ciuis-body-right-navbar">
					<ul class="nav navbar-nav navbar-right ciuis-body-user-nav">
						<li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"> <img src="<?php echo base_url('assets/img/customer_avatar.png'); ?>"><span class="user-name"><?php echo $_SESSION[ 'name' ] ?> <?php echo $_SESSION[ 'surname' ] ?></span></a>
							<ul role="menu" class="dropdown-menu animated fadeIn">
								<li>
									<div class="user-info">
										<div class="user-name"><?php echo $_SESSION[ 'name' ] ?> <?php echo $_SESSION[ 'surname' ] ?></div>
									</div>
								</li>
								<li><a href="<?php echo base_url('area/logout');?>"><span class="icon mdi mdi-power"></span><?php echo lang('logout')?></a>
								</li>
							</ul>
						</li>
					</ul>
					<div class="crm-name"><span><?php echo $settings['crm_name']?></span></div>
					<ul id="ciuis-liquid-menu" class="ciuis-menu hidden-xs hidden-sm">
						<li class="active"><a href="<?php echo base_url('area'); ?>" class="huppur"><span><?php echo lang('menu_panel'); ?></span></a></li>
						<li class=""><a href="<?php echo base_url('area/invoices'); ?>" class="huppur"><span><?php echo lang('menu_invoices'); ?></span></a></li>
						<li class=""><a href="<?php echo base_url('area/tickets'); ?>" class="huppur"><span><?php echo lang('menu_tickets'); ?></span></a></li>
						<li class=""><a href="<?php echo base_url('area/projects'); ?>" class="huppur"><span><?php echo lang('menu_projects'); ?></span></a></li>
						<li class=""><a href="<?php echo base_url('area/proposals'); ?>" class="huppur"><span><?php echo lang('menu_proposals'); ?></span></a></li>
					</ul>
					<ul class="nav navbar-nav navbar-right ciuis-body-icons-nav">
						<li class="dropdown"><a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle"><span class="ion-ios-bell-outline"></span><span class="<?php echo $newnotification; ?>"></span></a>
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
			<a id="ciuis-logo-donder" href="{{appurl}}area"><img width="34px" height="34px" src="<?php echo base_url('uploads/ciuis_settings/') ?>{{settings.logo}}" alt=""></a>
		  </div>
		  <div class="text ciuis-ver-menu-brand" ng-bind="settings.crm_name"></div>
		</div>
		<div class="primary-nav">
			<div class="slide one navigation">
				<div class="nav-top">   
					<div class="nav-list">
						<a ng-repeat="menu in areamenu" href="{{menu.url}}" class="nav-item">
							<div class="icon">
								<i class="material-icons {{menu.icon}}"></i>
							</div>
							<div class="text" ng-bind="menu.title"></div>
						</a> 
					</div>
				</div>
			</div>
			<div class="slide two apps inactive">
			</div>
		</div>
	</div>
	</div>