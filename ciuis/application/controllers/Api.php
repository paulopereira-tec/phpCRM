<?php
defined( 'BASEPATH' )OR exit( 'No direct script access allowed' );
class Api extends CIUIS_Controller {

	function index() {
		echo 'Ciuis RestAPI Service';
	}


	function settings() {
		$settings = $this->Settings_Model->get_settings_ciuis();
		echo json_encode( $settings );
	}

	function stats() {
		$otc = $this->Report_Model->otc();
		$yms = $this->Report_Model->yms();
		$bkt = $this->Report_Model->bkt();
		$ogt = $this->Report_Model->ogt();
		$pay = $this->Report_Model->pay();
		$exp = $this->Report_Model->exp();
		$bht = $this->Report_Model->bht();
		$ohc = $this->Report_Model->ohc();
		$oak = $this->Report_Model->oak();
		$akt = $this->Report_Model->akt();
		$mex = $this->Report_Model->mex();
		$pme = $this->Report_Model->pme();
		$ycr = $this->Report_Model->ycr();
		$oyc = $this->Report_Model->oyc();
		if ( $otc > 1 ) {
			$newticketmsg = lang( 'newtickets' );
		} else $newticketmsg = lang( 'newticket' );
		if ( $yms > 1 ) {
			$newcustomermsg = lang( 'newcustomers' );
		} else $newcustomermsg = lang( 'newcustomer' );
		if ( $bkt > $ogt ) {
			$todaysalescolor = 'default';
		} else {
			$todaysalescolor = 'danger';
		}
		$todayrate = $bkt - $ogt;
		if ( empty( $ogt ) ) {
			$todayrate = 'N/A';
		} else $todayrate = floor( $todayrate / $ogt * 100 );
		if ( $bkt > $ogt ) {
			$todayicon = 'icon ion-arrow-up-c';
		} else {
			$todayicon = 'icon ion-arrow-down-c';
		}
		$netcashflow = ( $pay - $exp );
		if ( $bht > $ohc ) {
			$weekstat = 'default';
		} else {
			$weekstat = 'danger';
		}
		$weekrate = $bht - $ohc;
		if ( empty( $ohc ) ) {
			$weekrate = 'N/A';
		} else $weekrate = floor( $weekrate / $ohc * 100 );
		if ( $bht > $ohc ) {
			$weekratestatus = lang( 'increase' );
		} else {
			$weekratestatus = lang( 'recession' );
		}
		if ( $akt > $oak ) {
			$montearncolor = 'success';
			$monicon = 'icon ion-arrow-up-c';
		} else {
			$montearncolor = 'danger';
			$monicon = 'icon ion-arrow-down-c';
		}
		$oao = $akt - $oak;
		if ( empty( $oak ) ) {
			$monmessage = '' . lang( 'notyet' ) . '';
		} else $monmessage = floor( $oao / $oak * 100 );
		$time = date( "H" );
		$timezone = date( "e" );
		if ( $time < "12" ) {
			$daymessage = lang( 'goodmorning' );
			$dayimage = base_url( 'assets/img/morning.png' );
		} else if ( $time >= "12" && $time < "17" ) {
			$daymessage = lang( 'goodafternoon' );
			$dayimage = base_url( 'assets/img/afternoon.png' );
		} else if ( $time >= "17" && $time < "19" ) {
			$daymessage = lang( 'goodevening' );
			$dayimage = base_url( 'assets/img/evening.png' );
		} else if ( $time >= "19" ) {
			$daymessage = lang( 'goodnight' );
			$dayimage = base_url( 'assets/img/night.png' );
		}
		if ( $mex > $pme ) {
			$expensecolor = 'warning';
		} else {
			$expensecolor = 'danger';
		}
		if ( $mex > $pme ) {
			$expenseicon = 'icon ion-arrow-up-c';
		} else {
			$expenseicon = 'icon ion-arrow-down-c';
		}
		$expenses = $mex - $pme;
		if ( empty( $pme ) ) {
			$expensestatus = '' . lang( 'notyet' ) . '';
		} else $expensestatus = floor( $expenses / $pme * 100 );
		if ( $ycr > $oyc ) {
			$yearcolor = 'success';
		} else {
			$yearcolor = 'danger';
		}
		if ( $ycr > $oyc ) {
			$yearicon = 'icon ion-arrow-up-c';
		} else {
			$yearicon = 'icon ion-arrow-down-c';
		}
		$yearly = $ycr - $oyc;
		if ( empty( $oyc ) ) {
			$yearmessage = '' . lang( 'notyet' ) . '';
		} else $yearmessage = floor( $yearly / $oyc * 100 );
		$newnotification = $this->Notifications_Model->newnotification();
		$stats = array(
			'mex' => $mex = $this->Report_Model->mex(),
			'pme' => $pme = $this->Report_Model->pme(),
			'bkt' => $bkt = $this->Report_Model->bkt(),
			'bht' => $bht = $this->Report_Model->bht(),
			'ogt' => $ogt = $this->Report_Model->ogt(),
			'ohc' => $ohc = $this->Report_Model->ohc(),
			'otc' => $otc = $this->Report_Model->otc(),
			'ycr' => $ycr = $this->Report_Model->ycr(),
			'oyc' => $oyc = $this->Report_Model->oyc(),
			'oft' => $oft = $this->Report_Model->oft(),
			'tef' => $tef = $this->Report_Model->tef(),
			'vgf' => $vgf = $this->Report_Model->vgf(),
			'tbs' => $tbs = $this->Report_Model->tbs(),
			'akt' => $akt = $this->Report_Model->akt(),
			'oak' => $oak = $this->Report_Model->oak(),
			'tfa' => $tfa = $this->Report_Model->tfa(),
			'yms' => $yms = $this->Report_Model->yms(),
			'ttc' => $ttc = $this->Report_Model->ttc(),
			'ipc' => $ipc = $this->Report_Model->ipc(),
			'atc' => $atc = $this->Report_Model->atc(),
			'ctc' => $ctc = $this->Report_Model->ctc(),
			'put' => $put = $this->Report_Model->put(),
			'pay' => $pay = $this->Report_Model->pay(),
			'exp' => $exp = $this->Report_Model->exp(),
			'twt' => $twt = $this->Report_Model->twt(),
			'clc' => $clc = $this->Report_Model->clc(),
			'mlc' => $mlc = $this->Report_Model->mlc(),
			'mtt' => $mtt = $this->Report_Model->mtt(),
			'mct' => $mct = $this->Report_Model->mct(),
			'ues' => $ues = $this->Report_Model->ues(),
			'myc' => $myc = $this->Report_Model->myc(),
			'tpz' => $tpz = $this->Report_Model->tpz(),
			'nsp' => $nsp = $this->Report_Model->nsp(),
			'sep' => $sep = $this->Report_Model->sep(),
			'pep' => $pep = $this->Report_Model->pep(),
			'cap' => $cap = $this->Report_Model->cap(),
			'cop' => $cop = $this->Report_Model->cop(),
			'not_started_percent' => $nspp = ( $tpz > 0 ? number_format( ( $nsp * 100 ) / $tpz ) : 0 ),
			'started_percent' => $sppp = ( $tpz > 0 ? number_format( ( $sep * 100 ) / $tpz ) : 0 ),
			'percentage_percent' => $pppp = ( $tpz > 0 ? number_format( ( $pep * 100 ) / $tpz ) : 0 ),
			'cancelled_percent' => $cppp = ( $tpz > 0 ? number_format( ( $cap * 100 ) / $tpz ) : 0 ),
			'complete_percent' => $comps = ( $tpz > 0 ? number_format( ( $cop * 100 ) / $tpz ) : 0 ),
			'totalpaym' => $totalpaym = $this->Report_Model->totalpaym(),
			'incomings' => $incomings = $this->Report_Model->incomings(),
			'outgoings' => $outgoings = $this->Report_Model->outgoings(),
			'ysy' => $ysy = ( $ttc > 0 ? number_format( ( $otc * 100 ) / $ttc ) : 0 ),
			'bsy' => $bsy = ( $ttc > 0 ? number_format( ( $ipc * 100 ) / $ttc ) : 0 ),
			'twy' => $twy = ( $ttc > 0 ? number_format( ( $atc * 100 ) / $ttc ) : 0 ),
			'iey' => $iey = ( $ttc > 0 ? number_format( ( $ctc * 100 ) / $ttc ) : 0 ),
			'ofy' => $ofy = ( $tfa > 0 ? number_format( ( $tef * 100 ) / $tfa ) : 0 ),
			'clp' => $clp = ( $mlc > 0 ? number_format( ( $clc * 100 ) / $mlc ) : 0 ),
			'mtp' => $mtp = ( $mtt > 0 ? number_format( ( $mct * 100 ) / $mtt ) : 0 ),
			'inp' => $inp = ( $put > 0 ? number_format( ( $pay * 100 ) / $put ) : 0 ),
			'ogp' => $ogp = ( $put > 0 ? number_format( ( $exp * 100 ) / $put ) : 0 ),
			'newticketmsg' => $newticketmsg,
			'newcustomermsg' => $newcustomermsg,
			'todaysalescolor' => $todaysalescolor,
			'todayrate' => $todayrate,
			'todayicon' => $todayicon,
			'netcashflow' => $netcashflow,
			'weekstat' => $weekstat,
			'weekrate' => $weekrate,
			'weekratestatus' => $weekratestatus,
			'daymessage' => $daymessage,
			'dayimage' => $dayimage,
			'montearncolor' => $montearncolor,
			'monicon' => $monicon,
			'monmessage' => $monmessage,
			'expensecolor' => $expensecolor,
			'expenseicon' => $expenseicon,
			'expensestatus' => $expensestatus,
			'yearcolor' => $yearcolor,
			'yearicon' => $yearicon,
			'yearmessage' => $yearmessage,
			'newnotification' => $newnotification,
			'totaltasks' => $totaltasks = $this->Report_Model->totaltasks(),
			'opentasks' => $opentasks = $this->Report_Model->opentasks(),
			'inprogresstasks' => $inprogresstasks = $this->Report_Model->inprogresstasks(),
			'waitingtasks' => $waitingtasks = $this->Report_Model->waitingtasks(),
			'completetasks' => $completetasks = $this->Report_Model->completetasks(),
		);
		echo json_encode( $stats );
	}

	function user( $id ) {
		$user = $this->Staff_Model->get_staff( $id );
		echo json_encode( $user );
	}

	function menu() {
		$menus = $this->Settings_Model->get_menus();
		$data_menus = array();
		foreach ( $menus as $menu ) {
			$sub_menus = $this->Settings_Model->get_submenus( $menu[ 'id' ] );
			$data_submenus = array();
			foreach ( $sub_menus as $sub_menu ) {
				if ( $sub_menu[ 'url' ] != NULL ) {
					$suburl = '' . base_url( $sub_menu[ 'url' ] ) . '';
				} else {
					$suburl = '#';
				}
				$data_submenus[] = array(
					'id' => $sub_menu[ 'id' ],
					'order_id' => $sub_menu[ 'order_id' ],
					'main_menu' => $sub_menu[ 'main_menu' ],
					'name' => $sub_menu[ 'name' ],
					'description' => $sub_menu[ 'description' ],
					'icon' => $sub_menu[ 'icon' ],
					'url' => $suburl,
				);
			};
			if ( $menu[ 'url' ] != NULL ) {
				$url = '' . base_url( $menu[ 'url' ] ) . '';
			} else {
				$url = '#';
			}
			$data_menus[] = array(
				'id' => $menu[ 'id' ],
				'order_id' => $menu[ 'order_id' ],
				'main_menu' => $menu[ 'main_menu' ],
				'name' => $menu[ 'name' ],
				'description' => $menu[ 'description' ],
				'icon' => $menu[ 'icon' ],
				'url' => $url,
				'sub_menu' => $data_submenus,
			);
		};
		echo json_encode( $data_menus );
	}

	function projects() {
		$projects = $this->Projects_Model->get_all_projects();
		$data_projects = array();
		foreach ( $projects as $project ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			$totaltasks = $this->Report_Model->totalprojecttasks( $project[ 'id' ] );
			$opentasks = $this->Report_Model->openprojecttasks( $project[ 'id' ] );
			$completetasks = $this->Report_Model->completeprojecttasks( $project[ 'id' ] );
			$progress = ( $totaltasks > 0 ? number_format( ( $completetasks * 100 ) / $totaltasks ) : 0 );
			$project_id = $project[ 'id' ];
			switch ( $project[ 'status' ] ) {
				case '1':
					$projectstatus = 'notstarted';
					$icon = 'notstarted.png';
					$status = lang( 'notstarted' );
					break;
				case '2':
					$projectstatus = 'started';
					$icon = 'started.png';
					$status = lang( 'started' );
					break;
				case '3':
					$projectstatus = 'percentage';
					$icon = 'percentage.png';
					$status = lang( 'percentage' );
					break;
				case '4':
					$projectstatus = 'cancelled';
					$icon = 'cancelled.png';
					$status = lang( 'cancelled' );
					break;
				case '5':
					$projectstatus = 'complete';
					$icon = 'complete.png';
					$status = lang( 'complete' );
					break;
			}
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $project[ 'start_date' ] );
					break;
				case 'dd.mm.yy':
					$startdate = _udate( $project[ 'start_date' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $project[ 'start_date' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $project[ 'start_date' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $project[ 'start_date' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $project[ 'start_date' ] );
					break;
			};
			if ( $project[ 'customercompany' ] === NULL ) {
				$customer = $project[ 'namesurname' ];
			} else $customer = $project[ 'customercompany' ];
			$enddate = $project[ 'deadline' ];
			$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( 'Asia/Dhaka' ) );
			$end_date = new DateTime( "$enddate", new DateTimeZone( 'Asia/Dhaka' ) );
			$interval = $current_date->diff( $end_date );
			$leftdays = $interval->format( '%a day(s)' );
			$members = $this->Projects_Model->get_members_index( $project_id );
			$milestones = $this->Projects_Model->get_all_project_milestones( $project_id );
			$data_projects[] = array(
				'id' => $project[ 'id' ],
				'project_id' => $project[ 'id' ],
				'name' => $project[ 'name' ],
				'pinned' => $project[ 'pinned' ],
				'progress' => $progress,
				'startdate' => $startdate,
				'leftdays' => $leftdays,
				'customer' => $customer,
				'status_icon' => $icon,
				'status' => $status,
				'status_class' => $projectstatus,
				'customer_id' => $project[ 'customer_id' ],
				'members' => $members,
				'milestones' => $milestones,
			);
		};
		echo json_encode( $data_projects );
	}

	function projectdetail( $id ) {
		$project = $this->Projects_Model->get_projects( $id );
		$settings = $this->Settings_Model->get_settings_ciuis();
		$milestones = $this->Projects_Model->get_all_project_milestones( $id );
		$projectmembers = $this->Projects_Model->get_members( $id );
		$project_logs = $this->Logs_Model->project_logs( $id );
		$totaltasks = $this->Report_Model->totalprojecttasks( $id );
		$opentasks = $this->Report_Model->openprojecttasks( $id );
		$completetasks = $this->Report_Model->completeprojecttasks( $id );
		$progress = ( $totaltasks > 0 ? number_format( ( $completetasks * 100 ) / $totaltasks ) : 0 );
		if ( $project[ 'customercompany' ] === NULL ) {
			$customer = $project[ 'namesurname' ];
		} else $customer = $project[ 'customercompany' ];
		$enddate = $project[ 'deadline' ];
		$current_date = new DateTime( date( 'Y-m-d' ), new DateTimeZone( $settings[ 'default_timezone' ] ) );
		$end_date = new DateTime( "$enddate", new DateTimeZone( $settings[ 'default_timezone' ] ) );
		$interval = $current_date->diff( $end_date );
		$project_left_date = $interval->format( '%a day(s)' );
		if ( date( "Y-m-d" ) > $project[ 'deadline' ] ) {
			$ldt = 'Time\'s up!';
		} else $ldt = $project_left_date;
		switch ( $project[ 'status' ] ) {
			case '1':
				$status = lang( 'notstarted' );
				break;
			case '2':
				$status = lang( 'started' );
				break;
			case '3':
				$status = lang( 'percentage' );
				break;
			case '4':
				$status = lang( 'cancelled' );
				break;
			case '5':
				$status = lang( 'complete' );
				break;
		};
		switch ( $settings[ 'dateformat' ] ) {
			case 'yy.mm.dd':
				$start = _rdate( $project[ 'start_date' ] );
				$deadline = _rdate( $project[ 'deadline' ] );
				$created = _rdate( $project[ 'created' ] );
				$finished = _rdate( $project[ 'finished' ] );

				break;
			case 'dd.mm.yy':
				$start = _udate( $project[ 'start_date' ] );
				$deadline = _udate( $project[ 'deadline' ] );
				$created = _udate( $project[ 'created' ] );
				$finished = _udate( $project[ 'finished' ] );
				break;
			case 'yy-mm-dd':
				$start = _mdate( $project[ 'start_date' ] );
				$deadline = _mdate( $project[ 'deadline' ] );
				$created = _mdate( $project[ 'created' ] );
				$finished = _mdate( $project[ 'finished' ] );
				break;
			case 'dd-mm-yy':
				$start = _cdate( $project[ 'start_date' ] );
				$deadline = _cdate( $project[ 'deadline' ] );
				$created = _cdate( $project[ 'created' ] );
				$finished = _cdate( $project[ 'finished' ] );
				break;
			case 'yy/mm/dd':
				$start = _zdate( $project[ 'start_date' ] );
				$deadline = _zdate( $project[ 'deadline' ] );
				$created = _zdate( $project[ 'created' ] );
				$finished = _zdate( $project[ 'finished' ] );
				break;
			case 'dd/mm/yy':
				$start = _kdate( $project[ 'start_date' ] );
				$deadline = _kdate( $project[ 'deadline' ] );
				$created = _kdate( $project[ 'created' ] );
				$finished = _kdate( $project[ 'finished' ] );
				break;
		};
		if ( in_array( current_user_id, array_column( $projectmembers, 'staff_id' ) ) || !if_admin ) {
			$authorization = "true";
		} else {
			$authorization = 'false';
		};
		if ( $project[ 'invoice_id' ] > 0) {
			$billed = lang( 'yes' );
		} else {
			$billed = lang( 'no' );
		}
		$data_projectdetail = array(
			'id' => $project[ 'id' ],
			'name' => $project[ 'name' ],
			'description' => $project[ 'description' ],
			'start' => $start,
			'deadline' => $deadline,
			'created' => $created,
			'finished' => $finished,
			'status' => $status,
			'progress' => $progress,
			'totaltasks' => $totaltasks,
			'opentasks' => $opentasks,
			'completetasks' => $completetasks,
			'customer' => $customer,
			'customer_id' => $project[ 'customer_id' ],
			'ldt' => $ldt,
			'authorization' => $authorization,
			'billed' => $billed,
			'milestones' => $milestones,
			'members' => $projectmembers,
			'project_logs' => $project_logs
		);
		echo json_encode( $data_projectdetail );
	}

	function projecttasks( $id ) {
		$tasks = $this->Tasks_Model->get_project_tasks( $id );
		$data_projecttasks = array();
		foreach ( $tasks as $task ) {

			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $task[ 'status_id' ] ) {
				case '1':
					$status = lang( 'open' );
					$taskdone = '';
					break;
				case '2':
					$status = lang( 'inprogress' );
					$taskdone = '';
					break;
				case '3':
					$status = lang( 'waiting' );
					$taskdone = '';
					break;
				case '4':
					$status = lang( 'complete' );
					$taskdone = 'done';
					break;
				case '5':
					$status = lang( 'cancelled' );
					$taskdone = '';
					break;
			};
			switch ( $task[ 'relation_type' ] ) {
				case 'project':
					$relationtype = 'Project';
					break;
				case 'ticket':
					$relationtype = 'Tıcket';
					break;
				case 'proposal':
					$relationtype = 'Proposal';
					break;
			};
			switch ( $task[ 'priority' ] ) {
				case '0':
					$priority = lang( 'low' );
					break;
				case '1':
					$priority = lang( 'medium' );
					break;
				case '2':
					$priority = lang( 'high' );
					break;
			};
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $task[ 'startdate' ] );
					$duedate = _rdate( $task[ 'duedate' ] );
					$created = _rdate( $task[ 'created' ] );
					$datefinished = _rdate( $task[ 'datefinished' ] );

					break;
				case 'dd.mm.yy':
					$startdate = _udate( $task[ 'startdate' ] );
					$duedate = _udate( $task[ 'duedate' ] );
					$created = _udate( $task[ 'created' ] );
					$datefinished = _udate( $task[ 'datefinished' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $task[ 'startdate' ] );
					$duedate = _mdate( $task[ 'duedate' ] );
					$created = _mdate( $task[ 'created' ] );
					$datefinished = _mdate( $task[ 'datefinished' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $task[ 'startdate' ] );
					$duedate = _cdate( $task[ 'duedate' ] );
					$created = _cdate( $task[ 'created' ] );
					$datefinished = _cdate( $task[ 'datefinished' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $task[ 'startdate' ] );
					$duedate = _zdate( $task[ 'duedate' ] );
					$created = _zdate( $task[ 'created' ] );
					$datefinished = _zdate( $task[ 'datefinished' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $task[ 'startdate' ] );
					$duedate = _kdate( $task[ 'duedate' ] );
					$created = _kdate( $task[ 'created' ] );
					$datefinished = _kdate( $task[ 'datefinished' ] );
					break;
			};
			$data_projecttasks[] = array(
				'id' => $task[ 'id' ],
				'name' => $task[ 'name' ],
				'relationtype' => $relationtype,
				'status' => $status,
				'status_id' => $task[ 'status_id' ],
				'duedate' => $duedate,
				'startdate' => $startdate,
				'done' => $taskdone,
			);
		};
		echo json_encode( $data_projecttasks );
	}

	function projectmilestones( $id ) {
		$milestones = $this->Projects_Model->get_all_project_milestones( $id );
		$data_milestones = array();
		foreach ( $milestones as $milestone ) {
			if ( date( "Y-m-d" ) > $milestone[ 'duedate' ] ) {
				$status = 'is-completed';
			}
			if ( date( "Y-m-d" ) < $milestone[ 'duedate' ] ) {
				$status = 'is-future';
			};
			$tasks = $this->Projects_Model->get_all_project_milestones_task( $milestone[ 'id' ] );
			$data_milestones[] = array(
				'id' => $milestone[ 'id' ],
				'name' => $milestone[ 'name' ],
				'duedate' => $milestone[ 'duedate' ],
				'description' => $milestone[ 'description' ],
				'order' => $milestone[ 'order' ],
				'due' => $milestone[ 'duedate' ],
				'status' => $status,
				'tasks' => $tasks,
			);
		};
		echo json_encode( $data_milestones );
	}

	function notes() {
		$relation_type = $this->uri->segment( 3 );
		$relation_id = $this->uri->segment( 4 );
		$notes = $this->db->select( '*,staff.staffname as notestaff,notes.id as id ' )->join( 'staff', 'notes.addedfrom = staff.id', 'left' )->get_where( 'notes', array( 'relation' => $relation_id, 'relation_type' => $relation_type ) )->result_array();
		$data_projectnotes = array();
		foreach ( $notes as $note ) {
			$data_projectnotes[] = array(
				'id' => $note[ 'id' ],
				'description' => $note[ 'description' ],
				'staffid' => $note[ 'addedfrom' ],
				'staff' => $note[ 'notestaff' ],
				'date' => _adate( $note[ 'created' ] ),
			);
		};
		echo json_encode( $data_projectnotes );


	}
	
	function projectfiles( $id ) {
		$files = $this->Projects_Model->get_project_files( $id );
		$data_files = array();
		foreach ( $files as $file ) {
			$data_files[] = array(
				'id' => $file[ 'id' ],
				'name' => $file[ 'file_name' ],
			);
		};
		echo json_encode( $data_files );
	}

	function projecttimelogs( $id ) {
		$timelogs = $this->Projects_Model->get_project_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $timelog[ 'task_id' ] );
			$start = $timelog[ 'start' ];
			$end = $timelog[ 'end' ];
			$timed_minute = intval( abs( strtotime( $start ) - strtotime( $end ) ) / 60 );
			$amount = $timed_minute / 60 * $task[ 'hourly_rate' ];
			if ( $task[ 'status_id' ] != 5 ) {
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'staff' => $timelog[ 'staffmember' ],
					'timed' => $timed_minute,
					'amount' => $amount,
				);
			}
		};
		echo json_encode( $data_timelogs );
	}

	function tasks() {
		$tasks = $this->Tasks_Model->get_all_tasks();
		$data_tasks = array();
		foreach ( $tasks as $task ) {

			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $task[ 'status_id' ] ) {
				case '1':
					$status = lang( 'open' );
					$taskdone = '';
					break;
				case '2':
					$status = lang( 'inprogress' );
					$taskdone = '';
					break;
				case '3':
					$status = lang( 'waiting' );
					$taskdone = '';
					break;
				case '4':
					$status = lang( 'complete' );
					$taskdone = 'done';
					break;
				case '5':
					$status = lang( 'cancelled' );
					$taskdone = 'done';
					break;
			};
			switch ( $task[ 'relation_type' ] ) {
				case 'project':
					$relationtype = lang( 'project' );
					break;
				case 'ticket':
					$relationtype = lang( 'ticket' );
					break;
				case 'proposal':
					$relationtype = lang( 'proposal' );
					break;
			};
			switch ( $task[ 'priority' ] ) {
				case '0':
					$priority = lang( 'low' );
					break;
				case '1':
					$priority = lang( 'medium' );
					break;
				case '2':
					$priority = lang( 'high' );
					break;
			};
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$startdate = _rdate( $task[ 'startdate' ] );
					$duedate = _rdate( $task[ 'duedate' ] );
					$created = _rdate( $task[ 'created' ] );
					$datefinished = _rdate( $task[ 'datefinished' ] );

					break;
				case 'dd.mm.yy':
					$startdate = _udate( $task[ 'startdate' ] );
					$duedate = _udate( $task[ 'duedate' ] );
					$created = _udate( $task[ 'created' ] );
					$datefinished = _udate( $task[ 'datefinished' ] );
					break;
				case 'yy-mm-dd':
					$startdate = _mdate( $task[ 'startdate' ] );
					$duedate = _mdate( $task[ 'duedate' ] );
					$created = _mdate( $task[ 'created' ] );
					$datefinished = _mdate( $task[ 'datefinished' ] );
					break;
				case 'dd-mm-yy':
					$startdate = _cdate( $task[ 'startdate' ] );
					$duedate = _cdate( $task[ 'duedate' ] );
					$created = _cdate( $task[ 'created' ] );
					$datefinished = _cdate( $task[ 'datefinished' ] );
					break;
				case 'yy/mm/dd':
					$startdate = _zdate( $task[ 'startdate' ] );
					$duedate = _zdate( $task[ 'duedate' ] );
					$created = _zdate( $task[ 'created' ] );
					$datefinished = _zdate( $task[ 'datefinished' ] );
					break;
				case 'dd/mm/yy':
					$startdate = _kdate( $task[ 'startdate' ] );
					$duedate = _kdate( $task[ 'duedate' ] );
					$created = _kdate( $task[ 'created' ] );
					$datefinished = _kdate( $task[ 'datefinished' ] );
					break;
			};
			$data_tasks[] = array(
				'id' => $task[ 'id' ],
				'name' => $task[ 'name' ],
				'relationtype' => $relationtype,
				'status' => $status,
				'status_id' => $task[ 'status_id' ],
				'duedate' => $duedate,
				'startdate' => $startdate,
				'done' => $taskdone,
				'' . lang( 'filterbystatus' ) . '' => $status,
				'' . lang( 'filterbypriority' ) . '' => $priority,
			);
		};
		echo json_encode( $data_tasks );
	}

	function taskdetail( $id ) {
		$tas = $this->Tasks_Model->get_task( $id );
		$rel_type = $tas[ 'relation_type' ];
		$task = $this->Tasks_Model->get_task_detail( $id, $rel_type );
		if ( $task[ 'milestone' ] != NULL ) {
			$milestone = $task[ 'milestone' ];
		} else {
			$milestone = lang( 'nomilestone' );
		}
		$settings = $this->Settings_Model->get_settings_ciuis();
		switch ( $task[ 'status_id' ] ) {
			case '1':
				$status = lang( 'open' );
				break;
			case '2':
				$status = lang( 'inprogress' );
				break;
			case '3':
				$status = lang( 'waiting' );
				break;
			case '4':
				$status = lang( 'complete' );
				break;
			case '5':
				$status = lang( 'cancelled' );
				break;
		};
		switch ( $task[ 'priority' ] ) {
			case '0':
				$priority = lang( 'low' );
				break;
			case '1':
				$priority = lang( 'medium' );
				break;
			case '2':
				$priority = lang( 'high' );
				break;
		};
		switch ( $settings[ 'dateformat' ] ) {
			case 'yy.mm.dd':
				$startdate = _rdate( $task[ 'startdate' ] );
				$duedate = _rdate( $task[ 'duedate' ] );
				$created = _rdate( $task[ 'created' ] );
				$datefinished = _rdate( $task[ 'datefinished' ] );

				break;
			case 'dd.mm.yy':
				$startdate = _udate( $task[ 'startdate' ] );
				$duedate = _udate( $task[ 'duedate' ] );
				$created = _udate( $task[ 'created' ] );
				$datefinished = _udate( $task[ 'datefinished' ] );
				break;
			case 'yy-mm-dd':
				$startdate = _mdate( $task[ 'startdate' ] );
				$duedate = _mdate( $task[ 'duedate' ] );
				$created = _mdate( $task[ 'created' ] );
				$datefinished = _mdate( $task[ 'datefinished' ] );
				break;
			case 'dd-mm-yy':
				$startdate = _cdate( $task[ 'startdate' ] );
				$duedate = _cdate( $task[ 'duedate' ] );
				$created = _cdate( $task[ 'created' ] );
				$datefinished = _cdate( $task[ 'datefinished' ] );
				break;
			case 'yy/mm/dd':
				$startdate = _zdate( $task[ 'startdate' ] );
				$duedate = _zdate( $task[ 'duedate' ] );
				$created = _zdate( $task[ 'created' ] );
				$datefinished = _zdate( $task[ 'datefinished' ] );
				break;
			case 'dd/mm/yy':
				$startdate = _kdate( $task[ 'startdate' ] );
				$duedate = _kdate( $task[ 'duedate' ] );
				$created = _kdate( $task[ 'created' ] );
				$datefinished = _kdate( $task[ 'datefinished' ] );
				break;
		};
		$taskdata = array(
			'id' => $task[ 'id' ],
			'name' => $task[ 'taskname' ],
			'description' => $task[ 'description' ],
			'project' => $task[ 'project' ],
			'milestone' => $milestone,
			'staff' => $task[ 'assigner' ],
			'status' => $status,
			'priority' => $priority,
			'startdate' => $startdate,
			'duedate' => $duedate,
			'created' => $created,
			'datefinished' => $datefinished,
			'hourlyrate' => $task[ 'hourly_rate' ],
			'timer' => $task[ 'timer' ],

		);
		echo json_encode( $taskdata );
	}
	
	function weekly_incomings(){
		$allsales[] = $this->Report_Model->weekly_incomings();
		for ( $i = 0; $i < count( $allsales ); $i++ ) {
			foreach ( $allsales[ $i ] as $salesc ) {
				$salesday = date( 'l', strtotime( $salesc[ 'date' ] ) );
				$salestotal = $salesc[ 'total' ];
				$data_timelogs = array();
				foreach ( weekdays_git() as $dayc ) {
					if ( $salesday == $dayc ) {
						$total = $salestotal;
					} else $total = 0;
					$data_timelogs[] = array(
						'day' => $dayc,
						'amount' => $total,
						'type' => 'incoming',
					);
				}

			}
		}
		echo json_encode( $data_timelogs );
	}

	function tasktimelogs( $id ) {
		$timelogs = $this->Tasks_Model->get_task_time_log( $id );
		$data_timelogs = array();
		foreach ( $timelogs as $timelog ) {
			$task = $this->Tasks_Model->get_task( $id );
			$start = $timelog[ 'start' ];
			$end = $timelog[ 'end' ];
			$timed_minute = intval( abs( strtotime( $start ) - strtotime( $end ) ) / 60 );
			$amount = $timed_minute / 60 * $task[ 'hourly_rate' ];
			if ( $task[ 'status_id' ] != 5 ) {
				$data_timelogs[] = array(
					'id' => $timelog[ 'id' ],
					'start' => $timelog[ 'start' ],
					'end' => $timelog[ 'end' ],
					'staff' => $timelog[ 'staffmember' ],
					'timed' => $timed_minute,
					'amount' => $amount,
				);
			};
		};
		echo json_encode( $data_timelogs );
	}

	function subtasks( $id ) {
		$subtasks = $this->Tasks_Model->get_subtasks( $id );
		echo json_encode( $subtasks );
	}

	function subtaskscomplete( $id ) {
		$subtaskscomplete = $this->Tasks_Model->get_subtaskscomplete( $id );
		echo json_encode( $subtaskscomplete );
	}

	function taskfiles( $id ) {
		$files = $this->Tasks_Model->get_task_files( $id );
		$data_files = array();
		foreach ( $files as $file ) {
			$data_files[] = array(
				'id' => $file[ 'id' ],
				'name' => $file[ 'file_name' ],
			);
		};
		echo json_encode( $data_files );
	}

	function milestones() {
		$milestones = $this->Projects_Model->get_all_milestones();
		$data_milestones = array();
		foreach ( $milestones as $milestone ) {
			$data_milestones[] = array(
				'id' => $milestone[ 'id' ],
				'milestone_id' => $milestone[ 'id' ],
				'name' => $milestone[ 'name' ],
				'project_id' => $milestone[ 'project_id' ],
			);
		};
		echo json_encode( $data_milestones );
	}

	function staff() {
		$staffs = $this->Staff_Model->get_all_staff();
		$data_staffs = array();
		foreach ( $staffs as $staff ) {
			$data_staffs[] = array(
				'id' => $staff[ 'id' ],
				'name' => $staff[ 'staffname' ],
				'avatar' => $staff[ 'staffavatar' ],
				'department' => $staff[ 'department' ],
				'phone' => $staff[ 'phone' ],
				'address' => $staff[ 'address' ],
				'email' => $staff[ 'email' ],
				'birthday' => $staff[ 'birthday' ],
				'last_login' => $staff[ 'last_login' ],
			);
		};
		echo json_encode( $data_staffs );
	}
	
	function departments() {
		$departments = $this->Settings_Model->get_departments();
		$data_departments = array();
		foreach ( $departments as $department ) {
			$data_departments[] = array(
				'id' => $department[ 'id' ],
				'name' => $department[ 'name' ],
			);
		};
		echo json_encode( $data_departments );
	}
	
	function expenses_by_relation() {
		$relation_type = $this->uri->segment( 3 );
		$relation_id = $this->uri->segment( 4 );
		$expenses = $this->Expenses_Model->get_all_expenses_by_relation($relation_type,$relation_id);
		$data_expenses = array();
		foreach ( $expenses as $expense ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$expensedate = _rdate( $expense[ 'date' ] );
					break;
				case 'dd.mm.yy':
					$expensedate = _udate( $expense[ 'date' ] );
					break;
				case 'yy-mm-dd':
					$expensedate = _mdate( $expense[ 'date' ] );
					break;
				case 'dd-mm-yy':
					$expensedate = _cdate( $expense[ 'date' ] );
					break;
				case 'yy/mm/dd':
					$expensedate = _zdate( $expense[ 'date' ] );
					break;
				case 'dd/mm/yy':
					$expensedate = _kdate( $expense[ 'date' ] );
					break;
			};
			if ( $expense[ 'invoice_id' ] == NULL ) {
				$billstatus = lang( 'notbilled' ) and $color = 'warning' and $billstatus_code = 'false';
			} else $billstatus = lang( 'billed' ) and $color = 'success' and $billstatus_code = 'true';
			if ( $expense[ 'customer_id' ] != 0 ) {
				$billable = 'true';
			} else {
				$billable = 'false';
			}
			$data_expenses[] = array(
				'id' => $expense[ 'id' ],
				'title' => $expense[ 'title' ],
				'prefix' => lang( 'expenseprefix' ),
				'longid' => str_pad( $expense[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'amount' => $expense[ 'amount' ],
				'staff' => $expense[ 'staff' ],
				'category' => $expense[ 'category' ],
				'billstatus' => $billstatus,
				'billstatus_code' => $billstatus_code,
				'color' => $color,
				'billable' => $billable,
				'date' => $expensedate,
			);
		};
		echo json_encode( $data_expenses );
	}

	function expenses() {
		$expenses = $this->Expenses_Model->get_all_expenses();
		$data_expenses = array();
		foreach ( $expenses as $expense ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$expensedate = _rdate( $expense[ 'date' ] );
					break;
				case 'dd.mm.yy':
					$expensedate = _udate( $expense[ 'date' ] );
					break;
				case 'yy-mm-dd':
					$expensedate = _mdate( $expense[ 'date' ] );
					break;
				case 'dd-mm-yy':
					$expensedate = _cdate( $expense[ 'date' ] );
					break;
				case 'yy/mm/dd':
					$expensedate = _zdate( $expense[ 'date' ] );
					break;
				case 'dd/mm/yy':
					$expensedate = _kdate( $expense[ 'date' ] );
					break;
			};
			if ( $expense[ 'invoice_id' ] == NULL ) {
				$billstatus = lang( 'notbilled' )and $color = 'warning';
			} else $billstatus = lang( 'billed' )and $color = 'success';
			if ( $expense[ 'customer_id' ] != 0 ) {
				$billable = 'true';
			} else {
				$billable = 'false';
			}
			$data_expenses[] = array(
				'id' => $expense[ 'id' ],
				'title' => $expense[ 'title' ],
				'prefix' => lang( 'expenseprefix' ),
				'longid' => str_pad( $expense[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'amount' => $expense[ 'amount' ],
				'staff' => $expense[ 'staff' ],
				'category' => $expense[ 'category' ],
				'billstatus' => $billstatus,
				'color' => $color,
				'billable' => $billable,
				'date' => $expensedate,
				'' . lang( 'filterbycategory' ) . '' => $expense[ 'category' ],
				'' . lang( 'filterbybillstatus' ) . '' => $billstatus,
			);
		};
		echo json_encode( $data_expenses );
	}

	function expensescategories() {
		$expensescategories = $this->Expenses_Model->get_all_expensecat();
		$data_expensescategories = array();
		foreach ( $expensescategories as $category ) {
			$catid = $category[ 'id' ];
			$amountby = $this->Report_Model->expenses_amount_by_category( $catid );
			if ( $amountby != NULL ) {
				$amtbc = $amountby;
			} else $amtbc = 0;
			$percent = $this->Report_Model->expenses_percent_by_category( $catid );
			$data_expensescategories[] = array(
				'id' => $category[ 'id' ],
				'name' => $category[ 'name' ],
				'description' => $category[ 'description' ],
				'amountby' => $amtbc,
				'percent' => $percent,
			);
		};
		echo json_encode( $data_expensescategories );
	}

	function proposals() {
		$proposals = $this->Proposals_Model->get_all_proposals();
		$data_proposals = array();
		foreach ( $proposals as $proposal ) {
			$pro = $this->Proposals_Model->get_proposals( $proposal[ 'id' ], $proposal[ 'relation_type' ] );
			if ( $pro[ 'relation_type' ] == 'customer' ) {
				if ( $pro[ 'customercompany' ] === NULL ) {
					$customer = $pro[ 'namesurname' ];
				} else $customer = $pro[ 'customercompany' ];
			}
			if ( $pro[ 'relation_type' ] == 'lead' ) {
				$customer = $pro[ 'leadname' ];
			}
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$date = _rdate( $proposal[ 'date' ] );
					$opentill = _rdate( $proposal[ 'opentill' ] );
					break;
				case 'dd.mm.yy':
					$date = _udate( $proposal[ 'date' ] );
					$opentill = _udate( $proposal[ 'opentill' ] );
					break;
				case 'yy-mm-dd':
					$date = _mdate( $proposal[ 'date' ] );
					$opentill = _mdate( $proposal[ 'opentill' ] );
					break;
				case 'dd-mm-yy':
					$date = _cdate( $proposal[ 'date' ] );
					$opentill = _cdate( $proposal[ 'opentill' ] );
					break;
				case 'yy/mm/dd':
					$date = _zdate( $proposal[ 'date' ] );
					$opentill = _zdate( $proposal[ 'opentill' ] );
					break;
				case 'dd/mm/yy':
					$date = _kdate( $proposal[ 'date' ] );
					$opentill = _kdate( $proposal[ 'opentill' ] );
					break;
			};
			switch ( $proposal[ 'status_id' ] ) {
				case '1':
					$status = lang( 'draft' );
					$class = 'proposal-status-accepted';
					break;
				case '2':
					$status = lang( 'sent' );
					$class = 'proposal-status-sent';
					break;
				case '3':
					$status = lang( 'open' );
					$class = 'proposal-status-open';
					break;
				case '4':
					$status = lang( 'revised' );
					$class = 'proposal-status-revised';
					break;
				case '5':
					$status = lang( 'declined' );
					$class = 'proposal-status-declined';
					break;
				case '6':
					$status = lang( 'accepted' );
					$class = 'proposal-status-accepted';
					break;

			};
			$data_proposals[] = array(
				'id' => $proposal[ 'id' ],
				'assigned' => $proposal[ 'assigned' ],
				'subject' => $proposal[ 'subject' ],
				'customer' => $customer,
				'relation_type' => $proposal[ 'relation_type' ],
				'relation' => $proposal[ 'relation' ],
				'date' => $date,
				'opentill' => $opentill,
				'status' => $status,
				'status_id' => $proposal[ 'status_id' ],
				'staff' => $proposal[ 'staffmembername' ],
				'staffavatar' => $proposal[ 'staffavatar' ],
				'total' => $proposal[ 'total' ],
				'class' => $class,
				'' . lang( 'filterbystatus' ) . '' => $status,
				'' . lang( 'filterbycustomer' ) . '' => $customer,
				'' . lang( 'filterbyassigned' ) . '' => $proposal[ 'staffmembername' ],
			);
		};
		echo json_encode( $data_proposals );
	}

	function invoices() {
		$invoices = $this->Invoices_Model->get_all_invoices();
		$data_invoices = array();
		foreach ( $invoices as $invoice ) {
			$settings = $this->Settings_Model->get_settings_ciuis();
			switch ( $settings[ 'dateformat' ] ) {
				case 'yy.mm.dd':
					$created = _rdate( $invoice[ 'created' ] );
					$duedate = _rdate( $invoice[ 'duedate' ] );
					break;
				case 'dd.mm.yy':
					$created = _udate( $invoice[ 'created' ] );
					$duedate = _udate( $invoice[ 'duedate' ] );
					break;
				case 'yy-mm-dd':
					$created = _mdate( $invoice[ 'created' ] );
					$duedate = _mdate( $invoice[ 'duedate' ] );
					break;
				case 'dd-mm-yy':
					$created = _cdate( $invoice[ 'created' ] );
					$duedate = _cdate( $invoice[ 'duedate' ] );
					break;
				case 'yy/mm/dd':
					$created = _zdate( $invoice[ 'created' ] );
					$duedate = _zdate( $invoice[ 'duedate' ] );
					break;
				case 'dd/mm/yy':
					$created = _kdate( $invoice[ 'created' ] );
					$duedate = _kdate( $invoice[ 'duedate' ] );
					break;
			};
			if ( $invoice[ 'duedate' ] == 0000 - 00 - 00 ) {
				$realduedate = 'No Due Date';
			} else $realduedate = $duedate;
			$totalx = $invoice[ 'total' ];
			$this->db->select_sum( 'amount' )->from( 'payments' )->where( '(invoice_id =' . $invoice[ 'id' ] . ') ' );
			$paytotal = $this->db->get();
			$balance = $totalx - $paytotal->row()->amount;
			if ( $balance > 0 ) {
				$invoicestatus = '';
			} else $invoicestatus = lang( 'paidinv' );
			$color = 'success';;
			if ( $paytotal->row()->amount < $invoice[ 'total' ] && $paytotal->row()->amount > 0 && $invoice[ 'status_id' ] == 3 ) {
				$invoicestatus = lang( 'partial' );
				$color = 'warning';
			} else {
				if ( $paytotal->row()->amount < $invoice[ 'total' ] && $paytotal->row()->amount > 0 ) {
					$invoicestatus = lang( 'partial' );
					$color = 'warning';
				}
				if ( $invoice[ 'status_id' ] == 3 ) {
					$invoicestatus = lang( 'unpaid' );
					$color = 'danger';
				}
			}
			if ( $invoice[ 'status_id' ] == 1 ) {
				$invoicestatus = lang( 'draft' );
				$color = 'muted';
			}
			if ( $invoice[ 'status_id' ] == 4 ) {
				$invoicestatus = lang( 'cancelled' );
				$color = 'danger';
			}
			if ( $invoice[ 'customercompany' ] === NULL ) {
				$customer = $invoice[ 'individual' ];
			} else $customer = $invoice[ 'customercompany' ];
			$data_invoices[] = array(
				'id' => $invoice[ 'id' ],
				'prefix' => lang( 'invoiceprefix' ),
				'longid' => str_pad( $invoice[ 'id' ], 6, '0', STR_PAD_LEFT ),
				'created' => $created,
				'duedate' => $realduedate,
				'customer' => $customer,
				'customer_id' => $invoice['customer_id'],
				'total' => $invoice[ 'total' ],
				'status' => $invoicestatus,
				'color' => $color,
				'' . lang( 'filterbystatus' ) . '' => $invoicestatus,
				'' . lang( 'filterbycustomer' ) . '' => $customer,
			);
		};
		echo json_encode( $data_invoices );
	}

	function invoicedetails( $id ) {
		$invoice = $this->Invoices_Model->get_invoices( $id );
		$payments = $this->db->select( '*,accounts.name as accountname,payments.id as id ' )->join( 'accounts', 'payments.account_id = accounts.id', 'left' )->get_where( 'payments', array( 'invoice_id' => $id ) )->result_array();
		$items = $this->db->select( '*,products.productname as name,invoiceitems.id as id ' )->join( 'products', 'invoiceitems.in[product_id] = products.id', 'left' )->get_where( 'invoiceitems', array( 'invoice_id' => $id ) )->result_array();
		$fatop = $this->Invoices_Model->get_invoice_productsi_art( $id );
		$tadtu = $this->Invoices_Model->get_invoice_tahsil_edilen( $id );
		$total = $invoice[ 'total' ];
		$today = time();
		$duedate = strtotime( $invoice[ 'duedate' ] ); // or your date as well
		$created = strtotime( $invoice[ 'created' ] );
		$paymentday = $duedate - $created; // Bunun sonucu 14 gün olcak
		$paymentx = $today - $created;
		$datepaymentnet = $paymentday - $paymentx;
		if ( $invoice[ 'duedate' ] == 0000 - 00 - 00 ) {
			$duedate_text = 'No Due Date';
		} else {
			if ( $datepaymentnet < 0 ) {
				$duedate_text = '<span class="text-danger mdi mdi-timer-off"></span> <span class="text-danger"><b>' . lang( 'overdue' ) . '</b> </span>';
				echo '<b>', floor( $datepaymentnet / ( 60 * 60 * 24 ) ), '</b> days';;

			} else {
				$duedate_text = lang( 'payableafter' ) . floor( $datepaymentnet / ( 60 * 60 * 24 ) ) . ' ' . lang( 'day' ) . '';

			}
		}
		if ( $invoice[ 'datesend' ] == '0000-00-00 00:00:00' ) {
			$mail_status = lang( 'notyetbeensent' );
		} else $mail_status = _adate( $invoice[ 'datesend' ] );
		$kalan = $total - $tadtu->row()->amount;
		$net_balance = $kalan;
		if ( $tadtu->row()->amount < $total && $tadtu->row()->amount > 0 ) {
			$partial_is = 'true';
		} else $partial_is = 'false';
		$invoice_details = array(
			'id' => $invoice[ 'id' ],
			'items' => $items,
			'payments' => $payments,
			'duedate_text' => $duedate_text,
			'mail_status' => $mail_status,
			'balance' => $net_balance,
			'partial_is' => $partial_is

		);
		echo json_encode( $invoice_details );
	}
	
	function leftmenu() {
		if (!if_admin) {$permission_menu =  '0';} else $permission_menu =  '1';
		$data_leftmenu = array(
            '1' => array(
				'title' => lang('x_menu_panel'),
				'show_staff' => 0,
				'url' => base_url('panel'),
				'icon' => 'ion-ios-analytics-outline',
			),
			'2' => array(
				'title' => lang('x_menu_customers'),
				'show_staff' => 0,
				'url' => base_url('customers'),
				'icon' => 'ico-ciuis-customers',
			),
			'3' => array(
				'title' => lang('x_menu_leads'),
				'show_staff' => 0,
				'url' => base_url('leads'),
				'icon' => 'ico-ciuis-leads',
			),
			'4' => array(
				'title' => lang('x_menu_projects'),
				'show_staff' => 0,
				'url' => base_url('projects'),
				'icon' => 'ico-ciuis-projects',
			),
			'5' => array(
				'title' => lang('x_menu_invoices'),
				'show_staff' => 0,
				'url' => base_url('invoices'),
				'icon' => 'ico-ciuis-invoices',
			),
			'6' => array(
				'title' => lang('x_menu_proposals'),
				'show_staff' => 0,
				'url' => base_url('proposals'),
				'icon' => 'ico-ciuis-proposals',
			),
			'7' => array(
				'title' => lang('x_menu_expenses'),
				'show_staff' => 0,
				'url' => base_url('expenses'),
				'icon' => 'ico-ciuis-expenses',
			),
			'8' => array(
				'title' => lang('x_menu_staff'),
				'show_staff' => $permission_menu,
				'url' => base_url('staff'),
				'icon' => 'ico-ciuis-staff',
			),
			'9' => array(
				'title' => lang('x_menu_tickets'),
				'show_staff' => 0,
				'url' => base_url('tickets'),
				'icon' => 'ico-ciuis-supports',
			),
            
        );
		echo json_encode( $data_leftmenu );
	}

	function dueinvoices() {
		$dueinvoices = $this->Invoices_Model->dueinvoices();
		$data_dueinvoices = array();
		foreach ( $dueinvoices as $invoice ) {
			switch ( $invoice[ 'type' ] ) {
				case '0':
					$customer = $invoice[ 'customercompany' ];
					break;
				case '1':
					$customer = $invoice[ 'individual' ];
					break;
			};
			$data_dueinvoices[] = array(
				'id' => $invoice[ 'id' ],
				'total' => $invoice[ 'total' ],
				'customer' => $customer,
			);
		};
		echo json_encode( $data_dueinvoices );
	}

	function overdueinvoices() {
		$overdueinvoices = $this->Invoices_Model->overdueinvoices();
		$data_overdueinvoices = array();
		foreach ( $overdueinvoices as $invoice ) {
			switch ( $invoice[ 'type' ] ) {
				case '0':
					$customer = $invoice[ 'customercompany' ];
					break;
				case '1':
					$customer = $invoice[ 'individual' ];
					break;
			};
			$today = time();
			$duedate = strtotime( $invoice[ 'duedate' ] ); // or your date as well
			$created = strtotime( $invoice[ 'created' ] );
			$paymentday = $duedate - $created; // Calculate days left.
			$paymentx = $today - $created;
			$datepaymentnet = $paymentday - $paymentx;
			if ( $datepaymentnet < 0 ) {
				$status = '' . floor( $datepaymentnet / ( 60 * 60 * 24 ) ) . ' days';
			};
			$data_overdueinvoices[] = array(
				'id' => $invoice[ 'id' ],
				'total' => $invoice[ 'total' ],
				'customer' => $customer,
				'status' => $status,
			);
		};
		echo json_encode( $data_overdueinvoices );
	}

	function reminders() {
		$reminders = $this->Trivia_Model->get_reminders();
		$data_reminders = array();
		foreach ( $reminders as $reminder ) {
			switch ( $reminder[ 'relation_type' ] ) {
				case 'event':
					$remindertitle = lang( 'eventreminder' );
					break;
				case 'lead':
					$remindertitle = lang( 'leadreminder' );
					break;
				case 'customer':
					$remindertitle = lang( 'customerreminder' );
					break;
				case 'invoice':
					$remindertitle = lang( 'invoicereminder' );
					break;
				case 'expense':
					$remindertitle = lang( 'expensereminder' );
					break;
				case 'ticket':
					$remindertitle = lang( 'ticketreminder' );
					break;
				case 'proposal':
					$remindertitle = lang( 'proposalreminder' );
					break;
			};
			$data_reminders[] = array(
				'id' => $reminder[ 'id' ],
				'title' => $remindertitle,
				'date' => _adate( $reminder[ 'date' ] ),
				'description' => $reminder[ 'description' ],
				'creator' => $reminder[ 'remindercreator' ],
			);
		};
		echo json_encode( $data_reminders );
	}

	function notifications() {
		$notifications = $this->Notifications_Model->get_all_notifications();
		$data_notifications = array();
		foreach ( $notifications as $notification ) {
			switch ( $notification[ 'markread' ] ) {
				case '0':
					$read = '-unread';
					break;
				case '1':
					$read = '';
					break;
			};
			$data_notifications[] = array(
				'id' => $notification[ 'notifyid' ],
				'target' => $notification[ 'target' ],
				'date' => tes_ciuis( $notification[ 'date' ] ),
				'detail' => $notification[ 'detail' ],
				'perres' => $notification[ 'perres' ],
				'biloku' => $read,
			);
		};
		echo json_encode( $data_notifications );
	}

	function tickets() {
		$tickets = $this->Tickets_Model->get_all_tickets();
		$data_tickets = array();
		foreach ( $tickets as $ticket ) {
			switch ( $ticket[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			$data_tickets[] = array(
				'id' => $ticket[ 'id' ],
				'subject' => $ticket[ 'subject' ],
				'message' => $ticket[ 'message' ],
				'staff_id' => $ticket[ 'staff_id' ],
				'contactname' => ''.$ticket[ 'contactname' ].' '.$ticket[ 'contactsurname' ].'',
				'priority' => $priority,
				'priority_id' => $ticket[ 'priority' ],
				'lastreply' => $ticket[ 'lastreply' ],
				'status_id' => $ticket[ 'status_id' ],
			);
		};
		echo json_encode( $data_tickets );
	}

	function newtickets() {
		$newtickets = $this->Tickets_Model->get_all_open_tickets();
		$data_newtickets = array();
		foreach ( $newtickets as $ticket ) {
			switch ( $ticket[ 'priority' ] ) {
				case '1':
					$priority = lang( 'low' );
					break;
				case '2':
					$priority = lang( 'medium' );
					break;
				case '3':
					$priority = lang( 'high' );
					break;
			};
			$data_newtickets[] = array(
				'id' => $ticket[ 'id' ],
				'subject' => $ticket[ 'subject' ],
				'contactsurname' => $ticket[ 'contactsurname' ],
				'contactname' => $ticket[ 'contactname' ],
				'priority' => $priority,
			);
		};
		echo json_encode( $data_newtickets );
	}

	function transactions() {
		$transactions = $this->Payments_Model->todaypayments();
		$data_transactions = array();
		foreach ( $transactions as $transaction ) {
			switch ( $transaction[ 'transactiontype' ] ) {
				case '0':
					$type = 'paymenttoday';
					break;
				case '1':
					$type = 'expensetoday';
					break;
			};
			switch ( $transaction[ 'transactiontype' ] ) {
				case '0':
					$icon = 'ion-log-in';
					break;
				case '1':
					$icon = 'ion-log-out';
					break;
			};
			switch ( $transaction[ 'transactiontype' ] ) {
				case '0':
					$title = lang( 'paymentistoday' );
					break;
				case '1':
					$title = lang( 'expensetoday' );
					break;
			};
			$data_transactions[] = array(
				'id' => $transaction[ 'id' ],
				'amount' => $transaction[ 'amount' ],
				'type' => $type,
				'title' => $title,
				'icon' => $icon,
			);
		};
		echo json_encode( $data_transactions );
	}

	function logs() {
		$logs = $this->Logs_Model->panel_last_logs();
		$data_logs = array();
		foreach ( $logs as $log ) {
			$data_logs[] = array(
				'logdate' => _adate( $log[ 'date' ] ),
				'date' => tes_ciuis( $log[ 'date' ] ),
				'detail' => $log[ 'detail' ],
				'customer_id' => $log[ 'customer_id' ],
				'project_id' => $log[ 'project_id' ],
				'staff_id' => $log[ 'staff_id' ],
			);
		};
		echo json_encode( $data_logs );
	}
	
	function contacts() {
		$contacts = $this->Contacts_Model->get_all_contacts();
		$data_contacts = array();
		foreach ( $contacts as $contact ) {
			$data_contacts[] = array(
				'id' => $contact[ 'id' ],
				'customer_id' => $contact[ 'customer_id' ],
				'name' => ''.$contact[ 'name' ].' '.$contact[ 'surname' ].'',
				'email' => $contact[ 'email' ],
				'phone' => $contact[ 'phone' ],
				'username' => $contact[ 'username' ],
				'address' => $contact[ 'address' ],
			);
		};
		echo json_encode( $data_contacts );
	}

	function customers() {
		$customers = $this->Customers_Model->get_all_customers();
		$data_customers = array();
		foreach ( $customers as $customer ) {
			switch ( $customer[ 'type' ] ) {
				case '0':
					$name = $customer[ 'company' ];
					$type = lang( 'corporatecustomers' );
					break;
				case '1':
					$name = $customer[ 'namesurname' ];
					$type = lang( 'individual' );
					break;
			};
			$this->db->select_sum( 'total' )->from( 'invoices' )->where( '(status_id = 3 AND customer_id = ' . $customer[ 'id' ] . ') ' );
			$mbb = $this->db->get();
			$contacts = $this->Contacts_Model->get_customer_contacts( $customer['id'] );
			$data_customers[] = array(
				'id' => $customer[ 'id' ],
				'customer_id' => $customer[ 'id' ],
				'name' => $name,
				'address' => $customer[ 'address' ],
				'email' => $customer[ 'email' ],
				'phone' => $customer[ 'phone' ],
				'balance' => $mbb->row()->total,
				'contacts' => $contacts,
				'' . lang( 'filterbytype' ) . '' => $type,
				'' . lang( 'filterbycountry' ) . '' => $customer[ 'country' ],
			);
		};
		echo json_encode( $data_customers );
	}
	
	function customerdetail( $id ) {
		$customer = $this->Customers_Model->get_customers( $id );
		$contacts = $this->Contacts_Model->get_customer_contacts( $id );
		$data_customerdetail = array(
			'id' => $customer[ 'id' ],
			'risk' => $customer[ 'risk' ],
			'contacts' => $contacts,
		);
		echo json_encode( $data_customerdetail );
	}

	function countries() {
		$countries = $this->db->order_by( "id", "asc" )->get( 'countries' )->result_array();
		$data_countries = array();
		foreach ( $countries as $country ) {
			$data_countries[] = array(
				'id' => $country[ 'id' ],
				'shortname' => $country[ 'shortname' ],
				'isocode' => $country[ 'isocode' ],
			);
		};
		echo json_encode( $data_countries );
	}

	function events() {
		$events = $this->Events_Model->get_all_events();
		$data_events = array();
		foreach ( $events as $event ) {
			if ( $event[ 'end' ] < date( " Y-m-d h:i:sa" ) ) {
				$status = 'past';
			} else {
				$status = 'next';
			};
			$data_events[] = array(
				'day' => date( 'D', strtotime( $event[ 'start' ] ) ),
				'aday' => _dDay( $event[ 'start' ] ),
				'start' => _adate( $event[ 'start' ] ),
				'detail' => tes_ciuis( $event[ 'start' ] ),
				'title' => $event[ 'title' ],
				'staff' => $event[ 'staffmembername' ],
				'status' => $status,
			);
		};
		echo json_encode( $data_events );
	}

	function todos() {
		$todos = $this->Trivia_Model->get_todos();
		$data_todo = array();
		foreach ( $todos as $todo ) {
			$data_todo[] = array(
				'id' => $todo[ 'id' ],
				'date' => _adate( $todo[ 'date' ] ),
				'description' => $todo[ 'description' ],
			);
		};
		echo json_encode( $data_todo );
	}

	function donetodos() {
		$donetodos = $this->Trivia_Model->get_done_todos();
		$data_donetodos = array();
		foreach ( $donetodos as $donetodo ) {
			$data_donetodos[] = array(
				'id' => $donetodo[ 'id' ],
				'date' => _adate( $donetodo[ 'date' ] ),
				'description' => $donetodo[ 'description' ],
			);
		};
		echo json_encode( $data_donetodos );
	}

	function accounts() {
		$accounts = $this->Accounts_Model->get_all_accounts();
		$data_account = array();
		foreach ( $accounts as $account ) {
			switch ( $account[ 'type' ] ) {
				case '0':
					$icon = 'mdi mdi-balance-wallet';
					break;
				case '1':
					$icon = 'mdi mdi-balance';
					break;
			};
			switch ( $account[ 'status_id' ] ) {
				case '0':
					$status = lang( 'accuntactive' );
					break;
				case '0':
					$status = lang( 'accuntnotactive' );
					break;
			};
			$data_account[] = array(
				'id' => $account[ 'id' ],
				'name' => $account[ 'name' ],
				'amount' => $data = $amountby = $this->Report_Model->get_account_amount( $account[ 'id' ] ),
				'icon' => $icon,
				'status' => $status,
			);
		};
		echo json_encode( $data_account );
	}

	function leads() {
		if ( !if_admin ) {
			$leads = $this->Leads_Model->get_all_leads_for_admin();
		} else {
			$leads = $this->Leads_Model->get_all_leads();
		};
		$data_leads = array();
		foreach ( $leads as $lead ) {
			$data_leads[] = array(
				'id' => $lead[ 'id' ],
				'name' => $lead[ 'leadname' ],
				'company' => $lead[ 'company' ],
				'phone' => $lead[ 'leadphone' ],
				'color' => $lead[ 'color' ],
				'status' => $lead[ 'status' ],
				'statusname' => $lead[ 'statusname' ],
				'source' => $lead[ 'source' ],
				'sourcename' => $lead[ 'sourcename' ],
				'assigned' => $lead[ 'leadassigned' ],
				'avatar' => $lead[ 'assignedavatar' ],
				'staff' => $lead[ 'staff_id' ],
				'createddate' => $lead[ 'created' ],
				'' . lang( 'filterbystatus' ) . '' => $lead[ 'statusname' ],
				'' . lang( 'filterbysource' ) . '' => $lead[ 'sourcename' ],
			);
		};
		echo json_encode( $data_leads );
	}

	function leadstatuses() {
		$leadstatuses = $this->Leads_Model->get_leads_status();
		echo json_encode( $leadstatuses );
	}

	function products() {
		$products = $this->Products_Model->get_all_products();
		$settings = $this->Settings_Model->get_settings_ciuis();
		$data_products = array();
		foreach ( $products as $product ) {
			switch ( $settings[ 'unitseparator' ] ) {
				case ',':
					$sale_price = number_format( $product[ 'sale_price' ], 2, ',', '.' );
					$purchase_price = number_format( $product[ 'purchase_price' ], 2, ',', '.' );
					$product_vat = number_format( $product[ 'vat' ], 2, ',', '.' );
					break;
				case '.':
					$sale_price = number_format( $product[ 'sale_price' ], 2, '.', ',' );
					$purchase_price = number_format( $product[ 'purchase_price' ], 2, '.', ',' );
					$product_vat = number_format( $product[ 'vat' ], 2, '.', ',' );
					break;
			}
			$data_products[] = array(
				'id' => $product[ 'id' ],
				'value' => $product[ 'id' ],
				'label' => $product[ 'productname' ],
				'description' => $product[ 'description' ],
				'sale_price' => $sale_price,
				'purchase_price' => $purchase_price,
				'vat' => $product_vat,
			);
		};
		echo json_encode( $data_products );
	}

}