<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Tasks extends CIUIS_Controller {

	function index() {
		$data[ 'title' ] = lang( 'tasks' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Tasks', 'tasks' );
		$this->breadcrumb->add_crumb( 'All Tasks' );
		$data[ 'tasks' ] = $this->Tasks_Model->get_all_tasks();
		$data[ 'settings' ] = $this->Settings_Model->get_settings_ciuis();
		$this->load->view( 'tasks/index', $data );
	}

	function create() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'name' => $this->input->post( 'name' ),
				'description' => $this->input->post( 'description' ),
				'priority' => $this->input->post( 'priority' ),
				'assigned' => $this->input->post( 'assigned' ),
				'relation_type' => $this->input->post( 'relation_type' ),
				'relation' => $this->input->post( 'relation' ),
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
				'project_id' => $this->input->post( 'relation' ),
			) );
			redirect( 'tasks/index' );
		}
	}

	function update( $id ) {
		$data[ 'tasks' ] = $this->Tasks_Model->get_task( $id );
		if ( isset( $data[ 'tasks' ][ 'id' ] ) ) {
			if ( isset( $_POST ) && count( $_POST ) > 0 ) {
				$params = array(
					'name' => $this->input->post( 'name' ),
					'description' => $this->input->post( 'description' ),
					'priority' => $this->input->post( 'priority' ),
					'status_id' => $this->input->post( 'status_id' ),
					'assigned' => $this->input->post( 'assigned' ),
					'public' => $this->input->post( 'public' ),
					'billable' => $this->input->post( 'billable' ),
					'visible' => $this->input->post( 'visible' ),
					'hourly_rate' => $this->input->post( 'hourly_rate' ),
					'startdate' => _pdate( $this->input->post( 'startdate' ) ),
					'duedate' => _pdate( $this->input->post( 'duedate' ) ),
				);
				$this->Tasks_Model->update_task( $id, $params );
				redirect( 'tasks/task/' . $id . '' );
			} else {
				$this->load->view( 'tasks/index', $data );
			}
		} else
			show_error( 'The task you are trying to edit does not exist.' );
	}

	function task( $id ) {
		$data[ 'title' ] = lang( 'task' );
		$this->breadcrumb->clear();
		$this->breadcrumb->add_crumb( 'Dashboard', 'panel' );
		$this->breadcrumb->add_crumb( 'Products', '../products' );
		$this->breadcrumb->add_crumb( 'Ürün Detayı' );
		$task = $this->Tasks_Model->get_task( $id );
		$rel_type = $task[ 'relation_type' ];
		$data[ 'task' ] = $this->Tasks_Model->get_task_detail( $id, $rel_type );
		$this->load->view( 'tasks/task', $data );
	}

	function addsubtask() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'description' => $_POST[ 'description' ],
				'taskid' => $_POST[ 'taskid' ],
				'staff_id' => $this->session->userdata( 'logged_in_staff_id' ),
				'created' => date( 'Y-m-d H:i:s' ),
			);
			$this->db->insert( 'subtasks', $params );
			$data[ 'insert_id' ] = $this->db->insert_id();;
			return json_encode( $data );
		}
	}

	function markascancelled() {
		if ( isset( $_POST[ 'task' ] ) ) {
			$task = $_POST[ 'task' ];
			$response = $this->db->where( 'id', $task )->update( 'tasks', array( 'status_id' => 5 ) );
			$response = $this->db->where( 'taskid', $task )->update( 'subtasks', array( 'complete' => 0 ) );
		}
	}

	function markascompletetask() {
		if ( isset( $_POST[ 'task' ] ) ) {
			$task = $_POST[ 'task' ];
			$response = $this->db->where( 'id', $task )->update( 'tasks', array( 'status_id' => 4 ) );
			$response = $this->db->where( 'taskid', $task )->update( 'subtasks', array( 'complete' => 1 ) );
		}
	}

	function completesubtasks() {
		if ( isset( $_POST[ 'subtask' ] ) ) {
			$subtask = $_POST[ 'subtask' ];
			$response = $this->db->where( 'id', $subtask )->update( 'subtasks', array( 'complete' => 1 ) );
		}
	}

	function removesubtasks() {
		if ( isset( $_POST[ 'subtask' ] ) ) {
			$subtask = $_POST[ 'subtask' ];
			$response = $this->db->where( 'id', $subtask )->delete( 'subtasks', array( 'id' => $subtask ) );
		}
	}

	function uncompletesubtasks() {
		if ( isset( $_POST[ 'task_id' ] ) ) {
			$subtask = $_POST[ 'task_id' ];
			$response = $this->db->where( 'id', $subtask )->update( 'subtasks', array( 'complete' => 0 ) );
		}
	}

	function starttimer() {
		if ( isset( $_POST ) && count( $_POST ) > 0 ) {
			$params = array(
				'task_id' => $_POST[ 'task' ],
				'project_id' => $_POST[ 'project' ],
				'staff_id' => $this->session->userdata( 'logged_in_staff_id' ),
				'start' => date( 'Y-m-d H:i' ),
			);
			$this->db->insert( 'tasktimer', $params );
			$response = $this->db->where( 'id', $_POST[ 'task' ] )->update( 'tasks', array( 'timer' => 1 ) );
			$data[ 'insert_id' ] = $this->db->insert_id();;
			return json_encode( $data );
		}
	}

	function stoptimer() {
		if ( isset( $_POST[ 'task' ] ) ) {
			$task = $_POST[ 'task' ];
			$end = date( 'Y-m-d H:i' );
			$response = $this->db->where( 'task_id', $task )->update( 'tasktimer', array( 'end' => $end, 'end' => $end, 'reason' => 'test' ) );
			$response = $this->db->where( 'id', $_POST[ 'task' ] )->update( 'tasks', array( 'timer' => 0 ) );
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
			$taskid = $this->input->post( 'relation' );
			$params = array(
				'relation_type' => $this->input->post( 'relation_type' ),
				'relation' => $this->input->post( 'relation' ),
				'file_name' => $image_data[ 'file_name' ],
				'created' => date( " Y.m.d H:i:s " ),
			);
			$this->db->insert( 'files', $params );
			redirect( 'tasks/task/' . $taskid . '' );
		}
	}

	function remove( $id ) {
		if ( isset( $id ) ) {
			$response = $this->db->where( 'id', $id )->delete( 'tasks', array( 'id' => $id ) );
			redirect( 'tasks/' );
		}
	}

}