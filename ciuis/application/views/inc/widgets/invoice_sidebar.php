<aside class="page-aside ciuis-sag-sidebar-xs">
	<div class="ciuis-body-scroller nano ps-container ps-theme-default" data-ps-id="ac74da58-8e1c-6b15-4582-65d6b23ba5fc">
		<div class="invoice-sidebar">
		<div class="invoice-sidebar-header">
			<h4 class="pull-left" ng-show="invoice.balance != 0"><?php echo lang('balance')?> : <span class="money-area" ng-bind="invoice.balance"></span></h4>
			<h4 class="pull-left" ng-hide="invoice.balance != 0" style="color: #22c39e;"><?php echo lang('paidinv') ?> <i class="icon ion-checkmark-circled"></i></h4>
			<span ng-hide="invoice.partial_is != 'true'" class="label pull-right label-warning" style=" margin-top: 10px; margin-left: 40px; "><?php echo lang('partial') ?></span>
		</div>
			<div style="background: rgb(255, 255, 255); border-bottom-left-radius: 10px; padding: 20px; margin-bottom: 15px; border-bottom-right-radius: 10px;" class="">
				<div id="detail" class="panel">
					<div class="row">
						<div class="col-md-12">
							<div class="col-md-12 detail_ui_elemani_invoice">
								<div class="col-md-2 nopadding">
									<span class="ion-ios-bell detail-ui-ikon-invoice"></span>
								</div>
								<div class="col-md-8 detail-ui-detail-invoice" ng-bind="invoice.duedate_text"></div>
							</div>
							<div class="col-md-12 detail_ui_elemani_invoice">
								<div class="col-md-2 nopadding">
									<span class="ion-android-mail detail-ui-ikon-invoice"></span>
								</div>
								<div class="col-md-8 detail-ui-detail-invoice" ng-bind="invoice.mail_status"></div>
							</div>
							<div class="col-md-12 detail_ui_elemani_invoice">
								<div class="col-md-2 nopadding">
									<span class="ion-person detail-ui-ikon-invoice"></span>
								</div>
								<div class="col-md-8 detail-ui-detail-invoice"><a href="<?php echo $invoices['staff_id'];?>"><b><?php echo $invoices['staffmembername'];?></b></a>
								</div>
							</div>
							<div class="btn-group">
								<a href="<?php echo base_url('invoices/share/'.$invoices['id'].''); ?>" class="btn btn-default"><i class="ion-send"></i> <?php echo lang('send'); ?></a>
								<a target="new" href="<?php echo base_url('invoices/print_/'.$invoices['id'].''); ?>" type="submit" class="btn btn-default" data-original-title="<?php echo lang('print')?>" data-placement="bottom" data-toggle="tooltip"><i class="ion-android-print"></i></a>
								<a href="<?php echo base_url('invoices/download/'.$invoices['id'].''); ?>" type="submit" class="btn btn-space btn-default" data-original-title="<?php echo lang('download')?>" data-placement="bottom" data-toggle="tooltip"><i class="ion-arrow-down-c"></i></a>
							</div>
							<button type="button" ng-show="invoice.balance != 0"  class="btn btn-default pull-right add-payment"><?php echo lang('recordpayment'); ?></button>
						</div>
					</div>
				</div>
				<div class="add-payment-form">
					<div class="row">
						<?php echo form_open('payments/add/',array("class"=>"form-vertical")); ?>
						<div class="col-md-12">
							<div class="form-group">
								<label for="">
									<?php echo lang('datepayment')?>
								</label>
								<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
									<input required type='input' name="date" value="" placeholder="<?php echo date('d.m.Y');?>" class=" form-control" id=""/>
								</div>
							</div>
							<div class="form-group">
								<label for="">
									<?php echo lang('amount')?>
								</label>
								<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="mdi mdi-money"></i></span>
									<input type="text" name="amount" value="" class="input-money-format form-control" placeholder="0.00">
									<input type="hidden" name="invoicetotal" value="<?php echo $invoices['total']; ?>">
									<input type="hidden" name="customer" value="<?php echo $invoices['customer_id']; ?>">
								</div>
							</div>
							<div class="form-group">
								<label for="">
									<?php echo lang('description')?>
								</label>
								<div class="input-group xs-pt-10"><span class="input-group-addon"><i class="ion-asterisk"></i></span>
									<input type="text" name="not" value="" class=" form-control" id="" placeholder="Description for this payment">
								</div>
							</div>
							<div class="form-group">
								<label for="">Account</label>
								<select id="account" name="account" class="form-control select2">
									<?php
									foreach ( $accounts as $account ) {
										$selected = ( $account[ 'id' ] == $this->input->post( 'account' ) ) ? ' selected="selected"' : null;
										echo '<option value="' . $account[ 'id' ] . '" ' . $selected . '>' . $account[ 'name' ] . '</option>';
									}
									?>
								</select>
							</div>
							<input type="hidden" name="invoice" value="<?php echo $invoices['id'];?>">
							<input type="hidden" name="staff" value="<?php echo $this->session->userdata('logged_in_staff_id'); ?>">
						</div>
						<div class="pull-right">
							<div class="btn-group">
								<button class="btn btn-default cancel-payment">
									<?php echo lang('cancel')?>
								</button>
								<button type="submit" class="btn btn-space btn-default">
									<?php echo lang('save')?>
								</button>
							</div>
						</div>
						<?php echo form_close(); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="panel panel-default panel-table borderten">
			<div class="panel-heading"><?php echo lang('payments')?><span class="panel-subtitle"><?php echo lang('paymentsside')?></span>
			</div>
			<div class="panel-body <?php if ($tadtu->row()->amount == 0){echo 'text-center';}?>">
			<?php if ($tadtu->row()->amount == 0){echo '<img width="80%" src="'.base_url('assets/img/payments.png').'">';}?>
			
				<table class="table <?php if ($tadtu->row()->amount == 0){echo 'hide';}?>">
					<thead>
						<tr>
							<th style="width:30%;"><?php echo lang('date')?></th>
							<th class="text-left"><?php echo lang('account')?></th>
							<th class="text-right"><?php echo lang('amount')?></th>
						</tr>
					</thead>
					<tbody>
						<?php foreach($payments as $payment){?>
						<tr>
							<td>
								<small class="text-muted">
									<?php echo _udate($payment['date'])?>
								</small>
							</td>
							<td class="text-left">
								<small>
									<?php echo $payment['accountname'];?>
								</small>
							</td>
							<td class="text-right">
								<span class="badge">
								<span class="money-area"><?php echo $payment['amount']?></span>
								</span>
							</td>
						</tr>
						<?php }?>
					</tbody>
				</table>
				<br>
			</div>
		</div>
	</div>
</aside>