<?php
class Customers_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	// Get Customer
	
	function get_customers( $id ) {
		$this->db->select( '*,countries.shortname as country, customers.id as id ' );
		$this->db->join( 'countries', 'customers.country_id = countries.id', 'left' );
		return $this->db->get_where( 'customers', array( 'customers.id' => $id ) )->row_array();
	}


	// Get All Customers
	
	function get_all_customers() {
		$this->db->select( '*,countries.shortname as country,countries.isocode as isocode, customers.id as id ' );
		$this->db->join( 'countries', 'customers.country_id = countries.id', 'left' );
		$this->db->order_by( 'customers.id', 'desc' );
		return $this->db->get_where( 'customers', array( '' ) )->result_array();
	}

	// ADD NEW CUSTOMER
	function add_customers( $params ) {
		$this->db->insert( 'customers', $params );
		//LOG
		$customer = $this->db->insert_id();
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->logged_in_staff_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('addedacustomer').' <a href="customers/customer/' . $customer . '">'.lang('customer').'-' . $customer . '</a>' ),
			'staff_id' => $loggedinuserid
		) );
		return $this->db->insert_id();
	}

	// UPDATE CUSTOMER
	
	function update_customers( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'customers', $params );
	}

	// DELETE CUSTOMER
	
	function delete_customers( $id ) {
		$response = $this->db->delete( 'invoices', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'contacts', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'payments', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'expenses', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'expenses', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'logs', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'notifications', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'projects', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'tickets', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'sales', array( 'customer_id' => $id ) ); 
		$response = $this->db->delete( 'customers', array( 'id' => $id ) );
		// LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->logged_in_staff_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('deleted').' '.lang('customer').'-' . $id . '' ),
			'staff_id' => $loggedinuserid
		) );
	}
	
	// CUSTOMER GRAPH
	
	function customer_annual_sales_chart( $id ) {
		$totalsales = array();
		$i = 0;
		for ( $MO = 1; $MO <= 12; $MO++ ) {
			$this->db->select( 'total' );
			$this->db->from( 'sales' );
			$this->db->where( 'MONTH(sales.date)', $MO );
			$this->db->where( 'customer_id = ' . $id . '' );
			$balances = $this->db->get()->result_array();
			if ( !isset( $totalsales[ $MO ] ) ) {
				$totalsales[ $i ] = array();
			}
			if ( count( $balances ) > 0 ) {
				foreach ( $balances as $balance ) {
					$totalsales[ $i ][] = $balance[ 'total' ];
				}
			} else {
				$totalsales[ $i ][] = 0;
			}
			$totalsales[ $i ] = array_sum( $totalsales[ $i ] );
			$i++;
		}
		return json_encode( $totalsales );
	}

	function search_json_customer() {
		$this->db->select( 'id customer,type customertype,company company,namesurname individual,' );
		$this->db->from( 'customers' );
		return $this->db->get()->result();
	}
}