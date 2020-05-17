<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Tickets extends CIUIS_Controller {
	public

	function index() {
		$data[ 'title' ] = lang( 'tickets' );
		$data[ 'tickets' ] = $this->Tickets_Model->get_all_tickets();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'tickets/index', $data );
	}

	function add() {
		$data[ 'title' ] = lang('addticket');
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Tickets', '../tickets' );
		$this->breadcrumb->add_crumb( 'Add Ticket' );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$config[ 'upload_path' ] = './uploads/attachments/';
			$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt';
			$this->load->library( 'upload', $config );
			$this->upload->do_upload( 'attachment' );
			$data_upload_files = $this->upload->data();
			$image_data = $this->upload->data();
			$params = array(
				'contact_id' => $this->input->post( 'contact' ),
				'customer_id' => $this->input->post( 'customer' ),
				'department_id' => $this->input->post( 'department' ),
				'priority' => $this->input->post( 'priority' ),
				'status_id' => 1,
				'subject' => $this->input->post( 'subject' ),
				'message' => $this->input->post( 'message' ),
				'attachment' => $image_data[ 'file_name' ],
				'date' => date( " Y.m.d H:i:s " ),
			);
			$this->session->set_flashdata( 'ntf1', lang('ticketadded') );
			$tickets_id = $this->Tickets_Model->add_tickets( $params );
			redirect( 'tickets/index' );
		}
	}

	function ticket( $id ) {
		$ticket = $this->Tickets_Model->get_tickets( $id );
		$data[ 'title' ] = $ticket['subject'];
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Tickets', '../tickets' );
		$this->breadcrumb->add_crumb( 'Ticket Detail' );
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$data[ 'ticket' ] = $this->Tickets_Model->get_tickets( $id );
		$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
		$this->load->view( 'tickets/ticket', $data );
	}

	function assignstaff() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'ticket_id' => $this->input->post( 'ticket' ),
				'staff_id' => $this->input->post( 'staff' ),
			);
			$staff = $this->Tickets_Model->assignstaff( $params );
			redirect( 'tickets/ticket/' . $this->input->post( 'ticket' ) . '' );
		}
	}

	function addreply() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$config[ 'upload_path' ] = './uploads/attachments/';
			$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt';
			$this->load->library( 'upload', $config );
			$this->upload->do_upload( 'attachment' );
			$data_upload_files = $this->upload->data();
			$image_data = $this->upload->data();
			$params = array(
				'ticket_id' => $this->input->post( 'ticket' ),
				'staff_id' => $this->input->post( 'staff' ),
				'contact_id' => $this->input->post( 'contact' ),
				'date' => $this->input->post( 'date' ),
				'name' => $this->input->post( 'name' ),
				'message' => $this->input->post( 'message' ),
				'attachment' => $image_data[ 'file_name' ],
			);
			// SEND EMAIL SETTINGS
			$contactinfo = $this->Contacts_Model->getUserInfo($this->input->post( 'contact' ));
			$setconfig = $this->Settings_Model->get_settings_ciuis();
			$this->load->library( 'email' );
			$config = array();
			$config[ 'protocol' ] = 'smtp';
			$config[ 'smtp_host' ] = $setconfig['smtphost'];
			$config[ 'smtp_user' ] = $setconfig['smtpusername'];
			$config[ 'smtp_pass' ] = $setconfig['smtppassoword'];
			$config[ 'smtp_port' ] = $setconfig['smtpport'];
			$sender = $setconfig['sendermail'];
			$data = array(
				'name' => $this->session->userdata('staffname'),
				'ticketlink' => '' . base_url( 'area/ticket/' . $this->input->post( 'ticket' ) . '' ) . ''
			);
			$body = $this->load->view( 'email/ticket.php', $data, TRUE );
			$this->email->initialize( $config );
			$this->email->set_newline( "\r\n" );
			$this->email->set_mailtype( "html" );
			$this->email->from( $sender ); // change it to yours
			$this->email->to( $contactinfo->email ); // change it to yours
			$this->email->subject( 'Your Ticket Replied' );
			$this->email->message( $body );
			$this->email->send();
			/////////////
			$replyid = $this->Tickets_Model->add_reply( $params );
			redirect( 'tickets/ticket/' . $this->input->post( 'ticket' ) . '' );
		}
	}
	
	function markas() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'ticket_id' => $_POST[ 'ticket_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Tickets_Model->markas();
		}
	}
		
	function remove( $id ) {
		$this->session->set_flashdata( 'ntf4', lang('ticketdeleted') );
		$tickets = $this->Tickets_Model->get_tickets( $id );
		if ( isset( $tickets[ 'id' ] ) ) {
			$this->Tickets_Model->delete_tickets( $id );
			redirect( 'tickets/index' );
		} else
			show_error( 'Eror' );
	}
}