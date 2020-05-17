<?php include_once(APPPATH . 'views/inc/header.php'); ?>
<div class="ciuis-body-content">
	<div class="main-content container-fluid col-md-9">
		<div class="row full-calendar">
			<div class="col-md-12">
				<div class="panel panel-default panel-fullcalendar borderten">
					<div class="panel-body">
						<div id="calendar"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="fullCalModal" class="modal fade">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span> <span class="sr-only"><?php echo lang('close')?></span></button>
					<h4 id="modalTitle" class="modal-title text-bold"></h4>
				</div>
				<div id="modalBody" class="modal-body">
					<p id="eventdetail"></p>
					<div class="pull-right">
					
					</div>
				</div>
				<div class="modal-footer">
					<div class="ticket-data user-avatar pull-left">
						<b id="staffname"></b>
						<span id="startdate"></span>
						<span id="enddate"></span>
					</div>
					<button type="button" class="btn btn-default" data-dismiss="modal">
						<?php echo lang('close')?>
					</button>
					<button class="btn btn-default"><a id="eventUrl" target="_blank"><?php echo lang('delete')?></a></button>
				</div>
			</div>
		</div>
	</div>
	<?php include_once(APPPATH . 'views/inc/sidebar.php'); ?>
	</div>
<?php include_once( APPPATH . 'views/inc/footer.php' );?>
<script src="<?php echo base_url(); ?>assets/lib/moment.js/min/moment.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/lib/jquery.fullcalendar/fullcalendar.min.js" type="text/javascript"></script>
<script src='<?php echo base_url(); ?>assets/lib/jquery.fullcalendar/lang-all.js'></script>
<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>assets/lib/jquery.fullcalendar/fullcalendar.min.css"/>

<script type="text/javascript">
	$( document ).ready( function () {
		//initialize the javascript
		App.init();
		App.pageCalendar();
	} );
</script>
<script>
	var App = ( function () {
		'use strict';
		App.pageCalendar = function () {
			$( '#external-events .fc-event' ).each( function () {
				// store data so the calendar knows to render an event upon drop
				$( this ).data( 'event', {
					title: $.trim( $( this ).text() ), // use the element's text as the event title
					stick: true // maintain when user navigates (see docs on the renderEvent method)
				} );
				// make the event draggable using jQuery UI
				$( this ).draggable( {
					zIndex: 999,
					revert: true, // will cause the event to go back to its
					revertDuration: 0 //  original position after the drag
				} );
			} );
			$.post( '<?php echo base_url('calendar/get_Events');?>',
				function ( data ) {
					//alert(data); 
					$( '#calendar' ).fullCalendar( {
						lang: '<?php echo lang('calendarlanguage'); ?>',
						header: {
							left: 'title',
							center: '',
							right: 'month,agendaWeek,agendaDay, today, prev,next',
						},
						eventClick: function ( event, jsEvent, view ) {
							$( '#modalTitle' ).html( event.title );
							$( '#eventdetail' ).html( event.activitydetail );
							$( '#staffname' ).html( event.stafname );
							$( '#startdate' ).html( event.start );
							$( '#enddate' ).html( event.end );
							$( '#eventUrl' ).attr( 'href', '<?php echo base_url('calendar/remove/')?>' + event.id );
							$( '#fullCalModal' ).modal();
						},
						defaultDate: new Date(),
						editable: true,
						eventLimit: true,
						droppable: true, // this allows things to be dropped onto the calendar
						drop: function () {
							// is the "remove after drop" checkbox checked?
							if ( $( '#drop-remove' ).is( ':checked' ) ) {
								// if so, remove the element from the "Draggable Events" list
								$( this ).remove();
							}
						},
						events: $.parseJSON( data )
					} );
				} );

		};
		return App;
	} )( App || {} );
</script> 
</body> 
</html>