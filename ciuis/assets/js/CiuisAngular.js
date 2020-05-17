var CiuisCRM = angular.module('Ciuis', ['Ciuis.datepicker', 'ngMaterial']);

function Ciuis_Controller($scope, $http) {
	"use strict";
	$scope.date = new Date();

	$http.get(BASE_URL + 'api/settings').then(function (Settings) {
		$scope.settings = Settings.data;
	});

	$http.get(BASE_URL + 'api/menu').then(function (Navbar) {
		$scope.navbar = Navbar.data;
	});

	$http.get(BASE_URL + 'api/user/' + ACTIVESTAFF).then(function (UserData) {
		$scope.user = UserData.data;
	});

	$http.get(BASE_URL + 'api/projects').then(function (Projects) {
		$scope.projects = Projects.data;
	});

	$http.get(BASE_URL + 'api/staff').then(function (Staff) {
		$scope.staff = Staff.data;
	});

	$http.get(BASE_URL + 'api/stats').then(function (Stats) {
		$scope.stats = Stats.data;
	});

	$http.get(BASE_URL + 'api/events').then(function (Events) {
		$scope.events = Events.data;
	});

	$http.get(BASE_URL + 'api/transactions').then(function (Transactions) {
		$scope.transactions = Transactions.data;
	});

	$http.get(BASE_URL + 'api/dueinvoices').then(function (Dueinvoices) {
		$scope.dueinvoices = Dueinvoices.data;
	});

	$http.get(BASE_URL + 'api/overdueinvoices').then(function (Overdueinvoices) {
		$scope.overdueinvoices = Overdueinvoices.data;
	});

	$http.get(BASE_URL + 'api/newtickets').then(function (Newtickets) {
		$scope.newtickets = Newtickets.data;
	});

	$http.get(BASE_URL + 'api/notifications').then(function (Notifications) {
		$scope.notifications = Notifications.data;
	});

	$http.get(BASE_URL + 'api/logs').then(function (Logs) {
		$scope.logs = Logs.data;
	});

	$http.get(BASE_URL + 'api/todos').then(function (Todos) {
		$scope.todos = Todos.data;
	});

	$http.get(BASE_URL + 'api/donetodos').then(function (Donetodos) {
		$scope.tododone = Donetodos.data;
	});

	$http.get(BASE_URL + 'api/reminders').then(function (Reminders) {
		$scope.reminders = Reminders.data;
	});

	$http.get(BASE_URL + 'api/countries').then(function (Countries) {
		$scope.countries = Countries.data;
	});

	$http.get(BASE_URL + 'api/customers').then(function (Customers) {
		$scope.all_customers = Customers.data;
	});

	$http.get(BASE_URL + 'api/contacts').then(function (Contacts) {
		$scope.all_contacts = Contacts.data;
	});

	$http.get(BASE_URL + 'api/departments').then(function (Departments) {
		$scope.departments = Departments.data;
	});
	
	$scope.activestaff = ACTIVESTAFF;

	angular.element(document).ready(function () {

		$('#ciuisloader').hide();
		$(document).ready(function () {
			App.init();
			App.formElements();
		});
		// AUTO NUMERIC MONEY FORMATTER
		// MONEY FORMAT TYPE SETTINGS
		$(".money-area").autoNumeric('init', {
			aSep: ASEP,
			aDec: ADEC,
			aPad: 2,
			aSign: CURRENCY,
			pSign: CPOSITION,
		});
		// AUTONUMERIC MONEY FORMAT
		$(".input-money-format").autoNumeric('init', {
			aSep: ASEP,
			aDec: ADEC,
			aPad: 2
		});

		var milestone_projectExpandablemilestonetitle = $('.milestone_project-action.is-expandable .milestonetitle');
		$(milestone_projectExpandablemilestonetitle).attr('tabindex', '0');
		// Give milestone_projects ID's
		$('.milestone_project').each(function (i, $milestone_project) {
			var $milestone_projectActions = $($milestone_project).find('.milestone_project-action.is-expandable');
			$($milestone_projectActions).each(function (j, $milestone_projectAction) {
				var $milestoneContent = $($milestone_projectAction).find('.content');
				$($milestoneContent).attr('id', 'milestone_project-' + i + '-milestone-content-' + j).attr('role', 'region');
				$($milestoneContent).attr('aria-expanded', $($milestone_projectAction).hasClass('expanded'));
				$($milestone_projectAction).find('.milestonetitle').attr('aria-controls', 'milestone_project-' + i + '-milestone-content-' + j);
			});
		});
		$(milestone_projectExpandablemilestonetitle).click(function () {
			$(this).parent().toggleClass('is-expanded');
			$(this).siblings('.content').attr('aria-expanded', $(this).parent().hasClass('is-expanded'));
		});
		// Expand or navigate back and forth between sections
		$(milestone_projectExpandablemilestonetitle).keyup(function (e) {
			if (e.which === 13) { //Enter key pressed
				$(this).click();
			} else if (e.which === 37 || e.which === 38) { // Left or Up
				$(this).closest('.milestone_project-milestone').prev('.milestone_project-milestone').find('.milestone_project-action .milestonetitle').focus();
			} else if (e.which === 39 || e.which === 40) { // Right or Down
				$(this).closest('.milestone_project-milestone').next('.milestone_project-milestone').find('.milestone_project-action .milestonetitle').focus();
			}
		});
	});

	$scope.AddEvent = function () {
		$('#addevent').modal();
	};

	$scope.PostEventForm = function () {
		var dataObj = $.param({
			title: $scope.title,
			public: $scope.public,
			detail: $scope.detail,
			eventstart: $scope.eventstart,
			eventend: $scope.eventend,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'calendar/addevent';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					console.log(response);
					$('#addevent').modal('hide');
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: EVENTADDEDMSG,
						position: 'bottom',
						class_name: 'color success',
					});
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.AddTodo = function () {
		var dataObj = $.param({
			tododetail: $scope.tododetail,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'trivia/addtodo';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					console.log(response);
					$scope.todos.push({
						'description': $scope.tododetail,
						'date': 'Right Now',
					});
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: TODOADDEDMSG,
						position: 'bottom',
						class_name: 'color success',
					});
					$('input[type="text"],textarea').val('');
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.DeleteTodo = function (index) {
		var todo = $scope.todos[index];
		var dataObj = $.param({
			todo: todo['id'],
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'trivia/removetodo';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					$scope.todos.splice($scope.todos.indexOf(todo), 1);
					console.log(response);
				},
				function (response) {
					console.log(response);
				}
			);
	};
	$scope.TodoAsUnDone = function (index) {
		var todo = $scope.tododone[index];
		var dataObj = $.param({
			todo: todo['id'],
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		$http.post(BASE_URL + 'trivia/undonetodo', dataObj, config)
			.then(
				function (response) {
					var todo = $scope.tododone[index];
					$scope.tododone.splice($scope.tododone.indexOf(todo), 1);
					$scope.todos.unshift(todo);
					console.log(response);
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.TodoAsDone = function (index) {
		var todo = $scope.todos[index];
		var dataObj = $.param({
			todo: todo['id'],
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		$http.post(BASE_URL + 'trivia/donetodo', dataObj, config)
			.then(
				function (response) {
					var todo = $scope.todos[index];
					$scope.todos.splice($scope.todos.indexOf(todo), 1);
					$scope.tododone.unshift(todo);
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: TODODONEMSG,
						position: 'bottom',
						class_name: 'color success',
					});
					console.log(response);
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.ReminderRead = function (index) {
		var reminder = $scope.reminders[index];
		var dataObj = $.param({
			reminder_id: reminder['id'],
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'trivia/markreadreminder';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					$scope.reminders.splice($scope.reminders.indexOf(reminder), 1);
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: REMINDERREAD,
						class_name: 'color success'
					});
					console.log(response);
				},
				function (response) {
					console.log(response);
				}
			);
	};


	$scope.InvoiceCancel = function (e) {
		var id = $(e.target).data('invoice');
		var dataObj = $.param({
			status_id: 4,
			invoice_id: id,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'invoices/cancelled';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: INVMARKCACELLED,
						class_name: 'color danger'
					});
					$('.toggle-due').hide();
					$('.toggle-cash').hide();
					$('.cancelledinvoicealert').show();
					console.log(response);
				},
				function (response) {
					console.log(response);
				}
			);
	};
	
	$scope.NotificationRead = function (index) {
		var notification = $scope.notifications[index];
		var dataObj = $.param({
			notification: notification['id'],
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'notifications/markread';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					console.log(response);
				},
				function (response) {
					console.log(response);
				}
			);
	};
	
	
	$scope.ticketstatuses = [{
		code: 1,
		name: 'OPEN'
	}, {
		code: 2,
		name: 'IN PROGRESS'
	}, {
		code: 3,
		name: 'ANSWERED'
	}, {
		code: 4,
		name: 'CLOSED'
	}];

	$scope.ChangeTicketStatus = function () {
		var dataObj = $.param({
			statusid: $scope.item.code,
			ticketid: $(".tickid").val(),
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		$http.post(BASE_URL + 'tickets/chancestatus', dataObj, config)
			.then(
				function (response) {
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: TICKSTATUSCHANGE,
						class_name: 'color success'
					});
					$(".label-status").text($scope.item.name);
					console.log(response);
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.AddProject = function () {
		var dataObj = $.param({
			name: $scope.pname,
			description: $scope.pdescription,
			customer: $scope.pcustomer,
			start: $scope.pstart,
			deadline: $scope.pdeadline,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'projects/create';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					console.log(response);
					$('#createnew').modal('hide');
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.AddProjectMember = function () {
		var selectedstaffmember = $('#newmember option:selected').val(); // Dont Forger This Function -- User every select2
		var dataObj = $.param({
			staff: selectedstaffmember,
			project: PROJECTID,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		var posturl = BASE_URL + 'projects/addmember';
		$http.post(posturl, dataObj, config)
			.then(
				function (response) {
					console.log(response);
					$('#addpeople').modal('hide');
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: 'Staff added reflesh page',
						class_name: 'color success'
					});
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.appurl = BASE_URL;
	$scope.UPIMGURL = UPIMGURL;
	$scope.IMAGESURL = IMAGESURL;
	$scope.SETFILEURL = SETFILEURL;
	$scope.ONLYADMIN = SHOW_ONLY_ADMIN;
	$http.get(BASE_URL + 'api/leftmenu').then(function (LeftMenu) {
		$scope.menu = LeftMenu.data;
	});
}

function Leads_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/leads').then(function (Leads) {
		$scope.leads = Leads.data;
		// Filtered Datas
		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			return ($scope.leads || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};
		$scope.FilteredData = function (item) {
			// Use this snippet for matching with AND
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;
		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		// Filtered Datas
		$scope.search = {
			name: '',
			statusname: ''
		};
		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
			var ps = [];
			var start;

			start = $scope.currentPage;
			//  console.log($scope.pageCount(),$scope.currentPage)
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}

			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};

		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};

		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};

		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};

		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};

		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};

		$scope.pageCount = function () {
			return Math.ceil($scope.leads.length / $scope.itemsPerPage) - 1;
		};
	});

	$http.get(BASE_URL + 'api/leadstatuses').then(function (LeadStatuses) {
		$scope.leadstatuses = LeadStatuses.data;
	});
}

function Lead_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/notes/lead/' + LEADID).then(function (Notes) {
		$scope.notes = Notes.data;
		$scope.DeleteNote = function (index) {
			var note = $scope.notes[index];
			var dataObj = $.param({
				notes: note['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'trivia/removenote';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.notes.splice($scope.notes.indexOf(note), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});
}

function Accounts_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/accounts').then(function (Accounts) {
		$scope.accounts = Accounts.data;
	});
}

function Project_Controller($scope, $http, $filter) {
	"use strict";
	$http.get(BASE_URL + 'api/projectdetail/' + PROJECTID).then(function (Project) {
		$scope.project = Project.data;
		$scope.projectmembers = $scope.project.members;
		$scope.UnlinkMember = function (index) {
			var link = $scope.projectmembers[index];
			var linkid = link['id'];
			var dataObj = $.param({
				linkid: linkid
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			$http.post(BASE_URL + 'projects/unlinkmember/' + linkid, dataObj, config)
				.then(
					function (response) {
						$scope.projectmembers.splice($scope.projectmembers.indexOf(link), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};
		$scope.DeleteFile = function (index) {
			var file = $scope.files[index];
			var dataObj = $.param({
				fileid: file['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'projects/deletefile';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.files.splice($scope.files.indexOf(file), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};

	});
	$http.get(BASE_URL + 'api/projecttasks/' + PROJECTID).then(function (ProjectTasks) {
		$scope.projecttasks = ProjectTasks.data;
	});

	$http.get(BASE_URL + 'api/projectmilestones/' + PROJECTID).then(function (Milestones) {
		$scope.milestones = Milestones.data;


		$scope.AddMilestone = function () {
			var dataObj = $.param({
				order: $scope.milestoneorder,
				name: $scope.milestonename,
				description: $scope.milestonedescription,
				duedate: $scope.milestoneduedate,
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'projects/addmilestone/' + PROJECTID;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$scope.milestones.push({
							'order': $scope.milestoneorder,
							'name': $scope.milestonename,
							'duedate': $scope.milestoneduedate,
						});
						$.gritter.add({
							title: '<b>' + NTFTITLE + '</b>',
							text: 'Milestone added',
							position: 'bottom',
							class_name: 'color success',
						});
						$('#newmilestone').modal('hide');
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.UpdateMilestone = function (index) {
			var milestone = $scope.milestones[index];
			var milestone_id = milestone['id'];
			$scope.milestone = milestone;
			var dataObj = $.param({
				order: $scope.milestone.order,
				name: $scope.milestone.name,
				description: $scope.milestone.description,
				duedate: $scope.milestone.duedate,
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'projects/updatemilestone/' + milestone_id;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$('#updatemilestone' + milestone_id + '').modal('hide');
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.RemoveMilestone = function (index) {
			var milestone = $scope.milestones[index];
			var dataObj = $.param({
				milestone: milestone['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'projects/removemilestone';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.milestones.splice($scope.milestones.indexOf(milestone), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};

	});

	$http.get(BASE_URL + 'api/notes/project/' + PROJECTID).then(function (Notes) {
		$scope.notes = Notes.data;
		$scope.DeleteNote = function (index) {
			var note = $scope.notes[index];
			var dataObj = $.param({
				notes: note['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'trivia/removenote';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.notes.splice($scope.notes.indexOf(note), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});
	
	$http.get(BASE_URL + 'api/expenses_by_relation/project/' + PROJECTID).then(function (Expenses) {
		$scope.expenses = Expenses.data;
		$scope.TotalExpenses = function(){
			return $scope.expenses.reduce(function(total,expense){
				return total + (expense.amount * 1 || 0);
			},0);
		};

		$scope.billedexpenses = $filter('filter')($scope.expenses, { billstatus_code: "true" });
		$scope.BilledExpensesTotal = function(){
			return $scope.billedexpenses.reduce(function(total,expense){
				return total + (expense.amount * 1 || 0);
			},0);
		};
		
		$scope.unbilledexpenses = $filter('filter')($scope.expenses, { billstatus_code: "false" });
		$scope.UnBilledExpensesTotal = function(){
			return $scope.unbilledexpenses.reduce(function(total,expense){
				return total + (expense.amount * 1 || 0);
			},0);
		};
		
	});
	
	$http.get(BASE_URL + 'api/projecttimelogs/' + PROJECTID).then(function (TimeLogs) {
		$scope.timelogs = TimeLogs.data;
		$scope.getTotal = function () {
			var TotalTime = 0;
			for (var i = 0; i < $scope.timelogs.length; i++) {
				var timelog = $scope.timelogs[i];
				TotalTime += (timelog.timed);
			}
			return TotalTime;
		};
		$scope.ProjectTotalAmount = function () {
			var TotalAmount = 0;
			for (var i = 0; i < $scope.timelogs.length; i++) {
				var timelog = $scope.timelogs[i];
				TotalAmount += (timelog.amount);
			}
			return TotalAmount;
		};
	});

	$http.get(BASE_URL + 'api/projectfiles/' + PROJECTID).then(function (Files) {
		$scope.files = Files.data;
	});
	
	$http.get(BASE_URL + 'api/accounts').then(function (Accounts) {
		$scope.accounts = Accounts.data;
	});

	$http.get(BASE_URL + 'api/expensescategories').then(function (Epxensescategories) {
		$scope.expensescategories = Epxensescategories.data;
	});
}

function Customers_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/customers').then(function (Customers) {
		$scope.customers = Customers.data;
		// Filtered Datas
		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			return ($scope.customers || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};
		$scope.FilteredData = function (item) {
			// Use this snippet for matching with AND
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;

		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		$scope.updateDropdown = function (_prop) {
			var _opt = this.filter_select,
				_optList = this.getOptionsFor(_prop),
				len = _optList.length;

			if (_opt == 'all') {
				for (var j = 0; j < len; j++) {
					$scope.filter[_prop][_optList[j]] = true;
				}
			} else {
				for (var j = 0; j < len; j++) {
					$scope.filter[_prop][_optList[j]] = false;
				}
				$scope.filter[_prop][_opt] = true;
			}
		};
		// Filtered Datas
		$scope.search = {
			name: '',
		};
		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
			var ps = [];
			var start;

			start = $scope.currentPage;
			//  console.log($scope.pageCount(),$scope.currentPage)
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}

			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};

		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};

		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};

		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};

		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};

		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};

		$scope.pageCount = function () {
			return Math.ceil($scope.customers.length / $scope.itemsPerPage) - 1;
		};
	});
}

function Customer_Controller($scope, $http) {
	"use strict";

	$http.get(BASE_URL + 'api/customerdetail/' + CUSTOMERID).then(function (Customer) {
		$scope.customer = Customer.data;
		$scope.contacts = $scope.customer.contacts;
		$scope.UpdateContact = function (index) {
			var contact = $scope.contacts[index];
			var contact_id = contact['id'];
			$scope.contact = contact;
			var dataObj = $.param({
				name: $scope.contact.name,
				surname: $scope.contact.surname,
				phone: $scope.contact.phone,
				intercom: $scope.contact.intercom,
				mobile: $scope.contact.mobile,
				email: $scope.contact.email,
				address: $scope.contact.address,
				skype: $scope.contact.skype,
				linkedin: $scope.contact.linkedin,
				position: $scope.contact.position,
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'customers/updatecontact/' + contact_id;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$('#updatecontact' + contact_id + '').modal('hide');
					},
					function (response) {
						console.log(response);
					}
				);
		};
		$scope.UpdateContactPassword = function (index) {
			var contact = $scope.contacts[index];
			var contact_id = contact['id'];
			$scope.contact = contact;
			var dataObj = $.param({
				password: $scope.contact.newpassword,
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'customers/changecontactpassword/' + contact_id;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$('#changepassword' + contact_id + '').modal('hide');
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});

	$http.get(BASE_URL + 'api/notes/customer/' + CUSTOMERID).then(function (Notes) {
		$scope.notes = Notes.data;
		$scope.DeleteNote = function (index) {
			var note = $scope.notes[index];
			var dataObj = $.param({
				notes: note['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'trivia/removenote';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.notes.splice($scope.notes.indexOf(note), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});
	$scope.EditContactButton = function () {
		$('.contact-detail-modal').modal('hide');
	};
	$scope.DeleteContactButton = function () {
		$('.contact-detail-modal').modal('hide');
	};
	$scope.ChangePasswordButton = function () {
		$('.contact-detail-modal').modal('hide');
	};

}

function Tasks_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/tasks').then(function (Tasks) {
		$scope.tasks = Tasks.data;
		// Filtered Datas
		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			return ($scope.tasks || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};
		$scope.FilteredData = function (item) {
			// Use this snippet for matching with AND
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;

		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		// Filtered Datas
		$scope.search = {
			name: '',
		};
		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
			var ps = [];
			var start;

			start = $scope.currentPage;
			//  console.log($scope.pageCount(),$scope.currentPage)
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}

			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};

		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};

		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};

		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};

		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};

		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};

		$scope.pageCount = function () {
			return Math.ceil($scope.tasks.length / $scope.itemsPerPage) - 1;
		};

	});

	$http.get(BASE_URL + 'api/projects').then(function (Projects) {
		$scope.projects = Projects.data;
	});

	$http.get(BASE_URL + 'api/milestones').then(function (Milestones) {
		$scope.milestones = Milestones.data;
	});
}

function Task_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/taskdetail/' + TASKID).then(function (taskdetail) {
		$scope.taskdetail = taskdetail.data;
	});
	$http.get(BASE_URL + 'api/tasktimelogs/' + TASKID).then(function (TimeLogs) {
		$scope.timelogs = TimeLogs.data;
		$scope.getTotal = function () {
			var total = 0;
			for (var i = 0; i < $scope.timelogs.length; i++) {
				var timelog = $scope.timelogs[i];
				total += (timelog.timed);
			}
			return total;
		};
		$scope.ProjectTotalAmount = function () {
			var total = 0;
			for (var i = 0; i < $scope.timelogs.length; i++) {
				var timelog = $scope.timelogs[i];
				total += (timelog.amount);
			}
			return total;
		};
	});

	$http.get(BASE_URL + 'api/milestones').then(function (Milestones) {
		$scope.milestones = Milestones.data;
	});

	$http.get(BASE_URL + 'api/taskfiles/' + TASKID).then(function (Files) {
		$scope.files = Files.data;
	});

	$scope.title = 'Sub Tasks';

	// Array of uncomplete tasks
	$http.get(BASE_URL + 'api/subtasks/' + TASKID).then(function (Subtasks) {
		$scope.subtasks = Subtasks.data;
		$scope.createTask = function () {
			var dataObj = $.param({
				description: $scope.newTitle,
				taskid: TASKID,
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'tasks/addsubtask';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.subtasks.unshift({
							description: $scope.newTitle,
							date: Date.now()
						});
						$scope.newTitle = '';
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.removeTask = function (index) {
			var subtask = $scope.subtasks[index];
			var dataObj = $.param({
				subtask: subtask['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			$http.post(BASE_URL + 'tasks/removesubtasks', dataObj, config)
				.then(
					function (response) {
						$scope.subtasks.splice($scope.subtasks.indexOf(subtask), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.completeTask = function (index) {
			var subtask = $scope.subtasks[index];
			var dataObj = $.param({
				subtask: subtask['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			$http.post(BASE_URL + 'tasks/completesubtasks', dataObj, config)
				.then(
					function (response) {
						subtask.complete = true;
						$scope.subtasks.splice($scope.subtasks.indexOf(subtask), 1);
						$scope.SubTasksComplete.unshift(subtask);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.uncompleteTask = function (index) {
			var task = $scope.SubTasksComplete[index];
			var dataObj = $.param({
				task: task['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			$http.post(BASE_URL + 'tasks/uncompletesubtasks', dataObj, config)
				.then(
					function (response) {
						var task = $scope.SubTasksComplete[index];
						$scope.SubTasksComplete.splice($scope.SubTasksComplete.indexOf(task), 1);
						$scope.subtasks.unshift(task);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};

	});
	$http.get(BASE_URL + 'api/subtaskscomplete/' + TASKID).then(function (SubTasksComplete) {
		$scope.taskCompletionTotal = function (unit) {
			var total = $scope.taskLength();
			return Math.floor(100 / total * unit);
		};
		$scope.SubTasksComplete = SubTasksComplete.data;
		$scope.taskLength = function () {
			return $scope.subtasks.length + $scope.SubTasksComplete.length;
		};
	});

	$scope.MarkAsCompleteTask = function () {
		var dataObj = $.param({
			task: TASKID,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		$http.post(BASE_URL + 'tasks/markascompletetask', dataObj, config)
			.then(
				function (response) {
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: TASKMARKEDASCOMPLETE,
						class_name: 'color success'
					});
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.MarkAsCancelled = function () {
		var dataObj = $.param({
			task: TASKID,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		$http.post(BASE_URL + 'tasks/markascancelled', dataObj, config)
			.then(
				function (response) {
					$.gritter.add({
						title: '<b>' + NTFTITLE + '</b>',
						text: 'Task marked as cancelled',
						class_name: 'color danger'
					});
				},
				function (response) {
					console.log(response);
				}
			);
	};

	$scope.startTimerforTask = function () {
		var dataObj = $.param({
			task: TASKID,
			project: TASKPROJECT,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		$http.post(BASE_URL + 'tasks/starttimer', dataObj, config)
			.then(
				function (response) {
					$(".start-timer-btn").hide();
					$(".stop-timer-btn").show();
				},
				function (response) {
					console.log(response);
				}
			);
	};
	$scope.stopTimerforTask = function () {
		var dataObj = $.param({
			task: TASKID,
		});
		var config = {
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
			}
		};
		$http.post(BASE_URL + 'tasks/stoptimer', dataObj, config)
			.then(
				function (response) {
					$(".start-timer-btn").show();
					$(".stop-timer-btn").hide();
				},
				function (response) {
					console.log(response);
				}
			);
	};
}

function Expenses_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/expenses').then(function (Expenses) {
		$scope.expenses = Expenses.data;
		$scope.search = {
			name: '',
		};
		// Filtered Datas
		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			return ($scope.expenses || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};
		$scope.FilteredData = function (item) {
			// Use this snippet for matching with AND
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;
		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		// Filtered Datas
		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
			var ps = [];
			var start;

			start = $scope.currentPage;
			//  console.log($scope.pageCount(),$scope.currentPage)
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}

			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};

		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};

		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};

		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};

		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};

		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};

		$scope.pageCount = function () {
			return Math.ceil($scope.expenses.length / $scope.itemsPerPage) - 1;
		};
	});
	
	$http.get(BASE_URL + 'api/accounts').then(function (Accounts) {
		$scope.accounts = Accounts.data;
	});

	$http.get(BASE_URL + 'api/expensescategories').then(function (Epxensescategories) {
		$scope.expensescategories = Epxensescategories.data;

		$scope.UpdateExpenseCategory = function (index) {
			var category = $scope.expensescategories[index];
			var category_id = category['id'];
			$scope.category = category;
			var dataObj = $.param({
				name: $scope.category.name,
				description: $scope.category.description,
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'expenses/editcategory/' + category_id;
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$('#updatecategory' + category_id + '').modal('hide');
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});
}

function Invoices_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/invoices').then(function (Invoices) {
		$scope.invoices = Invoices.data;
		$scope.search = {
			customer: ''
		};
		// Filtered Datas
		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			return ($scope.invoices || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};
		$scope.FilteredData = function (item) {
			// Use this snippet for matching with AND
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;

		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		$scope.updateDropdown = function (_prop) {
				var _opt = this.filter_select,
					_optList = this.getOptionsFor(_prop),
					len = _optList.length;

				if (_opt == 'all') {
					for (var j = 0; j < len; j++) {
						$scope.filter[_prop][_optList[j]] = true;
					}
				} else {
					for (var j = 0; j < len; j++) {
						$scope.filter[_prop][_optList[j]] = false;
					}
					$scope.filter[_prop][_opt] = true;
				}
			}
			// Filtered Datas
		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
			var ps = [];
			var start;

			start = $scope.currentPage;
			//  console.log($scope.pageCount(),$scope.currentPage)
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}

			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};

		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};

		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};

		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};

		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};

		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};

		$scope.pageCount = function () {
			return Math.ceil($scope.invoices.length / $scope.itemsPerPage) - 1;
		};
	});

}

function Invoice_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/invoicedetails/' + INVOICEID).then(function (InvoiceDetails) {
		$scope.invoice = InvoiceDetails.data;
	});

}

function Proposals_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/proposals').then(function (Proposals) {
		$scope.proposals = Proposals.data;
		$scope.search = {
			subject: '',
		};
		// Filtered Datas
		$scope.filter = {};
		$scope.getOptionsFor = function (propName) {
			return ($scope.proposals || []).map(function (item) {
				return item[propName];
			}).filter(function (item, idx, arr) {
				return arr.indexOf(item) === idx;
			}).sort();
		};
		$scope.FilteredData = function (item) {
			// Use this snippet for matching with AND
			var matchesAND = true;
			for (var prop in $scope.filter) {
				if (noSubFilter($scope.filter[prop])) {
					continue;
				}
				if (!$scope.filter[prop][item[prop]]) {
					matchesAND = false;
					break;
				}
			}
			return matchesAND;

		};

		function noSubFilter(subFilterObj) {
			for (var key in subFilterObj) {
				if (subFilterObj[key]) {
					return false;
				}
			}
			return true;
		}
		$scope.updateDropdown = function (_prop) {
				var _opt = this.filter_select,
					_optList = this.getOptionsFor(_prop),
					len = _optList.length;

				if (_opt == 'all') {
					for (var j = 0; j < len; j++) {
						$scope.filter[_prop][_optList[j]] = true;
					}
				} else {
					for (var j = 0; j < len; j++) {
						$scope.filter[_prop][_optList[j]] = false;
					}
					$scope.filter[_prop][_opt] = true;
				}
			}
			// Filtered Datas
		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
			var ps = [];
			var start;

			start = $scope.currentPage;
			//  console.log($scope.pageCount(),$scope.currentPage)
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}

			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};

		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};

		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};

		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};

		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};

		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};

		$scope.pageCount = function () {
			return Math.ceil($scope.proposals.length / $scope.itemsPerPage) - 1;
		};
	});

}

function Proposal_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/products').then(function (Products) {
		$scope.products = Products.data;
	});
	$http.get(BASE_URL + 'api/notes/proposal/' + PROPOSALID).then(function (Notes) {
		$scope.notes = Notes.data;
		$scope.DeleteNote = function (index) {
			var note = $scope.notes[index];
			var dataObj = $.param({
				notes: note['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'trivia/removenote';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.notes.splice($scope.notes.indexOf(note), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};
	});
}

function Projects_Controller($scope, $http) {
	"use strict";

	$http.get(BASE_URL + 'api/projects').then(function (Projects) {
		$scope.projects = Projects.data;

		$scope.pinnedprojects = Projects.data;

		$scope.CheckPinned = function (index) {
			var project = $scope.projects[index];
			var dataObj = $.param({
				project: project['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			$http.post(BASE_URL + 'projects/checkpinned', dataObj, config)
				.then(
					function (response) {
						console.log(response);
						$.gritter.add({
							title: '<b>' + NTFTITLE + '</b>',
							text: 'Project pinned',
							class_name: 'color success'
						});
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.UnPinned = function (index) {
			var pinnedproject = $scope.pinnedprojects[index];
			var dataObj = $.param({
				pinnedproject: pinnedproject['id'],
			});
			var config = {
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded;charset=utf-8;'
				}
			};
			var posturl = BASE_URL + 'projects/unpinned';
			$http.post(posturl, dataObj, config)
				.then(
					function (response) {
						$scope.pinnedprojects.splice($scope.pinnedprojects.indexOf(pinnedproject), 1);
						console.log(response);
					},
					function (response) {
						console.log(response);
					}
				);
		};

		$scope.itemsPerPage = 6;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 6;
			var ps = [];
			var start;

			start = $scope.currentPage;
			//  console.log($scope.pageCount(),$scope.currentPage)
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}

			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};

		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};

		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};

		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};

		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};

		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};

		$scope.pageCount = function () {
			return Math.ceil($scope.projects.length / $scope.itemsPerPage) - 1;
		};
	});
}

function Tickets_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/tickets').then(function (Tickets) {
		$scope.tickets = Tickets.data;
		$scope.search = {
			subject: '',
			message: ''
		};
	});

	$http.get(BASE_URL + 'api/customers').then(function (Customers) {
		$scope.customers = Customers.data;
	});

	$http.get(BASE_URL + 'api/contacts').then(function (Contacts) {
		$scope.contacts = Contacts.data;
	});
}

function Ticket_Controller($scope, $http) {
	"use strict";

	$http.get(BASE_URL + 'api/customers').then(function (Customers) {
		$scope.customers = Customers.data;
	});

	$http.get(BASE_URL + 'api/contacts').then(function (Contacts) {
		$scope.contacts = Contacts.data;
	});
}

function Products_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'api/products').then(function (Products) {
		$scope.products = Products.data;
		$scope.itemsPerPage = 5;
		$scope.currentPage = 0;
		$scope.range = function () {
			var rangeSize = 5;
			var ps = [];
			var start;

			start = $scope.currentPage;
			//  console.log($scope.pageCount(),$scope.currentPage)
			if (start > $scope.pageCount() - rangeSize) {
				start = $scope.pageCount() - rangeSize + 1;
			}

			for (var i = start; i < start + rangeSize; i++) {
				if (i >= 0) {
					ps.push(i);
				}
			}
			return ps;
		};

		$scope.prevPage = function () {
			if ($scope.currentPage > 0) {
				$scope.currentPage--;
			}
		};

		$scope.DisablePrevPage = function () {
			return $scope.currentPage === 0 ? "disabled" : "";
		};

		$scope.nextPage = function () {
			if ($scope.currentPage < $scope.pageCount()) {
				$scope.currentPage++;
			}
		};

		$scope.DisableNextPage = function () {
			return $scope.currentPage === $scope.pageCount() ? "disabled" : "";
		};

		$scope.setPage = function (n) {
			$scope.currentPage = n;
		};

		$scope.pageCount = function () {
			return Math.ceil($scope.products.length / $scope.itemsPerPage) - 1;
		};
	});
}

CiuisCRM.controller('Ciuis_Controller', Ciuis_Controller);
CiuisCRM.controller('Leads_Controller', Leads_Controller);
CiuisCRM.controller('Lead_Controller', Lead_Controller);
CiuisCRM.controller('Accounts_Controller', Accounts_Controller);
CiuisCRM.controller('Customers_Controller', Customers_Controller);
CiuisCRM.controller('Customer_Controller', Customer_Controller);
CiuisCRM.controller('Tasks_Controller', Tasks_Controller);
CiuisCRM.controller('Task_Controller', Task_Controller);
CiuisCRM.controller('Expenses_Controller', Expenses_Controller);
CiuisCRM.controller('Invoices_Controller', Invoices_Controller);
CiuisCRM.controller('Invoice_Controller', Invoice_Controller);
CiuisCRM.controller('Proposals_Controller', Proposals_Controller);
CiuisCRM.controller('Proposal_Controller', Proposal_Controller);
CiuisCRM.controller('Projects_Controller', Projects_Controller);
CiuisCRM.controller('Project_Controller', Project_Controller);
CiuisCRM.controller('Tickets_Controller', Tickets_Controller);
CiuisCRM.controller('Ticket_Controller', Ticket_Controller);
CiuisCRM.controller('Products_Controller', Products_Controller);

// ALL FILTERS

CiuisCRM.filter('trustAsHtml', ['$sce', function ($sce) {
	"use strict";
	return function (text) {
		return $sce.trustAsHtml(text);
	};
}]);
CiuisCRM.filter('pagination', function () {
	"use strict";
	return function (input, start) {
		if (!input || !input.length) {
			return;
		}
		start = +start; //parse to int
		return input.slice(start);
	};
});
CiuisCRM.filter('time', function () {
	"use strict";
	var conversions = {
		'ss': angular.identity,
		'mm': function (value) {
			return value * 60;
		},
		'hh': function (value) {
			return value * 3600;
		}
	};

	var padding = function (value, length) {
		var zeroes = length - ('' + (value)).length,
			pad = '';
		while (zeroes-- > 0) pad += '0';
		return pad + value;
	};

	return function (value, unit, format, isPadded) {
		var totalSeconds = conversions[unit || 'ss'](value),
			hh = Math.floor(totalSeconds / 3600),
			mm = Math.floor((totalSeconds % 3600) / 60),
			ss = totalSeconds % 60;

		format = format || 'hh:mm:ss';
		isPadded = angular.isDefined(isPadded) ? isPadded : true;
		hh = isPadded ? padding(hh, 2) : hh;
		mm = isPadded ? padding(mm, 2) : mm;
		ss = isPadded ? padding(ss, 2) : ss;

		return format.replace(/hh/, hh).replace(/mm/, mm).replace(/ss/, ss);
	};
});
CiuisCRM.filter("myfilter", function ($filter) {
	"use strict";
	return function (items, from, to) {
		return $filter('filter')(items, "createddate", function (v) {
			var date = v;
			return date >= from && date <= to;
		});
	};
});

// ALL DIRECTIVES

CiuisCRM.directive('loadMore', function () {
	"use strict";
	return {
		template: "<a ng-click='loadMore()' id='loadButton' class='activity_tumu'><i style='font-size:22px;' class='icon ion-android-arrow-down'></i></a>",
		link: function (scope) {
			scope.LogLimit = 2;
			scope.loadMore = function () {
				scope.LogLimit += 5;
				if (scope.logs.length < scope.LogLimit) {
					CiuisCRM.element(loadButton).fadeOut();
				}
			};
		}
	};
});