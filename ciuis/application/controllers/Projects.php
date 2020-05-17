<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Projects extends CIUIS_Controller {
	function index() {
		$data[ 'title' ] = lang( 'projects' );
		$this->load->library( 'breadcrumb' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( lang( 'menu_panel' ), 'panel' );
		$this->breadcrumb->add_crumb( 'projects', 'projects' );
		$this->breadcrumb->add_crumb( 'All Projects' );
		$data[ 'projects' ] = $this->Projects_Model->get_all_projects();
		$this->load->view( 'projects/index', $data );
	}

	function project( $id ) {
		$project = $this->Projects_Model->get_projects( $id );
		$data[ 'title' ] = $project[ 'name' ];
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Proposals', 'proposals' );
		$this->breadcrumb->add_crumb( 'Proposal Detayı' );
		$data[ 'projects' ] = $this->Projects_Model->get_projects( $id );
		$this->load->view( 'projects/project', $data );
	}

	function create() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $_POST[ 'name' ],
				'description' => $_POST[ 'description' ],
				'customer_id' => $_POST[ 'customer' ],
				'start_date' => _pdate( $_POST[ 'start' ] ),
				'deadline' => _pdate( $_POST[ 'deadline' ] ),
				'staff_id' => $this->session->userdata( 'logged_in_staff_id' ),
				'status_id' => 1,
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$this->db->insert( 'projects', $params );
			$data[ 'insert_id' ] = $this->db->insert_id();;
			$loggedinuserid = $this->session->logged_in_staff_id;
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . ' created new project' ),
				'staff_id' => $loggedinuserid,
				'project_id' => $data[ 'insert_id' ],
			) );
			return json_encode( $data );
		}
	}

	function update( $id ) {
		$data[ 'project' ] = $this->Projects_Model->get_projects( $id );
		if ( isset( $data[ 'project' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'pname' ),
					'description' => $this->input->post( 'description' ),
					'customer_id' => $this->input->post( 'pcustomer' ),
					'start_date' => _pdate( $this->input->post( 'startdate' ) ),
					'deadline' => _pdate( $this->input->post( 'deadline' ) ),
				);
				$this->Projects_Model->update( $id, $params );
				redirect( 'projects/project/' . $id . '' );
			} else {
				$this->load->view( 'projects/index', $data );
			}
		} else
			show_error( 'The task you are trying to edit does not exist.' );
	}

	function markas() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'project_id' => $_POST[ 'project_id' ],
				'status_id' => $_POST[ 'status_id' ],
			);
			$tickets = $this->Projects_Model->markas();
		}
	}

	function addmilestone( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'project_id' => $id,
				'name' => $this->input->post( 'name' ),
				'order' => $this->input->post( 'order' ),
				'duedate' => _phdate( $this->input->post( 'duedate' ) ),
				'description' => $this->input->post( 'description' ),
				'created' => date( 'Y-m-d' ),
				'color' => 'green',
			);
			$response = $this->Projects_Model->add_milestone( $id, $params );
		}
	}

	function updatemilestone( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'order' => $this->input->post( 'order' ),
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
				'duedate' => $this->input->post( 'duedate' ),
			);
			$this->Projects_Model->update_milestone( $id, $params );
		}
	}

	function removemilestone() {
		if ( isset( $_POST[ 'milestone' ] ) ) {
			$milestone = $_POST[ 'milestone' ];
			$response = $this->db->delete( 'milestones', array( 'id' => $milestone ) );
		}
	}

	function addtask( $id ) {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
				'priority' => $this->input->post( 'priority' ),
				'assigned' => $this->input->post( 'assigned' ),
				'relation_type' => 'project',
				'relation' => $id,
				'milestone' => $this->input->post( 'milestone' ),
				'public' => $this->input->post( 'public' ),
				'billable' => $this->input->post( 'billable' ),
				'visible' => $this->input->post( 'visible' ),
				'hourly_rate' => $this->input->post( 'hourly_rate' ),
				'startdate' => _pdate( $this->input->post( 'startdate' ) ),
				'duedate' => _pdate( $this->input->post( 'duedate' ) ),
				'addedfrom' => $this->session->userdata( 'logged_in_staff_id' ),
				'status_id' => 1,
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$this->session->set_flashdata( 'ntf1', '<b>Task Added</b>' );
			$this->db->insert( 'tasks', $params );
			$loggedinuserid = $this->session->logged_in_staff_id;
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . ' added new task' ),
				'staff_id' => $loggedinuserid,
				'project_id' => $id,
			) );
			redirect( 'projects/project/' . $id . '' );
		}
	}

	function addmember() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'staff_id' => $_POST[ 'staff' ],
				'project_id' => $_POST[ 'project' ],
			);
			$this->db->insert( 'projectmembers', $params );
			$data[ 'insert_id' ] = $this->db->insert_id();;
			$staffavatar = $this->session->staffavatar;
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( 'You have been added a new project' ),
				'perres' => $staffavatar,
				'staff_id' => $_POST[ 'staff' ],
				'target' => '' . base_url( 'projects/project/' . $_POST[ 'project' ] . '' ) . ''
			) );
			$loggedinuserid = $this->session->logged_in_staff_id;
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . ' added new member to project' ),
				'staff_id' => $loggedinuserid,
				'project_id' => $_POST[ 'project' ],
			) );
			return json_encode( $data );
		}
	}

	function unlinkmember( $id ) {
		if ( isset( $_POST[ 'linkid' ] ) ) {
			$linkid = $_POST[ 'linkid' ];
			$response = $this->db->where( 'id', $linkid )->delete( 'projectmembers', array( 'id' => $linkid ) );
		}
	}

	function deletefile() {
		if ( isset( $_POST[ 'fileid' ] ) ) {
			$file = $_POST[ 'fileid' ];
			$response = $this->db->where( 'id', $file )->delete( 'files', array( 'id' => $file ) );
		}
	}

	function addfile() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$config[ 'upload_path' ] = './uploads/files/';
			$config[ 'allowed_types' ] = 'zip|rar|tar|gif|jpg|png|jpeg|pdf|doc|docx|xls|xlsx|mp4|txt|csv|ppt|opt';
			$this->load->library( 'upload', $config );
			$this->upload->do_upload( 'file_name' );
			$data_upload_files = $this->upload->data();
			$image_data = $this->upload->data();
			$projectid = $this->input->post( 'relation' );
			$params = array(
				'relation_type' => $this->input->post( 'relation_type' ),
				'relation' => $this->input->post( 'relation' ),
				'file_name' => $image_data[ 'file_name' ],
				'created' => date( " Y.m.d H:i:s " ),
			);
			$this->db->insert( 'files', $params );
			redirect( 'projects/project/' . $projectid . '' );
		}
	}

	function checkpinned() {
		if ( isset( $_POST[ 'project' ] ) ) {
			$project = $_POST[ 'project' ];
			$response = $this->db->where( 'id', $project )->update( 'projects', array( 'pinned' => 1 ) );
		}
	}

	function unpinned() {
		if ( isset( $_POST[ 'pinnedproject' ] ) ) {
			$pinnedproject = $_POST[ 'pinnedproject' ];
			$response = $this->db->where( 'id', $pinnedproject )->update( 'projects', array( 'pinned' => 0 ) );
		}
	}
	
	function addexpense() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'category_id' => $this->input->post( 'category' ),
				'staff_id' => $this->input->post( 'staff' ),
				'customer_id' => $this->input->post( 'customer' ),
				'relation_type' => $this->input->post( 'relation_type' ),
				'relation' => $this->input->post( 'relation' ),
				'account_id' => $this->input->post( 'account' ),
				'title' => $this->input->post( 'title' ),
				'date' => _phdate( $this->input->post( 'date' ) ),
				'created' => $this->input->post( 'created' ),
				'amount' => $this->input->post( 'amount' ),
				'description' => $this->input->post( 'description' ),
			);
			$expenses_id = $this->Expenses_Model->add_expenses( $params );
			redirect( 'projects/project/'.$this->input->post( 'relation' ).'' );
		} 
	}
	
	function convertinvoice( $id ) {
		$project = $this->Projects_Model->get_projects( $id );
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'staff_id' => $project[ 'staff_id' ],
				'customer_id' => $project[ 'customer_id' ],
				'created' => date( 'Y-m-d H:i:s' ),
				'status_id' => 3,
				'total' => $this->input->post( 'total' ),
				'project_id' => $id,
				'total_sub' => $this->input->post( 'total' ),
			);
			$this->db->insert( 'invoices', $params );
			$invoice = $this->db->insert_id();
			$this->db->insert( 'invoiceitems', array(
				'invoice_id' => $invoice,
				'in[name]' => $project[ 'name' ],
				'in[total]' => $this->input->post( 'total' ),
				'in[price]' => $this->input->post( 'total' ),
				'in[amount]' => 1,
				'in[unit]' => 'Unit',
				'in[description]' => $project[ 'description' ],
			) );
			$loggedinuserid = $this->session->logged_in_staff_id;
			$this->db->insert( $this->db->dbprefix . 'sales', array(
				'invoice_id' => '' . $invoice . '',
				'status_id' => 3,
				'staff_id' => $loggedinuserid,
				'customer_id' => $project[ 'customer_id' ],
				'total' => $this->input->post( 'total' ),
				'date' => date( 'Y-m-d H:i:s' )
			) );
			$staffname = $this->session->staffname;
			$this->db->insert( 'logs', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' ),
				'detail' => ( '' . $message = sprintf( lang( 'projecttoinvoicelog' ), $staffname, $project[ 'id' ] ) . '' ),
				'staff_id' => $loggedinuserid,
				'customer_id' => $project[ 'customer_id' ],
			) );
			$response = $this->db->where( 'id', $id )->update( 'projects', array( 'invoice_id' => $invoice ) );
			redirect( 'invoices/edit/' . $invoice . '' );
		}
	}

	/* Remove Project */
	function remove( $id ) {
		$projects = $this->Projects_Model->get_projects( $id );
		if ( isset( $projects[ 'id' ] ) ) {
			$this->Projects_Model->delete_projects( $id );
			redirect( 'projects/index' );
		} else
			show_error( 'The projects you are trying to delete does not exist.' );
	}

}