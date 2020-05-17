<?php

class Tasks_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_task( $id ) {
		return $this->db->get_where( 'tasks', array( 'id' => $id ) )->row_array();
	}

	function get_task_detail( $id, $rel_type ) {
		if ( $rel_type == 'project' ) {
			$this->db->select( '*,tasks.name as taskname,tasks.datefinished as datefinished,tasks.created as created,tasks.duedate as duedate, tasks.description as description,projects.name as project,milestones.name as milestone,staff.staffname as assigner,tasks.status_id as status_id,tasks.id as id' );
			$this->db->join( 'projects', 'tasks.relation = projects.id', 'left' );
			$this->db->join( 'milestones', 'tasks.milestone = milestones.id', 'left' );
			$this->db->join( 'staff', 'tasks.assigned = staff.id', 'left' );
			return $this->db->get_where( 'tasks', array( 'tasks.id' => $id ) )->row_array();
		} elseif ( $rel_type == 'ticket' ) {
			$this->db->select( '*,tasks.name as taskname,tasks.description as description,projects.name as project,milestones.name as milestone,staff.staffname as assigner,tasks.status_id as status_id,tasks.id as id' );
			$this->db->join( 'projects', 'tasks.project_id = projects.id', 'left' );
			$this->db->join( 'milestones', 'tasks.milestone = milestones.id', 'left' );
			$this->db->join( 'staff', 'tasks.assigned = staff.id', 'left' );
			return $this->db->get_where( 'tasks', array( 'tasks.id' => $id ) )->row_array();
		}

	}
	function get_task_time_log($id) {
		$this->db->select('*,staff.staffname as staffmember,tasktimer.id as id');
		$this->db->join( 'staff', 'tasktimer.staff_id = staff.id', 'left' );
		return $this->db->get_where( 'tasktimer', array( 'tasktimer.task_id' => $id ) )->result_array();
	}

	function get_project_tasks( $id ) {
		$this->db->select( '*' );
		return $this->db->get_where( 'tasks', array( 'tasks.relation_type' => 'project', 'tasks.relation' => $id, 'tasks.milestone' => '0' ) )->result_array();

	}

	function get_all_tasks() {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'tasks', array( '' ) )->result_array();
	}

	function get_subtasks( $id ) {
		$this->db->order_by( 'id', 'desc' );
		return $this->db->get_where( 'subtasks', array( 'subtasks.taskid' => $id, 'subtasks.complete' => 0 ) )->result_array();
	}

	function get_subtaskscomplete( $id ) {
		return $this->db->get_where( 'subtasks', array( 'subtasks.taskid' => $id, 'subtasks.complete' => 1 ) )->result_array();
	}

	function get_task_files( $id ) {
		$this->db->select( '*' );
		return $this->db->get_where( 'files', array( 'files.relation_type' => 'task', 'files.relation' => $id ) )->result_array();

	}
	function update_task( $id, $params ) {
		$this->db->where( 'id', $id );
		$response = $this->db->update( 'tasks', $params );
		$loggedinuserid = $this->session->logged_in_staff_id;
		$staffname = $this->session->staffname;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> '.lang('updated').' <a href="tasks/task/' . $id . '">'.lang('task').'-' . $id . '</a>.' ),
			'staff_id' => $loggedinuserid,
		) );
	}

}