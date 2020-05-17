<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Proposals extends CIUIS_Controller {

	function index() {
		$data[ 'title' ] = lang( 'proposals' );
		$this->load->library( 'breadcrumb' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Proposals', 'proposals' );
		$this->breadcrumb->add_crumb( 'All Proposals' );
		$data[ 'proposals' ] = $this->Proposals_Model->get_all_proposals();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'proposals/index', $data );
	}

	function add() {
		$data[ 'title' ] = lang( 'createproposal' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Proposals', '../proposals' );
		$this->breadcrumb->add_crumb( 'New Proposal' );
		$data[ 'fu' ] = $this->db->get_where( 'proposalitems' )->result_array();
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
			if ( $this->input->post( 'relation_type' ) == 'customer' ) {
				$relation = $this->input->post( 'related_customer' );
			} else {
				$relation = $this->input->post( 'related_lead' );
			};
			$params = array(
				'subject' => $this->input->post( 'subject' ),
				'content' => $this->input->post( 'content' ),
				'date' => _pdate( $this->input->post( 'date' ) ),
				'created' => _pdate( $this->input->post( 'created' ) ),
				'opentill' => _pdate( $this->input->post( 'opentill' ) ),
				'relation_type' => $this->input->post( 'relation_type' ),
				'relation' => $relation,
				'assigned' => $this->input->post( 'assigned' ),
				'addedfrom' => $this->input->post( 'addedfrom' ),
				'datesend' => _pdate( $this->input->post( 'datesend' ) ),
				'comment' => $this->input->post( 'comment' ),
				'status_id' => $this->input->post( 'status' ),
				'invoice_id' => $this->input->post( 'invoice' ),
				'dateconverted' => $this->input->post( 'dateconverted' ),
				'total_sub' => $this->input->post( 'total_sub' ),
				'total_discount' => $this->input->post( 'total_discount' ),
				'sub_discount' => $this->input->post( 'sub_discount' ),
				'sub_discount_type' => $this->input->post( 'sub_discount_type' ),
				'total_sub_discount' => $this->input->post( 'total_sub_discount' ),
				'sub_discount_status' => $this->input->post( 'sub_discount_status' ),
				'total_vat' => $this->input->post( 'total_vat' ),
				'total' => $this->input->post( 'total' ),
			);
			$proposals_id = $this->Proposals_Model->proposal_add( $params );
			redirect( 'proposals/index' );
		} else {
			$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
			$data[ 'all_accounts' ] = $this->Accounts_Model->get_all_accounts();
			$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
			$data[ 'all_leads' ] = $this->Leads_Model->get_all_leads();
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$this->load->view( 'proposals/add', $data );
		}
	}
	public

	function get_json_items() {
		$area_id = $this->input->post( 'area' );
		$urunfiyat = $this->Products_Model->get_all_products();
		echo json_encode( $urunfiyat );
	}

	function edit( $id ) {
		$data[ 'title' ] = lang( 'updateproposaltitle' );
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposalitems' ] = $this->db->select( '*,products.productname as name,proposalitems.id as id ' )->join( 'products', 'proposalitems.in[product_id] = products.id', 'left' )->get_where( 'proposalitems', array( 'proposal_id' => $id ) )->result_array();
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
		if ( isset( $pro[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				if ( $this->input->post( 'relation_type' ) == 'customer' ) {
					$relation = $this->input->post( 'related_customer' );
				} else {
					$relation = $this->input->post( 'related_lead' );
				};
				$params = array(
					'subject' => $this->input->post( 'subject' ),
					'content' => $this->input->post( 'content' ),
					'date' => _pdate( $this->input->post( 'date' ) ),
					'created' => _pdate( $this->input->post( 'created' ) ),
					'opentill' => _pdate( $this->input->post( 'opentill' ) ),
					'relation_type' => $this->input->post( 'relation_type' ),
					'relation' => $relation,
					'assigned' => $this->input->post( 'assigned' ),
					'addedfrom' => $this->input->post( 'addedfrom' ),
					'datesend' => _pdate( $this->input->post( 'datesend' ) ),
					'comment' => $this->input->post( 'comment' ),
					'status_id' => $this->input->post( 'status' ),
					'invoice_id' => $this->input->post( 'invoice' ),
					'dateconverted' => $this->input->post( 'dateconverted' ),
					'total_sub' => $this->input->post( 'total_sub' ),
					'total_discount' => $this->input->post( 'total_discount' ),
					'sub_discount' => $this->input->post( 'sub_discount' ),
					'sub_discount_type' => $this->input->post( 'sub_discount_type' ),
					'total_sub_discount' => $this->input->post( 'total_sub_discount' ),
					'sub_discount_status' => $this->input->post( 'sub_discount_status' ),
					'total_vat' => $this->input->post( 'total_vat' ),
					'total' => $this->input->post( 'total' ),
				);
				$this->session->set_flashdata( 'ntf1', 'Proposal ' . $id . ' Updated!' );
				$this->Proposals_Model->update_proposals( $id, $params );
				redirect( 'proposals/edit/' . $id . '' );
			} else {
				$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
				$data[ 'accounts' ] = $this->Accounts_Model->get_all_accounts();
				$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
				$data[ 'all_accounts' ] = $this->Accounts_Model->get_all_accounts();
				$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
				$data[ 'all_leads' ] = $this->Leads_Model->get_all_leads();
				$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
				$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
				$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
				$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
				$data[ 'events' ] = $this->Events_Model->get_all_events();
				$data[ 'todaypayments' ] = $this->Payments_Model->todaypayments();
				$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
				$this->load->view( 'proposals/edit', $data );
			}
		} else
			$this->session->set_flashdata( 'ntf3', '' . $id . lang( 'proposalediterror' ) );
	}

	//function updateproposalitemsingle() {
	//	$this->Proposals_Model->updateproposalitemsingleinline( $column, $lastvalue, $id );
	//}

	function proposal( $id ) {
		$data[ 'title' ] = lang( 'proposal' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Proposals', 'proposals' );
		$this->breadcrumb->add_crumb( 'Proposal Detayı' );
		$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
		$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
		$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
		$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
		$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
		$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
		$data[ 'events' ] = $this->Events_Model->get_all_events();
		$data[ 'todaypayments' ] = $this->Payments_Model->todaypayments();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'accounts' ] = $this->Accounts_Model->get_all_accounts();
		$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
		$data[ 'notes' ] = $this->db->select( '*,staff.staffname as notestaff,notes.id as id ' )->join( 'staff', 'notes.addedfrom = staff.id', 'left' )->get_where( 'notes', array( 'relation' => $id, 'relation_type' => 'proposal' ) )->result_array();
		$data[ 'comments' ] = $this->db->get_where( 'comments', array( 'relation' => $id, 'relation_type' => 'proposal' ) )->result_array();
		$data[ 'reminders' ] = $this->db->select( '*,staff.staffname as reminderstaff,staff.staffavatar as staffpicture,reminders.id as id ' )->join( 'staff', 'reminders.staff_id = staff.id', 'left' )->get_where( 'reminders', array( 'relation' => $id, 'relation_type' => 'proposal' ) )->result_array();
		$data[ 'proposalitems' ] = $this->db->select( '*,products.productname as name,proposalitems.id as id ' )->join( 'products', 'proposalitems.in[product_id] = products.id', 'left' )->get_where( 'proposalitems', array( 'proposal_id' => $id ) )->result_array();
		$data[ 'fatop' ] = $this->Proposals_Model->get_proposal_productsi_art( $id );
		$this->load->view( 'proposals/proposal', $data );
	}

	function pdf( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'title' ] = '' . lang( 'proposalprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'proposalitems' ] = $this->db->select( '*,products.productname as urun,proposalitems.id as id ' )->join( 'products', 'proposalitems.in[product_id] = products.id', 'left' )->get_where( 'proposalitems', array( 'proposal_id' => $id ) )->result_array();
		$this->load->view( 'proposals/proposal_pdf', $data );
	}

	function print_( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'title' ] = '' . lang( 'proposalprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'proposalitems' ] = $this->db->select( '*,products.productname as urun,proposalitems.id as id ' )->join( 'products', 'proposalitems.in[product_id] = products.id', 'left' )->get_where( 'proposalitems', array( 'proposal_id' => $id ) )->result_array();
		$this->load->view( 'proposals/proposal_print', $data );
	}

	function download( $id ) {
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'title' ] = '' . lang( 'proposalprefix' ) . '-' . str_pad( $id, 6, '0', STR_PAD_LEFT ) . '';
		$this->load->library( 'Pdf' );
		$obj_pdf = new TCPDF( 'I', PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'proposalitems' ] = $this->db->select( '*,products.productname as urun,proposalitems.id as id ' )->join( 'products', 'proposalitems.in[product_id] = products.id', 'left' )->get_where( 'proposalitems', array( 'proposal_id' => $id ) )->result_array();
		$this->load->view( 'proposals/proposal_download', $data );
	}

	function share( $id ) {
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
		//
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $rel_type == 'customer' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			switch ( $proposal[ 'type' ] ) {
				case '0':
					$proposalto = $proposal[ 'customer' ];
					break;
				case '1':
					$proposalto = $proposal[ 'individual' ];
					break;
			}
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		if ( $rel_type == 'lead' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$proposalto = $proposal[ 'leadname' ];
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		//
		$data = array(
			'customer' => $proposalto,
			'customermail' => $proposaltoemail,
			'proposallink' => '' . base_url( 'share/proposal/' . $id . '' ) . ''
		);
		$body = $this->load->view( 'email/proposals/sendproposal.php', $data, TRUE );
		$this->email->initialize( $config );
		$this->email->set_newline( "\r\n" );
		$this->email->set_mailtype( "html" );
		$this->email->from( $sender ); // change it to yours
		$this->email->to( $proposaltoemail ); // change it to yours
		$this->email->subject( 'New Proposal' );
		$this->email->message( $body );
		if ( $this->email->send() ) {
			$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		}


	}

	function expiration( $id ) {
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
		//
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		if ( $rel_type == 'customer' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			switch ( $proposal[ 'type' ] ) {
				case '0':
					$proposalto = $proposal[ 'customercompany' ];
					break;
				case '1':
					$proposalto = $proposal[ 'individual' ];
					break;
			}
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		if ( $rel_type == 'lead' ) {
			$proposal = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
			$proposalto = $proposal[ 'leadname' ];
			$proposaltoemail = $proposal[ 'toemail' ];
		}
		//
		$data = array(
			'customer' => $proposalto,
			'customermail' => $proposaltoemail,
			'proposallink' => '' . base_url( 'share/proposal/' . $id . '' ) . ''
		);
		$body = $this->load->view( 'email/proposals/expirationreminder.php', $data, TRUE );
		$this->email->initialize( $config );
		$this->email->set_newline( "\r\n" );
		$this->email->set_mailtype( "html" );
		$this->email->from( $sender ); // change it to yours
		$this->email->to( $proposaltoemail ); // change it to yours
		$this->email->subject( 'Proposal Expiry Reminder' );
		$this->email->message( $body );
		if ( $this->email->send() ) {
			$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'datesend' => date( 'Y-m-d H:i:s' ) ) );
			$this->session->set_flashdata( 'ntf1', '<b>' . lang( 'sendmailcustomer' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		} else {
			$this->session->set_flashdata( 'ntf4', '<b>' . lang( 'sendmailcustomereror' ) . '</b>' );
			redirect( 'proposals/proposal/' . $id . '' );
		}


	}

	function convertinvoice( $id ) {
		$data[ 'title' ] = lang( 'convertproposaltoinvoice' );
		$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
		$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
		$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
		$pro = $this->Proposals_Model->get_pro_rel_type( $id );
		$rel_type = $pro[ 'relation_type' ];
		$data[ 'proposals' ] = $this->Proposals_Model->get_proposals( $id, $rel_type );
		$data[ 'fu' ] = $this->db->get_where( 'invoiceitems' )->result_array();
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
				'proposal_id' => $id,
				'total_sub' => $this->input->post( 'total_sub' ),
				'total_discount' => $this->input->post( 'total_discount' ),
				'sub_discount' => $this->input->post( 'sub_discount' ),
				'sub_discount_type' => $this->input->post( 'sub_discount_type' ),
				'total_sub_discount' => $this->input->post( 'total_sub_discount' ),
				'sub_discount_status' => $this->input->post( 'sub_discount_status' ),
				'total_vat' => $this->input->post( 'total_vat' ),
				'total' => $this->input->post( 'total' ),
			);
			$invoices_id = $this->Invoices_Model->invoice_add( $params );
			$invoice = $this->db->insert_id();
			$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'invoice_id' => $invoice, 'status_id' => 6, 'dateconverted' => date( 'Y-m-d H:i:s' ) ) );
			redirect( 'invoices/invoice/' . $invoice . '' );
		} else {
			$data[ 'proposalitems' ] = $this->db->select( '*,products.productname as name,proposalitems.id as id ' )->join( 'products', 'proposalitems.in[product_id] = products.id', 'left' )->get_where( 'proposalitems', array( 'proposal_id' => $id ) )->result_array();
			$data[ 'products' ] = $this->Products_Model->get_all_products();
			$data[ 'all_customers' ] = $this->Customers_Model->get_all_customers();
			$data[ 'all_accounts' ] = $this->Accounts_Model->get_all_accounts();
			$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
			$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
			$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
			$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
			$data[ 'events' ] = $this->Events_Model->get_all_events();
			$data[ 'overdueinvoices' ] = $this->Invoices_Model->overdueinvoices();
			$data[ 'todaypayments' ] = $this->Payments_Model->todaypayments();
			$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
			$data[ 'logs' ] = $this->Logs_Model->panel_last_logs();
			$this->load->view( 'proposals/convert_invoice', $data );
		}
	}

	function markas() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'proposal_id' => $_POST[ 'proposal_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Proposals_Model->markas();
		}
	}

	function cancelled() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'proposal' => $_POST[ 'proposal_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Proposals_Model->cancelled();
		}
	}

	function addreminder() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'description' => $this->input->post( 'description' ),
				'relation' => $this->input->post( 'relation' ),
				'relation_type' => 'proposal',
				'staff_id' => $this->input->post( 'staff' ),
				'addedfrom' => $this->session->userdata( 'logged_in_staff_id' ),
				'date' => $this->input->post( 'date' ),
			);
			$notes = $this->Trivia_Model->add_reminder( $params );
			$this->session->set_flashdata( 'ntf1', '' . lang( 'reminderadded' ) . '' );
			redirect( 'proposals/proposal/' . $this->input->post( 'relation' ) . '' );
		} else {
			redirect( 'proposals/index' );
		}
	}

	function remove( $id ) {
		$proposals = $this->Proposals_Model->get_pro_rel_type( $id );
		if ( isset( $proposals[ 'id' ] ) ) {
			$this->session->set_flashdata( 'ntf4', lang( 'proposaldeleted' ) );
			$this->Proposals_Model->delete_proposals( $id );
			redirect( 'proposals/index' );
		} else
			show_error( 'The proposals you are trying to delete does not exist.' );
	}
}