<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Panel extends CIUIS_Controller {
	function index() {
		$data[ 'title' ] = 'Ciuis™ CRM';
		$data[ 'weekly_sales_chart' ] = json_encode( $this->Report_Model->weekly_sales_chart() );
		$data[ 'weekly_expenses_chart' ] = json_encode( $this->Report_Model->weekly_expenses() );
		$data[ 'monthly_expense_graph' ] = $this->Report_Model->a1();
		$data[ 'monthly_sales_graph' ] = $this->Report_Model->monthly_sales_graph();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'panel/index', $data );
	}
}