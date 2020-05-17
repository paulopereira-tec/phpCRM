<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Leads extends CIUIS_Controller {
	function kanban() {
		$data[ 'title' ] = lang( 'leads' );
		$data[ 'tcl' ] = $this->Report_Model->tcl();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		if (!if_admin) {$data[ 'leads' ] = $this->Leads_Model->get_all_leads_for_admin();}else{$data[ 'leads' ] = $this->Leads_Model->get_all_leads();};
		$data[ 'leadssources' ] = $this->Leads_Model->get_leads_sources();
		$data[ 'leadsstatuses' ] = $this->Leads_Model->get_leads_status();
		$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
		$data[ 'countries' ] = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		$this->load->view( 'leads/kanban', $data );
	}

	function index() {
		$data[ 'title' ] = lang( 'leads' );
		$data[ 'tlh' ] = $this->db->count_all('leads');
		$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
		$data[ 'tcl' ] = $this->Report_Model->tcl();
		$data[ 'tll' ] = $this->Report_Model->tll();
		$data[ 'tjl' ] = $this->Report_Model->tjl();
		$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
		$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
		$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		if (!if_admin) {$data[ 'leads' ] = $this->Leads_Model->get_all_leads_for_admin();}else{$data[ 'leads' ] = $this->Leads_Model->get_all_leads();};
		$data[ 'leadssources' ] = $this->Leads_Model->get_leads_sources();
		$data[ 'leadsstatuses' ] = $this->Leads_Model->get_leads_status();
		$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
		$data[ 'countries' ] = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		$data[ 'leads_by_leadsource' ] = json_encode( $this->Report_Model->leads_by_leadsource_leadpage() );
		$this->load->view( 'leads/index', $data );
	}
	function lead($id) {
		$data[ 'title' ] = lang( 'lead' );
		$data[ 'tbs' ] = $this->db->count_all( 'notifications', array( 'markread' => ( '0' ) ) );
		$data[ 'tcl' ] = $this->Report_Model->tcl();
		$data[ 'tll' ] = $this->Report_Model->tll();
		$data[ 'tjl' ] = $this->Report_Model->tjl();
		$lead = $this->Leads_Model->get_lead($id);
		$data[ 'newnotification' ] = $this->Notifications_Model->newnotification();
		$data[ 'readnotification' ] = $this->Notifications_Model->readnotification();
		$data[ 'notifications' ] = $this->Notifications_Model->get_all_notifications();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		if (!if_admin) {$data[ 'leads_table' ] = $this->Leads_Model->get_all_leads_for_admin();}else{$data[ 'leads_table' ] = $this->Leads_Model->get_all_leads();};
		$data[ 'leadssources' ] = $this->Leads_Model->get_leads_sources();
		$data[ 'leadsstatuses' ] = $this->Leads_Model->get_leads_status();
		$data[ 'all_staff' ] = $this->Staff_Model->get_all_staff();
		$data[ 'countries' ] = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		$data[ 'proposals' ] = $this->db->get_where( 'proposals', array( 'relation' => $id,'relation_type' => 'lead') )->result_array();
		$data[ 'notes' ] = $this->db->select( '*,staff.staffname as notestaff,notes.id as id ' )->join( 'staff', 'notes.addedfrom = staff.id', 'left' )->get_where( 'notes', array( 'relation' => $lead['id'],'relation_type' => 'lead' ) )->result_array();
		$data[ 'reminders' ] = $this->db->select( '*,staff.staffname as reminderstaff,staff.staffavatar as staffpicture,reminders.id as id ' )->join( 'staff', 'reminders.staff_id = staff.id', 'left' )->get_where( 'reminders', array( 'relation' => $lead['id'],'relation_type' => 'lead' ) )->result_array();
		$data[ 'lead' ] = $this->Leads_Model->get_lead($id);
		$this->load->view( 'leads/lead', $data );
	}

	function convertcustomer( $id ) {
		$lead = $this->Leads_Model->get_lead( $id );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'staff_id' => $lead[ 'staff_id' ],
				'company' => $lead[ 'company' ],
				'type' => $lead[ 'type' ],
				'namesurname' => $lead[ 'company' ],
				'created' => date( 'Y-m-d H:i:s' ),
				'address' => $lead[ 'address' ],
				'zipcode' => $lead[ 'zip' ],
				'country_id' => $id,
				'state' => $lead[ 'state' ],
				'city' => $lead[ 'city' ],
				'phone' => $lead[ 'phone' ],
				'email' => $lead[ 'email' ],
				'web' => $lead[ 'website' ],
			);
			if ( $lead[ 'dateconverted' ] == NULL ) {
				$this->db->insert( 'customers', $params );
				$customer = $this->db->insert_id();
				$loggedinuserid = $this->session->logged_in_staff_id;
				$staffname = $this->session->staffname;
				$this->db->insert( 'logs', array(
					'date' => date( 'Y-m-d H:i:s' ),
					'detail' => ( '' ),
					'detail' => ( '' . $message = sprintf( lang( 'leadconvert' ), $staffname, $lead[ 'company' ] ) . '' ),
					'staff_id' => $loggedinuserid,
					'customer_id' => $customer,
				) );
				$response = $this->db->where( 'id', $id )->update( 'leads', array( 'dateconverted' => date( 'Y-m-d H:i:s' ) ) );
				$response = $this->db->where( 'relation', $id,'relation_type', 'lead' )->update( 'proposals', array( 'relation' => $customer,'relation_type' => 'customer' ) );
				redirect( 'customers/customer/' . $customer . '' );
			} else {
				$this->session->set_flashdata( 'ntf4', '' . lang( 'leadalreadyconverted' ) . '' );
				redirect( 'leads' );
			}

		}
	}

	function add() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'created' => date( 'Y-m-d H:i:s' ),
				'type' => $this->input->post( 'type' ),
				'name' => $this->input->post( 'name' ),
				'title' => $this->input->post( 'title' ),
				'company' => $this->input->post( 'company' ),
				'description' => $this->input->post( 'description' ),
				'country_id' => $this->input->post( 'country' ),
				'zip' => $this->input->post( 'zip' ),
				'city' => $this->input->post( 'city' ),
				'state' => $this->input->post( 'state' ),
				'address' => $this->input->post( 'address' ),
				'email' => $this->input->post( 'email' ),
				'website' => $this->input->post( 'website' ),
				'phone' => $this->input->post( 'phone' ),
				'assigned_id' => $this->input->post( 'assigned' ),
				'source' => $this->input->post( 'source' ),
				'public' => $this->input->post( 'public' ),
				'dateassigned' => date( 'Y-m-d H:i:s' ),
				'staff_id' => $this->session->userdata( 'logged_in_staff_id' ),
				'status' => $this->input->post( 'status' ),
			);
			$customers_id = $this->Leads_Model->add_lead( $params );
			$this->session->set_flashdata( 'ntf1', '' . lang( 'leadadded' ) . '' );
			redirect( 'leads/' );
		}
	}

	function update( $id ) {
		$data[ 'lead' ] = $this->Leads_Model->get_lead( $id );
		if ( isset( $data[ 'lead' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'created' => date( 'Y-m-d H:i:s' ),
					'type' => $this->input->post( 'type' ),
					'name' => $this->input->post( 'name' ),
					'title' => $this->input->post( 'title' ),
					'company' => $this->input->post( 'company' ),
					'description' => $this->input->post( 'description' ),
					'country_id' => $this->input->post( 'country' ),
					'zip' => $this->input->post( 'zip' ),
					'city' => $this->input->post( 'city' ),
					'state' => $this->input->post( 'state' ),
					'address' => $this->input->post( 'address' ),
					'email' => $this->input->post( 'email' ),
					'website' => $this->input->post( 'website' ),
					'phone' => $this->input->post( 'phone' ),
					'assigned_id' => $this->input->post( 'assigned' ),
					'junk' => $this->input->post( 'junk' ),
					'lost' => $this->input->post( 'lost' ),
					'source' => $this->input->post( 'source' ),
					'public' => $this->input->post( 'public' ),
					'dateassigned' => date( 'Y-m-d H:i:s' ),
					'staff_id' => $this->session->userdata( 'logged_in_staff_id' ),
					'status' => $this->input->post( 'status' ),
				);
				$this->Leads_Model->update_lead( $id, $params );
				redirect( 'leads/lead/'.$id.'' );
			} else {
				redirect( 'leads/index' );
			}
		} else
			show_error( 'The expensecategory you are trying to edit does not exist.' );
	}

	function add_status() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'color' => $this->input->post( 'color' ),
			);
			$status = $this->Leads_Model->add_status( $params );
			redirect( 'leads/index' );
		} else {
			redirect( 'leads/index' );
		}
	}

	function add_source() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
			);
			$source = $this->Leads_Model->add_source( $params );
			redirect( 'leads/index' );
		} else {
			redirect( 'leads/index' );
		}
	}

	function update_status( $id ) {
		$data[ 'statuses' ] = $this->Leads_Model->get_status( $id );
		if ( isset( $data[ 'statuses' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
					'color' => $this->input->post( 'color' ),
				);
				$this->Leads_Model->update_status( $id, $params );
				redirect( 'leads/index' );
			} else {
				redirect( 'leads/index' );
			}
		} else
			show_error( 'The expensecategory you are trying to edit does not exist.' );
	}

	function update_source( $id ) {
		$data[ 'sources' ] = $this->Leads_Model->get_source( $id );
		if ( isset( $data[ 'sources' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
				);
				$this->Leads_Model->update_source( $id, $params );
				redirect( 'leads/index' );
			} else {
				redirect( 'leads/index' );
			}
		} else
			show_error( 'The expensecategory you are trying to edit does not exist.' );
	}

	function remove( $id ) {
		$lead = $this->Leads_Model->get_lead( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $lead[ 'id' ] ) ) {
			$this->Leads_Model->delete_lead( $id );
			redirect( 'leads/index' );
		} else
			show_error( 'The expenses you are trying to delete does not exist.' );
	}

	function removestatus( $id ) {
		$lead = $this->Leads_Model->get_status( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $lead[ 'id' ] ) ) {
			$this->Leads_Model->delete_status( $id );
			redirect( 'leads/index' );
		} else
			show_error( 'The expenses you are trying to delete does not exist.' );
	}

	function removesource( $id ) {
		$lead = $this->Leads_Model->get_source( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $lead[ 'id' ] ) ) {
			$this->Leads_Model->delete_source( $id );
			redirect( 'leads/index' );
		} else
			show_error( 'The expenses you are trying to delete does not exist.' );
	}

	function movelead() {
		$this->Leads_Model->movelead();
	}

	function addnote() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'description' => $this->input->post( 'description' ),
				'relation' => $this->input->post( 'leadid' ),
				'relation_type' => 'lead',
				'addedfrom' => $this->session->userdata( 'logged_in_staff_id' ),
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$notes = $this->Trivia_Model->add_note( $params );
			redirect( 'leads/lead/'.$this->input->post( 'leadid' ).'' );
		} else {
			redirect( 'leads/index' );
		}
	}
	function addreminder() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'description' => $this->input->post( 'description' ),
				'relation' => $this->input->post( 'relation' ),
				'relation_type' => 'lead',
				'staff_id' => $this->input->post( 'staff' ),
				'addedfrom' => $this->session->userdata( 'logged_in_staff_id' ),
				'date' => $this->input->post( 'date' ),
			);
			$notes = $this->Trivia_Model->add_reminder( $params );
			$this->session->set_flashdata( 'ntf1', ''.lang('reminderadded').'' );
			redirect( 'leads/lead/'.$this->input->post( 'relation' ).'' );
		} else {
			redirect( 'leads/index' );
		}
	}
	function removereminder( $id ) {
		$reminder = $this->Trivia_Model->get_reminder( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $reminder[ 'id' ] ) ) {
			$this->Trivia_Model->delete_reminder( $id );
			redirect( 'leads/index' );
		} else
			show_error( 'The reminder you are trying to delete does not exist.' );
	}
	function importcsv() {
		$this->load->library( 'csvimport' );
		$data[ 'leads' ] = $this->Leads_Model->get_leads_for_import();
		$data[ 'error' ] = ''; //initialize image upload error array to empty
		$config[ 'upload_path' ] = './uploads/imports/';
		$config[ 'allowed_types' ] = 'csv';
		$config[ 'max_size' ] = '1000';
		$this->load->library( 'upload', $config );
		// If upload failed, display error
		if ( !$this->upload->do_upload() ) {
			$data[ 'error' ] = $this->upload->display_errors();
			$this->session->set_flashdata( 'ntf1', 'Csv Data not Imported' );
			redirect( 'leads/index' );
		} else {
			$file_data = $this->upload->data();
			$file_path = './uploads/imports/' . $file_data[ 'file_name' ];
			if ( $this->csvimport->get_array( $file_path ) ) {
				$csv_array = $this->csvimport->get_array( $file_path );
				foreach ( $csv_array as $row ) {
					$insert_data = array(
						'created' => date( 'Y-m-d H:i:s' ),
						'type' => $row[ 'type' ],
						'name' => $row[ 'name' ],
						'title' => $row[ 'title' ],
						'company' => $row[ 'company' ],
						'description' =>$row[ 'description' ],
						'zip' => $row[ 'zip' ],
						'city' => $row[ 'city' ],
						'state' => $row[ 'state' ],
						'address' => $row[ 'address' ],
						'email' => $row[ 'email' ],
						'website' => $row[ 'website' ],
						'phone' => $row[ 'phone' ],
						'assigned_id' => $this->input->post( 'importassigned' ),
						'source' => $this->input->post( 'importsource' ),
						'dateassigned' => date( 'Y-m-d H:i:s' ),
						'staff' => $this->session->userdata( 'logged_in_staff_id' ),
						'status' => $this->input->post( 'importstatus' ),
					);
					$this->Leads_Model->insert_csv( $insert_data );
				}
				$this->session->set_flashdata( 'ntf3', 'Csv Data Imported Succesfully' );
				redirect( 'leads/index' );
				//echo "<pre>"; print_r($insert_data);
			} else
				redirect( 'leads/index' );
			$this->session->set_flashdata( 'ntf3', 'Error' );
		}
	}
	function markas_lost() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'leadid' => $_POST[ 'lead_id' ],
			);
			$response = $this->db->where( 'id', $_POST[ 'lead_id' ] )->update( 'leads', array( 'lost' => 1 ) );
		}
	}
	function markas_junk() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'leadid' => $_POST[ 'lead_id' ],
			);
			$response = $this->db->where( 'id', $_POST[ 'lead_id' ] )->update( 'leads', array( 'junk' => 1 ) );
		}
	}
	function unmarkas_lost() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'leadid' => $_POST[ 'lead_id' ],
			);
			$response = $this->db->where( 'id', $_POST[ 'lead_id' ] )->update( 'leads', array( 'lost' => 0 ) );
		}
	}
	function unmarkas_junk() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'leadid' => $_POST[ 'lead_id' ],
			);
			$response = $this->db->where( 'id', $_POST[ 'lead_id' ] )->update( 'leads', array( 'junk' => 0 ) );
		}
	}


	function removenote( $id ) {
		$note = $this->Trivia_Model->get_note( $id );
		// check if the expenses exists before trying to delete it
		if ( isset( $note[ 'id' ] ) ) {
			$this->Trivia_Model->delete_note( $id );
			redirect( 'leads/index' );
		} else
			show_error( 'The expenses you are trying to delete does not exist.' );
	}
}