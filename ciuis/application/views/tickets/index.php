<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Tickets_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-3">
	<div class="ticket-contoller-left">
	  <div class="tickets-top-left">
		<h1 class="text-bold" ng-bind="(tickets | filter:{staff_id:'<?php echo current_user_id ?>'}).length"></h1>
		<span>You Have</span>
	  </div>
		<div id="tickets-left-column text-left">
			<div class="col-md-12 ticket-row-left text-left">
			<p class="tickets-column-heading"><?php echo lang('browse') ?></p>
			<div class="tickets-vertical-menu">
			  <a ng-click="TicketsFilter = NULL" class="highlight text-uppercase"><i class="fa fa-inbox fa-lg" aria-hidden="true"></i> <?php echo lang('alltickets') ?> <span class="ticket-num" ng-bind="tickets.length"></span></a>
			  <a ng-click="TicketsFilter = {status_id: 1}" class="side-tickets-menu-item"><?php echo lang('open') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'1'}).length"></span></a>
			  <a ng-click="TicketsFilter = {status_id: 2}" class="side-tickets-menu-item"><?php echo lang('inprogress') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'2'}).length"></span></a>
			  <a ng-click="TicketsFilter = {status_id: 3}" class="side-tickets-menu-item"><?php echo lang('answered') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'3'}).length"></span></a>
			  <a ng-click="TicketsFilter = {status_id: 4}" class="side-tickets-menu-item"><?php echo lang('closed') ?> <span class="ticket-num" ng-bind="(tickets | filter:{status_id:'4'}).length"></span></a>
			  <h5 href="#" class="menu-icon active text-uppercase text-muted"><i class="fa fa-file-text fa-lg" aria-hidden="true"></i><?php echo lang('filterbypriority') ?></h5>
			  <a ng-click="TicketsFilter = {priority_id: 1}" class="side-tickets-menu-item"><?php echo lang('low') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'1'}).length"></span></a>
			  <a ng-click="TicketsFilter = {priority_id: 2}" class="side-tickets-menu-item"><?php echo lang('medium') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'2'}).length"></span></a>
			  <a ng-click="TicketsFilter = {priority_id: 3}" class="side-tickets-menu-item"><?php echo lang('high') ?> <span class="ticket-num" ng-bind="(tickets | filter:{priority_id:'3'}).length"></span></a>
			</div>
			</div>
			<button data-target="#addticket" data-toggle="modal" class="text-center btn btn-xl btn-warning"><span><i class="ion-plus-round"></i> <?php echo lang('newticket') ?></span></button>
		 </div>
	</div>
	</div>
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="tickets-top-barla"> 
		  <div class="col-md-3 col-xs-6 border-right text-uppercase">
				<div class="tasks-status-stat">
					<h3 class="text-bold ciuis-task-stat-title">
					<span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'1'}).length"></span>
					<span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
					</h3>
					<span class="ciuis-task-percent-bg">
					<span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'1'}).length * 100 / tickets.length }}%;"></span>
					</span>
				</div>
				<span style="color:#989898"><?php echo lang('open') ?></span>
			</div>
		  <div class="col-md-3 col-xs-6 border-right text-uppercase">
				<div class="tasks-status-stat">
					<h3 class="text-bold ciuis-task-stat-title">
					<span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'2'}).length"></span>
					<span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
					</h3>
					<span class="ciuis-task-percent-bg">
					<span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'2'}).length * 100 / tickets.length }}%;"></span>
					</span>
				</div>
				<span style="color:#989898"><?php echo lang('inprogress') ?></span>
			</div>
		  <div class="col-md-3 col-xs-6 border-right text-uppercase">
				<div class="tasks-status-stat">
					<h3 class="text-bold ciuis-task-stat-title">
					<span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'3'}).length"></span>
					<span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
					</h3>
					<span class="ciuis-task-percent-bg">
					<span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'3'}).length * 100 / tickets.length }}%;"></span>
					</span>
				</div>
				<span style="color:#989898"><?php echo lang('answered') ?></span>
			</div>
		  <div class="col-md-3 col-xs-6 border-right text-uppercase">
				<div class="tasks-status-stat">
					<h3 class="text-bold ciuis-task-stat-title">
					<span class="task-stat-number ng-binding" ng-bind="(tickets | filter:{status_id:'4'}).length"></span>
					<span class="task-stat-all ng-binding" ng-bind="'/'+' '+tickets.length+' '+'<?php echo lang('ticket') ?>'"></span>
					</h3>
					<span class="ciuis-task-percent-bg">
					<span class="ciuis-task-percent-fg" style="width: {{(tickets | filter:{status_id:'4'}).length * 100 / tickets.length }}%;"></span>
					</span>
				</div>
				<span style="color:#989898"><?php echo lang('closed') ?></span>
			</div>
		  </div>
		<div class="ticket-contoller-right">
		 <div class="col-md-4 ticket-list-by-priority">
		 <div class="ticket-list-by-priority-header">
		 	<span><i class="ion-android-alert text-danger"> </i><?php echo lang('high') ?></span>
		 </div>
			<div ng-repeat="ticket in tickets | filter:TicketsFilter | filter:search | filter: { priority_id: '3' }" class="tickets-top-bar-title">
		  	  <div  data-letter-avatar="MN" class="ticket-area-av-im2"></div>
			  <div class="ticket-area-icon-312_2"> 
			  	<a href="<?php echo base_url('tickets/ticket/') ?>{{ticket.id}}" ng-bind="ticket.subject"></a>
				<div><small>By </small> <small ng-bind="ticket.contactname"></small></div>
				<div ng-show="ticket.lastreply != NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small ng-bind="ticket.lastreply"></small></small></div>
				<div ng-show="ticket.lastreply == NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small>N/A</small></small></div>
				<div ng-hide="ticket.status_id != 4" class="ticket-closed-status ion-happy"></div>
			  </div>
			</div>
		 </div>
		 <div class="col-md-4 ticket-list-by-priority">
		 <div class="ticket-list-by-priority-header">
		 	<span><i class="ion-android-alert text-warning"> </i><?php echo lang('medium') ?></span>
		 </div>
		 	<div ng-repeat="ticket in tickets | filter:TicketsFilter | filter:search | filter: { priority_id: '2' }" class="tickets-top-bar-title">
		  	  <div  data-letter-avatar="MN" class="ticket-area-av-im2"></div>
			  <div class="ticket-area-icon-312_2"> 
			  	<a href="<?php echo base_url('tickets/ticket/') ?>{{ticket.id}}" ng-bind="ticket.subject"></a>
				<div><small>By </small> <small ng-bind="ticket.contactname"></small></div>
				<div ng-show="ticket.lastreply != NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small ng-bind="ticket.lastreply"></small></small></div>
				<div ng-show="ticket.lastreply == NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small>N/A</small></small></div>
				<div ng-hide="ticket.status_id != 4" class="ticket-closed-status ion-happy"></div>
			  </div>
			</div>
		 </div>
		 <div class="col-md-4 ticket-list-by-priority">
		 <div class="ticket-list-by-priority-header">
		 	<span><i class="ion-android-alert text-success"> </i><?php echo lang('low') ?></span>
		 </div>
		 	<div ng-repeat="ticket in tickets | filter:TicketsFilter | filter:search | filter: { priority_id: '1' }" class="tickets-top-bar-title">
		  	  <div  data-letter-avatar="MN" class="ticket-area-av-im2"></div>
			  <div class="ticket-area-icon-312_2"> 
			  	<a href="<?php echo base_url('tickets/ticket/') ?>{{ticket.id}}" ng-bind="ticket.subject"></a>
				<div><small>By </small> <small ng-bind="ticket.contactname"></small></div>
				<div ng-show="ticket.lastreply != NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small ng-bind="ticket.lastreply"></small></small></div>
				<div ng-show="ticket.lastreply == NULL"><small><strong><?php echo lang('lastreply') ?></strong> <small>N/A</small></small></div>
				<div ng-hide="ticket.status_id != 4" class="ticket-closed-status ion-happy"></div>
			  </div>
			</div>
		 </div>
		</div>
	</div>
<div id="addticket" tabindex="-1" role="content" class="modal fade colored-header colored-header-warning">
	<div class="modal-dialog">
		<?php echo form_open_multipart('tickets/add'); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title"><?php echo lang('newticket')?></h3>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
						<label for="subject">
							<?php echo lang('subject')?>
						</label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-information"></i></span>
							<input type="text" name="subject" value="<?php echo $this->input->post('subject'); ?>" class="form-control" id="title" placeholder="<?php echo lang('subject')?>"/>
						</div>
					</div>
				</div>
				<div class="col-md-6 md-pr-0">
					<div class="form-group">
						<label for="category">
							<?php echo lang('department')?>
						</label>
						<div class="add-on-edit">
							<select name="department" class="form-control select2">
								<option ng-repeat="department in departments" value="{{department.id}}">{{department.name}}</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="category">
							<?php echo lang('customer')?>
						</label>
						<div class="add-on-edit">
							  <select name="customer" class="form-control" ng-model="customers[$index]" ng-options="customer as customer.name for customer in customers track by customer.id"></select>
						</div>
					</div>
				</div>
				<div class="col-md-6 md-pr-10">
					<div class="form-group">
						<label for="p">
							<?php echo lang('priority')?>
						</label>
						<div class="add-on-edit">
							<select name="priority" class="form-control select2">
								<option value="0"><?php echo lang('low')?></option>
								<option value="1"><?php echo lang('medium')?></option>
								<option value="2"><?php echo lang('high')?></option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label for="category">
							<?php echo lang('contact')?>
						</label>
						<div class="add-on-edit">
							   <select name="contact" class="form-control" ng-model="contacts[$index]" ng-options="contact as contact.name +' '+ contact.surname for contact in customers[$index].contacts track by contact.id"></select>
						</div>
					</div>
				</div>
				<input hidden="" type="text" name="created" value="<?php echo date(" Y-m-d H:i:s "); ?>"/>
				<input type="hidden" name="staff" value="<?php echo $this->session->userdata('logged_in_staff_id'); ?>">
				<div class="col-md-12 md-pt-0">
					<div class="form-group">
						<label for="description">
							<?php echo lang('message')?>
						</label>
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-compose-outline"></i></span>
							<textarea name="message" class="form-control" id="message" placeholder="Message"><?php echo $this->input->post('message'); ?></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="file-upload">
							<div class="file-select">
								<div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span> <?php echo lang('attachment')?></div>
								<div class="file-select-name" id="noFile"><?php echo lang('nofile')?></div>
								<input type="file" name="attachment" id="chooseFile">
							</div>
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
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
</div>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>
