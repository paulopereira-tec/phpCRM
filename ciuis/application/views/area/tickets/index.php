<div class="ciuis-body-content">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="ticket-container tab-container">
			<div class="active-view">
				<div class="list-view">
					<div class="list-view-top">
						<input hidden="" type="search" class="textfilter" placeholder="Search by name"/>
						<form class="ticketfilterselectbox">
							<label class="select-box">
							<select id="select" class="filterbyword">
								<option value="all"><?php echo lang('all')?></option>
								<option value="2"><?php echo lang('high')?></option>
								<option value="1"><?php echo lang('medium')?></option>
								<option value="0"><?php echo lang('low')?></option>
							</select>
						</label>
						
						</form>
					</div>
					<ul class="list-view-list full-scroll nav tickets-tab">
						<?php foreach($tickets as $ticket){ ?>
						<li id="dana" class="<?php echo $ticket['priority']?>">
							<a href="<?php echo base_url('area/ticket/'.$ticket['id'].'');?>">
								<?php switch($ticket['priority']){ 
								case '0': echo '<span class="ticket-priority label label-primary">'.lang('low').'</span>';break; 
								case '1': echo '<span class="ticket-priority label label-warning">'.lang('medium').'</span>'; break;
								case '2': echo '<span class="ticket-priority label label-danger">'.lang('high').'</span>'; break;
								}?>
								<h3><?php echo lang('ticket')?>: <?php echo $ticket['id']; ?></h3>
								<h4>
									<?php echo $ticket['subject']; ?>
								</h4>
								<p>
									<?php echo $ticket['message']; ?>
								</p>
							</a>
						</li>
						<?php } ?>
					</ul>
				</div>
				<div class="ciuis-ticket">
					<div class="ciuis-ticket-top">
						<div class="ciuis-ticket-stats">
							<div class="row" style="padding: 0px 20px 0px 20px;">
								<ul class="ciuis-ticket-stats grid">
									<li class="ciuis-ist-tab ciuis-ist-tab-border-right col-md-3"> <span class="ciuis-is-x-status"><?php echo lang('open')?></span>
										<div class="pull-right"> <span class="ciuis-ticket-percent"> <span class="ciuis-ticket-percent-bg"> <span class="ciuis-ticket-percent-fg" style="width: <?php echo $ysy ?>%;"></span> </span> <span class="ciuis-ticket-percent-labels"> <span class="ciuis-ticket-percent-label"> %<?php echo $ysy ?> </span>
											<span class="ciuis-is-x-completes">
												<?php $this->db->where('status_id = 1 AND contact_id = '.$_SESSION[ 'contact_id' ].'');$this->db->from('tickets'); echo $this->db->count_all_results();?> /
												<?php $this->db->from('tickets')->where('contact_id = '.$_SESSION[ 'contact_id' ].''); echo $this->db->count_all_results();?> </span>
											</span>
											</span>
										</div>
									</li>
									<li class="ciuis-ist-tab ciuis-ist-tab-border-right col-md-3"> <span class="ciuis-is-x-status"><?php echo lang('inprogress')?></span>
										<div class="pull-right"> <span class="ciuis-ticket-percent"> <span class="ciuis-ticket-percent-bg"> <span class="ciuis-ticket-percent-fg" style="width: <?php echo $bsy ?>%;"></span> </span> <span class="ciuis-ticket-percent-labels"> <span class="ciuis-ticket-percent-label"> %<?php echo $bsy ?> </span>
											<span class="ciuis-is-x-completes">
												<?php $this->db->where('status_id = 2 AND contact_id = '.$_SESSION[ 'contact_id' ].'');$this->db->from('tickets'); echo $this->db->count_all_results();?> /
												<?php $this->db->from('tickets')->where('contact_id = '.$_SESSION[ 'contact_id' ].''); echo $this->db->count_all_results();?> </span>
											</span>
											</span>
										</div>
									</li>
									<li class="ciuis-ist-tab ciuis-ist-tab-border-right col-md-3"> <span class="ciuis-is-x-status"><?php echo lang('answered')?></span>
										<div class="pull-right"> <span class="ciuis-ticket-percent"> <span class="ciuis-ticket-percent-bg"> <span class="ciuis-ticket-percent-fg" style="width: <?php echo $twy ?>%;"></span> </span> <span class="ciuis-ticket-percent-labels"> <span class="ciuis-ticket-percent-label"> %<?php echo $twy ?> </span>
											<span class="ciuis-is-x-completes">
												<?php $this->db->where('status_id = 3 AND contact_id = '.$_SESSION[ 'contact_id' ].'');$this->db->from('tickets'); echo $this->db->count_all_results();?> /
												<?php $this->db->from('tickets')->where('contact_id = '.$_SESSION[ 'contact_id' ].''); echo $this->db->count_all_results();?> </span>
											</span>
											</span>
											</span>
										</div>
									</li>
									<li class="ciuis-ist-tab col-md-3"> <span class="ciuis-is-x-status"><?php echo lang('closed')?></span>
										<div class="pull-right"> <span class="ciuis-ticket-percent"> <span class="ciuis-ticket-percent-bg"> <span class="ciuis-ticket-percent-fg" style="width: <?php echo $iey ?>%;"></span> </span> <span class="ciuis-ticket-percent-labels"> <span class="ciuis-ticket-percent-label"> %<?php echo $iey ?> </span>
											<span class="ciuis-is-x-completes">
												<?php $this->db->where('status_id = 4 AND contact_id = '.$_SESSION[ 'contact_id' ].'');$this->db->from('tickets'); echo $this->db->count_all_results();?> /
												<?php $this->db->from('tickets')->where('contact_id = '.$_SESSION[ 'contact_id' ].''); echo $this->db->count_all_results();?> </span>
											</span>
											</span>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>
					<div class="ciuis-ticket-bottom pull-right lg-p-20">
						<button data-target="#addticket" data-toggle="modal" class="btn btn-warning btn-xl"><?php echo lang('newticket')?></button>
						<div id="addticket" tabindex="-1" role="content" class="modal fade colored-header colored-header-warning">
							<div class="modal-dialog">
								<?php echo form_open_multipart('area/addticket'); ?>
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
														<?php
														foreach ( $departments as $department ) {
															$selected = ( $department[ 'id' ] == $this->input->post( 'department' ) ) ? ' selected="selected"' : "";
															echo '<option value="' . $department[ 'id' ] . '" ' . $selected . '>' . $department[ 'name' ] . '</option>';
														}
														?>
													</select>
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
				</div>
			</div>
		</div>
	</div>
	<?php include_once(APPPATH . 'views/area/inc/sidebar.php'); ?>
	
</div>
<?php include_once(APPPATH . 'views/area/inc/footer.php');?>