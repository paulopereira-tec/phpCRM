<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Customers extends CIUIS_Controller {

	function index() {
		$data[ 'title' ] = lang( 'customers' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Customers', 'customers' );
		$this->breadcrumb->add_crumb( 'Tüm Customers' );
		$data[ 'customers' ] = $this->Customers_Model->get_all_customers();
		// Notification Data //
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'customersjson' ] = json_encode( $this->Customers_Model->search_json_customer() );
		$this->load->view( 'customers/index', $data );
	}

	/* ADD NEW CUSTOMER */

	function add() {
		$data[ 'title' ] = lang( 'addcustomer' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Customers', '../customers' );
		$this->breadcrumb->add_crumb( 'Firma Add' );
		$data[ 'countries' ] = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'created' => date( 'Y-m-d H:i:s' ),
				'type' => $this->input->post( 'type' ),
				'company' => $this->input->post( 'company' ),
				'namesurname' => $this->input->post( 'namesurname' ),
				'ssn' => $this->input->post( 'ssn' ),
				'executive' => $this->input->post( 'executive' ),
				'address' => $this->input->post( 'address' ),
				'phone' => $this->input->post( 'phone' ),
				'email' => $this->input->post( 'email' ),
				'fax' => $this->input->post( 'fax' ),
				'web' => $this->input->post( 'web' ),
				'taxoffice' => $this->input->post( 'taxoffice' ),
				'taxnumber' => $this->input->post( 'taxnumber' ),
				'country_id' => $this->input->post( 'country_id' ),
				'state' => $this->input->post( 'state' ),
				'city' => $this->input->post( 'city' ),
				'town' => $this->input->post( 'town' ),
				'zipcode' => $this->input->post( 'zipcode' ),
				'staff_id' => $this->session->userdata( 'logged_in_staff_id' ),
				'status_id' => $this->input->post( 'status' ),
			);
			$customers_id = $this->Customers_Model->add_customers( $params );
			$this->session->set_flashdata( 'ntf1', '' . lang( 'customeradded' ) . '' );
			redirect( 'customers/index' );
		}
	}

	/* UPDATE CUSTOMER INFORMATIONS */

	function customer( $id ) {
		$data[ 'title' ] = lang( 'customer' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Customers', '../customers' );
		$this->breadcrumb->add_crumb( 'Firma Detayı' );
		$customers = $this->Customers_Model->get_customers( $id );
		$data[ 'invoices' ] = $this->db->get_where( 'invoices', array( 'customer_id' => $id ) )->result_array();
		$data[ 'proposals' ] = $this->db->get_where( 'proposals', array( 'relation' => $id, 'relation_type' => 'customer' ) )->result_array();
		$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
		$data[ 'reminders' ] = $this->db->select( '*,staff.staffname as reminderstaff,staff.staffavatar as staffpicture,reminders.id as id ' )->join( 'staff', 'reminders.staff_id = staff.id', 'left' )->get_where( 'reminders', array( 'relation' => $customers[ 'id' ], 'relation_type' => 'customer' ) )->result_array();
		$data[ 'sales' ] = $this->db->get_where( 'sales', array( 'customer_id' => $id ) )->result_array();
		$data[ 'payments' ] = $this->db->get_where( 'payments', array( 'customer_id' => $id, 'transactiontype' => 0 ) )->result_array();
		$data[ 'tickets' ] = $this->db->get_where( 'tickets', array( 'customer_id' => $id ) )->result_array();
		$data[ 'countries' ] = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		if ( isset( $customers[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'type' => $this->input->post( 'type' ),
					'company' => $this->input->post( 'company' ),
					'namesurname' => $this->input->post( 'namesurname' ),
					'ssn' => $this->input->post( 'ssn' ),
					'executive' => $this->input->post( 'executive' ),
					'address' => $this->input->post( 'address' ),
					'phone' => $this->input->post( 'phone' ),
					'email' => $this->input->post( 'email' ),
					'fax' => $this->input->post( 'fax' ),
					'web' => $this->input->post( 'web' ),
					'taxoffice' => $this->input->post( 'taxoffice' ),
					'taxnumber' => $this->input->post( 'taxnumber' ),
					'country_id' => $this->input->post( 'country_id' ),
					'state' => $this->input->post( 'state' ),
					'city' => $this->input->post( 'city' ),
					'town' => $this->input->post( 'town' ),
					'zipcode' => $this->input->post( 'zipcode' ),
					'staff_id' => $this->session->userdata( 'logged_in_staff_id' ),
					'risk' => $this->input->post( 'risk' ),
					'status_id' => $this->input->post( 'status' ),
				);
				$this->session->set_flashdata( 'ntf3', '<span class="text-black"><b>' . lang( 'customerupdated' ) . '</b></span>' );
				$this->Customers_Model->update_customers( $id, $params );
				redirect( 'customers/customer/' . $id . '' );
			} else {
				$data[ 'customers' ] = $this->Customers_Model->get_customers( $id );
				$data[ 'customer_annual_sales_chart' ] = $this->Customers_Model->customer_annual_sales_chart( $id );
				$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
				$this->load->view( 'customers/customer', $data );
			}
		} else
			show_error( 'Eror' );
	}

	function contactadd() {
		if ( $this->Contacts_Model->isDuplicate( $this->input->post( 'email' ) ) ) {
			$this->session->set_flashdata( 'ntf4', 'Contact email already exists' );
			redirect( 'customers/customer/' . $this->input->post( 'customer' ) . '' );
		} else {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
					'surname' => $this->input->post( 'surname' ),
					'phone' => $this->input->post( 'phone' ),
					'intercom' => $this->input->post( 'intercom' ),
					'mobile' => $this->input->post( 'mobile' ),
					'email' => $this->input->post( 'email' ),
					'address' => $this->input->post( 'address' ),
					'skype' => $this->input->post( 'skype' ),
					'linkedin' => $this->input->post( 'linkedin' ),
					'customer_id' => $this->input->post( 'customer' ),
					'position' => $this->input->post( 'position' ),
					'primary' => $this->input->post( 'primary' ),
					'password' => password_hash( $this->input->post( 'password' ), PASSWORD_BCRYPT ),
				);
				$contacts_id = $this->Contacts_Model->contactadd( $params );
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
				$data = array(
					'name' => $this->session->userdata( 'staffname' ),
					'password' => $this->input->post( 'password' ),
					'email' => $this->input->post( 'email' ),
					'loginlink' => '' . base_url( 'customer/login' ) . ''
				);
				$body = $this->load->view( 'email/accountinfo.php', $data, TRUE );
				$this->email->initialize( $config );
				$this->email->set_newline( "\r\n" );
				$this->email->set_mailtype( "html" );
				$this->email->from( $sender ); // change it to yours
				$this->email->to( $this->input->post( 'email' ) ); // change it to yours
				$this->email->subject( 'Your Login Informations' );
				$this->email->message( $body );
				if ( $this->email->send() ) {
					$this->session->set_flashdata( 'ntf1', '' . $message = sprintf( lang( 'addedcontacts' ), $this->input->post( 'name' ) ) . '' );
					redirect( 'customers/customer/' . $this->input->post( 'customer' ) . '' );
				} else {

					$this->session->set_flashdata( 'ntf3', '' . $message = sprintf( lang( 'addedcontactsbut' ), $this->input->post( 'name' ) ) . '' );
					redirect( 'customers/customer/' . $this->input->post( 'customer' ) . '' );
				}

			}
		}
	}

	function updatecontact( $id ) {
		$contacts = $this->Contacts_Model->get_contacts( $id );
		if ( isset( $contacts[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
					'surname' => $this->input->post( 'surname' ),
					'phone' => $this->input->post( 'phone' ),
					'intercom' => $this->input->post( 'intercom' ),
					'mobile' => $this->input->post( 'mobile' ),
					'email' => $this->input->post( 'email' ),
					'address' => $this->input->post( 'address' ),
					'skype' => $this->input->post( 'skype' ),
					'linkedin' => $this->input->post( 'linkedin' ),
					'position' => $this->input->post( 'position' ),
				);

				$this->Contacts_Model->update_contacts( $id, $params );
				return $this->session->set_flashdata( 'ntf1', ' (' . $this->input->post( 'name' ) . ') ' . lang( 'contactupdated' ) . '' );
			} else {
				$data[ 'contacts' ] = $this->Contacts_Model->get_contacts( $id );
			}
		} else
			show_error( 'The contacts you are trying to edit does not exist.' );
	}

	function changecontactpassword( $id ) {
		$contacts = $this->Contacts_Model->get_contacts( $id );
		if ( isset( $contacts[ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'password' => password_hash( $this->input->post( 'contactnewpassword' ), PASSWORD_BCRYPT ),
				);
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
				$data = array(
					'name' => $this->session->userdata( 'staffname' ),
					'password' => $this->input->post( 'contactnewpassword' ),
					'email' => $contacts[ 'email' ],
					'loginlink' => '' . base_url( 'customer/login' ) . ''
				);
				$body = $this->load->view( 'email/passwordchanged.php', $data, TRUE );
				$this->email->initialize( $config );
				$this->email->set_newline( "\r\n" );
				$this->email->set_mailtype( "html" );
				$this->email->from( $sender ); // change it to yours
				$this->email->to( $contacts[ 'email' ] ); // change it to yours
				$this->email->subject( 'Your Password Changed' );
				$this->email->message( $body );
				$this->email->send();
				/////////////
				//LOG
				$customer = $contacts[ 'customer_id' ];
				$staffname = $this->session->staffname;
				$contactname = $contacts[ 'name' ];
				$contactsurname = $contacts[ 'surname' ];
				$loggedinuserid = $this->session->logged_in_staff_id;
				$this->db->insert( 'logs', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' . $message = sprintf( lang( 'changedpassword' ), $staffname, $contactname, $contactsurname ) . '' ),
					'staff_id' => $loggedinuserid,
					'customer_id' => $customer,
				) );
				$this->Contacts_Model->update_contacts( $id, $params );
				return $this->session->set_flashdata( 'ntf1', ' ' . $contacts[ 'name' ] . ' ' . lang( 'passwordchanged' ) . '' );
			} else {
				$data[ 'contacts' ] = $this->Contacts_Model->get_contacts( $id );
			}
		} else
			show_error( 'The contacts you are trying to edit does not exist.' );
	}

	function addreminder() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'description' => $this->input->post( 'description' ),
				'relation' => $this->input->post( 'relation' ),
				'relation_type' => 'customer',
				'staff_id' => $this->input->post( 'staff' ),
				'addedfrom' => $this->session->userdata( 'logged_in_staff_id' ),
				'date' => $this->input->post( 'date' ),
			);
			$notes = $this->Trivia_Model->add_reminder( $params );
			$this->session->set_flashdata( 'ntf1', '' . lang( 'reminderadded' ) . '' );
			redirect( 'customers/customer/' . $this->input->post( 'relation' ) . '' );
		} else {
			redirect( 'leads/index' );
		}
	}

	// DELETE CUSTOMER

	function remove( $id ) {
		$customers = $this->Customers_Model->get_customers( $id );
		if ( isset( $customers[ 'id' ] ) ) {
			$this->Customers_Model->delete_customers( $id );
			redirect( 'customers/index' );
		} else
			show_error( 'Customer not deleted' );
	}

	function customers_json() {
		$customers = $this->Customers_Model->get_all_customers();
		header( 'Content-Type: application/json' );
		echo json_encode( $customers );
	}

	function customers_arama_json() {
		$veriler = $this->Customers_Model->search_json_customer();
		echo json_encode( $veriler );

	}
}