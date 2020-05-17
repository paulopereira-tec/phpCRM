<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Accounts extends CIUIS_Controller {

	function index() {
		$data[ 'title' ] = lang( 'accounts' );
		$data[ 'accounts' ] = $this->Accounts_Model->get_all_accounts();
		$data[ 'tht' ] = $this->Report_Model->tht();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'accounts/index', $data );
	}

	function add() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'type' => $this->input->post( 'type' ),
				'bankname' => $this->input->post( 'bankname' ),
				'branchbank' => $this->input->post( 'branchbank' ),
				'account' => $this->input->post( 'account' ),
				'iban' => $this->input->post( 'iban' ),
				'status_id' => $this->input->post( 'status' ),
			);
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'accountadded' ) . '</b>' );
			$accountsid = $this->Accounts_Model->account_add( $params );
			redirect( 'accounts/index' );
		}
	}

	function update( $id ) {
		$data[ 'accounts' ] = $this->Accounts_Model->get_accounts( $id );
		if ( isset( $data[ 'accounts' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
					'bankname' => $this->input->post( 'bankname' ),
					'branchbank' => $this->input->post( 'branchbank' ),
					'account' => $this->input->post( 'account' ),
					'iban' => $this->input->post( 'iban' ),
					'status_id' => $this->input->post( 'status' ),
				);
				$this->Accounts_Model->updateaccount( $id, $params );
				redirect( 'accounts/account/' . $id . '' );
			} else {
				$this->load->view( 'accounts/', $data );
			}
		} else
			show_error( 'The expenses you are trying to edit does not exist.' );
	}

	function account( $id ) {
		$data[ 'title' ] = lang( 'account' );
		$accounts = $this->Accounts_Model->get_accounts( $id );
		$data[ 'payments' ] = $this->db->select( '*' )->order_by( 'id', 'desc' )->get_where( 'payments', array( 'account_id' => $id ) )->result_array();
		$data[ 'accounts' ] = $this->Accounts_Model->get_accounts( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'accounts/account', $data );
	}

	function remove( $id ) {
		$accounts = $this->Accounts_Model->get_accounts( $id );
		if ( isset( $accounts[ 'id' ] ) ) {
			$this->Accounts_Model->delete_account( $id );
			redirect( 'accounts/index' );
		}
	}
}