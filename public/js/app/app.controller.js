/**
 * Application controller list
 */

(function(){
	'use strict';

	/**
	 * Sales & Collection Report controller
	 */
	var app = angular.module('app');
	var defaultDate = '';
	var fetch = true;
	
	
	app.controller('SalesCollectionReport',['$scope','$resource','$uibModal','$window','$log',SalesCollectionReport]);
	
	function SalesCollectionReport($scope, $resource, $uibModal, $window, $log)
	{	    	
	    var params = [
		          'company_code',
		          'customer_name',
		          'invoice_date_from',
		          'invoice_date_to',
		          'collection_date_from',
		          'collection_date_to',
		          'posting_date_from',
		          'posting_date_to',
		          'salesman',
		          'invoice_number',
		          'or_number'
		          
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'salescollectionreport',params,$log);
	    
	    //editable rows
	    editTable($scope, $uibModal, $resource, $window, {}, $log);
	    		
	}
	
	
	/**
	 * Sales & Collection Posting controller
	 */

	app.controller('SalesCollectionPosting',['$scope','$resource','$uibModal','$window','$log',SalesCollectionPosting]);
	
	function SalesCollectionPosting($scope, $resource, $uibModal, $window, $log)
	{		
	    var params = [
		          'company_code',
		          'customer_name',
		          'invoice_date_from',
		          'invoice_date_to',
		          'collection_date_from',
		          'collection_date_to',
		          'posting_date_from',
		          'posting_date_to',
		          'salesman',
		          'invoice_number',
		          'or_number'
		];
	    
	    // main controller 
	    reportController($scope,$resource,$uibModal,$window,'salescollectionposting',params,$log);
	}
	
	
	/**
	 * Sales & Collection Summary controller
	 */

	app.controller('SalesCollectionSummary',['$scope','$resource','$uibModal','$window','$log',SalesCollectionSummary]);
	
	function SalesCollectionSummary($scope, $resource, $uibModal, $window, $log)
	{
	    var params = [
		          'company_code',
		          'invoice_date_from',
		          'salesman',
		          'area'
		          
		];
	    
	    // main controller 
	    reportController($scope,$resource,$uibModal,$window,'salescollectionsummary',params,$log);
	}
	
	/**
	 * Van & Inventory (Canned) controller
	 */

	app.controller('VanInventoryCanned',['$scope','$resource','$uibModal','$window','$log',VanInventoryCanned]);
	
	function VanInventoryCanned($scope, $resource, $uibModal, $window, $log)
	{	
		vanInventoryController($scope, $resource, $uibModal, $window, 'vaninventorycanned', $log);
	}
	
	/**
	 * Van & Inventory (Frozen) controller
	 */

	app.controller('VanInventoryFrozen',['$scope','$resource','$uibModal','$window','$log',VanInventoryFrozen]);
	
	function VanInventoryFrozen($scope, $resource, $uibModal, $window, $log)
	{	        
		vanInventoryController($scope, $resource, $uibModal, $window, 'vaninventoryfrozen', $log);
	}
	
	
	/**
	 * Van Inventory Controller
	 */
	function vanInventoryController(scope, resource, modal, window, reportType, log)
	{
		// Filter flag
		scope.toggleFilter = true;
		
		// items data
		scope.items = [];
		
		var report = reportType;
		
		// Fetch table data from server
	    scope.records = [];
	    
	    var API = resource('/reports/getdata/'+report);	    
	    var params = [
		          'salesman_code',
		          'transaction_date',
		          'transaction_date_from',
		          'transaction_date_to',
		          'status',
		          'inventory_type',
		          'invoice_number',
		          'stock_transfer_number',
		          'return_slip_num',
		          'reference_number'
		];
	    
	    fetchMore(scope,API,params,log);
	    	    
	    // Filter table records	    		
		filterSubmitVanInventory(scope,API,params,log);
		
	    // Download report
	    downloadReport(scope, modal, resource, window, report, params, log);	    
	    
	    // Format date
	    formatDate(scope);
	}
	/**
	 * Unpaid Report
	 */
	app.controller('Unpaid',['$scope','$resource','$uibModal','$window','$log',Unpaid]);
	
	function Unpaid($scope, $resource, $uibModal, $window, $log)
	{
		var params = [
			          'company_code',
			          'invoice_date_from',
			          'invoice_date_to',
			          'invoice_number',
			          'salesman',
			          'customer'
			];
		    
		// main controller
		reportController($scope,$resource,$uibModal,$window,'unpaidinvoice',params,$log);
	}
	
	/**
	 * Sales Report Per Material
	 */
	app.controller('SalesReportPerMaterial',['$scope','$resource','$uibModal','$window','$log',SalesReportPerMaterial]);
	
	function SalesReportPerMaterial($scope, $resource, $uibModal, $window, $log)
	{
		var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'company_code',
		          'customer',
		          'material',
		          'invoice_number',
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'salesreportpermaterial',params,$log);
	    
	    var API = '';
	    $scope.conditionCodes = function(){
	    	API = $resource('/reports/getdata/conditioncodes');
	    	API.get({},function(data){
		    	$scope.codes = data;
		    	$log.info(data);
		    });
	    }
	    
	    //Edit table records
	    //var selectAPI = '/reports/getdata/conditioncodes';
	    var options = {GOOD:'GOOD',BAD:'BAD'};
	    editTable($scope, $uibModal, $resource, $window, options, $log);
	}

	/**
	 * Sales Report Per Peso
	 */
	app.controller('SalesReportPerPeso',['$scope','$resource','$uibModal','$window','$log',SalesReportPerPeso]);
	
	function SalesReportPerPeso($scope, $resource, $uibModal, $window, $log)
	{
		var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'company_code',
		          'invoice_number',
		          'customer'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'salesreportperpeso',params,$log);
	    
	    editTable($scope, $uibModal, $resource, $window, {}, $log);
	}
	
	
	/**
	 * Return Report Per Material
	 */
	app.controller('ReturnReportPerMaterial',['$scope','$resource','$uibModal','$window','$log',ReturnReportPerMaterial]);
	
	function ReturnReportPerMaterial($scope, $resource, $uibModal, $window, $log)
	{
	    var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'company_code',
		          'invoice_number',
		          'material',
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'returnpermaterial',params,$log);
	}
	
	
	/**
	 * Return Report Per Peso
	 */
	app.controller('ReturnReportPerPeso',['$scope','$resource','$uibModal','$window','$log',ReturnReportPerPeso]);
	
	function ReturnReportPerPeso($scope, $resource, $uibModal, $window, $log)
	{
	    var params = [
		          'posting_date_from',
		          'posting_date_to',
		          'return_date_from',
		          'return_date_to',
		          'salesman_code',
		          'area',
		          'company_code',
		          'invoice_number',
		          'material',
		          'segment'
		];
	    
	    // main controller codes
	    reportController($scope,$resource,$uibModal,$window,'returnperpeso',params,$log);
	}
	
	/**
	 * Customer List
	 */
	app.controller('CustomerList',['$scope','$resource','$uibModal','$window','$log',CustomerList]);
	
	function CustomerList($scope, $resource, $uibModal, $window, $log)
	{	    	    
	    var params = [
		          'salesman_code',
		          'area',
		          'status',
		          'company_code',
		          'sfa_modified_date_from',
		          'sfa_modified_date_to',
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'customerlist',params,$log);
	}
	
	
	/**
	 * Salesman List
	 */
	app.controller('SalesmanList',['$scope','$resource','$uibModal','$window','$log',SalesmanList]);
	
	function SalesmanList($scope, $resource, $uibModal, $window, $log)
	{
		var params = [
		          'salesman_code',
		          'area',
		          'status',
		          'company_code',
		          'sfa_modified_date_from',
		          'sfa_modified_date_to'
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'salesmanlist',params,$log);
	    
	}
	
	/**
	 * Material Price List
	 */
	app.controller('MaterialPriceList',['$scope','$resource','$uibModal','$window','$log',MaterialPriceList]);
	
	function MaterialPriceList($scope, $resource, $uibModal, $window, $log)
	{	
	    var params = [
		          'company_code',
		          'area',
		          'segment_code',
		          'item_code',
		          'status',
		          'sfa_modified_date_from',
		          'sfa_modified_date_to'
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'materialpricelist',params,$log);
	 
	}
	
	/**
	 * Bir controller
	 */

	app.controller('Bir',['$scope','$resource','$uibModal','$window','$log',Bir]);
	
	function Bir($scope, $resource, $uibModal, $window, $log)
	{
			    
	    var params = [
		          'area',
		          'salesman',
		          'reference',
		          'document_date_from',
		          'document_date_to'
		];
	    
	    // main controller
	    reportController($scope,$resource,$uibModal,$window,'bir',params,$log);
	}

	
	/**
	 * Date Input Controller
	 */
	app.controller('Calendar',['$scope','$http','$log', Calendar]);
	
	function Calendar($scope, $http, $log)
	{	
		$scope.dateFrom = null;
	    $scope.dateTo = null;
	    
	    $scope.maxDate = new Date(2020, 5, 22);

		$scope.open = function($event, elementId) {
			$event.preventDefault();
		    $event.stopPropagation();
		    $scope[elementId] = true;
		};

		$scope.dateOptions = {
		    formatYear: 'yy',
		    startingDay: 0
		};

		//$scope.format = 'yyyy/MM/dd';
		$scope.format = 'MM/dd/yyyy';
			  
	}
	
	/**
	 * Date Input Controller for editable columns
	 */
	app.controller('EditableColumnsCalendar',['$scope','$http','$log', EditableColumnsCalendar]);
	
	function EditableColumnsCalendar($scope, $http, $log)
	{	
		if(defaultDate)
			$scope.dateFrom = defaultDate;
		else
			$scope.dateFrom = null;
	    $scope.dateTo = null;
	    
	    $scope.maxDate = new Date(2020, 5, 22);

		$scope.open = function($event, elementId) {
			$event.preventDefault();
		    $event.stopPropagation();
		    $scope[elementId] = true;
		};

		$scope.dateOptions = {
		    formatYear: 'yy',
		    startingDay: 0
		};

		//$scope.format = 'yyyy/MM/dd';
		$scope.format = 'MM/dd/yyyy';
			  
	}

	/**
	 * Get more data
	 */
	function fetchMore(scope, API, filter, log, loadMore)
	{
		var params = {};
		$.each(filter, function(key,val){
			params[val] = $('#'+val).val();			
		});
		params['transaction_date'] = scope.dateValue;
					
		$('p[id$="_error"]').addClass('hide');
		scope.toggleFilter = true;
		toggleLoading(true);
		log.info(params);
		log.info(scope.dateValue);
			
	    API.save(params,function(data){
	    		
	    		if(data.total)
	    		{
	    			scope.items.push({
				    	records: data.records,
				    	total: data.total,
				    	stocks: data.stocks,
				    	show_stocks: data.total_stocks,
				    	replenishment: data.replenishment,		    	
				    	showBody: data.total,
				    	showReplenishment: data.replenishment.total,
				    	short_over_stocks: data.short_over_stocks,
				    	stock_on_hand: data.stock_on_hand
			    	});
	    			$('#no_records_div').hide();
	    			fetch = false;
	    	//		log.info('fetch false');
	    		}
	    		else
	    		{
	    			if(!loadMore && !scope.items.length)
	    				$('#no_records_div').show();
	    		}
	    		
	    		toggleLoading();
		    	log.info(scope.items);
		    	
		});				
	}
	
	/**
	 * Centralized filter function
	 */
	function filterSubmitVanInventory(scope, API, filter, log)
	{
		scope.filter = function(){
	    	
			var hasError = false;			
			$.each(filter, function(key,val){
				if(val.indexOf('_from') != -1)
				{
					var from = $('#'+val).val();
					var to = $('#'+val.replace('_from','_to')).val();
						
					if(!from && !to)
					{
						hasError = true;
						$('#'+val.replace('_from','_error')).html('This field is required.');
						$('#'+val.replace('_from','_error')).removeClass('hide');
						
					}
					else if((from && !to) || (!from && to) || (new Date(from) > (new Date(to))))
					{
						hasError = true;						
						$('#'+val.replace('_from','_error')).html('Invalid date range.');
						$('#'+val.replace('_from','_error')).removeClass('hide');
					}
				}
			});
			
			if(!hasError)
			{
				var dateFrom = new Date($('#transaction_date_from').val());
				var dateTo = new Date($('#transaction_date_to').val());
				
				scope.items = [];
				scope.dateRanges = getDates(dateFrom,dateTo);
				
				while(scope.dateRanges.length)
				{
					scope.dateValue = scope.dateRanges.shift();			
					log.info(scope.dateRanges.length);
					
					if(!scope.dateRanges.length)
						$('#load_more').addClass('hide');			
					else
						$('#load_more').removeClass('hide');
					
					log.info(scope.dateRanges);
					log.info(scope.dateValue);
					
					fetchMore(scope, API, filter, log);
				}
			}
	    }
		
		scope.more = function() {
			
			while(scope.dateRanges.length)
			{
				if(scope.dateRanges.length > 0)
				{
					scope.dateValue = scope.dateRanges.shift();
					if(!scope.dateRanges.length)
						$('#load_more').addClass('hide');	
					log.info(scope.dateRanges);
					log.info(scope.dateValue);
					
					fetchMore(scope, API, filter, log, true);	
				}
				else
				{
					$('#load_more').addClass('hide');
				}
			}
			
		};
		
		scope.reset = function(){
	    				
			$('p[id$="_error"]').addClass('hide');
			scope.toggleFilter = true;
			toggleLoading();
	    	scope.items = []
	    	$('#no_records_div').removeClass('hide');
	    	$('#load_more').addClass('hide');
	    }
	}
	
	/**
	 * Centralized filter function
	 */
	function filterSubmit(scope, API, filter, log, report)
	{
		var params = {};
		
		scope.filter = function(){
	    	
			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;
			
			var hasError = false;
			$.each(filter, function(key,val){
				params[val] = $('#'+val).val();
					
				if(val.indexOf('_from') != -1)
				{
					var from = $('#'+val).val();
					var to = $('#'+val.replace('_from','_to')).val();
											
					if(((from && !to) || (!from && to) || (new Date(from) > (new Date(to)))) && report != 'salescollectionsummary')
					{
						hasError = true;
						$('#'+val.replace('_from','_error')).removeClass('hide');
					}
				}
					
			});
			log.info(params);
						
			
			if(!hasError)
			{
				$('p[id$="_error"]').addClass('hide');
				scope.toggleFilter = true;
				toggleLoading(true);
				API.save(params,function(data){
		    		log.info(data);
		    		togglePagination(data.total);
			    	scope.records = data.records;
			    	scope.total = data.total;
			    	scope.summary = data.summary;
			    	toggleLoading();			    	
			    });
			}
			
	    }
		
		scope.reset = function(){
	    	
			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;
			
			$.each(filter, function(key,val){
				params[val] = '';
			});
			log.info(filter);
			$('p[id$="_error"]').addClass('hide');
			
			if(report == 'salescollectionreport')
		    {
		    	var currentDate = new Date();
		    	var formatted = currentDate.getFullYear() + '/' + (currentDate.getMonth() + 1) + '/' + currentDate.getDate();
		    	params = {invoice_date_from:formatted,invoice_date_to:formatted};	  
		    	log.info(params);
		    }
			
			scope.toggleFilter = true;
			toggleLoading(true);
	    	API.save(params,function(data){
	    		log.info(data);
	    		togglePagination(data.total);
		    	scope.records = data.records;		    			    	
		    	toggleLoading();		    	
		    });
	    	
	    }
	}
	
	/**
	 * Centralized method for sorting
	 */
	function sortColumn(scope, API, filter, log)
	{
		var params = {};
		
		scope.sort = function(col) {
			scope.sortColumn = col;
			var el = $('th[id="'+col+'"]');
			
			el.parent().find('th').removeClass('sorted');
			el.parent().find('th>i').removeClass('fa-sort-asc');
			el.parent().find('th>i').removeClass('fa-sort-desc');
			el.parent().find('th>i').addClass('fa-sort');
			
			if(scope.sortDirection == 'desc')
			{					
				el.addClass('sorted');
				el.find('i').addClass('fa-sort-asc');				
				scope.sortDirection = 'asc';
			}
			else
			{				
				el.addClass('sorted');
				el.find('i').addClass('fa-sort-desc');
				scope.sortDirection = 'desc';
			}			
			
			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;
			
			$.each(filter, function(key,val){
				params[val] = $('#'+val).val();
			});
			log.info(params);

			scope.toggleFilter = true;
			toggleLoading(true);
			API.save(params, function(data){
				log.info(data);
				scope.records = data.records;		    	
		    	scope.toggleFilter = true;
		    	toggleLoading();
			});
		}
	}
	
	/**
	 * Centralized pagination function
	 */
	function pagination(scope, API, filter, log, vaninventory)
	{
		var params  = {};
		
		scope.page = 1;
	    scope.perpage = 25;
	    scope.total = 0;
	    
		// Paginate table records	    
	    scope.paginate = function(page) {
			scope.perpage = page;
			scope.page = 1;
			$('#limit'+page).parent().parent().find('.active').removeClass('active');
			$('#limit'+page).parent().addClass('active');
			
			params['page'] = scope.page;
			params['page_limit'] = scope.perpage;
			params['sort'] = scope.sortColumn;
			params['order'] = scope.sortDirection;
			
			$.each(filter, function(key,val){
				params[val] = $('#'+val).val();
			});
			log.info(params);
			
			toggleLoading(true);
			API.save(params, function(data){
				log.info(data);
				scope.records = data.records;		    	
		    	scope.toggleFilter = true;
		    	toggleLoading();
			});
		}
	    
	    // Pager table records
	    scope.pager = function(increment,first,last) {
	    	var request = false;
	    	if(first)
	    	{
	    		scope.page = 1;
	    		request = true;
	    	}
	    	else if(last)
	    	{
	    		scope.page = scope.total/scope.perpage;
	    		request = true;
	    	}
	    	else if((scope.page + increment > 0 && scope.page!=(scope.total/scope.perpage))
	    			|| (increment < 0 && scope.page > 1))
	    	{
	    		scope.page = scope.page + increment;
	    		request = true;
	    	}	
	    	if(request)
	    	{
	    		params['page'] = scope.page;
				params['page_limit'] = scope.perpage;
				params['sort'] = scope.sortColumn;
				params['order'] = scope.sortDirection;
				
	    		$.each(filter, function(key,val){
					params[val] = $('#'+val).val();
				});
				log.info(params);
				
	    		toggleLoading(true);
	    		API.save(params, function(data){
					log.info(data);
					scope.records = data.records;					
			    	scope.toggleFilter = true;
			    	toggleLoading();
				});
	    	}
		}
	}
	
	
	/**
	 * Edit table records
	 */
	function editTable(scope, modal, resource, window, options, log)
	{
		
		scope.editColumn = function(type, table, column, id, value, index, name, alias, getTotal){
			
			var selectOptions = options;
			/*if(selectAPI)
			{
				log.info(selectAPI);
				var API = resource(selectAPI);
				API.get({},function(data){
					log.info(data);
					selectOptions = data.options;
				});
			}*/
			
			var total = column;
			if(alias)
				total = alias;
			
			scope.oldVal = '';
			if(getTotal)
				scope.oldVal = value;
						
			var template = '';
			var inputType = '';
			switch(type)
			{
				case 'date':
					template = 'EditColumnDate';
					inputType = 'datetime';
					defaultDate = new Date(value);
					break;
				case 'select':
					template = 'EditColumnSelect';
					break;
				case 'number':	
					template = 'EditColumnText';
					inputType = 'number';
					value = Number(value);
					break;
				default:	
					template = 'EditColumnText';
					inputType = 'text';
					break;	
			}
			log.info(value);
			
			log.info(selectOptions);
			var params = {
					table: table,
					column: column,
					id: id,
					value: value,
					selectOptions: selectOptions,
					index: index,
					name: name,
					alias: alias,
					total: total,
					old: scope.oldVal,
					getTotal: getTotal,
					type: inputType
			};
			
			
			var modalInstance = modal.open({
			 	animation: true,
			 	scope: scope,
				templateUrl: template,
				controller: 'EditTableRecord',
				windowClass: 'center-modal',
				size: 'sm',
				resolve: {
					params: function () {
						return params;
				    }
				}
			});
		}		
		
	}
	
	/**
	 * Export report
	 */
	function downloadReport(scope, modal, resource, window, report, filter, log)
	{
		scope.download = function(type){
			
			var url = '/reports/getcount/'+report+'/'+type;
			var delimeter = '?';
			var query = '';
			$.each(filter, function(index,val){
				if(index > 0)
					delimeter = '&';
				query += delimeter + val + '=' + $('#'+val).val();				
			});
			url += query;
			log.info(url);
			
			var API = resource(url);
			API.get({}, function(data){
			
				log.info(data);
				if(!data.total)
				{
					var params = {message:'No data to export.'};		    
			    	var modalInstance = modal.open({
			    		animation: true,
					 	templateUrl: 'Info',
						controller: 'Info',
						windowClass: 'center-modal',
						size: 'sm',
						resolve: {
							params: function () {
								return params;
						    }
						}
					});
				}
				else if(data.max_limit)
				{
					scope.params = {
							chunks: data.staggered,
							title: 'Export ' + angular.uppercase(type),
							limit: data.limit,
							exportType: type,
							report: report,
							filter: filter
					};
		
					var modalInstance = modal.open({
						 	animation: true,
							templateUrl: 'exportModal',
							controller: 'ExportReport',
							resolve: {
								params: function () {
									return scope.params;
							    }
							}
					});
				 }
				 else
				 {
					 window.location.href = '/reports/export/'+type+'/'+report+query;
				}
			});
		}	
	}
	
	/**
	 * Centralized controller codes
	 */
	function reportController(scope, resource, modal, window, report, filter, log)
	{
		// Filter flag
		scope.toggleFilter = true;
		
		// Fetch table headers from server
	    /*scope.tableHeaders = {};
	    resource('/reports/getheaders/'+report).query({}, function(data){
	    	scope.tableHeaders = data;
	    });*/
	    
	    // Fetch table data from server
	    scope.records = [];	    
	    
	    var API = resource('/reports/getdata/'+report);
	    var params = {};
	    
	    if(report == 'salescollectionreport')
	    {
	    	var currentDate = new Date();
	    	var formatted = currentDate.getFullYear() + '/' + (currentDate.getMonth() + 1) + '/' + currentDate.getDate();
	    	params = {invoice_date_from:formatted,invoice_date_to:formatted};
	    	log.info(params);
	    }
	    else if(report == 'salescollectionsummary')
	    {
	    	var currentDate = new Date();
	    	var formatted = currentDate.getFullYear() + '/' + (currentDate.getMonth() + 1) + '/' + currentDate.getDate();
	    	params = {salesman:$('#salesman').val()};
	    	log.info(params);
	    }
	    
	    toggleLoading(true);
	    API.get(params,function(data){
	    	scope.records = data.records;
	    	scope.summary = data.summary;
	    	scope.total = data.total;
	    	log.info(data);	    	
	    	toggleLoading();
	    	togglePagination(data.total);	    	
	    });	    	    
	    
	    params = filter;
	    
	    //Sort table records
	    scope.sortColumn = '';
		scope.sortDirection = 'asc';
		sortColumn(scope,API,params,log);
	    
	    // Filter table records	    
	    filterSubmit(scope,API,params,log, report);
		
	    // Paginate table records	    
	    pagination(scope,API,params,log);
	    
	    // Download report
	    downloadReport(scope, modal, resource, window, report, filter, log);	    
	    
	    // Format date
	    formatDate(scope);
	    
	    //Format number
	    formatNumber(scope,log);
	}
	
	/**
	 * Toggle pagination div
	 */
	function togglePagination(show)
	{
		if(show)
		{
			$('#pagination_div').removeClass('hidden');
		    $('#pagination_div').addClass('show');
		    $('#no_records_div').hide();
		    $('#total_summary').show();
		}
		else
		{
			$('#pagination_div').removeClass('show');
		    $('#pagination_div').addClass('hidden');
		    $('#no_records_div').show();
		    $('#total_summary').hide();
		}		
	}
	
	/**
	 * Toggle loading div
	 */
	function toggleLoading(show)
	{
		if(show)
		{
			$('#loading_div').removeClass('hidden');
		    $('#loading_div').addClass('show');
		}
		else
		{
			$('#loading_div').removeClass('show');
		    $('#loading_div').addClass('hidden');
		}
	}
	
	
	/**
	 * Export report controller
	 */
	app.controller('ExportReport',['$scope','$uibModalInstance','$window','params','$log', ExportReport]);
	
	function ExportReport($scope, $uibModalInstance, $window, params, $log) {

		$scope.params = params;
		$scope.offset = 0;
	  
		$scope.selectItem = function(range){
			$scope.offset = range;
		}
	  
		$scope.download = function () {
			$uibModalInstance.close(true);
			
			var url = '/reports/export/'+$scope.params.exportType+'/'+$scope.params.report+'/'+$scope.offset;
			var delimeter = '?';
			$.each(params.filter, function(index,val){
				if(index > 0)
					delimeter = '&';
				url += delimeter + val + '=' + $('#'+val).val();				
			});
			$log.info(url);
			$window.location.href = url;
		};

		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
	};
	
	
	/**
	 * Edit Table record controller
	 */
	app.controller('EditTableRecord',['$scope','$uibModalInstance','$window','$resource','params','$log', EditTableRecord]);
	
	function EditTableRecord($scope, $uibModalInstance, $window, $resource, params, $log) {

		$scope.params = params;		
		$log.info(params);
		
		$scope.save = function () {
			var API = $resource('controller/reports/save');
			if($scope.params.type == 'datetime')
			{
				var val = $scope.params.value;
				$log.info('date_value ' + val);
				$scope.params.value = $('#date_value').val() + " " + val.split(" ")[1];
			}
			$log.info($scope.params);
			API.save($scope.params, function(data){
				$log.info(data);
				$log.info($scope.params.value);
				if($scope.params.alias)
				{
					$scope.records[$scope.params.index][$scope.params.alias] = $scope.params.value;
					if($scope.params.getTotal)
						$scope.summary[$scope.params.alias] = Number($scope.summary[$scope.params.alias]) - Number($scope.params.old) + Number($scope.params.value);
				}					
				else
				{
					$scope.records[$scope.params.index][$scope.params.column] = $scope.params.value;
					if($scope.params.getTotal)
						$scope.summary[$scope.params.column] = Number($scope.summary[$scope.params.column]) - Number($scope.params.old) + Number($scope.params.value);
				}					
				$('#'+$scope.params.index).addClass('modified');				
			});
			
			$uibModalInstance.dismiss('cancel');
		};
		
		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
		
		/*$scope.getDate = function(date){
	          var dateOut = new Date(date);
	          return dateOut;
	    };*/
	};
	
	
	/**
	 * Get date ranges base from parameters
	 */
	function getDates(startDate, stopDate) {
	    var dateArray = new Array();
	    var currentDate = startDate;
	    while (currentDate <= stopDate) {
	    	var formatted = currentDate.getFullYear() + '/' + (currentDate.getMonth() + 1) + '/' + currentDate.getDate();
	    	dateArray.push( formatted )
	    	currentDate = currentDate.addDays(1);	        	        	       
	    }
	    return dateArray;
	}
	
	/**
	 * Add days
	 */
	Date.prototype.addDays = function(days) {
	    var dat = new Date(this.valueOf())
	    dat.setDate(dat.getDate() + days);
	    return dat;
	}
	
	
	
	/**
	 * User List controller
	 */
	app.controller('UserList',['$scope','$resource','$window','$uibModal','$log', UserList]);
	
	function UserList($scope, $resource, $window, $uibModal, $log) {

		// Filter flag
		$scope.toggleFilter = true;
		
	    // Fetch table data from server
	    $scope.records = [];	    
	    
	    var API = $resource('/reports/getdata/userlist');
	    var params = {};
	    
	    toggleLoading(true);
	    API.get(params,function(data){
	    	$scope.records = data.records;
	    	$scope.total = data.total;
	    	$log.info(data);	    	
	    	toggleLoading();
	    	togglePagination(data.total);
	    });	    	    
	    
	    params = {
	    	fullname: 'fullname',
	    	user_group_id: 'user_group_id',
	    	location_assignment_code: 'location_assignment_code',
	    	location_assignment_type: 'location_assignment_type',
	    	user_group_id: 'user_group_id',
	    	created_at_from: 'created_at_from',
	    	created_at_to: 'created_at_to'
	    };
	    
	    //Sort table records
	    $scope.sortColumn = '';
		$scope.sortDirection = 'asc';
		sortColumn($scope,API,params,$log);
	    
	    // Filter table records	    
	    filterSubmit($scope,API,params,$log);
		
	    // Paginate table records	    
	    pagination($scope,API,params,$log);	  
	    
	    var params;
	    $scope.activate = function(id,row){	    	
	    	params = {id:id,action:'activate',message:'Are you sure you want to activate this user?',row:row};		    
	    	var modalInstance = $uibModal.open({
	    		scope: $scope,
			 	animation: true,
			 	templateUrl: 'Confirm',
				controller: 'UserAction',
				windowClass: 'center-modal',
				size: 'sm',
				resolve: {
					params: function () {
						return params;
				    }
				}
			});
	    }
	    
	    $scope.deactivate = function(id,row){
	    	params = {id:id,action:'deactivate',message:'Are you sure you want to deactivate this user?',row:row};		    
	    	var modalInstance = $uibModal.open({
	    		scope: $scope,
			 	animation: true,
			 	templateUrl: 'Confirm',
				controller: 'UserAction',
				windowClass: 'center-modal',
				size: 'sm',
				resolve: {
					params: function () {
						return params;
				    }
				}
			});
	    }
	    
	    $scope.remove = function(id){
	    	params = {id:id,action:'delete',message:'Are you sure you want to delete this user?'};		    
	    	var modalInstance = $uibModal.open({
			 	animation: true,
			 	scope: $scope,
			 	templateUrl: 'Confirm',
				controller: 'UserAction',
				windowClass: 'center-modal',
				size: 'sm',
				resolve: {
					params: function () {
						return params;
				    }
				}
			});
	    }

	};
	
	/**
	 * Format date
	 */
	function formatDate(scope) {
		
		// @Function
	    // Description  : Triggered while displaying expiry date in Customer Details screen.
	    scope.formatDate = function(date){
	    	  if(!date) return '';	
	          var dateOut = new Date(date);
	          return dateOut;
	    };
	}
	
	/**
	 * Format money
	 */
	function formatNumber(scope, log) {

	    scope.formatNumber = function(number, negate, round){
	    	
	    	  if('string' == typeof number)
	    	  {
	    		  number = Number(number);
	    		  if(round)
	    		  {
	    			  number = Math.round(number);
	    			  if(negate) number = '('+number+')';
	    			  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	    		  }
	    		  number = number.toFixed(2);
	    	  }
	    		
	    	  if('number' == typeof number)
	    	  {
	    		  if(round)
	    		  {
	    			  number = Math.round(number);
	    			  if(negate) number = '('+number+')';
	    			  return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	    		  }
	    		  number = number.toString();
	    	  }
	    		  
	    	  
	    	  if(!number || number == undefined || number == '0') return '';
	    	  
	    	  var chunks = [];
	    	  var realNumber;	    	  
	    	  
	    	  if(number.indexOf('.') != -1)
	    	  {
	    		  chunks = number.split('.');
	    		  realNumber = chunks[0].toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") + '.' + chunks[1];
	    	  }
	    	  else
	    	  {
	    		  realNumber = number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
	    	  }
	    	  if(negate === '1' || negate === true || negate === 1)
	    		  realNumber = '(' + realNumber + ')';
	    	  return realNumber;
	    };
	}
	
	
	/**
	 * User List controller
	 */
	app.controller('UserAdd',['$scope','$resource','$location','$log', UserAdd]);
	
	function UserAdd($scope, $resource, $location, $log) {

		$scope.id = 0;
	    // Save user profile
	    saveUser($scope,$resource,$location,$log);
	};
	
	
	
	/**
	 * User List controller
	 */
	app.controller('UserEdit',['$scope','$resource','$routeParams','$location','$log', UserEdit]);
	
	function UserEdit($scope, $resource, $routeParams, $location, $log) {

		$scope.age = '';
		$scope.from = null;
		$scope.to = null;
		$scope.id = 0;
		
		var API = $resource('/user/edit/'+$routeParams.id);
	    var params = {};
	    
	    API.get(params,function(data){
	    	$scope.records = data;
	    	$log.info(data);
	    	$scope.id = data.id;
	    	$scope.age = Number(data.age);	    	
	    	$scope.from = new Date(data.location_assignment_from)
	    	$scope.to = new Date(data.location_assignment_to)	    	
	    });
	    
	    // Save user profile
	    saveUser($scope,$resource,$location,$log);
	};
	
	/**
	 * Save user profile
	 */
	function saveUser(scope, resource, location, log)
	{
		scope.personalInfoError = false;
		scope.locationInfoError = false;
		scope.success = false;		
		
		scope.save = function(edit,profile){
			
			var personalInfoErrors = [];
			var personalInfoErrorList = '';
			scope.emailList = [];
			scope.usernameList = [];
			
			var API;
			/*var API = $resource('user/getemails');
			API.get({}, function(data){
				//$log.info(data);
				var emails = [];
				$.each(data, function(index,val){
					$log.info(val);
					emails.push(val);
				})
				$scope.emailList = emails;
			});
			$log.info($scope.emailList);
			
			API = $resource('user/getusernames');
			API.get({}, function(data){
				//$log.info(data);
				var usernames = [];
				$.each(data, function(index,val){
					usernames.push(val);
				})
				$scope.usernameList = usernames;
			});
			$log.info($scope.usernameList);*/
			
			// validate personal info
			if(!$('#fname').val())
			{
				personalInfoErrors.push('First Name is a required field.');
			}
			if(!$('#email').val())
			{
				personalInfoErrors.push('Email is a required field.');
			}
			
			var rgxEmail = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			if($('#email').val() && !rgxEmail.test($('#email').val()))
			{
				personalInfoErrors.push('Invalid email address.');
			}
		/*	if($('#email').val() && $.inArray($('#email').val(),$scope.emailList))
			{
				personalInfoErrors.push('Email must be unique.');
			}
			
			if($('#username').val() && $.inArray($('#username').val(),$scope.usernameList))
			{
				personalInfoErrors.push('Username must be unique.');
			}*/
			
			/*var numeric = new RegExp('/^\d+$/');
			if($('#telephone').val() && !numeric.test($('#telephone')))
			{
				personalInfoErrors.push('Telephone must be numeric.');
			}
			if($('#mobile').val() && !numeric.test($('#mobile')))
			{
				personalInfoErrors.push('Mobile must be numeric.');
			}*/
			
			if(!edit)
			{
				if(!$('#password').val())
				{
					personalInfoErrors.push('Password is a required field.');
				}
				if(!$('#confirm_pass').val())
				{
					personalInfoErrors.push('Confirm password is a required field.');
				}
				
				if($('#password').val() && $('#confirm_pass').val() && $('#password').val() != $('#confirm_pass').val())
				{
					personalInfoErrors.push('Password don\'t match.')
				}
			}			
			
			if(personalInfoErrors.length > 0)
			{
				var i = 0;
				personalInfoErrorList = '<ul>';
				for(i = 0; i < personalInfoErrors.length; i++)
				{
					personalInfoErrorList += '<li>'+personalInfoErrors[i]+'</li>';
				}
				personalInfoErrorList += '</ul>';
				$('#error_list_personal').html(personalInfoErrorList);
				scope.personalInfoError = true;
				scope.success = false;
			}
			else
			{
				scope.personalInfoError = false;
			}
			
			
			var locationErrors = [];
			var locationErrorList = '';
			
			// validate personal info
			if(!$('#role').val())
			{
				locationErrors.push('Role is a required field.')
			}
			if(!$('#area').val())
			{
				locationErrors.push('Area is a required field.')
			}
			if(!$('#assignment_type').val())
			{
				locationErrors.push('Assignment is a required field.')
			}
			
			if(locationErrors.length > 0)
			{
				var i = 0;
				locationErrorList = '<ul>';
				for(i = 0; i < locationErrors.length; i++)
				{
					locationErrorList += '<li>'+locationErrors[i]+'</li>';
				}
				locationErrorList += '</ul>';
				$('#error_list_location').html(locationErrorList);
				scope.locationInfoError = true;
				scope.success = false;
			}
			else
			{
				scope.locationInfoError = false;
			}
			
			if(!scope.locationInfoError && !scope.personalInfoError)
			{
				var params = {
					   id: scope.id,
				       fname: $('#fname').val(),
				       lname: $('#lname').val(),
				       mname: $('#mname').val(),
				       email: $('#email').val(),
				       username: $('#username').val(),
				       password: $('#password').val(),
				       address: $('#address').val(),
				       gender: $('#gender').val(),
				       age: $('#age').val(),
				       telephone: $('#telephone').val(),
				       mobile: $('#mobile').val(),
				       role: $('#role').val(),
				       area: $('#area').val(),
				       assignment_type: $('#assignment_type').val(),
				       assignment_date_from: $('#assignment_date_from').val(),
				       assignment_date_to: $('#assignment_date_to').val()
				};
				
				API = resource('controller/user/save');				
				log.info(params);
				API.save(params, function(data){
					log.info(data);
					scope.success = true;
					if(!profile)
						location.path('user.list');
				});
			}
		}
	}
	
	
	
	/**
	 * Sync controller
	 */

	app.controller('Sync',['$scope','$resource','$log',Sync]);
	
	function Sync($scope, $resource, $log)
	{			    
		$scope.showError = false;
		$scope.showSuccess = false;
	    $scope.showLoading = false;
	    $scope.syncLogs = '';
	    
	    $scope.sync = function(){
	    	
	    	$scope.showLoading = true;
	    	var API = $resource('controller/reports/sync');				
			API.get({}, function(data){
				$scope.syncLogs = data.logs;
				$scope.showSuccess = true;	
				$scope.showLoading = false;	
			},
			function(error){
				$scope.showLoading = false;
				$scope.showError = true;
			});
	    }
	}
	
	
	/**
	 * User Action Controller
	 */
	app.controller('UserAction',['$scope','$uibModalInstance','$window','$resource','params','$log', UserAction]);
	
	function UserAction($scope, $uibModalInstance, $window, $resource, params, $log) {

		$scope.params = params;		
		$log.info(params);
		$log.info($scope);
		$scope.ok = function () {				
			switch($scope.params.action)
			{
				case 'activate':
					var API = $resource('/controller/user/activate/'+$scope.params.id);		    
				    API.get({},function(data){
				    	$scope.$parent.records[$scope.params.row].active = true;
				    	$log.info(data);
				    });
					break;
				case 'deactivate':
			    	var API = $resource('/controller/user/deactivate/'+$scope.params.id);		    
				    API.get({},function(data){
				    	$scope.$parent.records[$scope.params.row].active = false;				    	
				    	$log.info(data);
				    });
					break;
				case 'delete':
					var API = $resource('/controller/user/delete/'+$scope.params.id);		    
				    API.get({},function(data){
				    	$('#'+$scope.params.id).remove();
				    	$log.info(data);
				    });
					break;
			}
			$uibModalInstance.dismiss('cancel');
		};
		
		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
		
	};

	
	/**
	 * Change password Controller
	 */

	app.controller('ChangePassword',['$scope','$resource','$log',ChangePassword]);
	
	function ChangePassword($scope, $resource, $log)
	{			    
		$scope.error = false;
		$scope.success = false;
		$scope.submit = function(){
			
			var errorList = [];
			if(!$.trim($('#old_password').val()))
			{
				errorList.push('Old password is a required field.');
			}
			if(!$.trim($('#new_password').val()))
			{
				errorList.push('New password is a required field.');
			}
			if(!$.trim($('#confirm_password').val()))
			{
				errorList.push('Confirm password is a required field.');
			}
			
			if($.trim($('#confirm_password').val()) && $.trim($('#new_password').val()) && $.trim($('#new_password').val()) != $.trim($('#confirm_password').val()))
			{
				errorList.push('Password don\'t match.');
			}
			
			$log.info(errorList);
			if(errorList.length > 0)
			{
				var i = 0;
				var errorHtml = '<ul>';
				for(i = 0; i < errorList.length; i++)
				{
					errorHtml += '<li>'+errorList[i]+'</li>';
				}
				errorHtml += '</ul>';
				$('#error_list').html(errorHtml);
				$scope.error = true;
				$scope.success = false;
			}
			else
			{
				$('#error_list').html('');
				$scope.error = false;				
			}
			
			
	    	var params = {old_pass:$('#old_password').val(),new_pass:$('#new_password').val()};
	    	$log.info(params);
	    	var API = $resource('controller/user/changepass');				
			API.save(params, function(data){
				$log.info(data);
				if(data.success)
				{
					$scope.success = true;
				}	
				if(data.failure)
				{
					$('#error_list').html('Incorrect password.');
					$scope.error = true;
				}
			});
	    }
	}
	
	
	/**
	 * Profile Controller
	 */

	app.controller('Profile',['$scope','$resource','$location','$log',Profile]);
	
	function Profile($scope, $resource, $location, $log)
	{			    
		$scope.age = '';
		$scope.from = null;
		$scope.to = null;
		$scope.id = 0;
		
		var API = $resource('/user/myprofile');
	    var params = {};
	    
	    API.get(params,function(data){
	    	$scope.records = data;
	    	$log.info(data);
	    	$scope.id = data.id;
	    	$scope.age = Number(data.age);
	    	if(data.location_assignment_from != '0000-00-00 00:00:00' && data.location_assignment_from != null)
	    		$scope.from = new Date(data.location_assignment_from)
	    	if(data.location_assignment_to != '0000-00-00 00:00:00' && data.location_assignment_to != null)
	    		$scope.to = new Date(data.location_assignment_to)	    
	    	
	    });
	    
	    // Save user profile
	    saveUser($scope,$resource,$location,$log);
	}

	/**
	 * User Action Controller
	 */
	app.controller('Info',['$scope','$uibModalInstance','params','$log', Info]);
	
	function Info($scope, $uibModalInstance, params, $log) {

		$scope.params = params;		
		$log.info(params);
		
		$scope.cancel = function () {
			$uibModalInstance.dismiss('cancel');
		};
		
	};
	
	app.controller('MainCtrl', function($scope) {
		  $scope.var1 = '07-2013';
		});

})();