<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Customer_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="row ciuis-customers-detail-header">
			<div class="col-md-4">
				<h3 class="text-bold"><?php if ($customers['type']==0) { echo $customers['company'];} else echo $customers['namesurname']; ?></h3>
				<address style="font-weight:500; color:#b5b5b5;" class="invoice-address text-muted"><?php echo $customers['address']; ?></address>
			</div>
			<div class="col-md-3">
				<div class="reset-ul">
					<address class="ciuis-customer-detail-am">
						<p class="cmdam-title"><strong><span class="mdi mdi-email"></span> <?php echo lang('customeremail');?></strong></p>
						<span class="cmdam-detail"><?php echo $customers['email']; ?></span>
					</address>
					<address class="ciuis-customer-detail-am">
						<p class="cmdam-title"><strong><span class="mdi mdi-globe-alt"></span> <?php echo lang('customerweb');?></strong></p>
						<span class="cmdam-detail"><?php echo $customers['web']; ?></span>
					</address>
				</div>
			</div>
			<div class="col-md-3">
				<div class="reset-ul">
					<address class="ciuis-customer-detail-am">
						<p class="cmdam-title"><strong><span class="mdi mdi-phone"></span> <?php echo lang('customerphone');?></strong></p>
						<span class="cmdam-detail"><?php echo $customers['phone']; ?></span>
					</address>
					<address class="ciuis-customer-detail-am">
						<p class="cmdam-title"><strong><span class="mdi mdi-dialpad"></span> <?php echo lang('customerfax');?></strong></p>
						<span class="cmdam-detail"><?php echo $customers['fax']; ?></span>
					</address>
				</div>
			</div>
			<div class="col-md-2 text-right">
				<h2 style="font-weight: 600; color: #6e7479; padding: 0; margin-bottom: 0; text-align: center; line-height: 12px;">
					<?php $this->db->select_sum('total');$this->db->from('invoices');$this->db->where('(status_id = 3 AND customer_id = '.$customers['id'].') ');
						$mbb = $this->db->get();if ($mbb->row()->total>0){echo'<span style="font-size: 22px;" class="money-area">'.$mbb->row()->total.'<br><span style="font-size:10px">'.lang('currentdebt').'</span>';}else{echo '<i style="font-size: 39px;" class="text-success ion-android-checkmark-circle"></i><br><span class="text-success" style="font-size:10px">'.lang('nobalance').'</span>' ;}?>
				</h2>
			</div>
		</div>
		<div style="border-top: 2px solid #d8dfe3;">
		<ul class="nav nav-tabs">
			<li class="active"><a href="#customersummary" data-toggle="tab" aria-expanded="true"><strong><?php echo lang('summary');?></strong></a></li>
			<li class=""><a href="#invoices" data-toggle="tab" aria-expanded="false"><strong><?php echo lang('customerinvoices');?></strong></a>	</li>
			<li class=""><a href="#proposals" data-toggle="tab" aria-expanded="false"><strong><?php echo lang('proposals');?></strong></a>	</li>
			<li class=""><a href="#payments" data-toggle="tab" aria-expanded="false"><strong><?php echo lang('payments')?></strong></a></li>
			<li class=""><a href="#tickets" data-toggle="tab" aria-expanded="false"><strong><?php echo lang('tickets')?></strong></a></li>
			<li><a href="#notes" data-toggle="tab"><strong><i class="ion-document-text"></i> <?php echo lang('notes') ?></strong></a></li>
			<li><a href="#reminders" data-toggle="tab"><strong><i class="ion-ios-bell"></i> <?php echo lang('reminders') ?></strong></a></li>
		</ul>
		</div>
		<div class="main-content container-fluid col-md-4" style="padding-right: 0;padding-left: 0;padding-top: 0;border-top: 1px solid #d8dfe3;">
			<div id="ciuis-customer-detail-contacts">
				<div id="ciuis-customer-detail-contacts-list">
					<div id="ciuis-customer-contacts-menu">
						<div class="pull-left"><h4><?php echo lang('customercontacts');?></h4></div>
						<div data-target="#contactadd" data-toggle="modal" class="pull-right add-contact-button"><i class="ion-person-add"></i></div>
					</div>
					<div id="ciuis-customer-contact-detail">
					<div class="contact-contents" ng-repeat="contact in contacts">
						<div class="ciuis-customer-contacts">
							<div data-toggle="modal" data-target="#contactmodal{{contact.id}}">
								<div class="ciuis-contact-avatar"><span class="avatar-xs-title">{{contact.name}}</span></div>
								<div style="padding: 16px;position: initial;">
									<strong>{{contact.name}} {{contact.surname}}</strong>
									<br>
									<span>{{contact.email}}</span>
								</div>
								<div class="status" ng-class="{'available' : contact.primary != 0}"></div>
							</div>
						</div>
						<!-- Oter Contact Actions -->
						<div id="contactmodal{{contact.id}}" tabindex="-1" role="dialog" class="modal fade contact-detail-modal">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
									</div>
									<div class="modal-body">
										<div class="user-info-list panel panel-default">
											<div class="panel-heading panel-heading-divider">
												<strong>{{contact.name}} {{contact.surname}}</strong>
												<h4 style="margin: 0px;" class="pull-right">
													<span ng-show="contact.primary != 0" class="text-success"><i class="ion-person"></i> <b><?php echo lang('primarycontact')?></b></span>
												</h4>
												<span class="panel-subtitle"><strong>{{contact.email}}</strong></span>
											</div>
											<div class="panel-body">
												<table class="no-border no-strip skills">
													<tbody class="no-border-x no-border-y">
														<tr style="border-bottom: 1px solid rgb(239, 239, 239);">
															<td class="icon"><span class="mdi mdi-case"></span></td>
															<td class="item"><?php echo lang('contactposition')?><span class="icon s7-portfolio"></span></td>
															<td>{{contact.position}}</td>
														</tr>
														<tr style="border-bottom: 1px solid rgb(239, 239, 239);">
															<td class="icon"><span class="mdi mdi-phone"></span></td>
															<td class="item"><?php echo lang('contactphone')?><span class="icon s7-phone"></span></td>
															<td>{{contact.phone}} - {{contact.intercom}}</td>
														</tr>
														<tr style="border-bottom: 1px solid rgb(239, 239, 239);">
															<td class="icon"><span class="mdi ion-iphone"></span></td>
															<td class="item"><?php echo lang('contactmobile')?><span class="icon s7-phone"></span></td>
															<td>{{contact.mobile}}</td>
														</tr>
														<tr style="border-bottom: 1px solid rgb(239, 239, 239);">
															<td class="icon"><span class="mdi mdi-pin"></span></td>
															<td class="item"><?php echo lang('contactaddress')?><span class="icon s7-map-marker"></span></td>
															<td>{{contact.address}}</td>
														</tr>
														<tr style="border-bottom: 1px solid rgb(239, 239, 239);">
															<td class="icon"><span class="mdi mdi-skype"></span></td>
															<td class="item"><?php echo lang('contactskype')?><span class="icon s7-gift"></span></td>
															<td>{{contact.skype}}</td>
														</tr>
														<tr style="border-bottom: 1px solid rgb(239, 239, 239);">
															<td class="icon"><span class="mdi mdi-linkedin"></span></td>
															<td class="item"><?php echo lang('contactlinkedin')?><span class="icon s7-gift"></span></td>
															<td>{{contact.linkedin}}</td>
														</tr>
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="modal-footer">
										<button ng-click='ChangePasswordButton()' data-toggle="modal" data-target="#changepassword{{contact.id}}" class="btn btn-danger modal-close pull-left"><i class="ion-refresh"> </i><?php echo lang('changepassword')?></button>
										<div class="btn-group">
											<button ng-click='DeleteContactButton()' data-toggle="modal" data-target="#mod-danger{{contact.id}}" class="btn btn-default modal-close contact-delete-button"><?php echo lang('delete')?></button>
											<button ng-click='EditContactButton()' data-toggle="modal" data-target="#updatecontact{{contact.id}}" type="submit" class="btn btn-default modal-close"><?php echo lang('edit')?></button>
										</div>
									</div>
								</div>
							</div>
						</div>
						<div id="changepassword{{contact.id}}" tabindex="-1" role="dialog" class="modal fade">
							<div class="modal-dialog">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="pull-left"><?php echo lang('changepassword');?></h3>
										<button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
									</div>
									<hr>
									<div class="modal-body">
										<div class="col-md-12 nopadding">
											<div class="form-group">
												<label for="ad">
													<b><?php echo lang('password');?></b>
												</label>
												<p class="xs-mb-5">Customer Area Login Password<a href="javascript:;" data-toggle="popover" data-trigger="hover" title="<?php echo lang('information')?>" data-content="<?php echo lang('contactprimaryhover')?>" data-placement="top"><b> ?</b></a>
												</p>
												<div class="input-group ">
													<input ng-model="contact.newpassword" type="text" class="form-control " rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
													<span class="input-group-btn"><button type="button" class="btn btn-default getNewPass"><span class="ion-refresh"></span>
													</button>
													</span>
												</div>
											</div>
										</div>
										<div class="form-group">
											<button ng-click="UpdateContactPassword($index)" class="btn btn-default pull-right"><?php echo lang('changepassword');?></button>
										</div>
									</div>
									<div class="modal-footer"></div>
								</div>
							</div>
						</div>
						<div id="mod-danger{{contact.id}}" tabindex="-1" role="dialog" class="modal fade">
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
												<?php echo lang('contactattentiondetail'); ?>
											</p>
											<div class="xs-mt-50">
												<a type="button" data-dismiss="modal" class="btn btn-space btn-default">
													<?php echo lang('cancel'); ?>
												</a>
												<a href="<?php echo base_url(); ?>contacts/remove/{{contact.id}}" type="button" class="btn btn-space btn-danger">
													<?php echo lang('delete'); ?>
												</a>
											</div>
										</div>
									</div>
									<div class="modal-footer"></div>
								</div>
							</div>
						</div>
						<div id="updatecontact{{contact.id}}" tabindex="-1" role="dialog" class="modal fade">
							<div class="modal-dialog modal-lg">
								<div class="modal-content">
									<div class="modal-header">
										<h3 class="pull-left">
											<?php echo lang('update');?>
										</h3>
										<button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
									</div>
									<div class="modal-body">
										<div class="col-md-12 nopadding">
											<md-input-container flex-gt-sm class="col-md-4">
											  <label><?php echo lang('contactname');?></label>
											  <input ng-model="contact.name">
											</md-input-container>
											<md-input-container flex-gt-sm class="col-md-4">
											  <label><?php echo lang('contactsurname');?></label>
											  <input ng-model="contact.surname">
											</md-input-container>
											<md-input-container flex-gt-sm class="col-md-4">
											  <label><?php echo lang('contactposition');?></label>
											  <input ng-model="contact.position">
											</md-input-container>

										</div>
										<div class="col-md-12 nopadding">
											<md-input-container class="col-md-4">
											  <label><?php echo lang('contactphone');?></label>
											  <input ng-model="contact.phone">
											</md-input-container>
											<md-input-container class="col-md-4">
											  <label><?php echo lang('contactintercom');?></label>
											  <input ng-model="contact.intercom">
											</md-input-container>
											<md-input-container class="col-md-4">
											  <label><?php echo lang('contactmobile');?></label>
											  <input ng-model="contact.mobile">
											</md-input-container>
										</div>
										<div class="col-md-12 nopadding">
											<md-input-container class="col-md-4">
											  <label><?php echo lang('contactemail');?></label>
											  <input ng-model="contact.email">
											</md-input-container>
											<md-input-container class="col-md-4">
											  <label><?php echo lang('contactskype');?></label>
											  <input ng-model="contact.skype">
											</md-input-container>
											<md-input-container class="col-md-4">
											  <label><?php echo lang('contactlinkedin');?></label>
											  <input ng-model="contact.linkedin">
											</md-input-container>
										</div>
										<div class="col-md-12 nopadding">
											<md-input-container class="col-md-12">
											  <label><?php echo lang('contactaddress');?></label>
											  <input ng-model="contact.address">
											</md-input-container>
										</div>
										<div class="form-group">
											<button ng-click="UpdateContact($index)" class="btn btn-ciuis pull-right ci-update-contact-button"><?php echo lang('update');?></button>
										</div>
									</div>
									<div class="modal-footer"></div>
								</div>
							</div>
						</div>
						<!-- Oter Contact Actions -->
					</div>
				</div>
				</div>
			</div>
		</div>
		<div class="main-content container-fluid col-md-8" style="padding: 0;border-top: 1px solid #d8dfe3;">
			<div class="panel-default panel-tab">
				<div class="tab-container">
				<ul class="nav nav-tabs" style="height: 44px">
						<li style="margin-top: 5px;margin-right: 10px;" class="btn-group btn-space pull-right">
							<button type="button" data-target="#edit" data-toggle="modal" data-placement="left" title="" class="btn btn-default" data-original-title="<?php echo lang('edit')?>"><i class="icon mdi mdi-edit"> </i> <?php echo lang('editcustomer') ?></button>
							<button type="button" data-target="#remove" data-toggle="modal" data-placement="left" title="" class="btn btn-default" data-original-title="<?php echo lang('delete')?>"><i class="icon mdi mdi-delete"></i></button>
						</li>
					</ul>
					<div class="tab-content ciuis-customers-wrapper">
						<div id="customersummary" class="tab-pane cont active">
							<div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-4">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2>
											<?php echo lang('riskstatus');?>
										</h2>
										<small>
											<?php echo lang('customerrisksubtext');?>
										</small>
										<?php 
											$this->db->select('risk');
											$this->db->from('customers');
											$this->db->where('(id = '.$customers['id'].') ');
											$riskstatus = $this->db->get();

											if ($riskstatus->row()->risk<1)
											{
												echo '<div class="stat"><span style="color:#eaeaea;"><i class="text-success mdi mdi-shield-check"></i> '.lang('norisk').'</span></div>' ;
											}
											else 
											{if ($riskstatus->row()->risk>50)
												{
													echo '<div class="stat"><span>%'.$riskstatus->row()->risk.'</span></div><div class="progress"><div style="width: '.$riskstatus->row()->risk.'%" class="progress-bar progress-bar-danger"></div></div>' ;
												}
												else
													echo '<div class="stat"><span>%'.$riskstatus->row()->risk.'</span></div><div class="progress"><div style="width: '.$riskstatus->row()->risk.'%" class="progress-bar progress-bar-primary"></div></div>' ;
											}
										?>
										<p>
											<?php echo lang('customerrisksubtext');?>
										</p>
									</div>
								</div>
							</div>
							<div style="border-right: 1px solid rgb(234, 234, 234);" class="col-md-4">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2>
											<?php echo lang('netsales');?>
										</h2>
										<small>
											<?php echo lang('netsalesdetail');?>
										</small>
										<div class='stat'>
											<span>
												<?php 
													$this->db->select_sum('total');
													$this->db->from('invoices');
													$this->db->where('(status_id = 2 AND customer_id = '.$customers['id'].') ');
													$mbb = $this->db->get();
													if ($mbb->row()->total>0){
														echo '<span class="money-area">'.$mbb->row()->total.'</span>';
													}
													else{
														echo '<span class="text-success" style="font-size:10px">'.lang('nosalesyet').'</span>' ;
													}
												?>
												
											</span>
										</div>
										<p>
											<?php echo lang('netsalesdescription');?>
										</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class='customer-42525'>
									<div class='customer-42525__inner'>
										<h2>
											<?php echo lang('totalsales');?>
										</h2>
										<small>
											<?php echo lang('totalsalesdetail');?>
										</small>
										<div class='stat'>
											<span>
												<?php 
													$this->db->select_sum('total');
													$this->db->from('invoices');
													$this->db->where('(status_id != 1 AND customer_id = '.$customers['id'].') ');
													$mbb = $this->db->get();
													if ($mbb->row()->total>0){
														echo '<span class="money-area">'.$mbb->row()->total.'</span>';
													}
													else{
														echo '<span class="text-success" style="font-size:10px">'.lang('nosalesyet').'</span>' ;
													}
												?>
											</span>
										</div>
										<p>
											<?php echo lang('totalsalesdescription');?>
										</p>
									</div>
								</div>
							</div>
							<hr style="margin-bottom: 10px;">
							<div class="my-2">
								<div class="chart-wrapper" style="height:210">
									<canvas id="customerthisyearsalesgraph" height="210px"></canvas>
								</div>
							</div>
						</div>
						<div id="invoices" class="tab-pane">
							<div class="panel panel-default panel-table">
								<div class="panel-body" style="overflow: scroll;height: 410px;">
									<table id="table2" class="table table-striped table-hover table-fw-widget">
										<thead>
											<tr>
												<th><?php echo lang('id')?></th>
												<th><?php echo lang('dateofissuance')?></th>
												<th class="text-right"><?php echo lang('total')?></th>
											</tr>
										</thead>
										<?php foreach($invoices as $mf){ ?>
										<tr>
											<td>
												<a class="label label-default" href="<?php echo base_url('invoices/invoice/'.$mf['id'].'')?>"><i class="ion-document"> </i><?php echo lang('invoiceprefix'),'-',str_pad($mf['id'], 6, '0', STR_PAD_LEFT); ?></a>
											</td>
											<td>
												<?php echo _adate($mf['created']); ?>
											</td>
											<td class="text-right">
											<span class="money-area"><?php echo $mf['total']?></span>
											</td>
										</tr>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>
						<div id="proposals" class="tab-pane">
							<div class="panel panel-default panel-table">
								<div class="panel-body" style="overflow: scroll;height: 410px;">
									<table id="table2" class="table table-striped table-hover table-fw-widget">
										<thead>
											<tr>
												<th><?php echo lang('id')?></th>
												<th><?php echo lang('subject')?></th>
												<th><?php echo lang('dateofissuance')?></th>
												<th><?php echo lang('opentill')?></th>
												<th class="text-right"><?php echo lang('total')?></th>
											</tr>
										</thead>
										<?php foreach($proposals as $proposal){ ?>
										<tr>
										
											<td>
												<a class="label label-default" href="<?php echo base_url('proposals/proposal/'.$proposal['id'].'')?>"><i class="ion-document"> </i><?php echo lang('proposalprefix'),'-',str_pad($proposal['id'], 6, '0', STR_PAD_LEFT); ?></a>
											</td>
											<td><?php echo $proposal['subject']?></td>
											<td>
												<?php echo _adate($proposal['date']); ?>
											</td>
											<td>
												<?php echo _adate($proposal['opentill']); ?>
											</td>
											<td class="text-right">
											<span class="money-area"><?php echo $proposal['total']?></span>
											</td>
										</tr>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>
						<div id="payments" class="tab-pane cont">
							<div class="panel panel-table">
								<div class="panel-body" style="overflow: scroll;height: 410px;">
									<table id="table2" class="table table-striped table-hover table-fw-widget">
										<thead>
											<tr>
												<th><?php echo lang('id')?></th>
												<th><?php echo lang('invoice')?></th>
												<th><?php echo lang('date')?></th>
												<th class="text-right"><?php echo lang('amount')?></th>
											</tr>
										</thead>
										<?php foreach($payments as $payment){ ?>
										<tr>
											<td>
												<a class="label label-default" href=""><i class="ion-document"> </i><?php echo $payment['id']; ?></a>
											</td>
											<td>
												<b><a class="label label-default" href="<?php echo base_url('invoices/invoice/'.$payment['invoice_id'].'')?>"><?php echo lang('invoiceprefix'),'-',$payment['invoice_id']; ?></a></b>

											</td>
											<td>
												<?php echo _adate($payment['date']); ?>
											</td>
											<td class="text-right">
												<span class="money-area"><?php echo $payment['amount']?></span>
											</td>
										</tr>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>
						<div id="tickets" class="tab-pane">
							<div class="panel panel-default panel-table">
								<div class="panel-body" style="overflow: scroll;height: 410px;">
									<table id="table2" class="table table-striped table-hover table-fw-widget">
										<thead>
											<tr>
												<th><?php echo lang('id')?></th>
												<th><?php echo lang('subject')?></th>
												<th><?php echo lang('date')?></th>
												<th class="text-right"><?php echo lang('status')?></th>
											</tr>
										</thead>
										<?php foreach($tickets as $tickets){ ?>
										<tr>
											<td>
												<a class="label label-default" href="<?php echo base_url('tickets/ticket/'.$tickets['id'].'')?>"><i class="ion-document"> </i><?php echo $tickets['id']; ?></a>
											</td>
											<td>
												<?php echo $tickets['subject'] ?>
											</td>
											<td><?php echo _adate($tickets['date']); ?></td>
											<td class="text-right">
												<?php echo $tickets['status_id'] ?>
											</td>
										</tr>
										<?php } ?>
									</table>
								</div>
							</div>
						</div>
						<div id="notes" class="tab-pane">
							<div class="col-md-12" style="margin-top: 10px; height: 435px; overflow: scroll;">
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
										by <strong><a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}" ng-bind="note.staff"></a></strong> at <span ng-bind="note.date"></span>
										</p>
									</div>
								</article>
							</section>
							<section class="md-pb-30">
								<div class="form-group">
									<textarea required name="description" placeholder="Type something" class="form-control note-description"></textarea>
									<input class="note-relation-id" hidden="" type="text" name="customer" value="<?php echo $customers['id'] ?>">
									<input class="note-type" hidden="" type="text" value="customer">
								</div>
								<div class="form-group pull-right">
									<button type="button" class="btn btn-default btn-space"><i class="icon s7-mail"></i> <?php echo lang('cancel')?></button>
									<button class="btn btn-default btn-space add-note-button"><i class="icon s7-close"></i> <?php echo lang('add')?></button>
								</div>
							</section>
							</div>
						</div>
						<div id="reminders" class="tab-pane cont">
							<div class="panel panel-default panel-table">
								<div class="panel-body" style="overflow: scroll;height: 410px;">
									<table class="table table-striped table-hover reminder-table">
										<thead>
											<tr>
												<th style="width:30%;">
													<?php echo lang('description') ?>
												</th>
												<th style="width:20%;">
													<?php echo lang('remind') ?>
												</th>
												<th style="width:10%;">
													<?php echo lang('date') ?>
												</th>
												<th style="width:10%; text-align: right;">
													<button type="button" data-toggle="dropdown" class="add-reminder btn btn-default dropdown-toggle ion-android-alarm-clock">
														<?php echo lang('addreminder') ?>
													</button>
												</th>
											</tr>
										</thead>
										<tbody>
											<?php foreach($reminders as $reminder) {?>
											<tr class="reminder-<?php echo $reminder['id']; ?>">
												<td class="cell-detail">
													<span class="cell-detail-description">
														<?php echo $reminder['description']; ?>
													</span>
												</td>
												<td class="user-avatar cell-detail user-info"><img src="<?php echo base_url('uploads/images/'.$reminder['staffpicture'].'')  ?>" alt="Avatar">
													<span>
														<?php echo $reminder['reminderstaff']; ?>
													</span>
												</td>
												<td class="cell-detail">
													<span>
														<?php echo _adate($reminder['date']); ?>
													</span>
												</td>
												<td class="text-right"><button data-reminder="<?php echo $reminder['id']; ?>" type="button" class="btn btn-default ion-android-delete delete-reminder"></button>
												</td>
											</tr>
											<?php }?>
										</tbody>
									</table>
									<div class="reminder-form col-md-12" style="display: none">
										<?php echo form_open_multipart('customers/addreminder',array("class"=>"form-horizontal col-md-12")); ?>
										<div class="col-md-12 md-p-0">
											<div class="col-md-6 md-pl-0">
												<div class="form-group md-pl-0 md-pr-10">
													<label for="date">
														<?php echo lang('datetobenotified'); ?>
													</label>
													<div data-start-view="3" data-date-format="yyyy-mm-dd - HH:ii" data-link-field="dtp_input1" class="input-group date datetimepicker"><span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
														<input name="date" required size="16" type="text" value="<?php $this->input->post('date')?>" class="form-control ci-event-start" placeholder="<?php echo date(" d.m.Y "); ?>">
													</div>
												</div>
											</div>

											<div class="col-md-6 md-pr-0">
												<div class="form-group  md-pr-0">
													<label for="staff">
														<?php echo lang('setreminderto');?>
													</label>
													<select required name="staff" class="select2">
														<?php
														foreach ( $all_staff as $staff ) {
															$selected = ( $staff[ 'id' ] == $this->input->post( 'staff' ) ) ? ' selected="selected"' : null;
															echo '<option value="' . $staff[ 'id' ] . '" ' . $selected . '>' . $staff[ 'staffname' ] . '</option>';
														}
														?>
													</select>
												</div>
											</div>
										</div>
										<div class="form-group">
											<label for="assignedstaff">
												<?php echo lang('description');?>
											</label>
											<textarea name="description" class="form-control"><?php $this->input->post('description')?></textarea>
											<input hidden="" type="text" name="relation" value="<?php echo $customers['id']; ?>">
										</div>
										<div class="form-group pull-right">
											<button type="button" class="btn btn-default btn-space reminder-cancel"><i class="icon s7-mail"></i> <?php echo lang('cancel')?></button>
											<button type="submit" class="btn btn-default btn-space"><i class="icon s7-close"></i> <?php echo lang('add')?></button>
										</div>
										<?php echo form_close(); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-12 panel borderten" style="padding:20px;">
			<div style="margin: 0 0px 8px;" class="panel-heading panel-heading-divider">
				<span><strong><?php echo lang('customeractivities');?></strong></span>
				<span class="panel-subtitle"><?php echo lang('customeractivitiessubtext');?></span>
			</div>
			<div style="padding:0px;" class="panel-body">
				<ul class="user-timeline">					
					<li ng-repeat="log in logs | filter: { customer_id: '<?php echo $customers['id'];?>' }">
						<div class="user-timeline-title" ng-bind="log.date"></div>
						<div class="user-timeline-description" ng-bind-html="log.detail|trustAsHtml"></div>
					</li>					
				</ul>
			</div>
		</div>
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
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
						<?php echo lang('customerattentiondetail'); ?>
					</p>
					<div class="xs-mt-50">
						<a type="button" data-dismiss="modal" class="btn btn-space btn-default">
							<?php echo lang('cancel'); ?>
						</a>
						<a href="<?php echo base_url('customers/remove/'.$customers['id'].'')?>" type="button" class="btn btn-space btn-danger">
							<?php echo lang('delete'); ?>
						</a>
					</div>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<div id="contactadd" tabindex="-1" role="dialog" class="modal fade">
	<?php echo form_open('customers/contactadd',array("class"=>"form-vertical")); ?>
	<div style="width: 65%;" class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h3 class="pull-left">
					<?php echo lang('newcontacttitle');?>
				</h3>
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
			</div>
			<div class="modal-body">
				<div class="col-md-12 nopadding">
					<div style="padding: 0px;" class="form-group col-md-4">
						<label for="name">
							<b><?php echo lang('contactname');?></b>
						</label>
					
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-person"></i></span>
							<input required type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="name" placeholder="<?php echo lang('contactname');?>"/>
							<input type="hidden" name="customer" value="<?php echo $customers['id']; ?>"/>
						</div>
					</div>
					<div style="padding-right: 0px;" class="form-group col-md-4">
						<label for="surname">
							<b><?php echo lang('contactsurname');?></b>
						</label>
					
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-person-outline"></i></span>
							<input required type="text" name="surname" value="<?php echo $this->input->post('surname'); ?>" class="form-control" id="surname" placeholder="<?php echo lang('contactsurname');?>"/>
						</div>
					</div>
					<div style="padding-right: 0px;" class="form-group col-md-4">
						<label for="position">
							<b><?php echo lang('contactposition');?></b>
						</label>
					
						<input type="text" name="position" value="<?php echo $this->input->post('position'); ?>" class="form-control" id="position" placeholder="<?php echo lang('contactposition');?>"/>
					</div>
				</div>
				<div class="col-md-12 nopadding">
					<div style="padding: 0px;" class="form-group col-md-4">
						<label for="ad">
							<b><?php echo lang('contactphone');?></b>
						</label>
					
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-telephone"></i></span>
							<input type="text" name="phone" value="<?php echo $this->input->post('phone'); ?>" class="form-control" id="phone" placeholder="<?php echo lang('contactphone');?>"/>
						</div>
					</div>
					<div style="padding-right: 0px;" class="form-group col-md-4">
						<label for="intercom">
							<b><?php echo lang('contactintercom');?></b>
						</label>
					
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-ios-grid-view-outline"></i></span>
							<input type="text" name="intercom" value="<?php echo $this->input->post('intercom'); ?>" class="form-control" id="intercom" placeholder="<?php echo lang('contactintercom');?>"/>
						</div>
					</div>
					<div class="form-group col-md-4 md-pr-0 sm-pr-0 lg-pr-0">
						<label for="ad">
							<b><?php echo lang('contactmobile');?></b>
						</label>
					
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-iphone"></i></span>
							<input type="text" name="mobile" value="<?php echo $this->input->post('mobile'); ?>" class="form-control" id="mobile" placeholder="<?php echo lang('contactmobile');?>"/>
						</div>
					</div>
				</div>
				<div class="col-md-12 nopadding">
					<div class="form-group col-md-4 md-p-0 sm-p-0 lg-p-0">
						<label for="email">
							<b><?php echo lang('contactemail');?></b>
						</label>
					
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-at"></i></span>
							<input required type="text" name="email" value="<?php echo $this->input->post('email'); ?>" class="form-control" id="email" placeholder="<?php echo lang('contactemail');?>"/>
						</div>
					</div>
					<div class="form-group col-md-4 md-pr-0 sm-pr-0 lg-pr-0">
						<label for="skype">
							<b><?php echo lang('contactskype');?></b>
						</label>
					
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-social-skype"></i></span>
							<input type="text" name="skype" value="<?php echo $this->input->post('skype'); ?>" class="form-control" id="skype" placeholder="Skype"/>
						</div>
					</div>
					<div class="form-group col-md-4 md-pr-0 sm-pr-0 lg-pr-0 ">
						<label for="linkedin">
							<b><?php echo lang('contactlinkedin');?></b>
						</label>
					
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-social-linkedin"></i></span>
							<input type="text" name="linkedin" value="<?php echo $this->input->post('linkedin'); ?>" class="form-control" id="linkedin" placeholder="Linkedin"/>
						</div>
					</div>
					<div style="display: none" class="form-group col-md-4 password-input md-pl-0 sm-pl-0 lg-pl-0 md-pr-0 sm-pr-0 lg-pr-0">
						<label for="password">
							<b><?php echo lang('password');?></b>
						</label>
						<p class="xs-mb-5">Customer Area Login Password<a href="javascript:;" data-toggle="popover" data-trigger="hover" title="<?php echo lang('information')?>" data-content="<?php echo lang('contactprimaryhover')?>" data-placement="top"><b> ?</b></a>
						</p>
						<div class="input-group ">
							<input name="password" type="text" class="form-control " rel="gp" data-size="9" id="nc" data-character-set="a-z,A-Z,0-9,#">
							<span class="input-group-btn"><button type="button" class="btn btn-default getNewPass"><span class="ion-refresh"></span>
							</button>
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-12 nopadding">
					<div class="form-group">
						<div class="input-group xs-mb-15"><span class="input-group-addon"><i class="ion-location"></i></span>
							<textarea name="address" class="form-control" id="address" placeholder="<?php echo lang('contactaddress');?>"><?php echo $this->input->post('address'); ?></textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<div class="ciuis-body-checkbox has-success col-md-5">
						<input name="primary" class="primary-check" id="primary" type="checkbox" value="1" onchange="valueChanged()">
						<label for="primary"><?php echo lang('primarycontact') ?></label>
					</div>
					<button type="submit" class="btn btn-ciuis pull-right">
						<?php echo lang('contactaddbuton');?>
					</button>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
<div id="edit" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-warning">
	<?php echo form_open('customers/customer/'.$customers['id'],array("class"=>"form-vertical")); ?>
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title">
					<?php echo lang('updatecustomertitle');?>
				</h3>
				<span>
					<?php echo lang('updatecustomerdescription');?>
				</span>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<?php if ($customers['type']==0) {echo'<label for="company">'.lang('updatecustomercompany').'</label><div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-case"></i></span><input type="text" name="company" value="'.($this->input->post('company') ? $this->input->post('company') : $customers['company']).'" class="form-control" id="company"/></div>';}
											else echo'<label for="namesurname">'.lang('updatecustomerindividualname').'</label><div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-case"></i></span><input type="text" name="namesurname" value="'.($this->input->post('namesurname') ? $this->input->post('namesurname') : $customers['namesurname']).'" class="form-control" id="namesurname"/></div>';
								?>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="taxoffice">
								<?php echo lang('taxofficeedit');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-local-atm"></i></span>
								<input type="text" name="taxoffice" value="<?php echo ($this->input->post('taxoffice') ? $this->input->post('taxoffice') : $customers['taxoffice']); ?>" class="form-control" id="taxoffice"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<?php if ($customers['type']==0) {echo'<label for="taxnumber">'.lang('taxnumberedit').'</label><div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-case"></i></span><input type="text" name="taxnumber" value="'.($this->input->post('taxnumber') ? $this->input->post('taxnumber') : $customers['taxnumber']).'" class="form-control" id="taxnumber"/></div>';}
											else echo'<label for="ssn">'.lang('ssnedit').'</label><div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-case"></i></span><input type="text" name="ssn" value="'.($this->input->post('ssn') ? $this->input->post('ssn') : $customers['ssn']).'" class="form-control" id="ssn"/></div>';
								?>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="executive">
								<?php echo lang('executiveupdate');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-account"></i></span>
								<input type="text" name="executive" value="<?php echo ($this->input->post('executive') ? $this->input->post('executive') : $customers['executive']); ?>" class="form-control" id="executive"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="zipcode">
								<?php echo lang('zipcode');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="ion-paper-airplane"></i></span>
								<input type="text" name="zipcode" value="<?php echo ($this->input->post('zipcode') ? $this->input->post('zipcode') : $customers['zipcode']); ?>" class="form-control" id="zipcode"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="phone">
								<?php echo lang('customerphoneupdate');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-phone"></i></span>
								<input type="text" name="phone" value="<?php echo ($this->input->post('phone') ? $this->input->post('phone') : $customers['phone']); ?>" class="form-control" id="phone"/>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="fax">
								<?php echo lang('customerfaxupdate');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-scanner"></i></span>
								<input type="text" name="fax" value="<?php echo ($this->input->post('fax') ? $this->input->post('fax') : $customers['fax']); ?>" class="form-control" id="fax"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="email">
								<?php echo lang('emailedit');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon">@</span>
								<input type="text" name="email" value="<?php echo ($this->input->post('email') ? $this->input->post('email') : $customers['email']); ?>" class="form-control" id="email"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-4">
						<div class="form-group">
							<label for="web">
								<?php echo lang('customerwebupdate');?>
							</label>
							<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
								<input type="text" name="web" value="<?php echo ($this->input->post('web') ? $this->input->post('web') : $customers['web']); ?>" class="form-control" id="web"/>
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-md-12">
						<div class="form-group">
							<label for="email">
								<?php echo lang('customeraddressupdate');?>
							</label>
							<textarea name="address" class="form-control"><?php echo ($this->input->post('address') ? $this->input->post('address') : $customers['address']); ?></textarea>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-xs-12 col-md-6 col-lg-3">
						<div class="form-group">
							<label for="email">
								<?php echo lang('customercountryupdate');?>
							</label>
							<select required name="country_id" class="select2">
								<option value="<?php echo $customers['country_id'];?>"><?php echo $customers['country'];?></option>
								<option ng-repeat="country in countries" value="country.id">{{country.shortname}}</option>
							</select>
						
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-3">
						<div class="form-group">
							<label for="state">
								<?php echo lang('stateupdate');?>
							</label>
							<div class="input-group"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
								<input type="text" name="state" value="<?php echo ($this->input->post('state') ? $this->input->post('state') : $customers['state']); ?>" class="form-control" id="state"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-3">
						<div class="form-group">
							<label for="city">
								<?php echo lang('cityupdate');?>
							</label>
							<div class="input-group"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
								<input type="text" name="city" value="<?php echo ($this->input->post('city') ? $this->input->post('city') : $customers['city']); ?>" class="form-control" id="city"/>
							</div>
						</div>
					</div>
					<div class="col-xs-12 col-md-6 col-lg-3">
						<div class="form-group">
							<label for="town">
								<?php echo lang('townupdate');?>
							</label>
							<div class="input-group"><span class="input-group-addon"><i class="mdi mdi-http"></i></span>
								<input type="text" name="town" value="<?php echo ($this->input->post('town') ? $this->input->post('town') : $customers['town']); ?>" class="form-control" id="town"/>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<div class="form-group text-left">
					<div class="col-md-8">
						<md-slider-container>
						  <span><?php echo lang('riskstatus');?></span>
						  <md-slider flex min="0" max="100" ng-model="customer.risk" aria-label="red" id="red-slider">
						  </md-slider>
						  <md-input-container>
							<input name="risk" flex type="number" ng-model="customer.risk" aria-label="red" aria-controls="red-slider">
						  </md-input-container>
						</md-slider-container>
					</div>
				</div>
				
				<input hidden="" type="text" name="type" value="<?php echo $customers['type'];?>">
				<button type="button" data-dismiss="modal" class="btn btn-default modal-close">
					<?php echo lang('cancel');?>
				</button>
				<button type="submit" class="btn btn-default modal-close">
					<?php echo lang('update');?>
				</button>
			</div>
		</div>
	</div>
	<?php echo form_close(); ?>
</div>
<script>
	var CUSTOMERID = "<?php echo $customers['id'];?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script src="<?php echo base_url(); ?>assets/lib/chartjs/dist/Chart.bundle.js" type="text/javascript"></script>
<script>
	$( function () {
		var data = {
			"labels": [ "<?php echo lang('january');?>", "<?php echo lang('february');?>", "<?php echo lang('march');?>", "<?php echo lang('april');?>", "<?php echo lang('may');?>", "<?php echo lang('june');?>", "<?php echo lang('july');?>", "<?php echo lang('august');?>", "<?php echo lang('september');?>", "<?php echo lang('october');?>", "<?php echo lang('november');?>", "<?php echo lang('december');?>" ],
			"datasets": [ {
				"type": "line",
				backgroundColor: 'rgba(57, 57, 57, 0.69)',
				"hoverBorderColor": "#f5f5f5",

				borderColor: '#ffbc00',
				borderWidth: 1,
				"data": <?php echo $customer_annual_sales_chart ?>,
			} ]
		};
		var options = {
			responsive: true,
			maintainAspectRatio: false,
			scales: {
				xAxes: [ {
					categoryPercentage: .2,
					barPercentage: 1,
					position: 'top',
					gridLines: {
						color: '#C7CBD5',
						zeroLineColor: '#C7CBD5',
						drawTicks: true,
						borderDash: [ 5, 5 ],
						offsetGridLines: false,
						tickMarkLength: 10,
						callback: function ( value ) {
							console.log( value )
								// return value.charAt(0) + value.charAt(1) + value.charAt(2);
						}
					},
					ticks: {
						callback: function ( value ) {
							return value.charAt( 0 ) + value.charAt( 1 ) + value.charAt( 2 );
						}
					}
				} ],
				yAxes: [ {
					display: false,
					gridLines: {
						drawBorder: true,
						drawOnChartArea: true,
						borderDash: [ 8, 5 ],
						offsetGridLines: true
					},
					ticks: {
						beginAtZero: true,
						max: <?php echo $ycr ?>,
						maxTicksLimit: 12,
					}
				} ]
			},
			legend: {
				display: false
			}
		};
		var ctx = $( '#customerthisyearsalesgraph' );
		var mainChart = new Chart( ctx, {
			type: 'bar',
			data: data,
			options: options
		} );
	} );
</script>