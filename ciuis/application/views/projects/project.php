<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Project_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="panel panel-default" style="border-radius: 5px;">
			<div class="panel-heading project-detail-header">
				<div class="stepper__row pull-left">
					<div ng-repeat="milestone in project.milestones | limitTo:4" class="stepper--horizontal" ng-class="{'stepper--horizontal--disabled' : milestone.duedate >= date}">
						<div class="stepper--horizontal__circle">
							<span class="stepper--horizontal__circle__text" ng-bind="milestone.order"></span>
						</div>
						<div class="stepper--horizontal__details">
							<h3 class="heading__three" ng-bind="milestone.name"></h3>
							<p class="paragraph" ng-bind="milestone.description"></p>
						</div>
					</div>
					<div ng-show="!milestones.length">
					<button ng-show="project.authorization === 'true'" data-toggle="modal" data-target="#newmilestone" class="btn btn-success"><i class="ion-flag"> </i><?php echo  lang('addfirsmilestone')?></button>
					</div>
				</div>
				<div class="project-actions pull-right">
					<div ng-show="project.authorization === 'true'" class="btn-group pull-right">
						<button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo lang('action')?> <i class="ion-android-more-vertical action-button-ciuis"></i></button>
						<ul class="dropdown-menu" role="menu">
							<li><a href="#" data-toggle="modal" data-target="#update"><?php echo lang('updateproject');?></a></li>
							<li><a href="#" data-toggle="modal" data-target="#newmilestone"><?php echo lang('addmilestone'); ?></a></li>
							<li><a href="#" data-toggle="modal" data-target="#newtask"><?php echo lang('addtask') ?></a></li>
							<li><a href="#" data-toggle="modal" data-target="#newexpense"><?php echo lang('newexpense') ?></a></li>
							<li class="divider"></li>
							<li data-sname="<?php echo lang('notstarted') ?>" data-status="1" data-project="{{project.id}}"><a class="mark-as-p" href="#"><?php echo lang('markasprojectnotstarted') ?></a> </li>
							<li data-sname="<?php echo lang('started') ?>" data-status="2" data-project="{{project.id}}"><a class="mark-as-p" href="#"><?php echo lang('markasprojectstarted') ?></a> </li>
							<li data-sname="<?php echo lang('percentage') ?>" data-status="3" data-project="{{project.id}}"><a class="mark-as-p" href="#"><?php echo lang('markasprojectpercentage') ?></a> </li>
							<li data-sname="<?php echo lang('cancelled') ?>" data-status="4" data-project="{{project.id}}"><a class="mark-as-p" href="#"><?php echo lang('markasprojectcancelled') ?></a> </li>
							<li data-sname="<?php echo lang('complete') ?>" data-status="5" data-project="{{project.id}}"><a class="mark-as-p" href="#"><?php echo lang('markasprojectcomplete') ?></a> </li>
							<li class="divider"></li>
							<li><a href="#" data-toggle="modal" data-target="#convert"><strong><?php echo lang('convertinvoice') ?></strong></a></li>
							<li class="divider"></li>
							<li><a href="#" data-toggle="modal" data-target="#remove"><?php echo lang('delete'); ?></a></li>
						</ul>
					</div>
				</div>
			</div>
			<div id="project-details" class="on-schedule">
				<div id="top-details" class="has-due-date">
					<div>
						<h5><?php echo lang('deadline') ?></h5>
						<h3 ng-bind="project.deadline"></h3>
					</div>
					<div>
						<h5><?php echo lang('status') ?> <span class="status-indicator on-schedule"></span></h5>
						<h3 class="on-schedule" ng-bind="project.status"></h3>
					</div>
					<div>
						<h5><?php echo lang('totaltime') ?></h5>
						<h3 ng-bind="getTotal() | time:'mm':'hhh mmm':false"></h3>
					</div>
					<div>
						<h5><?php echo lang('billed') ?></h5>
						<h3><span ng-bind="project.billed"></span> 
						<a ng-hide="project.billed != '<?php echo lang( 'yes' ) ?>'" class="label label-success" href="<?php echo base_url('invoices/invoice/'.$projects['invoice_id'].'')?>"><?php echo lang('invoiceprefix'),'-',str_pad($projects['invoice_id'], 6, '0', STR_PAD_LEFT) ?></a></h3>
					</div>
					<div>
						<h5><?php echo lang('amount') ?></h5>
						<h3><span class="money-area" ng-bind="ProjectTotalAmount()"></span></h3>
					</div>
					<div>
						<h5><?php echo lang('opentasks') ?></h5>
						<h3 ng-bind="project.opentasks"></h3>
					</div>
				</div>
			</div>
			<div class="tab-container">
				<ul class="nav nav-tabs nav-tabs-info text-bold">
					<li class="active"><a href="#summary" data-toggle="tab" aria-expanded="true"><?php echo lang('summary') ?></a></li>
					<li class=""><a href="#milestones" data-toggle="tab" aria-expanded="false"><i class="ion-flag"></i> <?php echo lang('milestones') ?></a></li>
					<li class=""><a href="#tasks" data-toggle="tab" aria-expanded="false"><i class="ion-clipboard"></i> <?php echo lang('tasks') ?></a></li>
					<li class=""><a href="#notes" data-toggle="tab" aria-expanded="false"><i class="ion-quote"></i> <?php echo lang('notes') ?></a></li>
					<li class=""><a href="#timelog" data-toggle="tab" aria-expanded="false"><i class="ion-ios-stopwatch"></i> <?php echo lang('timelogs') ?></a></li>
					<li class=""><a href="#expenses" data-toggle="tab" aria-expanded="false"><i class="ion-paper-airplane"></i> <?php echo lang('expenses') ?></a></li>
				</ul>
				<div class="tab-content" style="padding: 15px;">
					<div id="summary" class="tab-pane cont active">
						<div class="row">
							<div class="col-md-12 md-mb-15">
								<div class="col-md-4 project-progress-detail">
								<div class="col-md-7">
									<h4 style="background: #fdfdfd; margin-top: -10px; padding-left: 5px; font-weight: 600; color: #393939; width: 175px;"><?php echo lang('projectprogress') ?></h4>
									<div class="project-progress-detail-body">
										<div class="c100 p{{project.progress}}">
											<span ng-bind="project.progress+'%'"></span>
											<div class="slice">
												<div class="bar"></div>
												<div class="fill"></div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-5 md-mt-20">
									<div class="counter counter-big">
										<div class="text-success text-bold value">
											<b><span ng-bind="project.progress+'%'"></span></b>
										</div>
										<div class="text-success"><?php echo lang('progresscompleted') ?></div>
									</div>
									<hr>
									<div class="counter counter-big">
										<div class="text-muted text-bold value">
											<b><span ng-bind="100 - project.progress+'%'"></span></b>
										</div>
										<div class="text-muted"><?php echo lang('progressuncompleted') ?></div>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="ciuis-project-detail-amount stats">
								<div class="panel-body">
									<div>
										<h4 class="m-xs text-success text-bold" ng-bind="project.customer"></h4>
									</div>
									<hr style="margin-top: 15px; margin-bottom: 5px;">
										<div class="row">
											<div class="col-xs-6">
												<h4><strong></strong> <i class="ion-ios-stopwatch-outline"></i></h4>
												<small class="stat-label text-muted"><?php echo lang('dayspast') ?></small>
											</div>
											<div class="col-xs-6">
												<div class="left-days">
													<h4><strong ng-bind="project.ldt"></strong> <i class="ion-ios-stopwatch-outline"></i></h4>
												<small class="stat-label text-muted"><?php echo lang('daysleft') ?></small>
												</div>
											</div>
										</div>
										<hr style="margin-top: 15px; margin-bottom: 5px;">
										<div class="row">
											<div class="col-xs-4">
												<h4><span class="money-area"><span ng-bind="TotalExpenses()"></span></span></h4>
												<small class="stat-label"><?php echo lang('totalexpenses') ?></small>
											</div>
											<div class="col-xs-4">
												<h4><span class="money-area"><span ng-bind="BilledExpensesTotal()"></span></span> <i class="ion-ios-copy text-success"></i></h4>
												<small class="stat-label"><?php echo lang('billedexpenses') ?></small>
											</div>
											<div class="col-xs-4">
												<h4><span class="money-area"><span ng-bind="UnBilledExpensesTotal()"></span></span> <i class="ion-alert text-danger"></i></h4>
												<small class="stat-label"><?php echo lang('unbilledexpenses') ?></small>
											</div>
										</div>
									</div>
								</div>
							</div>
							</div>
							<div class="col-md-12 gantt-container hidden" style="padding: 0px">
								<div id="gantt_here" style='width:100%; height:100%;'></div>
							</div>
							<div class="col-md-12">
								<div style="margin: 0 0px 8px;" class="panel-heading panel-heading-divider"><span><strong><?php echo lang('projectactivities') ?></strong></span></div>
								<div style="padding:0px;" class="panel-body">
									<ul class="user-timeline">
										<li ng-repeat="log_project in project.project_logs" >
											<div class="user-timeline-title" ng-bind="log_project.date"></div>
											<div class="user-timeline-description" ng-bind="log_project.detail|trustAsHtml"></div>
										</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<div id="milestones" class="tab-pane cont">
					<article class="project_milestone_detail">
					  <ul class="milestone_project">
						<li ng-repeat="milestone in milestones" class="milestone_project-milestone {{milestone.status}}">
						  <div class="milestone_project-action is-expandable expanded">
							<div data-toggle="modal" data-target="#updatemilestone{{milestone.id}}" class="edit-milestone ion-ios-compose"></div> 
							<div ng-click='RemoveMilestone($index)' class="remove-milestone ion-trash-b"></div> 
							<h2 class="milestonetitle" ng-bind="milestone.name"></h2>
							<span class="milestonedate" ng-bind="milestone.duedate"></span>
							<div class="content">
								<div ng-repeat="task in milestone.tasks" class="milestone-todos-list">
								  <ul class="all-milestone-todos">
									<li ng-class="{'done' : task.status == 4}" class="milestone-todos-list-item col-md-12">
									<span class="pull-left col-md-5"><strong ng-bind="task.name"></strong><br><small ng-bind="task.name"></small></span>
										<div class="col-md-7">
										<div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('startdate') ?> <i class="ion-ios-stopwatch-outline"></i></small><br><strong ng-bind="task.startdate"></strong></span></div>
										<div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('duedate') ?> <i class="ion-ios-timer-outline"></i></small><br><strong ng-bind="task.duedate"></strong></span></div>
										<div class="col-md-4"><span class="date-start-task">
										<small class="text-muted"><?php echo lang('status') ?> <i class="ion-ios-flag"></i></small><br>
										<strong ng-if="task.status_id == '1' "><?php echo lang('open') ?></strong>
										<strong ng-if="task.status_id == '2' "><?php echo lang('inprogress') ?></strong>
										<strong ng-if="task.status_id == '3' "><?php echo lang('waiting') ?></strong>
										<strong ng-if="task.status_id == '4' "><?php echo lang('complete') ?></strong>
										</span>
										</div>
										<div class="col-md-2">
										<a ng-href="<?php echo base_url('/tasks/task/')?>{{task.id}}" class="edit-task pull-left"><i class="ion-android-open"></i></a>
										</div>
										</div>
									</li>
								 </ul>
								</div>
							</div>
						  </div>
						  <div id="updatemilestone{{milestone.id}}" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
										<h3 class="modal-title"><?php echo lang('update') ?> {{milestone.name}}</h3>
									</div>
									<div class="col-md-6 md-pr-0">
										<div class="modal-body md-pr-5">
											<div class="form-group">
												<label for="title"><?php echo lang('name'); ?></label>
												<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
													<input required type="text" ng-model="milestone.name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
												</div>
											</div>
										</div>
									</div>
									<div class="col-md-6 md-pl-0">
										<div class="modal-body md-pl-5">
											<div class="form-group">
												<label for="date"><?php echo lang('duedate'); ?></label>
												<datepicker date-format="yyyy-MM-dd" selector="form-control">
													<div class="input-group">
														<input ng-model="milestone.duedate" class="form-control" placeholder="<?php echo lang('chooseadate')?>"/>
														<span class="input-group-addon" style="cursor: pointer">
														<i class="icon-th mdi mdi-calendar"></i>
														</span>
													</div>
												</datepicker>
											</div>
										</div>
									</div>
									<div class="col-md-12 md-pt-0">
										<div class="modal-body md-pt-0">
											<div class="form-group">
											<label for="description"><?php echo lang('description'); ?></label>
												<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
													<textarea ng-model="milestone.description" class="form-control" id="description" placeholder="Description"></textarea>
												</div>
											</div>
										</div>
										<div class="modal-footer">
											<div class="form-group pull-left col-md-5 md-pl-0">
												<div class="input-group"><span class="input-group-addon"><i class="ion-drag"></i></span>
													<input required type="text" ng-model="milestone.order" class="form-control input-sm" id="title" placeholder="Order"/>
												</div>
											</div>
											<button data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
											<button ng-click="UpdateMilestone($index)" class="btn btn-default"><?php echo lang('save'); ?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
						</li>
					  </ul>
					</article>
					</div>
					<div id="tasks" class="tab-pane cont">
					<div class="row">
						<div class="col-md-3 col-xs-6 border-right">
							<div class="tasks-status-stat">
								 <h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number" ng-bind="(projecttasks | filter:{status_id:'1'}).length"></span>
								 <span class="task-stat-all text-uppercase" ng-bind="'/'+' '+projecttasks.length+' '+'<?php echo lang('task') ?>'"></span></h3>
								 <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(projecttasks | filter:{status_id:'1'}).length * 100 / projecttasks.length }}%;"></span> </span>
							</div>
							 <span class="text-uppercase" style="color:#989898"><?php echo lang('open') ?></span>
						</div>
						<div class="col-md-3 col-xs-6 border-right">
							<div class="tasks-status-stat">
								  <h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number" ng-bind="(projecttasks | filter:{status_id:'2'}).length"></span>
								  <span class="task-stat-all text-uppercase" ng-bind="'/'+' '+projecttasks.length+' '+'<?php echo lang('task') ?>'"></span></h3>
								  <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(projecttasks | filter:{status_id:'2'}).length * 100 / projecttasks.length }}%;"></span> </span>
							</div>
							 <span class="text-uppercase" style="color:#989898"><?php echo lang('inprogress') ?></span>
						</div>
						<div class="col-md-3 col-xs-6 border-right">
							<div class="tasks-status-stat">
								 <h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number" ng-bind="(projecttasks | filter:{status_id:'3'}).length"></span><span class="task-stat-all text-uppercase" ng-bind="'/'+' '+projecttasks.length+' '+'<?php echo lang('task') ?>'"></span></h3>
								 <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(projecttasks | filter:{status_id:'3'}).length * 100 / projecttasks.length }}%;"></span> </span>
							</div>
							 <span class="text-uppercase" style="color:#989898"><?php echo lang('waiting') ?></span>
						</div>
						<div class="col-md-3 col-xs-6 border-right">
							<div class="tasks-status-stat">
								 <h3 class="text-bold ciuis-task-stat-title"><span class="task-stat-number" ng-bind="(projecttasks | filter:{status_id:'4'}).length"></span><span class="task-stat-all text-uppercase" ng-bind="'/'+' '+projecttasks.length+' '+'<?php echo lang('task') ?>'"></span></h3>
								 <span class="ciuis-task-percent-bg"> <span class="ciuis-task-percent-fg" style="width: {{(projecttasks | filter:{status_id:'4'}).length * 100 / projecttasks.length }}%;"></span> </span>
							</div>
							 <span class="text-uppercase" style="color:#989898"><?php echo lang('complete') ?></span>
						</div>
					</div>
					<div ng-repeat="projecttask in projecttasks" class="milestone-todos-list">
					  <ul class="all-milestone-todos">
						<li class="milestone-todos-list-item col-md-12 {{projecttask.done}}">
						<span class="pull-left col-md-5"><strong ng-bind="projecttask.name"></strong><br><small ng-bind="projecttask.name"></small></span>
							<div class="col-md-7">
							<div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('startdate') ?> <i class="ion-ios-stopwatch-outline"></i></small><br><strong ng-bind="projecttask.startdate"></strong></span></div>
							<div class="col-md-3"><span class="date-start-task"><small class="text-muted"><?php echo lang('duedate') ?> <i class="ion-ios-timer-outline"></i></small><br><strong ng-bind="projecttask.duedate"></strong></span></div>
							<div class="col-md-4"><span class="date-start-task">
							<small class="text-muted"><?php echo lang('status') ?> <i class="ion-ios-flag"></i></small><br>
							<strong ng-bind="projecttask.status"></strong>
							</span>
							</div>
							<div class="col-md-2">
							<a ng-href="<?php echo base_url('/tasks/task/')?>{{projecttask.id}}" class="edit-task pull-left"><i class="ion-android-open"></i></a>
							</div>
							</div>
						</li>
					 </ul>
					</div>
					</div>
					<div id="notes" class="tab-pane">
						<section class="ciuis-notes show-notes">
							<article ng-repeat="note in notes" class="ciuis-note-detail">
								<div class="ciuis-note-detail-img">
									<img src="<?php echo base_url('assets/img/note.png') ?>" alt="" width="50" height="50" />
								</div>
								<div class="ciuis-note-detail-body">
									<div class="text">
									  <p>
									  <span ng-bind="note.description"></span>
									  <a ng-click='DeleteNote($index)' style="cursor: pointer;" class="mdi ion-trash-b pull-right delete-note-button"></a>
									  </p>
									  
									</div>
									<p class="attribution">
									<?php echo lang('addedby') ?>  <strong><a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}" ng-bind="note.staff"></a></strong> <?php echo lang('at') ?>  <span ng-bind="note.date"></span>
									</p>
								</div>
							</article>
						</section>
						<section class="md-pb-30">
							<div class="form-group">
								<textarea required name="description" placeholder="Type something" class="form-control note-description"></textarea>
								<input class="note-relation-id" hidden="" type="text" name="customer" value="{{project.id}}">
								<input class="note-type" hidden="" type="text" value="project">
							</div>
							<div class="form-group pull-right">
								<button type="button" class="btn btn-default btn-space"><i class="icon s7-mail"></i> <?php echo lang('cancel')?></button>
								<button class="btn btn-default btn-space add-note-button"><i class="icon s7-close"></i> <?php echo lang('add')?></button>
							</div>
						</section>
					</div>
					<div id="timelog" class="tab-pane cont">
					<article class="time-log-project">
					<div class="panel panel-default panel-table">
						<div class="panel-body" style="overflow: scroll;height: 410px;">
							<table id="table2" class="table table-striped table-hover table-fw-widget">
								<thead>
									<tr>
										<th><?php echo lang('id') ?> </th>
										<th><?php echo lang('start') ?> </th>
										<th><?php echo lang('end') ?> </th>
										<th><?php echo lang('staff') ?> </th>
										<th><?php echo lang('timed') ?> </th>
										<th><?php echo lang('amount') ?> </th>
									</tr>
								</thead>
								<tr ng-repeat="timelog in timelogs">
									<td ng-bind="timelog.id"></td>
									<td ng-bind="timelog.start"></td>
									<td ng-bind="timelog.end"></td>
									<td ng-bind="timelog.staff"></td>
									<td ng-bind="timelog.timed | time:'mm':'hhh mmm':false"></td>
									<td><span class="money-area"><span ng-bind="timelog.amount"></span></span></td>	
								</tr>
							</table>
						</div>
					</div>
					</article>
					</div>
					<div id="expenses" class="tab-pane cont">
					<article class="expenses-project">
						<ul class="custom-ciuis-list-body" style="padding: 0px;">
						<li ng-repeat="expense in expenses"i class="ciuis-custom-list-item ciuis-special-list-item lead-name">
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
					</article>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 project-sidebar">
		<div class="project-assignee">
			<div class="ciuis-project-detail-sidebar-header">
			<h4><i class="ion-ios-people icon-project-sidebar"></i> <?php echo lang('peopleonthisprojects') ?> <div ng-show="project.authorization === 'true'" class="add-new-staff-for-project ion-ios-personadd-outline pull-right"></div></h4>
			</div>
			<div id="ciuis-customer-contact-detail">
				<div ng-show="project.authorization != 'true'" role="alert" class="alert alert-warning alert-icon alert-dismissible">
					<div class="icon"><span class="mdi mdi-block-alt"></span></div>
					<div class="message">
					<button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="mdi mdi-close"></span></button><?php echo lang('notauthorized') ?>
					</div>
				</div>
				<div data-linkid="{{member.id}}" ng-repeat="member in project.members" class="ciuis-customer-contacts">
					<div data-toggle="modal" data-target="#contactmodal1">
						<img width="40" height="40" src="{{UPIMGURL}}{{member.staffavatar}}" alt="">
						<div style="padding: 16px;position: initial;">
							<strong ng-bind="member.staffname"></strong>
							<br>
							<span ng-bind="member.email"></span>
						</div>
						<div ng-show="project.authorization === 'true'" ng-click='UnlinkMember($index)' class="unlink">
						<i class="ion-ios-close-outline"></i>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 md-pr-0 md-pl-0 md-pb-10 task-files">
			<div class="panel-heading panel-heading-divider">
				<span><?php echo lang('files') ?></span>
				<div ng-show="project.authorization === 'true'" class="add-file pull-right ion-plus-round"></div>  
				<span class="panel-subtitle"><?php echo lang('projectsfiles') ?></span>
			</div>
			<div class="panel-body">
			  <div class="xs-mt-10">
				<div class="list-group">
					<div ng-repeat="file in files" class="list-group-item">
					<span class="badge badge-info"><span ng-click='DeleteFile($index)' class="ion-android-delete delete-file-btn"></span></span>
					<span class="badge badge-default"><a target="new" href="<?php echo base_url('uploads/files/');?>{{file.name}}" class="ion-ios-cloud-download"> <?php echo lang('download') ?></a></span> 
					<span class="text-primary ion-document icon"></span>
					<span ng-bind="file.name"></span>
					</div>
				<div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
				</div>
			  </div>
			</div>
			<div class="add-file-cover">
			<?php echo form_open_multipart('projects/addfile',array("class"=>"form-horizontal")); ?>
				<div class="form-field form-field-file">
				<label for="file-upload"><?php echo lang('choosefile') ?></label>
				<input required type="file" name="file_name" id="file-upload" />
				<input type="hidden" name="relation_type" value="project" />
				<input type="hidden" name="relation" value="{{project.id}}" />
				<button type="submit" class="btn-send-file btn ion-android-checkmark-circle"></button>
				</div>
			<?php echo form_close(); ?>
			</div>
		</div>
	</div>
<div id="addpeople" tabindex="-1" role="content" class="modal fade colored-header colored-header-warning">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title">
					<?php echo lang('addpeopleforthisproject') ?>
				</h3>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<h4><b><?php echo lang('choosestaff') ?></b></h4>
					<select id="newmember" name="staff" class="select2 form-control" data-placeholder="Choose a Staff">
						<option ng-repeat="member in staff" value="{{member.id}}">{{member.name}}</option>
					</select>
				</div>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
					<?php echo lang('cancel'); ?>
				</button>
				<button ng-click='AddProjectMember()' type="submit" class="btn btn-default add-project-memberd">
					<?php echo lang('add'); ?>
				</button>
			</div>
		</div>
	</div>
</div>
<div id="update" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog">
	<?php echo form_open('projects/update/'.$projects['id'],array()); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title"><?php echo lang('updateprojectinformations') ?></h3>
			</div>
			<div class="col-md-6 md-pr-0">
				<div class="modal-body md-pr-5">
					<div class="form-group">
						<label for="title"><?php echo lang('name'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
							<input required type="text" name="pname" value="<?php echo $projects['name'];?>" class="form-control pname"/>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('startdate') ?></label>
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input placeholder="<?php echo date(" d.m.Y "); ?>" required type='input' name="startdate" value="<?php echo $projects['start_date'];?>" class="form-control pstart" id="date"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 md-pl-0">
				<div class="modal-body md-pl-5">
					<div class="form-group">
						<label for="customer"><?php echo lang('choisecustomer'); ?></label>
						<div class="add-on-edit">
							<select id="pcustomer" name="pcustomer" class="form-control select2 pcustomer">
								<option value="<?php echo $projects['customer_id'];?>"><?php if($projects['type']==0) {echo $projects['customercompany'];} else echo $projects['individual'];?></option>
								<option ng-repeat="customer in all_customers" value="{{customer.id}}">{{customer.name}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('deadline') ?></label>
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input placeholder="<?php echo date(" d.m.Y "); ?>" required type='input' name="deadline" value="<?php echo $projects['deadline'];?>" class="form-control pdeadline" id="date"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-12 md-pt-0">
				<div class="modal-body md-pt-0">
					<div class="form-group">
					<label for="description"><?php echo lang('description'); ?></label>
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
							<textarea name="description" class="form-control pdesc" id="description" placeholder="Description"><?php echo $projects['description'];?></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
					<button class="btn btn-default postevent update-project"><?php echo lang('save'); ?></button>
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>
	</div>
</div>
<div id="newmilestone" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title"><?php echo lang('addmilestone')?></h3>
			</div>
			<div class="col-md-6 md-pr-0">
				<div class="modal-body md-pr-5">
					<div class="form-group">
						<label for="title"><?php echo lang('name'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
							<input required type="text" ng-model="milestonename" class="form-control" id="title" placeholder="<?php echo lang('name'); ?>"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 md-pl-0">
				<div class="modal-body md-pl-5">
					<div class="form-group">
						<label for="date"><?php echo lang('duedate'); ?></label>
						<datepicker date-format="yyyy-MM-dd" selector="form-control">
							<div class="input-group">
								<input ng-model="milestoneduedate" class="form-control" placeholder="<?php echo lang('chooseadate')?>"/>
								<span class="input-group-addon" style="cursor: pointer">
								<i class="icon-th mdi mdi-calendar"></i>
								</span>
							</div>
						</datepicker>
					</div>
				</div>
			</div>
			<div class="col-md-12 md-pt-0">
				<div class="modal-body md-pt-0">
					<div class="form-group">
					<label for="description"><?php echo lang('description'); ?></label>
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
							<textarea name="description" class="form-control" ng-model="milestonedescription" placeholder="Description"></textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="form-group pull-left col-md-5 md-pl-0">
						<div class="input-group"><span class="input-group-addon"><i class="ion-drag"></i></span>
							<input required type="text" ng-model="milestoneorder" class="form-control input-sm" id="title" placeholder="Order"/>
						</div>
					</div>
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
					<button ng-click="AddMilestone()" class="btn btn-default"><?php echo lang('save'); ?></button>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="newtask" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog modal-lg">
	<?php echo form_open_multipart('projects/addtask/'.$projects['id'].'',array()); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title"><?php echo lang('createnewtask') ?></h3>
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
						<label for="title"><?php echo lang('hourlyrate') ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-social-usd"></i></span>
							<input ng-model="hourly_rate" required type="text" name="hourly_rate" value="" class="form-control hourly_rate input-money-format" placeholder="Hourly Rate like $23"/>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('startdate') ?></label>
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
					<div class="form-group col-md-6 md-p-0">
						<label for="customer"><?php echo lang('priority'); ?></label>
						<div class="add-on-edit">
							<select name="priority" ng-model="priority" class="form-control select2 priority">
								<option value=""><?php echo lang('select') ?></option>
								<option value="2"><?php echo lang('high') ?></option>
								<option value="1"><?php echo lang('medium') ?></option>
								<option value="0"><?php echo lang('low') ?></option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-6 md-pr-0">
						<label for="project"><?php echo lang('selectmilestone') ?></label>
						<div class="add-on-edit">
							 <select name="milestone" class="form-control milestone" data-placeholder="Choose a Milestone…">
							 	<option value=""><?php echo lang('select') ?></option>
								<option ng-repeat="opmilestone in project.milestones" value="{{opmilestone.id}}">{{opmilestone.name}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="date"><?php echo lang('duedate') ?></label>
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input ng-model="duedate" placeholder="<?php echo date(" d.m.Y "); ?>" required type='input' name="duedate" value="1" class="form-control duedate" id="date"/>
						</div>
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
						<label for="billable"><?php echo lang('billable') ?></label>
					</div>
					<div class="ciuis-body-checkbox has-primary pull-left md-ml-20">
						<input name="visible" class="primary-check" id="visible" type="checkbox" value="1">
						<label for="visible">
							<?php echo lang('visiblecustomer') ?>
						</label>
					</div>
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
					<button type="submit" class="btn btn-default"><?php echo lang('save'); ?></button>
				</div>
			</div>
		</div>
	<?php echo form_close(); ?>
	</div>
</div>
<div id="newexpense" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog">
		<?php echo form_open('projects/addexpense'); ?>
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
					<input type="hidden" name="relation_type" value="project" />
					<input type="hidden" name="relation" value="{{project.id}}" />
					<input type="hidden" name="customer" value="{{project.customer_id}}" />
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
					<button type="submit" class="btn btn-default"><?php echo lang('save'); ?></button>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<div id="convert" tabindex="-1" role="dialog" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
		<?php echo form_open('projects/convertinvoice/'.$projects['id'].'',array("class"=>"form-vertical")); ?>
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
			</div>
			<div class="modal-body">
			<input type="hidden" name="itemname" value="{{project.name}}">
			<input type="hidden" name="total" value="{{ProjectTotalAmount()}}">
			<input type="hidden" name="description" value="{{project.description}}">
				<div class="text-center">
					<div class="text-success"><span class="modal-main-icon mdi mdi-info"></span>
					</div>
					<h3>
						<?php echo lang('information'); ?>
					</h3>
					<p>
						<?php echo lang('convertexpensedetail'); ?>
					</p>
					<div class="xs-mt-50">
						<a type="button" data-dismiss="modal" class="btn btn-space btn-default">
							<?php echo lang('cancel'); ?>
						</a>
						<button type="submit" class="btn btn-space btn-default">
							<?php echo lang('convert'); ?>
						</button>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
		<?php echo form_close(); ?>
		</div>
	</div>
</div>
<div id="remove" tabindex="-1" role="dialog" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span>
					</div>
					<h3>
						<?php echo lang('attention'); ?>
					</h3>
					<p>
						<?php echo lang('projectattentiondetail'); ?>
					</p>
					<div class="xs-mt-50">
						<a type="button" data-dismiss="modal" class="btn btn-space btn-default">
							<?php echo lang('cancel'); ?>
						</a>
						<a href="<?php echo base_url('projects/remove/'.$projects['id'].'')?>" type="button" class="btn btn-space btn-danger">
							<?php echo lang('delete'); ?>
						</a>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
</div>
<script>
	var PROJECTID = "<?php echo $projects['id'];?>";
</script>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
<!-- Extra Script -->
<script src='<?php echo base_url('assets/lib/gantt/gantt.js');?>'></script>
<link rel='stylesheet prefetch' href='<?php echo base_url('assets/lib/gantt/gantt.css');?>'>
<script src='<?php echo base_url('assets/lib/jquery-ui/jquery-ui.min.js');?>'></script>
<script type="text/javascript">
var projects_with_milestones = {
	"data":[
		{"id":12, "text":"Task #1", "start_date":"03-04-2017", "duration":"5", "parent":"11", "progress": 1, "open": true},
	]
};
gantt.init("gantt_here");
gantt.parse(projects_with_milestones);
</script>
<!-- Extra Script -->
