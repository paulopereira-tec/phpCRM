<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Proposal_Controller">
	<div class="main-content container-fluid col-md-9 borderten">
		<div class="panel panel-default borderten">
			<div class="tab-container">
				<ul class="nav nav-tabs">
					<li class="active"><a href="#proposal" data-toggle="tab"><strong><?php echo lang('proposal') ?></strong></a></li>
					<li><a href="#notes" data-toggle="tab"><strong><i class="ion-document-text"></i> <?php echo lang('notes') ?></strong></a></li>
					<li><a href="#comments" data-toggle="tab"><strong><i class="ion-ios-chatbubble"></i> <?php echo lang('comments') ?></strong></a></li>
					<li><a href="#reminders" data-toggle="tab"><strong><i class="ion-ios-bell"></i> <?php echo lang('reminders') ?></strong></a></li>
				</ul>
				<div class="tab-content borderten">
					<div id="proposal" class="tab-pane active cont">
						<div class="proposal">
							<header class="clearfix">
								<div id="tools col-md-12">
							<?php if($proposals['status_id'] == 1){echo '<span class="label label-success p-s-lab pull-left proposal-status-draft">'.lang('draft').'</span>';}  ?>
							<?php if($proposals['status_id'] == 2){echo '<span class="label label-success p-s-lab pull-left proposal-status-sent">'.lang('sent').'</span>';}  ?>
							<?php if($proposals['status_id'] == 3){echo '<span class="label label-success p-s-lab pull-left proposal-status-open">'.lang('open').'</span>';}  ?>
							<?php if($proposals['status_id'] == 4){echo '<span class="label label-success p-s-lab pull-left proposal-status-revised">'.lang('revised').'</span>';}  ?>
							<?php if($proposals['status_id'] == 5){echo '<span class="label label-success p-s-lab pull-left proposal-status-declined">'.lang('declined').'</span>';}  ?>
							<?php if($proposals['status_id'] == 6){echo '<span class="label label-success p-s-lab pull-left proposal-status-accepted">'.lang('accepted').'</span>';}  ?>
									<a href="<?php echo base_url('invoices/invoice/'.$proposals['invoice_id'].'')?>" type="button" class="btn btn-success pull-right" style="<?php if($proposals['invoice_id'] === NULL){echo 'display:none';}?>">
										<b><i class="ion-document-text"> </i><?php echo lang('invoiceprefix'),'-',str_pad($proposals['invoice_id'], 6, '0', STR_PAD_LEFT) ?></b>
									</a>
									<div class="btn-group btn-hspace pull-right">
										<button type="button" data-toggle="dropdown" class="btn btn-success dropdown-toggle" style="<?php if($proposals['invoice_id'] !== NULL){echo 'display:none';}?>">
											<?php echo lang('convert') ?> <span class="icon-dropdown mdi mdi-chevron-down"></span>
										</button>
										<ul role="menu" class="dropdown-menu">
											<li <?php if($proposals['relation_type'] == 'lead'){echo 'disabled data-toggle="tooltip" data-placement="right" data-container="body" title="'.lang('leadproposalconvertalert').'"';}  ?>>
											<?php if($proposals['relation_type'] == 'customer'){echo '<a href="'.base_url('proposals/convertinvoice/'.$proposals['id'].'').'">'.lang('invoice').'</a>';}  ?>
											<?php if($proposals['relation_type'] == 'lead'){echo '<a style="cursor: not-allowed;" href="#">'.lang('invoice').'</a>';}  ?>
											</li>
										</ul>
									</div>

									<div class="btn-group btn-space pull-right">
										<a href="<?php echo base_url('proposals/share/'.$proposals['id'].'')?>" type="button" class="btn btn-default"><i class="icon mdi mdi-email"></i></a>
										<a target="_blank" href="<?php echo base_url('proposals/download/'.$proposals['id'].'') ?>" class="btn btn-default"><i class="icon mdi mdi-collection-pdf"></i></a>
										<a target="_blank" href="<?php echo base_url('proposals/print_/'.$proposals['id'].'') ?>" type="button" class="btn btn-default"><i class="icon mdi mdi-print"></i></a>
										<button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">
											<?php echo lang('action') ?> <span class="icon-dropdown mdi mdi-chevron-down"></span>
										</button>
										<ul role="menu" class="dropdown-menu">
											<li><a href="<?php echo base_url('share/proposal/'.$proposals['id'].'')?>" target="_blank"><?php echo lang('viewproposal') ?></a> </li>
											<li><a href="<?php echo base_url('proposals/expiration/'.$proposals['id'].'')?>"><?php echo lang('sentexpirationreminder')  ?></a> </li>
											<li data-sname="Draft" data-status="1" data-proposal="<?php echo $proposals['id']; ?>"><a class="mark-as-btw" href="#"><?php echo lang('markasdraft') ?></a> </li>
											<li data-sname="Sent" data-status="2" data-proposal="<?php echo $proposals['id']; ?>"><a class="mark-as-btw" href="#"><?php echo lang('markassent'); ?></a> </li>
											<li data-sname="Open" data-status="3" data-proposal="<?php echo $proposals['id']; ?>"><a class="mark-as-btw" href="#"><?php echo lang('markasopen'); ?></a> </li>
											<li data-sname="Revised" data-status="4" data-proposal="<?php echo $proposals['id']; ?>"><a class="mark-as-btw" href="#"><?php echo lang('markasrevised'); ?></a> </li>
											<li data-sname="Declined" data-status="5" data-proposal="<?php echo $proposals['id']; ?>"><a class="mark-as-btw" href="#"><?php echo lang('markasdeclined'); ?></a> </li>
											<li data-sname="Accepted" data-status="6" data-proposal="<?php echo $proposals['id']; ?>"><a class="mark-as-btw" href="#"><?php echo lang('markasaccepted'); ?></a> </li>
											<li class="divider"> <a href="#"></a> </li>
											<li>
												<a href="<?php echo base_url('proposals/edit/'.$proposals['id'].'')?>">
													<?php echo lang('edit') ?>
												</a>
											</li>
											<li class="divider"> <a href="#"></a> </li>
											<li>
												<a href="<?php echo base_url('proposals/remove/'.$proposals['id'].'')?>" class="text-danger">
													<?php echo lang('delete') ?>
												</a>
											</li>
										</ul>
									</div>
								</div>
							</header>
							<main>
								<div id="details" class="clearfix">
									<div id="company">
										<h2 class="name">
											<?php echo $settings['company'] ?>
										</h2>
										<div>
											<?php echo $settings['address'] ?>
										</div>
										<div>
											<?php echo lang('phone')?>:</b>
											<?php echo $settings['phone'] ?>
										</div>
										<div>
											<a href="mailto:<?php echo $settings['email'] ?>">
												<?php echo $settings['email'] ?>
											</a>
										</div>
									</div>
									<div id="client">
										<div class="to"><b><?php echo lang('proposalto'); ?>:</b>
										</div>
										<h2 class="name">
											<?php if($proposals['relation_type'] == 'customer'){if($proposals['customercompany']===NULL){echo $proposals['namesurname'];} else echo $proposals['customercompany'];} ?>
											<?php if($proposals['relation_type'] == 'lead'){echo $proposals['leadname'];} ?>
										</h2>
										<div class="address">
											<?php echo $proposals['toaddress']; ?>
										</div>
										<div class="email">
											<a href="mailto:<?php echo $proposals['toemail']; ?>">
												<?php echo $proposals['toemail']; ?>
											</a>
										</div>
									</div>
									<div id="invoice">
										<h1>
											<?php echo lang('proposalprefix'),'-',str_pad($proposals['id'], 6, '0', STR_PAD_LEFT); ?>
										</h1>
										<div class="date"><?php echo lang('dateofissuance')?>: <?php switch($settings['dateformat']){ 
								case 'yy.mm.dd': echo _rdate($proposals['date']);break; 
								case 'dd.mm.yy': echo _udate($proposals['date']); break;
								case 'yy-mm-dd': echo _mdate($proposals['date']); break;
								case 'dd-mm-yy': echo _cdate($proposals['date']); break;
								case 'yy/mm/dd': echo _zdate($proposals['date']); break;
								case 'dd/mm/yy': echo _kdate($proposals['date']); break;
								}?></div>
										<div class="date text-bold"><?php echo lang('opentill')?>: <?php switch($settings['dateformat']){ 
								case 'yy.mm.dd': echo _rdate($proposals['opentill']);break; 
								case 'dd.mm.yy': echo _udate($proposals['opentill']); break;
								case 'yy-mm-dd': echo _mdate($proposals['opentill']); break;
								case 'dd-mm-yy': echo _cdate($proposals['opentill']); break;
								case 'yy/mm/dd': echo _zdate($proposals['opentill']); break;
								case 'dd/mm/yy': echo _kdate($proposals['opentill']); break;
								}?></div>
									</div>
								</div>
								<table border="0" cellspacing="0" cellpadding="0">
									<thead>
										<tr>
											
											<th class="desc"><?php echo lang('description') ?></th>
											<th class="qty"><?php echo lang('quantity') ?></th>
											<th class="unit"><?php echo lang('price') ?></th>
											<th class="discount"><?php echo lang('discount') ?></th>
											<th class="tax"><?php echo lang('vat') ?></th>
											<th class="total"><?php echo lang('total') ?></th>
										</tr>
									</thead>
									<tbody>
										<?php foreach($proposalitems as $item) {?>
										<tr>
											<td class="desc">
												<h3><?php if($item['in[product_id]'] = NULL){echo $item['name'];}else {echo $item['in[name]'];}?></b><br></h3>
												<?php echo $item['in[description]'];?>
											</td>
											<td class="qty"><?php echo $item['in[amount]'];?></td>
											<td class="unit"><span class="money-area"><?php echo $item['in[price]']?></span></td>
											<td class="discount"><?php echo $item['in[discount_rate]'];?>%</td>
											<td class="tax"><?php echo $item['in[vat]'] ?>%</td>
											<td class="total"><span class="money-area"><?php echo $item['in[total]']?></span></td>
										</tr>
										<?php }?>
									</tbody>
									<tfoot>
										<tr>
											<td></td>
											<td colspan="2"></td>
											<td colspan="2"><?php echo lang('subtotal')?></td>
											<td><span class="money-area"><?php echo $proposals['total_sub']?></span></td>
										</tr>
										<tr>
											<td></td>
											<td colspan="2"></td>
											<td colspan="2"><?php echo lang('discount') ?></td>
											<td><span class="money-area"><?php echo $proposals['total_discount']?></span></td>
										</tr>
										<tr>
											<td></td>
											<td colspan="2"></td>
											<td colspan="2"><?php echo lang('grosstotal') ?></td>
											<td><?php $grosstotal = ($proposals['total_sub'] - $proposals['total_discount']);?><span class="money-area"><?php echo $grosstotal?></span></td>
										</tr>
										<tr>
											<td></td>
											<td colspan="2"></td>
											<td colspan="2"><?php echo lang('tax') ?></td>
											<td><span class="money-area"><?php echo $proposals['total_vat']?></span></td>
										</tr>
										<tr>
											<td></td>
											<td colspan="2"></td>
											<td colspan="2"><?php echo lang('grandtotal') ?></td>
											<td><span class="money-area"><?php echo $proposals['total']?></span></td>
										</tr>
									</tfoot>
								</table>
							</main>
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
									by <strong><a href="<?php echo base_url('staff/staffmember/');?>/{{note.staffid}}" ng-bind="note.staff"></a></strong> at <span ng-bind="note.date"></span>
									</p>
								</div>
							</article>
						</section>
						<section class="md-pb-30">
							<div class="form-group">
								<textarea required name="description" placeholder="Type something" class="form-control note-description"></textarea>
								<input class="note-relation-id" hidden="" type="text" name="customer" value="<?php echo $proposals['id'] ?>">
								<input class="note-type" hidden="" type="text" value="proposal">
							</div>
							<div class="form-group pull-right">
								<button type="button" class="btn btn-default btn-space"><i class="icon s7-mail"></i> <?php echo lang('cancel')?></button>
								<button class="btn btn-default btn-space add-note-button"><i class="icon s7-close"></i> <?php echo lang('add')?></button>
							</div>
						</section>
					</div>
					<div id="comments" class="tab-pane">
						<section class="ciuis-notes show-notes">
						<?php foreach($comments as $comment){ ?>
							<article class="ciuis-note-detail">
								<div class="ciuis-note-detail-img">
									<img src="<?php echo base_url('assets/img/comment.png') ?>" alt="" width="50" height="50" />
								</div>
								<div class="ciuis-note-detail-body">
									<div class="text"><p><?php echo $comment['content']?></p></div>
									<p class="attribution"><strong>Customer Comment</strong> at <?php echo  _adate($comment['created']); ?></p>
								</div>
							</article>
						<?php } ?>
						</section>
					</div>
					<div id="reminders" class="tab-pane cont" style="margin-top: -20px;">
						<div class="panel panel-default panel-table">
							<div class="panel-body">
								<div class="table-responsive noSwipe">
									<table class="table table-striped table-hover reminder-table">
										<thead>
											<tr>
												<th style="width:17%;">
													<?php echo lang('description') ?>
												</th>
												<th style="width:20%;">
													<?php echo lang('remind') ?>
												</th>
												<th style="width:10%;">
													<?php echo lang('notified') ?>
												</th>
												<th style="width:10%;">
													<?php echo lang('date') ?>
												</th>
												<th style="width:10%;text-align: right;">
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
												<td class="cell-detail"><span>OK</span>
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
										<?php echo form_open_multipart('proposals/addreminder',array("class"=>"form-horizontal col-md-12")); ?>
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
											<input hidden="" type="text" name="relation" value="<?php echo $proposals['id']; ?>">
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
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
	
</div>
<script>
	var PROPOSALID = "<?php echo $proposals['id'];?>";
</script>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>