// Generate a password string
function randString(id) {
	"use strict";
	var dataSet = $(id).attr('data-character-set').split(',');
	var possible = '';
	if ($.inArray('a-z', dataSet) >= 0) {
		possible += 'abcdefghijklmnopqrstuvwxyz';
	}
	if ($.inArray('A-Z', dataSet) >= 0) {
		possible += 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	}
	if ($.inArray('0-9', dataSet) >= 0) {
		possible += '0123456789';
	}
	if ($.inArray('#', dataSet) >= 0) {
		possible += '![]{}()%&*$#^<>~@|';
	}
	var text = '';
	for (var i = 0; i < $(id).attr('data-size'); i++) {
		text += possible.charAt(Math.floor(Math.random() * possible.length));
	}
	return text;
}
// Create a new password on page load
$('input[rel="gp"]').each(function () {
	"use strict";
	$(this).val(randString($(this)));
});

// Create a new password
$(".getNewPass").click(function () {
	"use strict";
	var field = $(this).closest('div').find('input[rel="gp"]');
	field.val(randString(field));
});

// Auto Select Pass On Focus
$('input[rel="gp"]').on("click", function () {
	"use strict";
	$(this).select();
});

function valueChanged() {
	"use strict";
	if ($('.primary-check').is(":checked"))
		$(".password-input").show();
	else
		$(".password-input").hide();
}

$(".mark-as-btw").click(function () {
	"use strict";
	var statusid = $(this).parent().data('status');
	var proposal = $(this).parent().data('proposal');
	var statusna = $(this).parent().data('sname');
	$.ajax({
		type: "POST",
		url: BASE_URL + "proposals/markas",
		data: {
			status_id: statusid,
			proposal_id: proposal,
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$.gritter.add({
				title: '<b>' + NTFTITLE + '</b>',
				text: '<b>Marked as' + statusna + '</b>',
				class_name: 'color success'
			});
			$(".p-s-lab").text(statusna);
		}
	});
	return false;
});
$(".mark-as-p").click(function () {
	"use strict";
	var statusid = $(this).parent().data('status');
	var project = $(this).parent().data('project');
	var statusna = $(this).parent().data('sname');
	$.ajax({
		type: "POST",
		url: BASE_URL + "projects/markas",
		data: {
			status_id: statusid,
			project_id: project,
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$.gritter.add({
				title: '<b>' + NTFTITLE + '</b>',
				text: '<b>Project marked as'+' ' + statusna + '</b>',
				class_name: 'color success'
			});
			$(".p-s-lab").text(statusna);
		}
	});
	return false;
});
$(".mark-as-t").click(function () {
	"use strict";
	var statusid = $(this).parent().data('status');
	var ticket = $(this).parent().data('ticket');
	var statusna = $(this).parent().data('sname');
	$.ajax({
		type: "POST",
		url: BASE_URL + "tickets/markas",
		data: {
			status_id: statusid,
			ticket_id: ticket,
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$.gritter.add({
				title: '<b>' + NTFTITLE + '</b>',
				text: '<b>Ticket marked as'+' ' + statusna + '</b>',
				class_name: 'color success'
			});
			$(".label-status").text(statusna);
		}
	});
	return false;
});
$(".create-project").click(function () {
	"use strict";
	var name = $('.pname').val();
	$.ajax({
		type: "POST",
		url: BASE_URL + "projects/create",
		data: {
			name: name,
			description: $('.pdesc').val(),
			customer_id: $('#pcustomer option:selected').val(),
			start: $('.pstart').val(),
			deadline: $('.pdeadline').val(),
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$('#createnew').modal('hide');
		}
	});
	return false;
});
$(".create-project").click(function () {
	"use strict";
	var name = $('.pname').val();
	$.ajax({
		type: "POST",
		url: BASE_URL + "projects/update",
		data: {
			name: name,
			description: $('.pdesc').val(),
			customer_id: $('#pcustomer option:selected').val(),
			start: $('.pstart').val(),
			deadline: $('.pdeadline').val(),
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$('#createnew').modal('hide');
		}
	});
	return false;
});
$(".mark-as-lost-lead").click(function () {
	"use strict";
	var leadid = $(this).parent().data('leadid');
	var markname = $(this).parent().data('markname');
	$.ajax({
		type: "POST",
		url: BASE_URL + "leads/markas_lost",
		data: {
			lead_id: leadid,
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$.gritter.add({
				title: '<b>' + NTFTITLE + '</b>',
				text: '<b>' + LEADMARKEDAS + markname + '</b>',
				class_name: 'color success'
			});
			$(".unmark-as-lost-lead").show();
			$(".mark-as-lost-lead").hide();
			$(".mark-lost").show();
		}
	});
	return false;
});

$(".mark-as-junk-lead").click(function () {
	"use strict";
	var leadid = $(this).parent().data('leadid');
	var markname = $(this).parent().data('markname');
	$.ajax({
		type: "POST",
		url: BASE_URL + "leads/markas_junk",
		data: {
			lead_id: leadid,
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$.gritter.add({
				title: '<b>' + NTFTITLE + '</b>',
				text: '<b>' + LEADMARKEDAS + markname + '</b>',
				class_name: 'color success'
			});
			$(".unmark-as-junk-lead").show();
			$(".mark-as-junk-lead").hide();
			$(".mark-junk").show();
		}
	});
	return false;
});
$(".unmark-as-lost-lead").click(function () {
	"use strict";
	var leadid = $(this).parent().data('leadid');
	var markname = $(this).parent().data('markname');
	$.ajax({
		type: "POST",
		url: BASE_URL + "leads/unmarkas_lost",
		data: {
			lead_id: leadid,
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$.gritter.add({
				title: '<b>' + NTFTITLE + '</b>',
				text: '<b>' + LEADUNMARKEDAS + markname + '</b>',
				class_name: 'color success'
			});
			$(".mark-as-lost-lead").show();
			$(".unmark-as-lost-lead").hide();
			$(".mark-lost").hide();
		}
	});
	return false;
});
$(".unmark-as-junk-lead").click(function () {
	"use strict";
	var leadid = $(this).parent().data('leadid');
	var markname = $(this).parent().data('markname');
	$.ajax({
		type: "POST",
		url: BASE_URL + "leads/unmarkas_junk",
		data: {
			lead_id: leadid,
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$.gritter.add({
				title: '<b>' + NTFTITLE + '</b>',
				text: '<b>' + LEADUNMARKEDAS + markname + '</b>',
				class_name: 'color success'
			});
			$(".mark-as-junk-lead").show();
			$(".unmark-as-junk-lead").hide();
			$(".mark-junk").hide();
		}
	});
	return false;
});

// NOTIFICATION MARK AS READ CUSTOMER
$('.cusmark').click(function () {
	"use strict";
	var contactid = $(this).parent().data('id');
	$.ajax({
		url: BASE_URL + 'customer/markread',
		data: {
			"contact_id": contactid
		},
		type: 'post',
	});
});

$('form').submit(function () {
	"use strict";
	var form = $(this);
	$('.input-money-format').each(function (i) {
		var self = $(this);
		try {
			var v = self.autoNumeric('get');
			self.autoNumeric('destroy');
			self.val(v);
		} catch (err) {
			console.log("Not an autonumeric field: " + self.attr("amount"));
		}
	});
	return true;
});
// LOGO ANIMATION
$('#ciuis-logo-donder').addClass('animated rotateIn'); // Logo Transform
// PAGE FADE SCROLL
$(window).scroll(function () {
	"use strict";
	$(".fadeaway").css("opacity", 1 - $(window).scrollTop() / 150);
});
$(".open-menu").click(function () {
	"use strict";
	$('.vertical-nav-new-ciuis').show();
});
$('#chooseFile').bind('change', function () {
	"use strict";
	var filename = $("#chooseFile").val();
	if (/^\s*$/.test(filename)) {
		$(".file-upload").removeClass('active');
		$("#noFile").text("None Chosen");
	} else {
		$(".file-upload").addClass('active');
		$("#noFile").text(filename.replace("C:\\fakepath\\", ""));
	}
});
$(".lead-settings").click(function () {
	"use strict";
	$(".lead-right-bar").show();
	$(".lead-right-bar").addClass("fadeInLeft");
});
$(".hide-lead-settings").click(function () {
	"use strict";
	$(".lead-right-bar").hide();
	$(".lead-right-bar").addClass("fadeOutRight");
});
$('input[name=type]').change(function () {
	"use strict";
	if (!$(this).is(':checked')) {
		return;
	}
	if ($(this).val() === '0') {
		$('.company').show();
		$('.individual').hide();
	} else if ($(this).val() === '1') {
		$('.company').hide();
		$('.individual').show();
	}
});
$(".add-new-staff-for-project").click(function () {
	"use strict";
	$('#addpeople').modal('show');
});
var $btns = $('.pbtn').click(function () {
	"use strict";
	if (this.id == 'all') {
		$('#ciuisprojectcard > div').fadeIn(450);
	} else {
		var $el = $('.' + this.id).fadeIn(450);
		$('#ciuisprojectcard > div').not($el).hide();
	}
	$btns.removeClass('active');
	$(this).addClass('active');
});
$(".delete-note").click(function () {
	"use strict";
	var base_url = BASE_URL;
	var noteid = $(this).parent().data('id');
	var $div = $(this).closest('div.note-data');
	$.ajax({
		type: "POST",
		url: base_url + "trivia/removenote",
		data: {
			notes: noteid
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$.gritter.add({
				title: '<b>' + NTFTITLE + '</b>',
				text: 'Note Deleted',
				position: 'bottom',
				class_name: 'color warning',
			});
			$div.find('li').fadeOut(1000, function () {
				$div.remove();
			});
		}
	});
	return false;
});
$(".add-note-button").click(function () {
	"use strict";
	$.ajax({
		type: "POST",
		url: BASE_URL + "trivia/addnote",
		data: {
			description: $(".note-description").val(),
			relation: $(".note-relation-id").val(),
			relation_type: $(".note-type").val(),
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			var noteid = data.insert_id;
			$('.show-notes').append('<article ng-repeat="note in projectnotes" class="ciuis-note-detail"> <div class="ciuis-note-detail-img"> <img src="https://cdn1.iconfinder.com/data/icons/hawcons/32/699035-icon-47-note-important-128.png" alt="" width="50" height="50"> </div> <div class="ciuis-note-detail-body"> <div class="text"> <p><span>' + $('.note-description').val() + '</span> <a ng-click="DeleteNote($index)" style="cursor: pointer;" class="mdi ion-trash-b pull-right delete-note-button"></a> </p> </div> <p class="attribution"> by <strong><a href="' + BASE_URL + '/staff/staffmember/' + LOGGEDINSTAFFID + '">' + LOGGEDINSTAFFNAME + '</a></strong> at <span>' + TODAYDATE + '</span> </p> </div> </article>');
			$('.note-description').val('');
		}
	});
	return false;
});
$(".add-reminder").click(function () {
	"use strict";
	$('.reminder-table').hide();
	$('.reminder-form').show();
});
$(".reminder-cancel").click(function () {
	"use strict";
	$('.reminder-form').hide();
	$('.reminder-table').show();
});
$(".delete-reminder").click(function () {
	"use strict";
	var reminder = $(this).data('reminder');
	$.ajax({
		type: "POST",
		url: BASE_URL + "trivia/removereminder",
		data: {
			reminder: reminder
		},
		dataType: "text",
		cache: false,
		success: function (data) {
			$('.reminder-' + reminder + '').remove();
		}
	});
	return false;
});

//Hidden Items

$('.add-file-cover').hide();
$('.add-payment-form').hide();

// Hidden Items

$('.add-payment').click(function () {
	"use strict";
	$('.add-payment-form').show();
});
$('.cancel-payment').click(function () {
	"use strict";
	$('.add-payment-form').hide();
});

$(document).on('click', function (e) {
	"use strict";
	if ($(e.target).closest('.add-file').length) {
		$(".add-file-cover").show();
	} else if (!$(e.target).closest('.add-file-cover').length) {
		$('.add-file-cover').hide();
	}
});
$('.form-field-file').each(function () {
	"use strict";
	var label = $('label', this);
	var labelValue = $(label).html();
	var fileInput = $('input[type="file"]', this);

	$(fileInput).on('change', function () {
		var fileName = $(this).val().split('\\').pop();
		if (fileName) {
			$(label).html(fileName);
		} else {
			$(label).html(labelValue);
		}
	});

});
$('#relation_type').change(function () {
	"use strict";
	if ($(this).val() === 'customer') {
		$('.customer-select').show();
		$('.lead-select').hide();
		$('.relationer').val($(this).val());
	}
});
$('#relation_type').change(function () {
	"use strict";
	if ($(this).val() === 'lead') {
		$('.customer-select').hide();
		$('.lead-select').show();
		$('.relationer').val($(this).val());
	}
});
$(document).ready(function () {
	"use strict";
	$('input[name=type]').change(function () {
		if (!$(this).is(':checked')) {
			return;
		}
		if ($(this).val() === '0') {
			$('.bank').hide();
		} else if ($(this).val() === '1') {
			$('.bank').show();
		}
	});
});