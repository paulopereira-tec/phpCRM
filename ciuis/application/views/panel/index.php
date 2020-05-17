<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9 hidden-sm hidden-md hidden-lg" ng-hide="ONLYADMIN != 'true'">
		<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary.php'); ?>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9 hidden-sm hidden-md hidden-lg" ng-hide="ONLYADMIN != 'false'">
		<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary_staff.php'); ?>
		
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="ciuis-an-x">
			<div class="col-md-3 col-sm-3 col-lg-3 nopadding">
				<div class="ciuis-summary-two panel">
					<div style="font-size: 14px;padding: 12px 12px 12px 0px;border-bottom: 1px solid #f1f1f1;margin: 0;" class="panel-heading">
						<span style="padding-left: 20px;"><?php echo lang('panelsummary'); ?></span>
						<div class="tools"><span class="icon ion-flag"></span></div>
					</div>
					<div class="panel-body" style="margin: 0;padding: 0;">
						<div class="ciuis-dashboard-box-b1-xs-ca-body">
							<div class="ciuis-dashboard-box-stats ciuis-dashboard-box-stats-main">
								<div class="ciuis-dashboard-box-stats-amount" ng-bind="stats.otc"></div>
								<div class="ciuis-dashboard-box-stats-caption" ng-bind="stats.newticketmsg"></div>
								<div class="ciuis-dashboard-box-stats-change">
									<div class="ciuis-dashboard-box-stats-value ciuis-dashboard-box-stats-value--positive" ng-bind="'+' + stats.twt">+</div>
									<div class="ciuis-dashboard-box-stats-period"><?php echo lang('thisweek'); ?></div>
								</div>
							</div>
							<div class="ciuis-dashboard-box-stats">
								<div class="ciuis-dashboard-box-stats-amount" ng-bind="stats.yms"></div>
								<div class="ciuis-dashboard-box-stats-caption" ng-bind="stats.newcustomermsg"></div>
								<div class="ciuis-dashboard-box-stats-change">
									<div class="ciuis-dashboard-box-stats-value ciuis-dashboard-box-stats-value-negative ion-refresh"></div>
								</div>
							</div>
						</div>
					</div>
					<div class="hidden-xs" ng-hide="ONLYADMIN != 'true'">
						<h4 class="text-center"><?php echo lang('monthlyexpenses'); ?></h4>
					<div id="monthlyexpenses" style="height: 145px;display: block;bottom: 14px;position: absolute;width: 100%;border-bottom-left-radius: 5px;"></div>
					</div>
				</div>
			</div>
			<div class="col-sm-9 xs-p-0">
				<div class="panel panel-default trr-5">
					<div class="tab-container ciuis-summary-two trr-5">
						<ul class="nav nav-tabs trr-5">
						    <li class="active"><a href="#home" data-toggle="tab"><?php echo lang('welcome') ?></a></li>
							<button class="btn btn-default btn-sm pull-right md-mt-10 md-mr-10 ion-eye show-advanced-summary hidden">Show Advanced Summary</button>
							<button class="btn btn-info btn-sm pull-right md-mt-10 md-mr-10 ion-eye-disabled hide-advanced-summary" style="display: none">Hide Advanced Summary</button>
						</ul>
						<div class="tab-content brr-5 trr-5" ng-hide="ONLYADMIN != 'true'">
							<div id="home" class="tab-pane active cont">
								<div class="col-sm-4 nopadding">
									<div class="col-md-12 nopadding">
										<div class="hpanel stats">
											<div style="padding-top: 0px;line-height: 0.99;margin-right: 10px;" class="panel-body h-200 xs-p-0">
												<div class="col-md-12 xs-mb-20 md-pl-0">
													<h3 style="font-size:27px;line-height: 0.8;font-weight: 500;" class="no-margins font-extra-bold text-warning">
													<span class="money-area" ng-bind="stats.bkt"></span>
													</h3>
													<small><b><?php echo lang('todayssales'); ?></b></small>
													<div class="pull-right text-{{stats.todaysalescolor}}"><b ng-bind="stats.todayrate+'%'"><i class="{{stats.todayicon}}"></i>
													</b></div>
												</div>
												<div class="col-md-12 nopadding md-pt-10 xs-pt-20" style="border-top: 1px solid #e0e0e0;">
												<div class="stats-title"><h4 style="font-weight: 500;color: #c7cbd5;"><?php echo lang('netcashflow'); ?></h4></div>
													<h3 style="font-weight: 500;" class="m-b-xs"><span class="money-area" ng-bind="stats.netcashflow"></span></h3>
													<div style="height: 10px" class="progress">
													  <div style="font-size: 7px;line-height: 10px;width:{{stats.inp}}%" class="progress-bar progress-bar-success progress-bar-striped" ng-bind="stats.inp+'%'"> <?php echo lang('incomings'); ?><span class="sr-only"><?php echo lang('incomings'); ?></span></div>
													  <div style="font-size: 7px;line-height: 10px;width:{{stats.ogp}}%" class="progress-bar progress-bar-danger progress-bar-striped" ng-bind="stats.ogp+'%'"> <?php echo lang('outgoings'); ?><span class="sr-only"><?php echo lang('outgoings'); ?></span></div>
													</div>
													<div class="row">
														<div class="col-xs-6">
															<small class="stats-label text-uppercase text-bold text-success"><?php echo lang('incomings'); ?></small>
															<h4 class="money-area" ng-bind="stats.pay"></h4>
														</div>

														<div class="col-xs-6">
															<small class="stats-label text-uppercase text-bold text-danger"><?php echo lang('outgoings'); ?></small>
															<h4 class="money-area" ng-bind="stats.exp"></h4>
														</div>
													</div>
													<?php echo lang('cashflowdetail'); ?>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr class="hidden-sm hidden-md hidden-lg">
								<div class="col-sm-8 nopadding">
									<div class="widget widget-fullwidth ciuis-body-loading">
										<div class="widget-chart-container">
											<div class="widget-counter-group widget-counter-group-right">
												<div class="pull-left">
													<div class="pull-left text-left">
														<h4 style="padding: 0px;margin: 0px;"><b><?php echo lang('weeklygraphtitle'); ?></b></h4>
														<small><?php echo lang('weeklygraphdetailtext'); ?></small>
													</div>
												</div>
												<div class="counter counter-big">
													<div class="text-warning value"><span class="money-area" ng-bind="stats.bht"></span></div>
													<div class="desc"><?php echo lang('thisweek'); ?></div>
												</div>
												<div class="counter counter-big">
													<div class="value"><span class="text-{{stats.weekstat}}" ng-bind="stats.weekrate+'%'"></span></div>
													<div class="desc" ng-bind="stats.weekratestatus"></div>
												</div>
											</div>
											<div class="my-2">
												<div class="chart-wrapper" style="height:235px;">
													<canvas id="main-chart" height="235px"></canvas>
												</div>
											</div>
										</div>
										<div class="ciuis-body-spinner">
											<svg width="40px" height="40px" viewBox="0 0 66 66" xmlns="http://www.w3.org/2000/svg">
												<circle fill="none" stroke-width="4" stroke-linecap="round" cx="33" cy="33" r="30" class="circle"></circle>
											</svg>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div class="tab-content brr-5 trr-5" ng-hide="ONLYADMIN != 'false'">
							<div id="home" class="tab-pane active cont">
								<div class="col-sm-4 nopadding">
									<div class="col-md-12 nopadding">
										<div class="hpanel stats">
											<div style="padding-top: 0px;line-height: 0.99;margin-right: 10px;" class="panel-body h-200 xs-p-0">
												<div class="col-md-12 xs-mb-20 md-pl-0" style="line-height: 28px;">
												<div class="col-md-12 text-center">
												<p><img src="{{stats.dayimage}}" alt=""></p>
												<h4 ng-bind="stats.daymessage"></h4>
												<span ng-bind="user.staffname"></span>
												</div>
												<div class="col-md-12  md-pt-10 xs-pt-20 text-center" style="border-top: 1px solid #e0e0e0;"><?php echo lang('haveaniceday') ?></div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<hr class="hidden-sm hidden-md hidden-lg">
								<div class="col-sm-8 nopadding">
									<div class="panel panel-default">
									<div class="panel-body" style="height: 400px; overflow: scroll; zoom: 0.8; margin-top: 25px; box-shadow: inset 0px 17px 50px 10px #ffffff; overflow-y: scroll;">
										<ul class="user-timeline user-timeline-compact">
											<li ng-repeat="todo in todos" class="latest">
												<div class="user-timeline-title" ng-bind="todo.date"></div>
												<div class="user-timeline-description" ng-bind="todo.description"></div>
											</li>
										</ul>
									</div>
								</div>
								</div>
							</div>
							
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9 hidden-xs" ng-hide="ONLYADMIN != 'true'">
	<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary.php'); ?>
		
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9 hidden-xs" ng-hide="ONLYADMIN != 'false'">
	<?php include(APPPATH . 'views/inc/widgets/panel_bottom_summary_staff.php'); ?>
		
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
	
</div>
<script>
var PANELEXPENSECHARTCATEGORIES = ["<?php echo lang('january'); ?>", "<?php echo lang('february'); ?>", "<?php echo lang('march'); ?>", "<?php echo lang('april'); ?>", "<?php echo lang('may'); ?>", "<?php echo lang('june'); ?>", "<?php echo lang('july'); ?>", "<?php echo lang('august'); ?>", "<?php echo lang('september'); ?>", "<?php echo lang('october'); ?>", "<?php echo lang('november'); ?>", "<?php echo lang('december'); ?>"];
var PANELEXPENSECHARTDATAS = <?php echo $monthly_expense_graph ?>;
var PANELMAINCHARTDATAS = <?php echo $weekly_sales_chart ?>;
</script>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>

<script>
// Charts Datas //
// PANEL EXPENSE CHART
$(function () {
	Highcharts.setOptions({
		colors: ['#ffbc00', 'rgb(239, 89, 80)']
	});
	Highcharts.chart('monthlyexpenses', {
		title: {
			text: '',
		},
		credits: {
			enabled: false
		},
		chart: {
			backgroundColor: 'transparent',
			marginBottom: 0,
			marginLeft: -10,
			marginRight: -10,
			marginTop: 0,

			type: 'area',
		},
		exporting: {
			enabled: false
		},
		plotOptions: {
			series: {
				fillOpacity: 0.1
			},
			area: {
				lineWidth: 1,
				marker: {
					lineWidth: 2,
					symbol: 'circle',
					fillColor: 'black',
					radius: 3,
				},
				legend: {
					radius: 2,
				}
			}
		},
		xAxis: {
			categories: PANELEXPENSECHARTCATEGORIES,
			visible: true,
		},
		yAxis: {
			title: {
				enabled: false
			},
			visible: false
		},
		tooltip: {
			shadow: false,
			useHTML: true,
			padding: 0,
			formatter: function () {
				return '<div class="bis-tooltip" style="background-color: ' + this.color + '">' + this.x + ' <span>' + this.y + '$' + '</span></div>'
			}
		},
		legend: {
			align: 'right',
			enabled: false,
			verticalAlign: 'top',
			layout: 'vertical',
			x: -15,
			y: 100,
			itemMarginBottom: 20,
			useHTML: true,
			labelFormatter: function () {
				console.log(this)
				return '<span style="color:' + this.color + '">' + this.name + '</span>'
			},
			symbolPadding: 0,
			symbolWidth: 0,
			symbolRadius: 0
		},
		series: [{
			"data": PANELEXPENSECHARTDATAS
		}]
	}, function (chart) {
		var series = chart.series;
		series.forEach(function (serie) {
			console.log(serie)
			if (serie.legendSymbol) {
				console.log(serie.legendSymbol.destroy)

				serie.legendSymbol.destroy();
			}
			if (serie.legendLine) {
				serie.legendLine.destroy();
			}
		});
	});
});

// PANEL MAIN CHART
$(function () {
	"use strict";
	var data = PANELMAINCHARTDATAS;
	var options = {
		responsive: true,
		maintainAspectRatio: false,
		scales: {
			xAxes: [{
				categoryPercentage: .2,
				barPercentage: 1,
				position: 'top',
				gridLines: {
					color: '#C7CBD5',
					zeroLineColor: '#C7CBD5',
					drawTicks: true,
					borderDash: [8, 5],
					offsetGridLines: false,
					tickMarkLength: 10,
					callback: function (value) {
						console.log(value);
						// return value.charAt(0) + value.charAt(1) + value.charAt(2);
					}
				},
				ticks: {
					callback: function (value) {
						return value.charAt(0) + value.charAt(1) + value.charAt(2);
					}
				}
			}],
			yAxes: [{
				display: false,
				gridLines: {
					drawBorder: false,
					drawOnChartArea: false,
					borderDash: [8, 5],
					offsetGridLines: false
				},
				ticks: {
					beginAtZero: true,
					maxTicksLimit: 5,
				}
			}]
		},
		legend: {
			display: false
		}
	};
	var ctx = $('#main-chart');
	var mainChart = new Chart(ctx, {
		type: 'bar',
		data: data,
		borderRadius: 10,
		options: options
	});
});
</script>
