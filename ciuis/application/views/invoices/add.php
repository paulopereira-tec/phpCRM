<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Invoices_Controller">
	<?php echo form_open('invoices/add',array("class"=>"form-horizontal main-content container-fluid col-xs-12 col-md-12 col-lg-9")); ?>
	<input type="hidden" name="id" value="">
	<input type="hidden" name="type" value="purchase_invoice">
	<input type="hidden" name="related_to" value="">
	<div style="border-radius: 10px;" class="panel panel-white panel-form">
		<div class="panel-body" style="padding:30px 20px;">
			<div class="invoice-extra button-properties-list col-md-8 md-p-0">
				<div class="form-group property md-p-0" data-name="series" data-title="<?php echo lang('invoicenumber')?>" data-status="passive">
					<label for="in_series" class="col-sm-2 control-label"><?php echo lang('serie')?></label>
					<div class="col-sm-2">
						<div class="input-group-icon">
							<input type="text" name="series" id="in_series" class="form-control input-xs" value="<?php echo $this->input->post('series'); ?>">
							<div class="input-group-icon-addon"><i class="fa fa-sort-alpha-asc fa-fw"></i>
							</div>
						</div>
					</div>
					<label for="in_no" class="col-sm-2 control-label control-label-sm"><?php echo lang('invno')?></label>
					<div class="col-sm-4">
						<div class="input-group-icon">
							<input type="text" name="no" id="in_no" class="form-control input-xs" value="<?php echo $this->input->post('no'); ?>">
							<div class="input-group-icon-addon"><i class="fa fa-sort-numeric-asc fa-fw"></i>
							</div>
						</div>
					</div>
					<div class="col-sm-2"><br class="visible-xs">
						<a href="#" class="btn btn-default delete"><i class="icon icon-left mdi mdi mdi-delete text-danger"></i></a>
					</div>
				</div>
				<div class="form-group md-p-0">
					<div class="col-sm-1">
						<div class="button-properties" style="visibility: visible;"><button class="btn btn-lg btn-default btn-reverse" data-name="series"><i class="icon ion-plus"></i> <?php echo lang('addinvoicenumber'); ?></button> </div>
					</div>
				</div>
			</div>
			<div class="form-group md-p-0">
				<div class="col-sm-4 hidden-xs">
					<div class="btn-group pull-right">
						<a href="<?php echo site_url('invoices/'); ?>" class="btn btn-default btn-lg"><?php echo lang('cancel'); ?></a>
						<button type="submit" class="btn btn-space btn-default btn-lg"><?php echo lang('save'); ?></button>
					</div>
				</div>
			</div>
			<hr>
			<div class="col-md-6">
				<div class="form-group">
					<label for="in_account_name" class="col-sm-3 control-label control-label"><?php echo lang('invoicetablecustomer'); ?></label>
					<div class="col-sm-9 add-on-edit">
						<select required name="customer" class="form-control select2">
							<option value=""><?php echo lang('choisecustomer'); ?></option>
							<?php
							foreach ( $all_customers as $customers ) {
								$selected = ( $customers[ 'id' ] == $this->input->post( 'customer' ) ) ? ' selected="selected"' : null;
								if ( $customers[ 'type' ] == 0 ) {
									echo '<option value="' . $customers[ 'id' ] . '" ' . $selected . '>' . $customers[ 'company' ] . '</option>';
								} else echo '<option value="' . $customers[ 'id' ] . '" ' . $selected . '>' . $customers[ 'namesurname' ] . '</option>';
							}
							?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label for="in_date_issue" class="col-sm-3 control-label"><?php echo lang('dateofissuance'); ?></label>
					<div class="col-sm-9">
						<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input placeholder="<?php echo date(" d.m.Y "); ?>" required type='input' name="created" value="<?php echo $this->input->post('created'); ?>" class="form-control" id="created"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div id="toggle-invoice-status">
					<div class="form-group">
						<label class="col-md-3 control-label control-label-sm"><?php echo lang('invoicestatus'); ?></label>
						<div class="col-md-9">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-lg btn-default btn-reverse active">
								<input name="status" type="radio" autocomplete="off" checked value="3">
								<?php echo lang('willbepaid'); ?></label>
											<label class="btn btn-lg btn-default btn-reverse">
								<input name="status" type="radio" autocomplete="off" value="2">
								<?php echo lang('paid'); ?></label>
								<label class="btn btn-lg btn-default btn-reverse">
								<input name="status" type="radio"  autocomplete="off"  value="1">
								<?php echo lang('draft'); ?></label>
							</div>
						</div>
					</div>
					<div id="toggle-account-info">
						<div class="form-group toggle-cash" style="display:none;">
							<label for="vade" class="col-md-3 control-label control-label-sm"><?php echo lang('paidcashornank'); ?></label>
							<div class="col-md-9">
								<select name="account" class="form-control select2">
									<option value=""><?php echo lang('choiseaccount'); ?></option>
									<?php 
									foreach($all_accounts as $account)
									{
										$selected = ($account['id'] == $this->input->post('account')) ? ' selected="selected"' : null;

										echo '<option value="'.$account['id'].'" '.$selected.'>'.$account['name'].'</option>';
									} 
									?>
								</select>
							</div>
						</div>
						<div class="form-group toggle-payment" style="display:none;">
							<label for="vade" class="col-md-3 control-label control-label-sm"><span><?php echo lang('datepaid'); ?></span></label>
							<div class="col-md-9">
								<div class=" input-group-icon">
									<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
							<input placeholder="<?php echo date(" d.m.Y "); ?>" type='input' name="datepayment" value="<?php echo $this->input->post('datepayment'); ?>" class="form-control" id="datepayment"/>
						</div>
								</div>
							</div>
						</div>
						<div class="form-group toggle-due" style="">
							<label for="vade" class="col-md-3 control-label control-label-sm"><?php echo lang('duedate'); ?></label>
							<div class="col-md-9">
								<div data-min-view="2" data-date-format="dd.mm.yyyy" class="input-group date datetimepicker"> <span class="input-group-addon btn btn-default"><i class="icon-th mdi mdi-calendar"></i></span>
									<input placeholder="<?php echo date(" d.m.Y "); ?>" type='input' name="duedate" value="<?php echo $this->input->post('datepayment'); ?>" class="form-control" id="duedate"/>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="hidden-lg">
				<hr>
				<div class="form-group">
					<div class="col-md-offset-3 col-md-5">
						<button class="btn btn-save btn-lg" data-post-form="#form" tabindex="-1" data-loading-text="Kaydet"><?php echo lang('save'); ?></button>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body2 table-responsive">
			<table class="table table-hovered table-invoice">
				<thead>
					<tr>
						<th width="330"><?php echo lang('productservice'); ?></th>
						<th width="210" style="min-width:127px;"><?php echo lang('quantity'); ?></th>
						<th width="210"><?php echo lang('price'); ?></th>
						<th width="210"><?php echo lang('tax'); ?></th>
						<th width="230"><?php echo lang('total'); ?></th>
						<th width="40"></th>
						<th width="40"></th>
					</tr>
				</thead>
				<tbody>
					<tr class="select-properties-list sample-line" style="display:none">
						<td class="add-on-edit">
							<div class="add-on-edit">
							<input class="input-productcode" type="hidden" name="in[product_id][]">
								<input type="text" name="in[name][]" class="form-control input-product autocomplate-product ui-autocomplete-input " autocomplete="on" placeholder="Product Name">
								<small class="hide"><?php echo lang('new'); ?></small> </div>
							<input type="hidden" name="in[code][]" class="form-control input-code">
							<div class="property" data-name="description" data-title="<?php echo lang('description')?>" data-status="passive">
								<textarea type="text" name="in[description][]" class="form-control input-item-description" placeholder="<?php echo lang('description')?>"></textarea>
								<div class="property-delete"><a class="btn delete text-danger"><i class="icon icon-left mdi mdi mdi-delete"></i></a>
								</div>
							</div>
						</td>
						<td>
							<div class="input-group ">
								<input type="text" name="in[amount][]" class="form-control input-amount filter-money" value="1,00">
								<div class="input-group-addon text-muted">
									<a class="input-unit-editable" tabindex="-1"><?php echo lang('unit'); ?></a>
									<input type="hidden" name="in[unit][]" value="<?php echo lang('unit'); ?>" class="input-unit input-xs">
								</div>
							</div>
						</td>
						<td>
							<div class="input-group-icon ">
								<input type="text" name="in[price][]" class="form-control input-price filter-money">
								<input type="hidden" name="in[pricepost][]" class="price-post">
								<input type="hidden" name="in[price_discounted][]" class="form-control input-price-discounted" value="0">
							</div>
							<div class="property" data-name="indirim" data-title="<?php echo lang('discount'); ?>" data-status="passive">
							<div class="input-group ">
								 <input type="text" name="in[discount_rate][]" class="form-control input-discount-rate delete-on-delete" value="0">
							  <input name="in[discount_type][]" type="hidden" value="rate" class="input-discount-type">
							  <input type="hidden" name="in[discount_rate_status][]" class="form-control input-status" value="0">
								<div class="input-group-addon text-muted">%</div>
							</div>
						  </div>
						</td>
						<td>
							<div class="input-group ">
								<input type="text" name="in[vat][]" class="form-control input-vat input-vat-vat filter-number" value="0,00">
								<input type="hidden" name="in[total_vat][]" class="input-vat-vat-total" value="0">
								<div class="input-group-addon text-muted"><?php echo lang('vat'); ?> %</div>
							</div>
							
						</td>
						<td>
							<div class="input-group ">
								<input type="text" class="form-control input-total filter-money on-tab-add-line" value="0,00">
								<input type="hidden" name="in[total][]" class="input-total-real">
								<input name="in[currency][]" type="hidden" value="USD" class="input-currency">
								<input name="rate_in[currency][]" type="hidden" value="1" class="input-rate">
								<div class="input-group-addon text-muted"><?php echo currency;?></div>
							</div>
						</td>
						<td style="vertical-align: middle;">
							<div class="select-properties"></div>
						</td>
						<td style="vertical-align: middle;"><a class="btn btn-default btn-sm delete-line"><i class="icon icon-left mdi mdi mdi-delete text-danger"></i></a>
						</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td colspan="3"><a class="btn btn-default btn-reverse lg-mt-30" id="add-line"><?php echo lang('addnewline'); ?></a>
							<div class="clearfix"></div>
							<div class="pull-left" id="currency-list" style="margin-top:30px;"> </div>
						</td>
						<td colspan="3" rowspan="2" style="padding:0px;">
							<table class="table-total pull-right select-properties-list">
								<tbody>
									<tr class="sub-totals">
										<th width="280"><?php echo lang('subtotal'); ?></th>
										<th class="text-right" width="170">
											<div class="sub-total"><span class="money-format"><span class="money-main">0</span><span class="money-float">,00</span></span> <i class="fa fa-try"></i>
											</div>
										</th>
										<th width="50">
											<div class="select-properties dropdown" style="visibility: visible;"><a class="dropdown-toggle btn btn-sm btn-default " data-toggle="dropdown" aria-haspopup="true" aria-expanded="true"> <span class="vals"><i class="icon ion-plus"></i></span> </a>
												<ul class="dropdown-menu pull-right" aria-labelledby="dropdownMenu1">
													<li><a href="#" data-name="subtotaldiscount"><?php echo lang('subtotaldiscount'); ?></a>
													</li>
												</ul>
											</div>
										</th>
									</tr>
									<tr class="no-border line-discount" style="display: none;">
										<th width="200"><?php echo lang('linediscount');?></th>
										<th class="text-right"><span class="money-format"><span class="money-main">0</span><span class="money-float">,00</span></span> <i class="fa fa-try"></i>
										</th>
										<th></th>
									</tr>
									<tr class="no-border gross-total" style="display: none;">
										<th width="200"><?php echo lang('grosstotal')?></th>
										<th class="text-right"><span class="money-format"><span class="money-main">0</span><span class="money-float">,00</span></span> <i class="fa fa-try"></i>
										</th>
										<th></th>
									</tr>
								</tbody>
								<tbody>
									<tr>
										<th><?php echo lang('tax')?></th>
										<th class="text-right"><span class="vat-total money-format"><span class="money-main">0</span><span class="money-float">,00</span></span> <i class="fa fa-try"></i>
										</th>
										<th></th>
									</tr>
								</tbody>
								<tbody class="grandtotal">
									<tr class="money-bold">
										<th><?php echo lang('grandtotal'); ?></th>
										<th class="text-right"><span class="grant-total money-format"><span class="money-main">0</span><span class="money-float">,00</span></span> <i class="fa fa-try"></i>
										</th>
										<th></th>
									</tr>
								</tbody>
							</table>
							<input type="hidden" class="input-sub-total" name="total_sub" value="0">
							<input type="hidden" class="input-line-discount" name="total_discount" value="0">
							<input type="hidden" class="input-vat-total" name="total_vat" value="0">
							<input type="hidden" class="input-grant-total" name="total" value="0">
							<input type="hidden" name="staff" value="<?php echo $this->session->userdata('logged_in_staff_id'); ?>">
						</td>
					</tr>
				</tfoot>
			</table>
		</div>
	</div>
	</form>
	<?php include_once( APPPATH . 'views/inc/sidebar.php' );?>
	
</div>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>

<script>
var products = <?php echo $products; ?>;
</script>

<link rel="stylesheet" href="<?php echo base_url('assets/lib/x-editable/bootstrap3-editable/css/bootstrap-editable.css'); ?>">
<link rel="stylesheet" href="<?php echo base_url('assets/lib/jquery-ui/jquery-ui.css')?>">
<script src="<?php echo base_url('assets/lib/jquery/jquery.form.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/jquery/jquery.tools.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/x-editable/bootstrap3-editable/js/bootstrap-editable.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/lib/jquery-ui/jquery-ui.js')?>"></script>
<script src="<?php echo base_url('assets/js/CreateInvoice.js'); ?>"></script>
<script>
$(function () {
	"use strict";
	var id;
	id = new Invoice_Create({currency : 'USD', edit : 0,type : 'sale', payment_count : 1,copy:0});

});
</script>