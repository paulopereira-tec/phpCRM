<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Task_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-12">
		<div class="col-md-12 borderten md-p-0">
			<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
				<div class="panel borderten panel-default">
					<div class="panel-body" style="height: 218px">
						<div class="task-detail">
							<div class="task-summary">
								<div class="col-lg-4 col-sm-4 md-pl-0 md-pr-0">
									<span class="text-muted text-bold"><strong ng-bind="taskdetail.name"></strong></span>
									<p class="text-bold"><span class="label label-info">Project</span> <span ng-bind="taskdetail.project"></span></p>
								</div>
								<div class="col-lg-2 col-sm-2 md-pl-0 md-pr-0">
									<span class="text-muted">Milestone</span>
									<p class="text-bold" ng-bind="taskdetail.milestone"></p>
								</div>
								<div class="col-lg-2 col-sm-2 md-pl-0 md-pr-0">
									<span class="text-muted">Status</span>
									<p class="text-bold" ng-bind="taskdetail.status"></p>
								</div>
								<div class="col-lg-2 col-sm-2 md-pl-0 md-pr-0">
									<span class="text-muted">Priority</span>
									<p class="text-bold text-danger" ng-bind="taskdetail.priority"></p>
								</div>
								<div class="col-lg-1 col-sm-1 md-pl-0 md-pr-0">
									<span class="text-muted">Billable</span>
									<p class="text-bold text-danger"><span class="label label-success">Billable</span></p>
								</div>
								<div ng-hide="ONLYADMIN != 'true'" class="pull-right col-lg-1 col-sm-1 md-pl-0 md-pr-0">
									<div class="btn-group pull-right">
										<button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo lang('action')?> <i class="ion-android-more-vertical action-button-ciuis"></i></button>
										<ul class="dropdown-menu" role="menu">
											<li>
												<a ng-click='MarkAsCancelled()' data-toggle="modal" data-target="#convert"><strong>Mark as Cancelled</strong></a>
											</li>
											<li class="divider"></li>
											<li>
												<a data-toggle="modal" data-target="#remove"><?php echo lang('delete'); ?></a>
											</li>
										</ul>
									</div>
								</div>
							</div>
							<div class="task-description" style="float: left; width: 100%;">
								<h4><strong>Description</strong></h4>
								<p class="text-muted" ng-bind="taskdetail.description"></p>
							</div>
							<div class="clearfix"></div>
						</div>
					</div>
					<div>
						<div class="ciuis-task-subtask">
							<div class="todo-checklist-container">
								<div class="ciuis-sub-task">
									<h2 class="mb0">{{title}}: {{subtasks.length + SubTasksComplete.length}} {{subtasks.length + SubTasksComplete.length === 1 ? 'task' : 'subtasks'}}</h2>
								</div>
								<div class="ciuis-sub-task  ciuis-sub-task--small  ciuis-sub-task--highlight">
									<span>{{ SubTasksComplete.length }} of {{ taskLength() }} ({{ taskCompletionTotal(SubTasksComplete.length) }}%) subtasks complete.</span>
								</div>
								<div class="progress">
									<div style="width: {{ taskCompletionTotal(SubTasksComplete.length) }}%" class="progress-bar progress-bar-success progress-bar-striped active" ng-bind="'Complete '+taskCompletionTotal(SubTasksComplete.length)+'%'"></div>
								</div>
								<ul class="subtask-items">
									<li class="subtask-list-item">
										<form name="addTask" ng-submit="createTask()" novalidate>
											<input class="input-ui" type="text" ng-model="newTitle" placeholder="Write a new task and hit enter..." ng-required/>
											<div class="pull-right">
												<button ng-hide="true" class="btn" type="submit" ng-disabled="addTask.$invalid">Add Task</button>
											</div>
										</form>
									</li>
									<li class="subtask-list-item" ng-repeat="task in subtasks">
										<span ng-bind="task.description"></span>
										<div class="pull-right">
											<div class="sub-task-button" href ng-click="removeTask($index)">
												<span class="ion-trash-b"></span>
											</div>
											<div class="sub-task-button" href ng-click="completeTask($index)">
												<span class="ion-checkmark-round"></span>
											</div>
										</div>
									</li>
									<li class="subtask-list-item" ng-class="{ 'subtask-status subtask-status--done' : task.complete }" ng-repeat="task in SubTasksComplete">
										<span ng-bind="task.description"></span>
										<div class="pull-right">
											<div class="sub-task-button" href ng-click="uncompleteTask($index)">
												<span class="ion-refresh"></span>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<article class="time-log-project">
					<div class="panel panel-default panel-table">
						<div class="panel-heading"><strong>Task Time Logs</strong></div>
						<div class="panel-body">
							<table id="table2" class="table table-striped table-hover table-fw-widget">
								<thead>
									<tr>
										<th>ID</th>
										<th>START</th>
										<th>END</th>
										<th>STAFF</th>
										<th>TIMED</th>
										<th>AMOUNT</th>
									</tr>
								</thead>
								<tr ng-repeat="timelog in timelogs">
									<td ng-bind="timelog.id"></td>
									<td ng-bind="timelog.start"></td>
									<td ng-bind="timelog.end"></td>
									<td ng-bind="timelog.staff"></td>
									<td ng-bind="timelog.timed | time:'mm':'hhh mmm':false"></td>
									<td><span class="money-area" ng-bind="timelog.amount"></span></td>	
								</tr>
							</table>
						</div>
					</div>
					</article>
				</div>
			</div>
			<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3 md-pl-0 lead-left-bar">
				<div class="btn-group col-md-12 md-pr-0 md-pl-0 md-pb-0" style="display: <? if ( if_admin && $this->session->logged_in_staff_id != $task['assigned'] ) {echo 'none';}?>"</di>
					<?php if ($task['timer'] == '0') { ?>
						<button ng-click='startTimerforTask()' class="btn btn-default btn-big col-md-4 start-timer-btn"><i class="icon ion-ios-timer"></i> Start Timer</button>
						<button style="display: none" ng-click='stopTimerforTask()' class="btn btn-default btn-big col-md-4 stop-timer-btn"><i class="icon ion-ios-stopwatch"></i> Stop</button>
					<?php }?>
					<?php if ($task['timer'] == '1') { ?>
						<button style="display: none" ng-click='startTimerforTask()' class="btn btn-default btn-big col-md-4 start-timer-btn"><i class="icon ion-ios-timer"></i> Start Timer</button>
						<button ng-click='stopTimerforTask()' class="btn btn-default btn-big col-md-4 stop-timer-btn"><i class="icon ion-ios-stopwatch"></i> Stop</button>
					<?php }?>
					<button ng-click='MarkAsCompleteTask()'  class="btn btn-default btn-big col-md-4"><i class="icon ion-ios-checkmark-outline"></i> Mark Complete </button>
					<button data-target="#update" data-toggle="modal" class="btn btn-default btn-big col-md-4"><i class="icon ion-ios-plus-outline"></i> Update </button>
				</div>
				<div class="col-md-12 md-pr-0 md-pl-0 md-pb-10" style="background: white">
					<div class="form-group  col-sm-12 task-sidebar-item">
						<ul class="list-inline task-dates m-b-0 m-t-20">
							<li class="col-md-6">
								<h5 class="taskstatus-title">Start Date</h5>
								<strong ng-bind="taskdetail.startdate"></strong>
							</li>
							<li class="col-md-6">
								<h5 class="text-danger taskstatus-title"><strong>Due Date</strong></h5>
								<strong ng-bind="taskdetail.duedate"></strong>
							</li>
						</ul>
					</div>
					<div class="form-group  col-sm-12 task-sidebar-item">
						<ul class="list-inline task-dates m-b-0 m-t-20">
							<li class="col-md-6">
								<h5 class="taskstatus-title">Assigned By:</h5>
								<strong ng-bind="taskdetail.staff"></strong>
							</li>
							<li class="col-md-6">
								<h5 class="taskstatus-title">Created Date:</h5>
								<strong ng-bind="taskdetail.created"></strong>
							</li>
						</ul>
					</div>
					<div class="form-group  col-sm-12 task-sidebar-item">
						<ul class="list-inline task-dates m-b-0 m-t-20">
							<li class="col-md-6">
								<h5 class="taskstatus-title">Hourly Rate:</h5>
								<strong><span class="money-area" ng-bind="taskdetail.hourlyrate"></span></strong>
							</li>
							<li class="col-md-6">
								<h5 class="taskstatus-title">Total Time</h5>
								<strong ng-bind="getTotal() | time:'mm':'hhh mmm':false"></strong>
							</li>
						</ul>
					</div>
				</div>
				<div class="col-md-12 md-pr-0 md-pl-0 md-pb-10 task-files">
					<div class="panel-heading panel-heading-divider">Files  <div class="add-file pull-right ion-plus-round"></div>  <span class="panel-subtitle">Files of interest this task</span></div>
					<div class="panel-body">
					  <div class="xs-mt-10">
						<div class="list-group">
						<div ng-repeat="file in files" class="list-group-item">
						<span class="badge badge-info"><span ng-click='DeleteFile($index)' class="ion-android-delete delete-file-btn"></span></span><span class="badge badge-default"><a target="new" href="<?php echo base_url('uploads/files/');?>{{file.name}}" class="ion-ios-cloud-download"> Download</a></span> <span class="text-primary ion-document icon"></span><span ng-bind="file.name"></span>
						</div>
						<div ng-show="!files.length" class="text-center"><img width="70%" src="<?php echo base_url('assets/img/nofiles.jpg') ?>" alt=""></div>
						</div>
					  </div>
					</div>
					<div class="add-file-cover">
					<?php echo form_open_multipart('tasks/addfile',array("class"=>"form-horizontal")); ?>
						<div class="form-field form-field-file">
						<label for="file-upload">Choose File...</label>
						<input required type="file" name="file_name" id="file-upload" />
						<input type="hidden" name="relation_type" value="task" />
						<input type="hidden" name="relation" value="{{taskdetail.id}}" />
						<button type="submit" class="btn-send-file btn ion-android-checkmark-circle"></button>
						</div>
					<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="update" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog modal-lg">
	<?php echo form_open('tasks/update/'.$task['id'],array()); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title">Update Task</h3>
			</div>
			<div class="col-md-6 md-pr-0">
				<div class="modal-body md-pr-5">
					<div class="form-group">
						<label for="title"><?php echo lang('title'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
							<input required type="text" name="name" value="{{taskdetail.name}}" class="form-control name" placeholder="<?php echo lang('title'); ?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="title">Hourly Rate</label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-social-usd"></i></span>
							<input required type="text" name="hourly_rate" value="{{taskdetail.hourlyrate}}" class="form-control hourly_rate input-money-format" placeholder="Hourly Rate like $23"/>
						</div>
					</div>
					<div class="form-group">
						<label for="date">Start Date</label>
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input required type='input' name="startdate" value="{{taskdetail.startdate}}" class="form-control startdate" name="start_date"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 md-pl-0">
				<div class="modal-body md-pl-5">
					<div class="form-group">
						<label for="customer"><?php echo lang('assigned'); ?></label>
						<div class="add-on-edit">
							<select required name="assigned" class="select2">
							<option value="<?php echo $task['assigned'];?>"><?php echo $task['staffname'] ?></option>
							<option ng-repeat="member in staff" value="{{member.id}}">{{member.name}}</option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label for="customer"><?php echo lang('priority'); ?></label>
						<div class="add-on-edit">
							<select name="priority" class="form-control select2">
							<option selected value="<?php echo $task['priority'];?>">{{taskdetail.priority}}</option>
								<option value="0"><?php echo lang('low')?></option>
								<option value="1"><?php echo lang('medium')?></option>
								<option value="2"><?php echo lang('high')?></option>
							</select>
						</div>
					</div>
					<div class="form-group col-md-6">
						<label for="customer"><?php echo lang('status'); ?></label>
						<div class="add-on-edit">
							<select name="status_id" class="form-control select2">
							<option selected value="<?php echo $task['status_id'];?>">{{taskdetail.status}}</option>
								<option value="1"><?php echo lang('open')?></option>
								<option value="2"><?php echo lang('inprogress')?></option>
								<option value="3"><?php echo lang('waiting')?></option>
								<option value="4"><?php echo lang('complete')?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="date">Due Date</label>
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input required type='input' name="duedate" value="{{taskdetail.duedate}}" class="form-control duedate" id="date"/>
						</div>
					</div>
					
				</div>
			</div>
			<div class="col-md-12 md-pt-0">
				<div class="modal-body md-pt-0">
					<div class="form-group">
					<label for="description"><?php echo lang('description'); ?></label>
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
							<textarea name="description" class="form-control pdesc" id="description" placeholder="Description">{{taskdetail.description}}</textarea>
						</div>
					</div>
				</div>
				<div class="modal-footer">
				<div class="ciuis-body-checkbox has-success pull-left">
						<input name="public" class="success-check" id="publivs" type="checkbox" <?= $task['public'] == 1 ? 'checked value="1"' : 'value="1"' ?>>
						<label for="publivs">
							<?php echo lang('public');?>
						</label>
					</div>
					<div class="ciuis-body-checkbox has-primary pull-left md-ml-20">
						<input name="billable" class="primary-check" id="billable" type="checkbox" <?= $task['billable'] == 1 ? 'checked value="1"' : 'value="1"' ?>>
						<label for="billable">
							Billable
						</label>
					</div>
					<div class="ciuis-body-checkbox has-primary pull-left md-ml-20">
						<input name="visible" class="primary-check" id="visible" type="checkbox" <?= $task['visible'] == 1 ? 'checked value="1"' : 'value="1"' ?>>
						<label for="visible">
							Visible (Customer)
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
						<?php echo lang('accountattentiondetail'); ?>
					</p>
					<div class="xs-mt-50">
						<a type="button" data-dismiss="modal" class="btn btn-space btn-default">
							<?php echo lang('cancel'); ?>
						</a>
						<a href="<?php echo base_url('tasks/remove/'.$task['id'].'')?>" type="button" class="btn btn-space btn-danger">
							<?php echo lang('delete'); ?>
						</a>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<script>
	<?php if ($task['relation_type'] === 'project'){$taskproject = $task['relation'];}?>
	
	var TASKID = "<?php echo $task['id'];?>";
	var TASKPROJECT = "<?php echo $taskproject ?>"
	var TASKMARKEDASCOMPLETE = 'Task marked as complete';
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>