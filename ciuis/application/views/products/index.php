<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Products_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="row">
			<div class="col-md-12">
				<div style="border-radius: 10px;" class="panel-default panel-table">
					<div class="panel-heading">
						<B><?php echo lang('products'); ?></B>
						<div class="pull-right" id="buttons"></div>
						<button type="button" data-target="#add" data-toggle="modal" class="btn btn-space btn-default md-trigger btn-lg pull-right" data-original-title="Add Product"><i class="ion-plus-round"></i> <?php echo lang('addnewproduct'); ?></button>
						<span class="panel-subtitle">
							<?php echo lang('productsdescription'); ?>
						</span>
					</div>
					<div class="panel-body">
						<ul class="custom-ciuis-list-body" style="padding: 0px;">
						<li ng-repeat="product in products | pagination : currentPage*itemsPerPage | limitTo: 5"i class="ciuis-custom-list-item ciuis-special-list-item lead-name">
							<ul class="list-item-for-custom-list">
								<li class="ciuis-custom-list-item-item col-md-12">
								<div class="assigned-staff-for-this-lead user-avatar"><i class="ico-ciuis-products" style="font-size: 32px"></i></div>
									<div class="pull-left col-md-4">
									<a href="<?php echo base_url('products/product/') ?>{{product.id}}"><strong ng-bind="product.label"></strong></a><br>
									<small ng-bind="product.description| limitTo:35"></small>
									</div>
									<div class="col-md-8">
										<div class="col-md-3">
										<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('purchaseprice'); ?></small>
										<strong class="money-area" ng-bind="product.purchase_price"></strong>	
										</span>
										</div>
										<div class="col-md-3">
										<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('salesprice'); ?></small><br>
										<strong class="money-area" ng-bind="product.sale_price"></strong>
										</span>
										</div>
										<div class="col-md-3">
										<span class="date-start-task"><small class="text-muted text-uppercase"><?php echo lang('vat'); ?></small><br>
										<strong ng-bind="product.vat+'%'"></strong>
										</div>
										<div class="col-md-3">
											<a ng-href="<?php echo base_url('products/product/') ?>{{product.id}}" class="edit-task pull-left"><i class="ion-eye"></i></a>
											<a ng-href="<?php echo base_url('products/remove/') ?>{{product.id}}" class="edit-task pull-left"><i class="ion-trash-b"></i></a>
										</div>
									</div>
								</li>
							</ul>
						</li>
						<?php if (empty($products)) { echo '<img src="'.base_url('assets/img/no_lead.png').'" alt="">';}?>
						</ul>
						<div class="pagination-div">
							<ul class="pagination">
								<li ng-class="DisablePrevPage()">
									<a href ng-click="prevPage()"><i class="ion-ios-arrow-back"></i></a>
								</li>
								<li ng-repeat="n in range()" ng-class="{active: n == currentPage}" ng-click="setPage(n)">
									<a href="#" ng-bind="n+1"></a>
								</li>
								<li ng-class="DisableNextPage()">
									<a href ng-click="nextPage()"><i class="ion-ios-arrow-right"></i></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div id="add" tabindex="-1" role="content" class="modal fade colored-header colored-header-dark">
	<div class="modal-dialog">
		<?php echo form_open('products/add'); ?>
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
				<h3 class="modal-title"><?php echo lang('addproduct')?></h3>
			</div>
			<div class="col-md-6 md-pr-0">
				<div class="modal-body md-pr-5">
					<div class="form-group">
						<label for="productname"><?php echo lang('productname'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-ios-pricetags"></i></span>
							<input type="text" name="productname" value="<?php echo $this->input->post('productname'); ?>" class="form-control" id="productname" placeholder="<?php echo lang('productname')?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="sale_price"><?php echo lang('purchaseprice'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-social-usd"></i></span>
							<input type="text" name="purchase_price" value="<?php echo $this->input->post('purchase_price'); ?>" class="form-control" id="purchase_price" placeholder="0,00"/>
						</div>
					</div>
					<div class="form-group">
						<label for="sale_price"><?php echo lang('salesprice'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-social-usd"></i></span>
							<input type="text" name="sale_price" value="<?php echo $this->input->post('sale_price'); ?>" class="form-control" id="sale_price" placeholder="0,00"/>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-6 md-pl-0">
				<div class="modal-body md-pl-5">
					<div class="form-group">
						<label for="code"><?php echo lang('productcode'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-ios-barcode"></i></span>
							<input type="text" name="code" value="<?php echo $this->input->post('code'); ?>" class="form-control" id="code" placeholder="<?php echo lang('productcode')?>"/>
						</div>
					</div>
					<div class="form-group">
						<label for="vat"><?php echo lang('vat'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-ios-medical"></i></span>
							<input type="text" name="vat" value="<?php echo $this->input->post('vat'); ?>" class="form-control" id="vat" placeholder="Vat Rate %"/>
						</div>
					</div>
					<div class="form-group">
						<label for="stock"><?php echo lang('instock'); ?></label>
						<div class="input-group"><span class="input-group-addon"><i class="ion-cube"></i></span>
							<input type="text" name="stock" value="<?php echo $this->input->post('stock'); ?>" class="form-control" id="stock" placeholder="<?php echo lang('instock')?>"/>
						</div>
					</div>
				</div>
			</div>
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
				<div class="col-md-6 pull-left text-left md-pl-0">
                    <div class="ciuis-body-checkbox has-success">
                      <input name="stocktracking" id="yes" type="checkbox" value="1">
                      <label for="yes"><?php echo lang('stocktracking')?></label>
                    </div>
                  </div>
					<div class="btn-group">
						<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel'); ?></button>
					<button type="submit" class="btn btn-default"><?php echo lang('save'); ?></button>
					</div>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
</div>
<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>