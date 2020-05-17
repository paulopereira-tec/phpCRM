<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Area_Model extends CI_Model {
	public

	function __construct() {
		parent::__construct();
		$this->load->database();
	}
	/* Create Contact Function */
	function create_user( $email, $password ) {
		$data = array(
			'email' => $email,
			'password' => $this->hash_password( $password ),
			'created_at' => date( 'Y-m-j H:i:s' ),
		);
		return $this->db->insert( 'contacts', $data );
	}
	/* Resolve Contact Login */
	public

	function resolve_user_login( $email, $password ) {
		$this->db->select( 'password' );
		$this->db->from( 'contacts' );
		$this->db->where( 'email', $email );
		$hash = $this->db->get()->row( 'password' );
		return $this->verify_password_hash( $password, $hash );
	}
	/* Get Contact id from email */
	public

	function get_contact_id_from_email( $email ) {
		$this->db->select( 'id' );
		$this->db->from( 'contacts' );
		$this->db->where( 'email', $email );
		return $this->db->get()->row( 'id' );
	}
	/* Get user id from email */
	public

	function get_customer( $email ) {
		$this->db->select( 'customer_id' );
		$this->db->from( 'contacts' );
		$this->db->where( 'email', $email );
		return $this->db->get()->row( 'id' );
	}

	/* Get Contact */
	public

	function get_user( $contact_id ) {
		$this->db->from( 'contacts' );
		$this->db->where( 'id', $contact_id );
		return $this->db->get()->row();
	}
	/* Hash Password Function */
	private

	function hash_password( $password ) {
		return password_hash( $password, PASSWORD_BCRYPT );
	}
	/* Verify Password Hash* @return bool */
	private

	function verify_password_hash( $password, $hash ) {
		return password_verify( $password, $hash );

	}
	//TICKET FUNCTIONS
	function ttc() {
		$this->db->from( 'tickets' );
		$this->db->where( 'contact_id = ' . $_SESSION[ 'contact_id' ] . '' );
		$query = $this->db->get();
		$ttc = $query->num_rows();
		return $ttc;
	}

	function otc() {
		$this->db->from( 'tickets' )->where( 'status_id = 1 AND contact_id = ' . $_SESSION[ 'contact_id' ] . '' );
		$query = $this->db->get();
		$otc = $query->num_rows();
		return $otc;
	}

	function ipc() {
		$this->db->from( 'tickets' )->where( 'status_id = 2 AND contact_id = ' . $_SESSION[ 'contact_id' ] . '' );
		$query = $this->db->get();
		$ipc = $query->num_rows();
		return $ipc;
	}

	function atc() {
		$this->db->from( 'tickets' )->where( 'status_id = 3 AND contact_id = ' . $_SESSION[ 'contact_id' ] . '' );
		$query = $this->db->get();
		$atc = $query->num_rows();
		return $atc;
	}

	function ctc() {
		$this->db->from( 'tickets' )->where( 'status_id = 4 AND contact_id = ' . $_SESSION[ 'contact_id' ] . '' );
		$query = $this->db->get();
		$ctc = $query->num_rows();
		return $ctc;
	}

	function add_tickets( $params ) {
		$this->db->insert( 'tickets', $params );
		$ticket = $this->db->insert_id();
		$contactname = $_SESSION[ 'name' ];
		$contactsurname = $_SESSION[ 'surname' ];
		$loggedinuserid = $_SESSION[ 'contact_id' ];
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $contactname . ' ' . $contactsurname . ' '.lang('added').' <a href="tickets/ticket/' . $ticket . '"> '.lang('ticket').'-' . $ticket . '</a>' ),
			'customer_id' => $loggedinuserid
		) );
		$customer = $_SESSION[ 'customer' ];
		$staffavatar = 'n-img.png';
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $contactname . ' ' . $contactsurname . '</span> '.lang('addednewticket').'' ),
			'public' => 1,
			'target' => '' . base_url( 'tickets/ticket/' . $ticket . '' ) . '',
			'perres' => $staffavatar
		) );
		return $this->db->insert_id();
	}

	function markread() {
		if ( isset( $_POST[ 'notification' ] ) ) {
			$ntf = $_POST[ 'notification' ];
			$response = $this->db->where( 'id', $ntf )->update( 'notifications', array( 'customerread' => ( '1' ) ) );
		}
	}

	function readnotification() {
		$yeni = $this->db->where( 'customerread = "0" AND contact_id = ' . $_SESSION[ 'contact_id' ] . '' )->get( 'notifications' )->result();
		if ( $yeni ) {
			return '-unread';
		}
	}

	function newnotification() {
		$yeni = $this->db->where( 'customerread = "0" OR customer_id = ' . $_SESSION[ 'customer' ] . ' AND contact_id = ' . $_SESSION[ 'contact_id' ] . '' )->get( 'notifications' )->result();
		if ( $yeni ) {
			return 'indicator';
		}
	}

	function get_all_notifications() {
		$this->db->select( '*,,staff.staffname as staffmembername, staff.staffavatar as staffimage, notifications.id as notifyid ' );
		$this->db->join( 'staff', 'notifications.staff_id = staff.id', 'left' );
		$this->db->order_by( "notifyid", "desc" );
		$this->db->where( 'contact_id = ' . $_SESSION[ 'contact_id' ] . ' OR customer_id = ' . $_SESSION[ 'customer' ] . '' );
		return $this->db->get( 'notifications' )->result_array();
	}

	function dueinvoices() {

		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffimage,customers.company as customer,customers.namesurname as individual,customers.address as customeraddress,customers.email as customeremail,customers.type as type,invoicestatus.name as statusname, invoices.id as id ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->where( 'duedate = "' . date( 'Y-m-d' ) . '" AND customer_id = ' . $_SESSION[ 'customer' ] . '' );
		return $this->db->get( 'invoices' )->result_array();
	}

	function overdueinvoices() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffimage,customers.company as customer,customers.namesurname as individual,customers.address as customeraddress,customers.email as customeremail,customers.type as type,invoicestatus.name as statusname, invoices.id as id ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->where( 'CURDATE() >= duedate AND duedate != "0000.00.00" AND customer_id = ' . $_SESSION[ 'customer' ] . '' );
		return $this->db->get( 'invoices' )->result_array();
	}
	function customerdebt() {
		$this->db->select_sum( 'total' );
		$this->db->from( 'invoices' );
		$this->db->where( 'status_id = 3 AND customer_id = ' . $_SESSION[ 'customer' ] . '' );
		return $this->db->get()->row()->total;
	}

	function logs() {
		return $this->db->select( '*,,staff.staffname as staffmembername, staff.staffavatar as staffimage, logs.date as date ' )->join( 'staff', 'logs.staff_id = staff.id', 'left' )->order_by( "date", "desc" )->get_where( 'logs', array( 'customer_id' => $_SESSION[ 'customer' ] ) )->result_array();
	}
	// CUSTOMER GRAPH
	function customer_annual_sales_chart() {
		$customer = $_SESSION[ 'customer' ];
		$totalsales = array();
		$i = 0;
		for ( $mo = 1; $mo <= 12; $mo++ ) {
			$this->db->select( 'total' );
			$this->db->from( 'sales' );
			$this->db->where( 'MONTH(sales.date)', $mo );
			$this->db->where( 'customer_id = ' . $customer . '' );
			$gains = $this->db->get()->result_array();
			if ( !isset( $totalsales[ $mo ] ) ) {
				$totalsales[ $i ] = array();
			}
			if ( count( $gains ) > 0 ) {
				foreach ( $gains as $gainx ) {
					$totalsales[ $i ][] = $gainx[ 'total' ];
				}
			} else {
				$totalsales[ $i ][] = 0;
			}
			$totalsales[ $i ] = array_sum( $totalsales[ $i ] );
			$i++;
		}
		return json_encode( $totalsales );
	}

}