<?php
class Payments_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function addpayment( $params ) {
		$this->db->insert( 'payments', $params );
		$amount = $this->input->post( 'amount' );
		$invoicetotal = $this->input->post( 'invoicetotal' );
		if ( $amount == $invoicetotal ) {
			$response = $this->db->where( 'id', $this->input->post( 'invoice' ) )->update( 'invoices', array( 'status_id' => 2, 'duedate' => '' ) );
		} else {
			$response = $this->db->where( 'id', $this->input->post( 'invoice' ) )->update( 'invoices', array( 'status_id' => 3) );
		}
		return $this->db->insert_id();
	}

	function todaypayments() {
		return $this->db->get_where( 'payments', array( 'DATE(date)' => date( 'Y-m-d' ) ) )->result_array();
	}
}