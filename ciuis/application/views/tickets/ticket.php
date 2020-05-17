<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Ticket_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="ticket-container tab-container">
			<div class="active-view">
				<div class="ciuis-ticket">
					<div class="panel borderten">
						<?php $replies  = $this->db->get_where('ticketreplies',array('ticket_id'=> $ticket['id']))->result_array(); ?>
						<div class="ciuis-ticket-detail full-scroll tab-pane cont" id="ticketdetail">
							<span style="font-size: 22px"><strong><?php echo $ticket['subject']; ?></strong> ticket details.</span>
							<div class="ticket-actions pull-right">
								<div ng-show="activestaff == <?php echo $ticket['staff_id'] ?>" class="btn-group pull-right">
									<button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo lang('markas')?> <i class="ion-ios-circle-filled action-button-ciuis"></i></button>
									<ul class="dropdown-menu" role="menu">
										<li data-sname="<?php echo lang('open') ?>" data-status="1" data-ticket="<?php echo $ticket['id']; ?>"><a class="mark-as-t" href="#"><?php echo lang('open') ?></a> </li>
										<li data-sname="<?php echo lang('inprogress') ?>" data-status="2" data-ticket="<?php echo $ticket['id']; ?>"><a class="mark-as-t" href="#"><?php echo lang('inprogress') ?></a> </li>
										<li data-sname="<?php echo lang('answered') ?>" data-status="3" data-ticket="<?php echo $ticket['id']; ?>"><a class="mark-as-t" href="#"><?php echo lang('answered') ?></a> </li>
										<li data-sname="<?php echo lang('closed') ?>" data-status="4" data-ticket="<?php echo $ticket['id']; ?>"><a class="mark-as-t" href="#"><?php echo lang('closed') ?></a> </li>
									</ul>
								</div>
							</div>
							<div class="btn-group btn-space pull-right">
								<button type="button" class="btn btn-lg btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><?php echo lang('action')?> <i class="ion-android-more-vertical action-button-ciuis"></i></button>
								<ul class="dropdown-menu" role="menu">
									<li>
										<a data-toggle="modal" data-target="#assignstaff">
											<?php echo lang('assignstaff')?>
										</a>
									</li>
									<li class="divider"></li>
									<li>
										<a data-toggle="modal" data-target="#remove">
											<?php echo lang('delete')?>
										</a>
									</li>
								</ul>
							</div>
							<hr>
							<div class="ciuis-ticket-info">
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('assignedstaff')?>
										</div>
										<div class="ticket-data user-avatar">
											<?php if ($ticket['stid']==0) { echo '<span class="label label-default">'.lang('notassignedanystaff').'</span>';} else echo '<a style="text-transform: uppercase;" href="'.base_url('staff/staffmember/'.$ticket['stid'].'').'"> <img src="'.base_url().'/uploads/images/'.$ticket['staffavatar'].'" data-toggle="tooltip" data-placement="bottom" data-original-title="'.$ticket['staffmembername'].'"><b>'.$ticket['staffmembername'].'</b></a>'; ?>
										</div>
									</div>
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('customer')?>
										</div>
										<div class="ticket-data">
											<a href="<?php echo base_url('customers/customer/'.$ticket['customer_id'].'')?>">
												<?php if($ticket['type']==0) {echo $ticket['company'];}else echo $ticket['namesurname']; ?>
											</a>
										</div>
									</div>
								</div>
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('contactname')?>
										</div>
										<div class="ticket-data">
											<?php echo $ticket['contactname']; ?>
											<?php echo $ticket['surname']; ?>
										</div>
									</div>
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('department')?>
										</div>
										<div class="ticket-data">
											<?php echo $ticket['department']; ?>
										</div>
									</div>
								</div>
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('status')?>
										</div>
										<div class="ticket-data label-status">
											<?php 
											if ($ticket['status_id']== 1){ echo'<span class="label label-warning">'.lang('open').'</span>';} 
											if ($ticket['status_id']== 2){ echo'<span class="label label-primary">'.lang('inprogress').'</span>';}
											if ($ticket['status_id']== 3){ echo'<span class="label label-default">'.lang('answered').'</span>';}
											if ($ticket['status_id']== 4){ echo'<span class="label label-success">'.lang('closed').'</span>';}
											?>
										</div>
									</div>
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('priority')?>
										</div>
										<div class="ticket-data">
											<?php 
											if ($ticket['priority']== 1){ echo'<span class="ticket-priority label label-primary">'.lang('low').'</span>';} 
											if ($ticket['priority']== 2){ echo'<span class="ticket-priority label label-warning">'.lang('medium').'</span>';}
											if ($ticket['priority']== 3){ echo'<span class="ticket-priority label label-danger">'.lang('high').'</span>';}
											?>
										</div>
									</div>
								</div>
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('datetimeopened')?>
										</div>
										<div class="ticket-data">
											<?php echo  _adate($ticket['date']); ?>
										</div>
									</div>
									<div class="ciuis-ticket-fieldgroup">
										<div class="ticket-label">
											<?php echo lang('datetimelastreplies')?>
										</div>
										<div class="ticket-data">
											<?php echo  _adate($ticket['lastreply']); ?>
										</div>
									</div>
								</div>
								<div class="ciuis-ticket-row">
									<div class="ciuis-ticket-fieldgroup full">
										<div class="ticket-label">
											<b>
												<?php echo lang('message')?>
											</b>
										</div>
										<div style="padding: 10px; border: 2px solid #f6c162; border-radius: 3px; margin-bottom: 10px; font-weight: 600;" class="ticket-data">
											<?php echo $ticket['message']; ?>
											<?php if ($ticket['attachment'] != NULL) {echo '<br><span class="label label-default pull-right"><i class="ion-android-attach"></i> <a href="'.base_url('uploads/attachments/'.$ticket['attachment'].'').'">'.$ticket['attachment'].'</a></span><br>'; }?>
										</div>
										
									</div>
								</div>
								<div class="ticket-replies row">
								<div class="col-md-12">
								<section class="ciuis-notes show-notes">
								<?php foreach($replies as $reply){ ?>
									<article class="ciuis-note-detail">
										<div class="ciuis-note-detail-img">
											<img src="<?php echo base_url('assets/img/comment.png') ?>" alt="" width="50" height="50" />
										</div>
										<div class="ciuis-note-detail-body">
											<div class="text">
											  <p><?php echo $reply['message']?>
											  <?php if ($reply['attachment'] != NULL) {echo '<a class="delete-note-button pull-right" href="'.base_url('uploads/attachments/'.$reply['attachment'].'').'"><i class="ion-android-attach"></i></a></span>'; }?></p>
											</div>
											<p class="attribution">
											Replied by <strong><?php echo $reply['name']?></strong> at <?php echo  _adate($reply['date']); ?>
											</p>
										</div>
									</article>
								<?php } ?>
								</section>
								</div>
								<div class="col-md-12">
								<section class="col-md-12 <?php if($ticket['stid'] !== $this->session->userdata('logged_in_staff_id') && $ticket['stid'] != 0){echo 'hidden';}?>">
								<?php echo form_open_multipart('tickets/addreply',array("class"=>"form-horizontal")); ?>
									<div class="form-group">
										<textarea required name="message" placeholder="Type something" class="form-control note-description"></textarea>
										<input hidden="" type="text" name="ticket" value="<?php echo $ticket['id']; ?>">
										<input hidden="" type="text" name="contact" value="<?php echo $ticket['contact_id']; ?>">
										<input hidden="" type="text" name="name" value="<?php echo $staffname = $this->session->staffname; ?>">
										<input hidden="" type="text" name="staff" value="<?php echo $this->session->userdata('logged_in_staff_id'); ?>">
										<input hidden="" type="text" name="date" value="<?php echo date(" Y.m.d H:i:s "); ?>">
									</div>
									<div class="form-group pull-left">
										<div class="file-upload">
											<div class="file-select">
												<div class="file-select-button" id="fileName"><span class="mdi mdi-accounts-list-alt"></span>
													<?php echo lang('attachment')?>
												</div>
												<div class="file-select-name" id="noFile">
													<?php echo lang('notchoise')?>
												</div>
												<input type="file" name="attachment" id="chooseFile">
											</div>
										</div>
									</div>
									<div class="form-group pull-right">
										<button type="button" class="btn btn-default btn-space"><i class="icon s7-mail"></i> <?php echo lang('cancel')?></button>
										<button type="submit" class="btn btn-default btn-space"><i class="icon s7-close"></i> <?php echo lang('reply')?></button>
									</div>
								<?php echo form_close(); ?>
								</section>
								</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="assignstaff" tabindex="-1" role="content" class="modal fade colored-header colored-header-warning">
		<div class="modal-dialog">
			<?php echo form_open('tickets/assignstaff'); ?>
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title">
						<?php echo lang('assignstaff')?>
					</h3>
				</div>
				<div class="modal-body">

					<div class="form-group">
						<h4><b><?php echo lang('assignstaff'); ?></b></h4>
						<select name="staff" class="select2 ">
							<option selected="selected" value="0">
								<?php echo lang('assignstaff'); ?>
							</option>
							<?php
							foreach ( $all_staff as $staff ) {
								echo '<option value="' . $staff[ 'id' ] . '">' . $staff[ 'staffname' ] . '</option>';
							}
							?>
						</select>
					</div>
					<input hidden="" type="text" name="ticket" value="<?php echo $ticket['id']?>">

				</div>
				<div class="modal-footer">
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
						<?php echo lang('cancel'); ?>
					</button>
					<button type="submit" class="btn btn-default">
						<?php echo lang('assign'); ?>
					</button>
				</div>
			</div>
			<?php echo form_close(); ?>
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
							<?php echo lang('ticketattentiondetail'); ?>
						</p>
						<div class="xs-mt-50">
							<a type="button" data-dismiss="modal" class="btn btn-space btn-default">
								<?php echo lang('cancel'); ?>
							</a>
							<a href="<?php echo base_url('tickets/remove/'.$ticket['id'].'')?>" type="button" class="btn btn-space btn-danger">
								<?php echo lang('delete'); ?>
							</a>
						</div>
					</div>
				</div>
				<div class="modal-footer"></div>
			</div>
		</div>
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
	
</div>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>