<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Payments extends CIUIS_Controller {
	function add() {
		$amount = $this->input->post( 'amount' );
		$invoicetotal = $this->input->post( 'invoicetotal' );
		if ( $amount > $invoicetotal ) {
			$this->session->set_flashdata( 'ntf3', '<span class="text-black"><b>' . lang( 'paymentamounthigh' ) . '</b></span>' );
			redirect( 'invoices/edit/' . $this->input->post( 'invoice' ) . '' );
		} else {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'invoice_id' => $this->input->post( 'invoice' ),
					'amount' => $amount,
					'account_id' => $this->input->post( 'account' ),
					'date' => _pdate( $this->input->post( 'date' ) ),
					'not' => $this->input->post( 'not' ),
					'attachment' => $this->input->post( 'attachment' ),
					'customer_id' => $this->input->post( 'customer' ),
					'staff_id' => $this->input->post( 'staff' ),
				);
				$payments = $this->Payments_Model->addpayment( $params );
				redirect( 'invoices/edit/' . $this->input->post( 'invoice' ) . '' );
			}
		}
	}
}