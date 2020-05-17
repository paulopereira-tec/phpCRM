var CiuisCRM = angular.module('Ciuis', ['Ciuis.datepicker', 'ngMaterial']);

function Area_Controller($scope, $http) {
	"use strict";
	$scope.date = new Date();

	$http.get(BASE_URL + 'area/get_settings').then(function (Settings) {
		$scope.settings = Settings.data;
	});

	$http.get(BASE_URL + 'area/get_projects').then(function (Projects) {
		$scope.projects = Projects.data;
	});

	$http.get(BASE_URL + 'area/get_staff').then(function (Staff) {
		$scope.staff = Staff.data;
	});

	$http.get(BASE_URL + 'area/get_stats').then(function (Stats) {
		$scope.stats = Stats.data;
	});

	$http.get(BASE_URL + 'area/get_transactions').then(function (Transactions) {
		$scope.transactions = Transactions.data;
	});

	$http.get(BASE_URL + 'area/get_notifications').then(function (Notifications) {
		$scope.notifications = Notifications.data;
	});

	$http.get(BASE_URL + 'area/get_logs').then(function (Logs) {
		$scope.logs = Logs.data;
	});

	$http.get(BASE_URL + 'area/get_countries').then(function (Countries) {
		$scope.countries = Countries.data;
	});

	$http.get(BASE_URL + 'area/get_customers').then(function (Customers) {
		$scope.all_customers = Customers.data;
	});

	$http.get(BASE_URL + 'area/get_contacts').then(function (Contacts) {
		$scope.all_contacts = Contacts.data;
	});

	$http.get(BASE_URL + 'area/get_departments').then(function (Departments) {
		$scope.departments = Departments.data;
	});

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
		var posturl = BASE_URL + 'area/markread';
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

	$scope.appurl = BASE_URL;
	$scope.UPIMGURL = UPIMGURL;
	$scope.IMAGESURL = IMAGESURL;
	$scope.SETFILEURL = SETFILEURL;
	$http.get(BASE_URL + 'area/get_leftmenu').then(function (LeftMenu) {
		$scope.areamenu = LeftMenu.data;
	});
}

function Project_Controller($scope, $http, $filter) {
	"use strict";
	$http.get(BASE_URL + 'area/get_projectdetail/' + PROJECTID).then(function (Project) {
		$scope.project = Project.data;
		$scope.projectmembers = $scope.project.members;
	});
	$http.get(BASE_URL + 'area/get_projecttasks/' + PROJECTID).then(function (ProjectTasks) {
		$scope.projecttasks = ProjectTasks.data;
	});

	$http.get(BASE_URL + 'area/get_projectmilestones/' + PROJECTID).then(function (Milestones) {
		$scope.milestones = Milestones.data;
	});

	$http.get(BASE_URL + 'area/get_notes/project/' + PROJECTID).then(function (Notes) {
		$scope.notes = Notes.data;
	});
	
	$http.get(BASE_URL + 'area/get_expenses_by_relation/project/' + PROJECTID).then(function (Expenses) {
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
	$http.get(BASE_URL + 'area/get_projecttimelogs/' + PROJECTID).then(function (TimeLogs) {
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
	$http.get(BASE_URL + 'area/get_projectfiles/' + PROJECTID).then(function (Files) {
		$scope.files = Files.data;
	});
}

function Invoices_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'area/get_invoices').then(function (Invoices) {
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
	$http.get(BASE_URL + 'area/get_invoicedetails/' + INVOICEID).then(function (InvoiceDetails) {
		$scope.invoice = InvoiceDetails.data;
	});

}

function Proposals_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'area/get_proposals').then(function (Proposals) {
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
	$http.get(BASE_URL + 'area/get_products').then(function (Products) {
		$scope.products = Products.data;
	});
}

function Projects_Controller($scope, $http) {
	"use strict";
	$http.get(BASE_URL + 'area/get_projects').then(function (Projects) {
		$scope.projects = Projects.data;
		$scope.pinnedprojects = Projects.data;
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
	$http.get(BASE_URL + 'area/get_tickets').then(function (Tickets) {
		$scope.tickets = Tickets.data;
		$scope.search = {
			subject: '',
			message: ''
		};
	});

	$http.get(BASE_URL + 'area/get_customers').then(function (Customers) {
		$scope.customers = Customers.data;
	});

	$http.get(BASE_URL + 'area/get_contacts').then(function (Contacts) {
		$scope.contacts = Contacts.data;
	});
}

function Ticket_Controller($scope, $http) {
	"use strict";

	$http.get(BASE_URL + 'area/get_customers').then(function (Customers) {
		$scope.customers = Customers.data;
	});

	$http.get(BASE_URL + 'area/get_contacts').then(function (Contacts) {
		$scope.contacts = Contacts.data;
	});
}


CiuisCRM.controller('Area_Controller', Area_Controller);
CiuisCRM.controller('Invoices_Controller', Invoices_Controller);
CiuisCRM.controller('Invoice_Controller', Invoice_Controller);
CiuisCRM.controller('Proposals_Controller', Proposals_Controller);
CiuisCRM.controller('Proposal_Controller', Proposal_Controller);
CiuisCRM.controller('Projects_Controller', Projects_Controller);
CiuisCRM.controller('Project_Controller', Project_Controller);
CiuisCRM.controller('Tickets_Controller', Tickets_Controller);
CiuisCRM.controller('Ticket_Controller', Ticket_Controller);

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