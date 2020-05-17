<?php
class Invoices_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_invoices( $id ) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,invoicestatus.name as statusname,invoices.status_id as status_id, invoices.id as id ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'invoices', array( 'invoices.id' => $id ) )->row_array();
	}

	function get_invoiceitems( $id ) {
		return $this->db->get_where( 'invoiceitems', array( 'id' => $id ) )->row_array();
	}
	// GET ALL INVOICES
	function get_all_invoices() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,invoicestatus.name as statusname,invoices.status_id as status_id, invoices.id as id ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->order_by( 'invoices.id', 'desc' );
		return $this->db->get_where( 'invoices', array( '' ) )->result_array();
	}

	function dueinvoices() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,customers.email as customeremail,customers.type as type,invoicestatus.name as statusname, invoices.id as id ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->order_by( 'invoices.id', 'desc' );
		return $this->db->get_where( 'invoices', array( 'DATE(duedate)' => date( 'Y-m-d' ) ) )->result_array();
	}

	function overdueinvoices() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individual,customers.address as customeraddress,customers.email as customeremail,customers.type as type,invoicestatus.name as statusname, invoices.id as id ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$this->db->where( 'CURDATE() > invoices.duedate AND invoices.duedate != "0000.00.00" AND invoices.status_id != "4" AND invoices.status_id != "2"' );
		$this->db->order_by( 'invoices.id', 'desc' );
		return $this->db->get( 'invoices' )->result_array();
	}
	// GET INVOICE DETAILS
	function get_invoice_detail( $id ) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffmemberresim,customers.company as customercompany,customers.namesurname as individualindividual,customers.address as customeraddress,customers.email as email,invoicestatus.name as statusname,invoices.status_id as status_id, invoices.id as id ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'invoices', array( 'invoices.id' => $id ) )->row_array();
	}

	function get_invoice_productsi_art( $id ) {
		$this->db->select_sum( 'in[total]' );
		$this->db->from( 'invoiceitems' );
		$this->db->where( '(invoice_id = ' . $id . ') ' );
		return $this->db->get();
	}

	function get_invoice_tahsil_edilen( $id ) {
		$this->db->select_sum( 'amount' );
		$this->db->from( 'payments' );
		$this->db->where( '(invoice_id = ' . $id . ') ' );
		return $this->db->get();
	}
	// CHANCE INVOCE STATUS

	function status_1( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'invoices', array( 'status_id' => ( '1' ) ) );
		$response = $this->db->update( 'sales', array( 'invoice_id' => $id, 'status_id' => '1' ) );
	}

	function status_2( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'invoices', array( 'status_id' => ( '2' ) ) );
		$response = $this->db->update( 'sales', array( 'invoice_id' => $id, 'status_id' => '2' ) );
	}

	function status_3( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'invoices', array( 'status_id' => ( '3' ) ) );
		$response = $this->db->update( 'sales', array( 'invoice' => $id, 'status_id' => '3' ) );
	}
	// ADD INVOICE
	function invoice_add( $params ) {
		$this->db->insert( 'invoices', $params );
		$invoice = $this->db->insert_id();
		if ( $this->input->post( 'status' ) == 2 ) {
			$loggedinuserid = $this->session->logged_in_staff_id;
			$this->db->insert( 'payments', array(
				'transactiontype' => 0,
				'invoice_id' => $invoice,
				'staff_id' => $loggedinuserid,
				'amount' => $this->input->post( 'total' ),
				'customer_id' => $this->input->post( 'customer' ),
				'account_id' => $this->input->post( 'account' ),
				'not' => 'Paymet for <a href="' . base_url( 'invoices/invoice/' . $invoice . '' ) . '">' . lang( 'invoiceprefix' ) . '' . $invoice . '</a>',
				'date' => _pdate( $this->input->post( 'datepayment' ) ),
			) );
		}
		// MULTIPLE INVOICE ITEMS POST
		$countitem = count( $this->input->post( 'in[product_id]' ) );
		$countitem = $countitem - 1;
		for ( $i = 0; $i < $countitem; $i++ ) {
			$iteminfo[] = array(
				'invoice_id' => $invoice,
				'in[itemid]' => $this->input->post( 'in[itemid]' )[ $i ],
				'in[name]' => $this->input->post( 'in[name]' )[ $i ],
				'in[code]' => $this->input->post( 'in[code]' )[ $i ],
				'in[product_id]' => $this->input->post( 'in[product_id]' )[ $i ],
				'in[description]' => $this->input->post( 'in[description]' )[ $i ],
				'in[amount]' => $this->input->post( 'in[amount]' )[ $i ],
				'in[unit]' => $this->input->post( 'in[unit]' )[ $i ],
				'in[price]' => $this->input->post( 'in[pricepost]' )[ $i ],
				'in[discount_rate]' => $this->input->post( 'in[discount_rate]' )[ $i ],
				'in[price_discounted]' => $this->input->post( 'in[price_discounted]' )[ $i ],
				'in[discount_type]' => $this->input->post( 'in[discount_type]' )[ $i ],
				'in[discount_rate_status]' => $this->input->post( 'in[discount_rate_status]' )[ $i ],
				'in[vat]' => $this->input->post( 'in[vat]' )[ $i ],
				'in[total_vat]' => $this->input->post( 'in[total_vat]' )[ $i ],
				'in[total]' => $this->input->post( 'in[total]' )[ $i ],
			);
		}
		$this->db->insert_batch( 'invoiceitems', $iteminfo );
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->logged_in_staff_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="invoices/invoice/' . $invoice . '">' . lang( 'invoiceprefix' ) . '-' . $invoice . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' )
		) );
		//NOTIFICATION
		$staffname = $this->session->staffname;
		$staffavatar = $this->session->staffavatar;
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $staffname . ' ' . lang( 'isaddedanewinvoice' ) . '' ),
			'customer_id' => $this->input->post( 'customer' ),
			'perres' => $staffavatar,
			'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
		) );
		//--------------------------------------------------------------------------------------
		$this->db->insert( $this->db->dbprefix . 'sales', array(
			'invoice_id' => '' . $invoice . '',
			'status_id' => $this->input->post( 'status' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' ),
			'total' => $this->input->post( 'total' ),
			'date' => date( 'Y-m-d H:i:s' )
		) );
		//----------------------------------------------------------------------------------------
		return $this->db->insert_id();
	}
	// UPDATE INVOCE
	function update_invoices( $id, $params ) {
		$this->db->where( 'id', $id );
		$invoice = $id;
		$response = $this->db->update( 'invoices', $params );
		$response = $this->db->delete( 'invoiceitems', array( 'invoice_id' => $id ) );
		$countitem = count( $this->input->post( 'in[itemid]' ) );
		$countitem = $countitem - 1;
		for ( $i = 0; $i < $countitem; $i++ ) {
			$newitem[] = array(
				'invoice_id' => $invoice,
				'in[name]' => $this->input->post( 'in[name]' )[ $i ],
				'in[code]' => $this->input->post( 'in[code]' )[ $i ],
				'in[product_id]' => $this->input->post( 'in[product_id]' )[ $i ],
				'in[description]' => $this->input->post( 'in[description]' )[ $i ],
				'in[amount]' => $this->input->post( 'in[amount]' )[ $i ],
				'in[unit]' => $this->input->post( 'in[unit]' )[ $i ],
				'in[price]' => $this->input->post( 'in[pricepost]' )[ $i ],
				'in[discount_rate]' => $this->input->post( 'in[discount_rate]' )[ $i ],
				'in[price_discounted]' => $this->input->post( 'in[price_discounted]' )[ $i ],
				'in[discount_type]' => $this->input->post( 'in[discount_type]' )[ $i ],
				'in[discount_rate_status]' => $this->input->post( 'in[discount_rate_status]' )[ $i ],
				'in[vat]' => $this->input->post( 'in[vat]' )[ $i ],
				'in[total_vat]' => $this->input->post( 'in[total_vat]' )[ $i ],
				'in[total]' => $this->input->post( 'in[total]' )[ $i ],
			);
		}
		$this->db->insert_batch( 'invoiceitems', $newitem );
		// UPDATE SALES INFORMATIONS
		$response = $this->db->where( 'invoice_id', $id )->update( 'sales', array(
			'status_id' => $this->input->post( 'status' ),
			'staff_id' => $this->input->post( 'staff' ),
			'customer_id' => $this->input->post( 'customer' ),
			'total' => $this->input->post( 'total' ),
		) );
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->logged_in_staff_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ) . ' <a href="invoices/invoice/' . $id . '">' . lang( 'invoiceprefix' ) . '-' . $id . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $this->input->post( 'customer' )
		) );
		//NOTIFICATION
		$staffname = $this->session->staffname;
		$staffavatar = $this->session->staffavatar;
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $staffname . ' ' . lang( 'uptdatedinvoice' ) . '' ),
			'customer_id' => $this->input->post( 'customer' ),
			'perres' => $staffavatar,
			'target' => '' . base_url( 'area/invoice/' . $invoice . '' ) . ''
		) );
		if ( $response ) {
			return "Invoice Updated.";
		} else {
			return "There was a problem during the update.";
		}
	}
	//INVOICE DELETE
	function delete_invoices( $id ) {
		$response = $this->db->delete( 'invoices', array( 'id' => $id ) );
		$response = $this->db->delete( 'invoiceitems', array( 'invoice_id' => $id ) );
		$response = $this->db->delete( 'payments', array( 'invoice_id' => $id ) );
		$response = $this->db->delete( 'sales', array( 'invoice_id' => $id ) );
		$response = $this->db->where( 'invoice_id', $id )->update( 'expenses', array( 'invoice_id' => null ) );
		// LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->logged_in_staff_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang( 'invoiceprefix' ) . '-' . $id . '' ),
			'staff_id' => $loggedinuserid
		) );
	}

	// function updateinvoiceitemsingleinline( $column, $lastvalue, $id ) {
	//	$column = $this->input->post( 'column' );
	//	$lastvalue = $this->input->post( 'lastvalue' );
	//	$id = $this->input->post( 'id' );
	//	$result = $this->db->where( 'id', $id )->update( 'invoiceitems', array(
	//		'' . $column . '' => '' . $lastvalue . ''
	//	) );
	//}
	
	function cancelled() {
		$response = $this->db->where( 'id', $_POST['invoice_id'] )->update( 'invoices', array( 'status_id' => $_POST['status_id'] ) );
		$response = $this->db->delete( 'sales', array( 'invoice_id' => $_POST['invoice_id'] ) );
		$response = $this->db->delete( 'payments', array( 'invoice_id' => $_POST['invoice_id'] ) );
	}

	function deleteinvoiceitem( $id ) {
		$response = $this->db->delete( 'invoiceitems', array( 'id' => $id ) );
	}
	public

	function get_invoice_year() {
		return $this->db->query( 'SELECT DISTINCT(YEAR(date)) as year FROM invoices ORDER BY year DESC' )->result_array();
	}
}