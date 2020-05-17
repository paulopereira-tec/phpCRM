<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Invoices extends CIUIS_Controller {

	function index() {
		$data[ 'title' ] = lang( 'invoices' );
		$this->load->library( 'breadcrumb' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Invoices', 'invoices' );
		$this->breadcrumb->add_crumb( 'Tüm Invoices' );
		$data[ 'off' ] = $this->Report_Model->pff();
		$data[ 'ofv' ] = $this->Report_Model->ofv();
		$data[ 'oft' ] = $this->Report_Model->oft();
		$data[ 'vgf' ] = $this->Report_Model->vgf();
		$data[ 'tfa' ] = $this->Report_Model->tfa();
		$data[ 'pfs' ] = $this->Report_Model->pfs();
		$data[ 'otf' ] = $this->Report_Model->otf();
		$data[ 'tef' ] = $this->Report_Model->tef();
		$data[ 'vdf' ] = $this->Report_Model->vdf();
		$data[ 'fam' ] = $this->Report_Model->fam();
		$data[ 'ofy' ] = ( $data[ 'tfa' ] > 0 ? number_format( ( $data[ 'tef' ] * 100 ) / $data[ 'tfa' ] ) : 0 );
		$data[ 'ofx' ] = ( $data[ 'tfa' ] > 0 ? number_format( ( $data[ 'otf' ] * 100 ) / $data[ 'tfa' ] ) : 0 );
		$data[ 'vgy' ] = ( $data[ 'tfa' ] > 0 ? number_format( ( $data[ 'vdf' ] * 100 ) / $data[ 'tfa' ] ) : 0 );
		$data[ 'invoices' ] = $this->Invoices_Model->get_all_invoices();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'invoices/index', $data );
	}

	function add() {
		$data[ 'title' ] = lang( 'newinvoice' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Invoices', '../invoices' );
		$this->breadcrumb->add_crumb( 'Invoice Add' );
		$products = $this->Products_Model->get_all_products();
		$settings = $this->Settings_Model->get_settings_ciuis();
		$data_products = array();
		foreach ( $products as $product ) {
			switch ( $settings[ 'unitseparator' ] ) {
				case ',':
					$sale_price = number_format( $product[ 'sale_price' ], 2, ',', '.' );
					$product_vat = number_format( $product[ 'vat' ], 2, ',', '.' );
					break;
				case '.':
					$sale_price = number_format( $product[ 'sale_price' ], 2, '.', ',' );
					$product_vat = number_format( $product[ 'vat' ], 2, '.', ',' );
					break;
			}
			$data_products[] = array(
				'value' => $product[ 'id' ],
				'label' => $product[ 'productname' ],
				'description' => $product[ 'description' ],
				'sale_price' => $sale_price,
				'vat' => $product_vat,
			);
		};
		$data[ 'products' ] = json_encode( $data_products );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'no' => $this->input->post( 'no' ),
				'series' => $this->input->post( 'series' ),
				'customer_id' => $this->input->post( 'customer' ),
				'staff_id' => $this->input->post( 'staff' ),
				'created' => _pdate( $this->input->post( 'created' ) ),
				'duedate' => _pdate( $this->input->post( 'duedate' ) ),
				'not' => $this->input->post( 'not' ),
				'datesend' => _pdate( $this->input->post( 'datesend' ) ),
				'datepayment' => _pdate( $this->input->post( 'datepayment' ) ),
				'status_id' => $this->input->post( 'status' ),
				'total_sub' => $this->input->post( 'total_sub' ),
				'total_discount' => $this->input->post( 'total_discount' ),
				'sub_discount' => $this->input->post( 'sub_discount' ),
				'sub_discount_type' => $this->input->post( 'sub_discount_type' ),
				'total_sub_discount' => $this->input->post( 'total_sub_discount' ),
				'sub_discount_status' => $this->input->post( 'sub_discount_status' ),
				'total_vat' => $this->input->post( 'total_vat' ),
				'total' => $this->input->post( 'total' ),
				'notetitle' => $this->input->post( 'notetitle' ),
			);
			$invoices_id = $this->Invoices_Model->invoice_add( $params );
			redirect( 'invoices/index' );
		} else {
			$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
			$data[ 'all_accounts' ] = $this->Accounts_Model->get_all_accounts();
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$this->load->view( 'invoices/add', $data );
		}
	}
	public

	function get_json_items() {
		$area_id = $this->input->post( 'area' );
		$urunfiyat = $this->Products_Model->get_all_products();
		echo json_encode( $urunfiyat );
	}

	function edit( $id ) {
		$data[ 'title' ] = lang( 'updateinvoicetitle' );
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$data[ 'invoiceitems' ] = $this->db->select( '*,products.productname as name,invoiceitems.id as id ' )->join( 'products', 'invoiceitems.in[product_id] = products.id', 'left' )->get_where( 'invoiceitems', array( 'invoice_id' => $id ) )->result_array();
		$data[ 'payments' ] = $this->db->select( '*,accounts.name as accountname,payments.id as id ' )->join( 'accounts', 'payments.account_id = accounts.id', 'left' )->get_where( 'payments', array( 'invoice_id' => $id ) )->result_array();
		$data[ 'fatop' ] = $this->Invoices_Model->get_invoice_productsi_art( $id );
		$data[ 'tadtu' ] = $this->Invoices_Model->get_invoice_tahsil_edilen( $id );
		$products = $this->Products_Model->get_all_products();
		$settings = $this->Settings_Model->get_settings_ciuis();
		$data_products = array();
		foreach ( $products as $product ) {
			switch ( $settings[ 'unitseparator' ] ) {
				case ',':
					$sale_price = number_format( $product[ 'sale_price' ], 2, ',', '.' );
					$product_vat = number_format( $product[ 'vat' ], 2, ',', '.' );
					break;
				case '.':
					$sale_price = number_format( $product[ 'sale_price' ], 2, '.', ',' );
					$product_vat = number_format( $product[ 'vat' ], 2, '.', ',' );
					break;
			}
			$data_products[] = array(
				'value' => $product[ 'id' ],
				'label' => $product[ 'productname' ],
				'description' => $product[ 'description' ],
				'sale_price' => $sale_price,
				'vat' => $product_vat,
			);
		};
		$data[ 'products' ] = json_encode( $data_products );
		if ( isset( $invoices[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'no' => $this->input->post( 'no' ),
					'series' => $this->input->post( 'series' ),
					'customer_id' => $this->input->post( 'customer' ),
					'staff_id' => $this->input->post( 'staff' ),
					'created' => _pdate( $this->input->post( 'created' ) ),
					'duedate' => _pdate( $this->input->post( 'duedate' ) ),
					'not' => $this->input->post( 'not' ),
					'datesend' => _pdate( $this->input->post( 'datesend' ) ),
					'datepayment' => _pdate( $this->input->post( 'datepayment' ) ),
					'status_id' => $this->input->post( 'status' ),
					'total_sub' => $this->input->post( 'total_sub' ),
					'total_discount' => $this->input->post( 'total_discount' ),
					'sub_discount' => $this->input->post( 'sub_discount' ),
					'sub_discount_type' => $this->input->post( 'sub_discount_type' ),
					'total_sub_discount' => $this->input->post( 'total_sub_discount' ),
					'sub_discount_status' => $this->input->post( 'sub_discount_status' ),
					'total_vat' => $this->input->post( 'total_vat' ),
					'total' => $this->input->post( 'total' ),
					'notetitle' => $this->input->post( 'notetitle' ),
				);
				$this->session->set_flashdata( 'ntf1', 'Invoice ' . $id . ' Updated!' );
				$this->Invoices_Model->update_invoices( $id, $params );
				redirect( 'invoices/edit/' . $id . '' );
			} else {
				$data[ 'invoices' ] = $this->Invoices_Model->get_invoices( $id );
				$data[ 'accounts' ] = $this->Accounts_Model->get_all_accounts();
				$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
				$data[ 'all_accounts' ] = $this->Accounts_Model->get_all_accounts();
				$data[ 'todaypayments' ] = $this->Payments_Model->todaypayments();
				$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
				$this->load->view( 'invoices/edit', $data );
			}
		} else
			$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'invoiceediterror' ) );
	}

	function invoice( $id ) {
		$data[ 'title' ] = lang( 'invoice' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Invoices', 'invoices' );
		$this->breadcrumb->add_crumb( 'Invoice Detayı' );
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'accounts' ] = $this->Accounts_Model->get_all_accounts();
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$data[ 'invoiceitems' ] = $this->db->select( '*,products.productname as name,invoiceitems.id as id ' )->join( 'products', 'invoiceitems.in[product_id] = products.id', 'left' )->get_where( 'invoiceitems', array( 'invoice_id' => $id ) )->result_array();
		$data[ 'payments' ] = $this->db->select( '*,accounts.name as accountname,payments.id as id ' )->join( 'accounts', 'payments.account_id = accounts.id', 'left' )->get_where( 'payments', array( 'invoice_id' => $id ) )->result_array();
		$data[ 'fatop' ] = $this->Invoices_Model->get_invoice_productsi_art( $id );
		$data[ 'tadtu' ] = $this->Invoices_Model->get_invoice_tahsil_edilen( $id );
		$this->load->view( 'invoices/invoice', $data );
	}

	function status_1( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$invoices = $this->Invoices_Model->status_1( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			$this->Invoices_Model->status_1( $id );

		}
		$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'statuschanged' ) );
		redirect( 'invoices/index' );
	}

	function status_2( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$invoices = $this->Invoices_Model->status_2( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			$this->Invoices_Model->status_2( $id );
		}
		$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'statuschanged' ) );
		redirect( 'invoices/index' );
	}

	function status_3( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$invoices = $this->Invoices_Model->status_3( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			$this->Invoices_Model->status_3( $id );
		}
		$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'statuschanged' ) );
		redirect( 'invoices/index' );
	}

	function status_4( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$invoices = $this->Invoices_Model->status_4( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			$this->Invoices_Model->status_4( $id );
		}
		$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'statuschanged' ) );
		redirect( 'invoices/index' );
	}

	function status_5( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$invoices = $this->Invoices_Model->status_5( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			$this->Invoices_Model->status_5( $id );
		}
		$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'statuschanged' ) );
		redirect( 'invoices/index' );
	}

	function status_6( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		$invoices = $this->Invoices_Model->status_6( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			$this->Invoices_Model->status_6( $id );
		}
		$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'statuschanged' ) );
		redirect( 'invoices/index' );
	}

	function pdf( $id ) {
		$ind = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'title' ] = '' . lang( 'invoiceprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'invoiceitems' ] = $this->db->select( '*,products.productname as urun,invoiceitems.id as id ' )->join( 'products', 'invoiceitems.in[product_id] = products.id', 'left' )->get_where( 'invoiceitems', array( 'invoice_id' => $id ) )->result_array();
		$this->load->view( 'invoices/invoice_pdf', $data );
	}

	function print_( $id ) {
		$ind = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'title' ] = '' . lang( 'invoiceprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'invoiceitems' ] = $this->db->select( '*,products.productname as urun,invoiceitems.id as id ' )->join( 'products', 'invoiceitems.in[product_id] = products.id', 'left' )->get_where( 'invoiceitems', array( 'invoice_id' => $id ) )->result_array();
		$this->load->view( 'invoices/invoice_print', $data );
	}

	function download( $id ) {
		$ind = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'title' ] = '' . lang( 'invoiceprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'invoiceitems' ] = $this->db->select( '*,products.productname as urun,invoiceitems.id as id ' )->join( 'products', 'invoiceitems.in[product_id] = products.id', 'left' )->get_where( 'invoiceitems', array( 'invoice_id' => $id ) )->result_array();
		$this->load->view( 'invoices/invoice_download', $data );
	}

	function share( $id ) {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffimage,customers.company as customer,customers.namesurname as individual,customers.address as customeraddress,customers.email as customeremail,customers.type as type,invoicestatus.name as statusname, invoices.id as id ' );
		$this->db->join( 'customers', 'invoices.customer_id = customers.id', 'left' );
		$this->db->join( 'invoicestatus', 'invoices.status_id = invoicestatus.id', 'left' );
		$this->db->join( 'staff', 'invoices.staff_id = staff.id', 'left' );
		$inv = $this->db->get_where( 'invoices', array( 'invoices.id' => $id ) )->row_array();
		$data[ 'invoices' ] = $this->Invoices_Model->get_invoice_detail( $id );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		// SEND EMAIL SETTINGS
		$setconfig = $this->Settings_Model->get_settings_ciuis();
		$this->load->library( 'email' );
		$config = array();
		$config[ 'protocol' ] = 'smtp';
		$config[ 'smtp_host' ] = $setconfig[ 'smtphost' ];
		$config[ 'smtp_user' ] = $setconfig[ 'smtpusername' ];
		$config[ 'smtp_pass' ] = $setconfig[ 'smtppassoword' ];
		$config[ 'smtp_port' ] = $setconfig[ 'smtpport' ];
		$sender = $setconfig[ 'sendermail' ];
		switch ( $inv[ 'type' ] ) {
			case '0':
				$invcustomer = $inv[ 'customer' ];
				break;
			case '1':
				$invcustomer = $inv[ 'individual' ];
				break;
		}
		$data = array(
			'customer' => $invcustomer,
			'customermail' => $inv[ 'email' ],
			'invoicelink' => '' . base_url( 'share/invoice/' . $id . '' ) . ''
		);
		$body = $this->load->view( 'email/invoices/sendinvoice.php', $data, TRUE );
		$this->email->initialize( $config );
		$this->email->set_newline( "\r\n" );
		$this->email->set_mailtype( "html" );
		$this->email->from( $sender ); // change it to yours
		$this->email->to( $inv[ 'email' ] ); // change it to yours
		$this->email->subject( 'Your Invoice Details' );
		$this->email->message( $body );
		if ( $this->email->send() ) {
			$response = $this->db->where( 'id', $id )->update( 'invoices', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'invoices/invoice/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'invoices/invoice/' . $id . '' );
		}


	}

	function cancelled() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'invoice_id' => $_POST[ 'invoice_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Invoices_Model->cancelled();
		}
	}

	function remove( $id ) {
		$invoices = $this->Invoices_Model->get_invoices( $id );
		if ( isset( $invoices[ 'id' ] ) ) {
			$this->session->set_flashdata( 'ntf4', lang( 'invoicedeleted' ) );
			$this->Invoices_Model->delete_invoices( $id );
			redirect( 'invoices/index' );
		} else
			show_error( 'The invoices you are trying to delete does not exist.' );
	}

	function removeitem() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'invitemid' => $_POST[ 'invitemid' ],
			);
			$response = $this->db->delete( 'invoiceitems', array( 'id' => $_POST[ 'invitemid' ] ) );
		}
	}

}