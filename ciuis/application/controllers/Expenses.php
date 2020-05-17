<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Expenses extends CIUIS_Controller {

	function index() {
		$data[ 'title' ] = lang( 'expenses' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Products', 'products' );
		$this->breadcrumb->add_crumb( 'Tüm Products' );
		$data[ 'expenses' ] = $this->Expenses_Model->get_all_expenses();
		$this->load->view( 'expenses/index', $data );
	}

	function add() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'category_id' => $this->input->post( 'category' ),
				'staff_id' => $this->input->post( 'staff' ),
				'customer_id' => $this->input->post( 'customer' ),
				'account_id' => $this->input->post( 'account' ),
				'title' => $this->input->post( 'title' ),
				'date' => _phdate( $this->input->post( 'date' ) ),
				'created' => $this->input->post( 'created' ),
				'amount' => $this->input->post( 'amount' ),
				'description' => $this->input->post( 'description' ),
			);
			$expenses_id = $this->Expenses_Model->add_expenses( $params );
			redirect( 'expenses/index' );
		} else {
			$data[ 'all_expensecat' ] = $this->Expenses_Model->get_all_expensecat();
			$data[ 'all_staff' ] = $this->Staff_model->get_all_staff();
			$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
			$data[ 'all_accounts' ] = $this->Accounts_model->get_all_accounts();
			$this->load->view( 'expenses/add', $data );
		}
	}

	function edit( $id ) {
		// check if the expenses exists before trying to edit it
		$data[ 'expenses' ] = $this->Expenses_Model->get_expenses( $id );

		if ( isset( $data[ 'expenses' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'category_id' => $this->input->post( 'category' ),
					'staff_id' => $this->input->post( 'staff' ),
					'customer_id' => $this->input->post( 'customer' ),
					'account_id' => $this->input->post( 'account' ),
					'title' => $this->input->post( 'title' ),
					'date' => _phdate( $this->input->post( 'date' ) ),
					'created' => $this->input->post( 'created' ),
					'amount' => $this->input->post( 'amount' ),
					'description' => $this->input->post( 'description' ),
				);
				$this->Expenses_Model->update_expenses( $id, $params );
				redirect( 'expenses/receipt/' . $id . '' );
			} else {
				$data[ 'all_expensecat' ] = $this->Expenses_Model->get_all_expensecat();
				$data[ 'all_staff' ] = $this->Staff_model->get_all_staff();
				$this->load->view( 'expenses/edit', $data );
			}
		} else
			show_error( 'The expenses you are trying to edit does not exist.' );
	}

	function receipt( $id ) {
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Products', 'products' );
		$this->breadcrumb->add_crumb( 'Tüm Products' );
		$data[ 'title' ] = lang( 'expense' );
		$data[ 'expenses' ] = $this->Expenses_Model->get_all_expenses();
		$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
		$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
		$data[ 'all_accounts' ] = $this->Accounts_Model->get_all_accounts();
		$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
		$data[ 'expensecat' ] = $this->Expenses_Model->get_all_expensecat();
		$data[ 'expenses' ] = $this->Expenses_Model->get_expenses( $id );
		$data[ 'expensesdata' ] = $this->Expenses_Model->get_all_expenses();
		if ( isset( $data[ 'expenses' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'category_id' => $this->input->post( 'category' ),
					'staff_id' => $this->input->post( 'staff' ),
					'customer_id' => $this->input->post( 'customer' ),
					'account_id' => $this->input->post( 'account' ),
					'title' => $this->input->post( 'title' ),
					'date' => _pdate( $this->input->post( 'date' ) ),
					'created' => $this->input->post( 'created' ),
					'amount' => $this->input->post( 'amount' ),
					'description' => $this->input->post( 'description' ),
				);
				$this->Expenses_Model->update_expenses( $id, $params );
				redirect( 'expenses/index' );
			} else {
				$data[ 'all_expensecat' ] = $this->Expenses_Model->get_all_expensecat();
				$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
				$this->load->view( 'expenses/receipt', $data );
			}
		} else
			show_error( 'The expenses you are trying to edit does not exist.' );
	}

	function convertinvoice( $id ) {
		$expenses = $this->Expenses_Model->get_expenses( $id );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'staff_id' => $expenses[ 'staff_id' ],
				'customer_id' => $expenses[ 'customer_id' ],
				'created' => date( 'Y-m-d H:i:s' ),
				'status_id' => 3,
				'total' => $expenses[ 'amount' ],
				'expense_id' => $id,
				'total_sub' => $expenses[ 'amount' ],
			);
			$this->db->insert( 'invoices', $params );
			$invoice = $this->db->insert_id();
			$this->db->insert( 'invoiceitems', array(
				'invoice_id' => $invoice,
				'in[name]' => $expenses[ 'title' ],
				'in[total]' => $expenses[ 'amount' ],
				'in[price]' => $expenses[ 'amount' ],
				'in[amount]' => 1,
				'in[unit]' => 'Unit',
				'in[description]' => $expenses[ 'desc' ],
			) );
			$loggedinuserid = $this->session->logged_in_staff_id;
			$this->db->insert( $this->db->dbprefix . 'sales', array(
				'invoice_id' => '' . $invoice . '',
				'status_id' => 3,
				'staff_id' => $loggedinuserid,
				'customer_id' => $expenses[ 'customer_id' ],
				'total' => $expenses[ 'amount' ],
				'date' => date( 'Y-m-d H:i:s' )
			) );
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' ),
				'detail' => ( '' . $message = sprintf( lang( 'expensetoinvoicelog' ), $staffname, $expenses[ 'id' ] ) . '' ),
				'staff_id' => $loggedinuserid,
				'customer_id' => $expenses[ 'customer_id' ],
			) );
			$response = $this->db->where( 'id', $id )->update( 'expenses', array( 'invoice_id' => $invoice ) );
			redirect( 'invoices/edit/' . $invoice . '' );
		}
	}

	function remove( $id ) {
		$expenses = $this->Expenses_Model->get_expenses( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $expenses[ 'id' ] ) ) {
			$this->Expenses_Model->delete_expenses( $id );
			redirect( 'expenses/index' );
		} else
			show_error( 'The expenses you are trying to delete does not exist.' );
	}

	function addcategory() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
			);
			$expensecategory_id = $this->Expenses_Model->add_expensecategory( $params );
			redirect( 'expenses/index' );
		} else {
			redirect( 'expenses/index' );
		}
	}

	function editcategory( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
			);
			$this->Expenses_Model->update_expensecategory( $id, $params );
		}
	}

	function removecategory( $id ) {
		$expensecategory = $this->Expenses_Model->get_expensecategory( $id );
		if ( isset( $expensecategory[ 'id' ] ) ) {
			$this->Expenses_Model->delete_expensecategory( $id );
			redirect( 'expenses/index' );
		} else
			show_error( 'The expensecategory you are trying to delete does not exist.' );
	}

}