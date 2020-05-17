<?php include_once(APPPATH . 'views/inc/header.php'); ?>

<div class="ciuis-body-content" ng-controller="Accounts_Controller">
	<div class="main-content container-fluid col-xs-12 col-md-12 col-lg-9">
		<div class="account-container-ciuis-65343256347">
			<section class="accounts-information-ciuis-1881-sonuzadek">
				<i class="ion-ios-bookmarks-outline icon"></i>
				<section class="account-information-cover-234">
					<h3 class="information"><?php echo lang('accountswelcome'); ?></h3>
					<a data-target="#newaccount" data-toggle="modal" class="reconnect-cta"><b><?php echo lang('newaccount'); ?></b></a>
				</section>
			</section>
			<section class="ciuis-accounts">
				<a ng-repeat="account in accounts" href="<?php echo base_url('accounts/account/{{account.id}}')?>" class="huppur ciuis-account checking">
					<div class="icon {{account.icon}}" width="23px" height="30px"></div>
					<div class="ciuis-account-information">
						<h4 class="ciuis-account-type" ng-bind="account.name"></h4>
						<p class="ciuis-account-detail" ng-bind="account.status"></p>
					</div>
					<label class="ciuis-account-temprorary"><p class="money-area" ng-bind="account.amount"></p></label>
				</a>
				<span class="pull-right"><p class="money-area"><?php echo $tht; ?></p></span>
			</section>
		</div>
		<div class="ciuis-account-attr"></div>
	</div>
	<div id="newaccount" tabindex="-1" role="dialog" class="modal fade colored-header colored-header-warning">
		<?php echo form_open('accounts/add',array("class"=>"form-vertical")); ?>
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
					<h3 class="modal-title text-modal">
						<?php echo lang('newaccount');?>
						<div class="col-md-4 xs-pt-10 pull-right">
							<div class="btn-group" data-toggle="buttons">
								<label class="btn btn-md btn-warning btn-reverse active"><input name="type" type="radio" checked value="0"><?php echo lang('cash')?></label>
								<label class="btn btn-md btn-warning btn-reverse"><input name="type" type="radio" value="1"><?php echo lang('bank')?></label>
							</div>
						</div>
					</h3>
					<span class="text-modal-detail"><?php echo lang('newaccountdetail');?></span>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-xs-12 col-md-12 col-lg-12">
							<div class="form-group">
								<label class=""><?php echo lang('accountname')?></label>
								<div class="input-group">
								<span class="input-group-addon"><i class="mdi mdi-money-box"></i></span>
									<input required type="text" name="name" value="<?php echo $this->input->post('name'); ?>" class="form-control" id="name"/ placeholder="<?php echo lang('accountname')?>">
								</div>
							</div>
							<div style="display:none" class="bank">
								<div class="form-group col-md-6 xs-pt-10 xs-pb-10 xs-pl-0">
									<label class=""><?php echo lang('bankname')?></label>
									<div class="input-group">
									<span class="input-group-addon"><i class="mdi mdi-balance"></i></span>
										<input type="text" name="bankname" value="<?php echo $this->input->post('bankname'); ?>" class="form-control" id="bankname"/ placeholder="Global Bank">
									</div>
								</div>
								<div class="form-group col-md-6 xs-pt-10 xs-pb-10 xs-pr-0 xs-pl-0">
									<label class=""><?php echo lang('branchbank')?></label>
									<div class="input-group">
									<span class="input-group-addon"><i class="mdi mdi-city-alt"></i></span>
										<input type="text" name="branchbank" value="<?php echo $this->input->post('branchbank'); ?>" class="form-control" id="branchbank"/ placeholder="Eg: Paris">
									</div>
								</div>
								<div class="form-group xs-pb-10">
									<label class=""><?php echo lang('accountnumber')?></label>
									<div class="input-group">
									<span class="input-group-addon"><i class="mdi mdi-collection-item-1"></i></span>
										<input type="text" name="account" value="<?php echo $this->input->post('account'); ?>" class="form-control" id="account"/ placeholder="0000071219812874">
									</div>
								</div>
								<div class="form-group xs-pb-10">
									<label class=""><?php echo lang('iban')?></label>
									<div class="input-group">
									<span class="input-group-addon"><i class="mdi mdi-card"></i></span>
										<input type="text" name="iban" value="<?php echo $this->input->post('iban'); ?>" class="form-control" id="iban"/ placeholder="GB29 RBOS 6016 1331 9268 19">
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<div class="switch-button switch-button-success pull-left">
						<input type="checkbox" checked value="0" name="status" id="swt6">
						<span><label for="swt6"></label></span>
					</div>
					<button type="button" data-dismiss="modal" class="btn btn-default modal-close"><?php echo lang('cancel');?></button>
					<button type="submit" class="btn btn-default modal-close"><?php echo lang('add');?></button>
				</div>
			</div>
		</div>
		<?php echo form_close(); ?>
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
	
</div>
<?php include_once(APPPATH . 'views/inc/footer.php'); ?>