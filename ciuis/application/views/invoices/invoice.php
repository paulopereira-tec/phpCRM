<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Invoice_Controller">
	<div class="main-content container-fluid col-md-9">
		<div class="row">
			<div class="col-md-12">
			<a href="<?php echo site_url('invoices/edit/'.$invoices['id']); ?>" class="btn btn-xl md-m-30 btn-default pull-right"><?php echo lang('updateinvoicetitle'); ?></a>
			<button data-toggle="modal" data-target="#remove<?php echo $invoices['id'];?>" class="btn btn-xl md-mt-30 btn-default pull-right"><?php echo lang('delete') ?></button>
			<div class="col-md-4 pull-right md-m-25" style="<?php if($invoices['status_id'] == 4){echo'display:interit';}else echo 'display:none'?>">
				<div role="alert" class="alert alert-danger alert-icon alert-icon-colored alert-dismissible" style="margin-top: 5px;">
				<div class="icon"><span class="mdi ion-android-cancel"></span></div>
				<div class="message" style="display: inherit">
					<strong><?php echo lang('cancelledinvoice');?></strong>
				</div>
				</div>
			</div>
				<div class="invoice">
				
					<div class="row invoice-header">
					
						<div class="col-xs-7">
							<div class="invoice-logo" style="background-image: url(<?php echo base_url('uploads/ciuis_settings/'.$settings['logo'].'') ?>)"></div>
						</div>
						<div class="col-xs-5 invoice-order"><span class="invoice-id"><?php echo lang('invoiceprefix'),'-',str_pad($invoices['id'], 6, '0', STR_PAD_LEFT); ?></span>
							<span class="incoice-date">
							<?php switch($settings['dateformat']){ 
							case 'yy.mm.dd': echo _rdate($invoices['created']);break; 
							case 'dd.mm.yy': echo _udate($invoices['created']); break;
							case 'yy-mm-dd': echo _mdate($invoices['created']); break;
							case 'dd-mm-yy': echo _cdate($invoices['created']); break;
							case 'yy/mm/dd': echo _zdate($invoices['created']); break;
							case 'dd/mm/yy': echo _kdate($invoices['created']); break;
							}?>
							</span>
						</div>
					</div>
					<div class="row invoice-data">
						<div class="col-xs-5 invoice-person">
							<span class="name"><?php echo $settings['company'] ?></span>
							<span><?php echo $settings['address'] ?></span>
							<span><?php echo $settings['zipcode'] ?>/<?php echo $settings['town'] ?>/<?php echo $settings['city'] ?>,<?php echo $settings['country_id'] ?></span>
							<span><b><?php echo lang('phone')?>:</b> <?php echo $settings['phone'] ?></span>
							<span><b><?php echo lang('fax')?>:</b> <?php echo $settings['fax'] ?></span>
							<span><b><?php echo lang('contactemail')?>:</b> <?php echo $settings['email'] ?></span>
							<span><b><?php echo $settings['taxoffice'] ?></b></span>
							<span><B><?php echo lang('vatnumber')?>:</B> <?php echo $settings['vatnumber'] ?></span>
						</div>
						<div class="col-xs-2 invoice-payment-direction">
						</div>
						<div class="col-xs-5 invoice-person">
							<h4><b><?php echo lang('to') ?></b></h4>
							<span class="name"><?php if($invoices['customercompany']===NULL){echo $invoices['namesurname'];} else echo $invoices['customercompany']; ?></span>
							<span><?php echo $invoices['email']; ?></span>
							<span><?php echo $invoices['customeraddress']; ?></span>
							<span><?php echo $invoices['phone'] ?></span>
							<span><?php echo $invoices['taxoffice'] ?></span>
							<span><B><?php echo lang('vatnumber')?>:</B><?php echo $invoices['taxnumber'] ?></span>
						</div>
					</div>
					<div class="row">
				<div class="col-md-12">
					<table class="invoice-details">
						<tr>
							<th style="width:30%"><?php echo lang('invoiceitemdescription')?></th>
							<th style="width:15%" class="amount"><?php echo lang('quantity')?></th>
							<th style="width:15%" class="amount"><?php echo lang('price')?></th>
							<th style="width:15%" class="amount"><?php echo lang('discount')?></th>
							<th style="width:15%" class="amount"><?php echo lang('vat')?></th>
							<th style="width:30%" class="amount"><?php echo lang('total')?></th>
						</tr>
						<?php foreach($invoiceitems as $fu) {?>
						<tr>
							<td class="description"><b><?php if($fu['in[product_id]'] = NULL){echo $fu['name'];}else {echo $fu['in[name]'];}?></b><br>(<?php echo $fu['in[description]'];?>)</td>
							<td class="amount">
							<span class="money-area"><?php echo $fu['in[amount]'];?></span>
							</td>
							<td class="amount">
							<span class="money-area"><?php echo $fu['in[price]']?></span>
							</td>
							<td class="amount">
								<?php echo $fu['in[discount_rate]'];?>
							</td>
							<td class="amount">
								<?php echo $fu['in[vat]'] ?>
							</td>
							<td class="amount">
							<span class="money-area"><?php echo $fu['in[total]']?></span>
							</td>
						</tr>
						<?php }?>
					</table>
					<div class="pull-right">
						<table class="invoice-details">
							<tr>
							<td class="summary"><?php echo lang('subtotal')?></td>
							<td class="amount">
							<span class="money-area"><?php echo $invoices['total_sub']?></span>
							</td>
						</tr>
						<tr>
							<td class="summary"><?php echo lang('linediscount')?></td>
							<td class="amount">
							<span class="money-area"><?php echo $invoices['total_discount']?></span>
							</td>
						</tr>
						<tr>
							<td class="summary"><?php echo lang('grosstotal')?></td>
							<td class="amount">
							<?php $grosstotal = ($invoices['total_sub'] - $invoices['total_discount']);?>
							<span class="money-area"><?php echo $grosstotal?></span>
							</td>
						</tr>
						<tr>
							<td class="summary"><?php echo lang('tax')?></td>
							<td class="amount">
							<span class="money-area"><?php echo $invoices['total_vat']?></span>
						</tr>
						
						<tr>
							<td class="summary total"><?php echo lang('total')?></td>
							<td class="amount total-value">
							<span class="money-area"><?php echo $invoices['total']?></span>
							</td>
						</tr>
						</table>
					</div>
				</div>
			</div>
					<div class="row">
						<div class="col-md-12 invoice-message">
							<span class="title"><?php echo $invoices['notetitle']; ?></span>
							<p><?php echo $invoices['not']; ?></p>
						</div>
					</div>
					<div class="row invoice-company-info">
						<div class="col-sm-6 col-md-2 invoice-logo" style="background-image: url(<?php echo base_url('uploads/ciuis_settings/'.$settings['logo'].'') ?>)"></div>
						<div class="col-sm-6 col-md-4 summary">
							<span class="title"><?php echo $settings['company'] ?></span>
							<p><?php echo $settings['address']; ?></p>
						</div>
						<div class="col-sm-6 col-md-3 phone">
							<ul class="list-unstyled">
								<li><?php echo $settings['phone']; ?></li>
								<li> <?php echo $settings['fax']; ?></li>
							</ul>
						</div>
						<div class="col-sm-6 col-md-2 email">
							<ul class="list-unstyled">
								<li><?php echo $settings['email']; ?></li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<div id="remove<?php echo $invoices['id'];?>" tabindex="-1" role="dialog" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close"><span class="mdi mdi-close"></span></button>
			</div>
			<div class="modal-body">
				<div class="text-center">
					<div class="text-danger"><span class="modal-main-icon mdi mdi-close-circle-o"></span>
					</div>
					<h3><?php echo lang('attention'); ?></h3>
					<p><?php echo lang('invoiceattentiondetail'); ?></p>
					<div class="xs-mt-50"> <a type="button" data-dismiss="modal" class="btn btn-space btn-default"><?php echo lang('cancel'); ?></a> <a href="<?php echo site_url('invoices/remove/'.$invoices['id']); ?>" type="button" class="btn btn-space btn-danger"><?php echo lang('delete'); ?></a> </div>
				</div>
			</div>
			<div class="modal-footer"></div>
		</div>
	</div>
</div>
<?php include_once(APPPATH . 'views/inc/widgets/invoice_sidebar.php'); ?>

<script>
var INVOICEID = <?php echo $invoices['id']; ?>;
</script>
</div>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>