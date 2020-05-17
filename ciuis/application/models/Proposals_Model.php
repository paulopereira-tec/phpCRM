<?php
class Proposals_Model extends CI_Model {
	function __construct() {
		parent::__construct();
	}

	function get_all_proposals() {
		$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,proposals.id as id' );
		$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
		$this->db->order_by( 'proposals.id', 'desc' );
		return $this->db->get( 'proposals' )->result_array();
	}

	function get_proposal( $id ) {
		return $this->db->get_where( 'proposals', array( 'id' => $id ) )->row_array();
	}

	function get_pro_rel_type( $id ) {
		return $this->db->get_where( 'proposals', array( 'id' => $id ) )->row_array();
	}

	function get_proposals( $id, $rel_type ) {
		if ( $rel_type == 'customer' ) {
			$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,customers.company as customercompany,customers.email as toemail,customers.namesurname as individual,customers.address as toaddress,proposals.status_id as status_id, proposals.id as id ' );
			$this->db->join( 'customers', 'proposals.relation = customers.id', 'left' );
			$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
			return $this->db->get_where( 'proposals', array( 'proposals.id' => $id ) )->row_array();
		} elseif ( $rel_type == 'lead' ) {
			$this->db->select( '*,staff.staffname as staffmembername,staff.staffavatar as staffavatar,leads.name as leadname,leads.address as toaddress,leads.email as toemail, proposals.id as id ' );
			$this->db->join( 'leads', 'proposals.relation = leads.id', 'left' );
			$this->db->join( 'staff', 'proposals.assigned = staff.id', 'left' );
			return $this->db->get_where( 'proposals', array( 'proposals.id' => $id ) )->row_array();
		}
	}

	function get_proposalitems( $id ) {
		return $this->db->get_where( 'proposalitems', array( 'id' => $id ) )->row_array();
	}
	// GET INVOICE DETAILS

	function get_proposal_productsi_art( $id ) {
		$this->db->select_sum( 'in[total]' );
		$this->db->from( 'proposalitems' );
		$this->db->where( '(proposal_id = ' . $id . ') ' );
		return $this->db->get();
	}

	// CHANCE INVOCE STATUS

	function status_1( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'status_id' => ( '1' ) ) );
		$response = $this->db->update( 'sales', array( 'proposal_id' => $id, 'status_id' => '1' ) );
	}

	function status_2( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'status_id' => ( '2' ) ) );
		$response = $this->db->update( 'sales', array( 'proposal_id' => $id, 'status_id' => '2' ) );
	}

	function status_3( $id ) {
		$response = $this->db->where( 'id', $id )->update( 'proposals', array( 'status_id' => ( '3' ) ) );
		$response = $this->db->update( 'sales', array( 'proposal_id' => $id, 'status_id' => '3' ) );
	}
	// ADD INVOICE
	function proposal_add( $params ) {
		$this->db->insert( 'proposals', $params );
		$proposal = $this->db->insert_id();
		// MULTIPLE INVOICE ITEMS POST
		$countitem = count( $this->input->post( 'in[product_id]' ) );
		$countitem = $countitem - 1;
		for ( $i = 0; $i < $countitem; $i++ ) {
			$iteminfo[] = array(
				'proposal_id' => $proposal,
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
		$this->db->insert_batch( 'proposalitems', $iteminfo );
		//LOG
		if ( $this->input->post( 'relation' ) === 1 ) {

			//NOTIFICATION
			$staffname = $this->session->staffname;
			$staffavatar = $this->session->staffavatar;
			$this->db->insert( 'notifications', array(
				'date' => date( 'Y-m-d H:i:s' ),
				'detail' => ( '' . $staffname . '' . lang( 'isaddedanewproposal' ) . '' ),
				'customer' => $this->input->post( 'relation' ),
				'perres' => $staffavatar,
				'target' => '' . base_url( 'area/proposal/' . $proposal . '' ) . ''
			) );
		}
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->logged_in_staff_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'added' ) . ' <a href="proposals/proposal/' . $proposal . '">' . lang( 'proposalprefix' ) . '-' . $proposal . '</a>.' ),
			'staff_id' => $loggedinuserid,
		) );
		return $this->db->insert_id();
	}
	function update_proposals( $id, $params ) {
		$this->db->where( 'id', $id );
		$proposal = $id;
		$response = $this->db->update( 'proposals', $params );
		$response = $this->db->delete( 'proposalitems', array( 'proposal_id' => $id ) );
		$countitem = count( $this->input->post( 'in[itemid]' ) );
		$countitem = $countitem - 1;
		for ( $i = 0; $i < $countitem; $i++ ) {
			$newitem[] = array(
				'proposal_id' => $proposal,
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
		$this->db->insert_batch( 'proposalitems', $newitem );
		//LOG
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->logged_in_staff_id;
		if ( $this->input->post( 'relation_type' ) == 'customer' ) {
			$relation = $this->input->post( 'related_customer' );
		} else {
			$relation = $this->input->post( 'related_lead' );
		};
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'updated' ) . ' <a href="proposals/proposal/' . $id . '">' . lang( 'proposalprefix' ) . '-' . $id . '</a>.' ),
			'staff_id' => $loggedinuserid,
			'customer_id' => $relation,
		) );
		//NOTIFICATION
		$staffname = $this->session->staffname;
		$staffavatar = $this->session->staffavatar;
		$this->db->insert( 'notifications', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '' . $staffname . ' ' . lang( 'uptdatedproposal' ) . '' ),
			'customer_id' => $relation,
			'perres' => $staffavatar,
			'target' => '' . base_url( 'area/proposal/' . $proposal . '' ) . ''
		) );
		if ( $response ) {
			return "Proposal Updated.";
		} else {
			return "There was a problem during the update.";
		}
	}
	//INVOICE DELETE
	function delete_proposals( $id ) {
		$response = $this->db->delete( 'proposals', array( 'id' => $id ) );
		$response = $this->db->delete( 'proposalitems', array( 'proposal_id' => $id ) );
		$staffname = $this->session->staffname;
		$loggedinuserid = $this->session->logged_in_staff_id;
		$this->db->insert( 'logs', array(
			'date' => date( 'Y-m-d H:i:s' ),
			'detail' => ( '<a href="staff/staffmember/' . $loggedinuserid . '"> ' . $staffname . '</a> ' . lang( 'deleted' ) . ' ' . lang( 'proposalprefix' ) . '-' . $id . '' ),
			'staff_id' => $loggedinuserid
		) );
	}

	function cancelled() {
		$response = $this->db->where( 'id', $_POST[ 'proposal_id' ] )->update( 'proposals', array( 'status_id' => $_POST[ 'status_id' ] ) );
	}

	function markas() {
		$response = $this->db->where( 'id', $_POST[ 'proposal_id' ] )->update( 'proposals', array( 'status_id' => $_POST[ 'status_id' ] ) );
	}

	function deleteproposalitem( $id ) {
		$response = $this->db->delete( 'proposalitems', array( 'id' => $id ) );
	}
	public

	function get_proposal_year() {
		return $this->db->query( 'SELECT DISTINCT(YEAR(date)) as year FROM proposals ORDER BY year DESC' )->result_array();
	}
}