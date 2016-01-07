<?php

Html::macro('tclose', function($paginate=true) {

	$html = '</table>';
	$html .= '</div>';

	$html .= '
			<script type="text/ng-template" id="EditColumnText">
        		<div class="modal-body">			
					<p>[[params.name]]</p>	
					<form class="form-inline">
				         <div class="form-group">
							<input type="text" ng-model="params.value" class="form-control input-sm">
						 </div>
						 <button class="btn btn-success" type="button btn-sm" ng-click="save()"><i class="glyphicon glyphicon-ok"></i></button>
						 <button class="btn btn-warning" type="button btn-sm" ng-click="cancel()"><i class="glyphicon glyphicon-remove"></i></button>					 		
					</form>   										 					
				</div>			    			
    		</script>
			
			<script type="text/ng-template" id="EditColumnSelect">
        		<div class="modal-body">
					<p>[[params.name]]</p>					
					<form class="form-inline">
				         <div class="form-group">
							<select class="form-control" ng-model="params.value">
							  <option ng-repeat="option in params.selectOptions">[[option]]</option>							  
							</select>
						 </div>
						 <button class="btn btn-success" type="button btn-sm" ng-click="save()"><i class="glyphicon glyphicon-ok"></i></button>
						 <button class="btn btn-warning" type="button btn-sm" ng-click="cancel()"><i class="glyphicon glyphicon-remove"></i></button>					 		
					</form>   										 					
				</div>			    			
    		</script>

			<script type="text/ng-template" id="EditColumnDate">
        		<div class="modal-body">		
					<p>[[params.name]]</p>			
					<form class="form-inline">
				         <div class="form-group">
							<div class="col-sm-8" data-ng-controller="Calendar" style="padding-left:0px;margin-left:0px;">
							 	<p class="input-group">
									<input type="hidden" id="default_value" ng-model="params.value">	
							 		<input type="text" id="date_value" name="date_value" show-weeks="true" ng-click="open($event,\'date_value\')" class="form-control" uib-datepicker-popup="[[format]]" ng-model="dateFrom" is-open="date_value" datepicker-options="dateOptions" close-text="Close" />
							 		<span class="input-group-btn">
							 			<button type="button" class="btn btn-default btn-sm" ng-click="open($event,\'date_value\')"><i class="glyphicon glyphicon-calendar"></i></button>
							 		</span>
							 	</p>
						 	</div>
						 <button class="btn btn-success" type="button btn-sm" ng-click="save()"><i class="glyphicon glyphicon-ok"></i></button>
						 <button class="btn btn-warning" type="button btn-sm" ng-click="cancel()"><i class="glyphicon glyphicon-remove"></i></button>					 		
					</form>   										 					
				</div>			    			
    		</script>
			
			
			';
	if($paginate)
	{
		$html .= '<div class="col-sm-12 fixed-table-pagination" id="pagination_div">
					<div class="pull-left pagination-detail">
					<span class="pagination-info">Showing [[((perpage*page)-perpage)+1]] to [[perpage*page]] of [[total]] rows&nbsp;</span>
					<span class="page-list">
						<div class="btn-group" uib-dropdown dropdown-append-to-body>
					      <button id="btn-append-to-body" type="button" class="btn btn-default btn-sm" uib-dropdown-toggle>
					        [[perpage]] <span class="caret"></span>
					      </button>
					      <ul class="uib-dropdown-menu" role="menu" aria-labelledby="btn-append-to-body">
					        <li role="menuitem" class="active" id="limit10" ng-click="paginate(10)"><a href="">10</a></li>
					        <li role="menuitem"><a href="" id="limit25" ng-click="paginate(25)">25</a></li>
					        <li role="menuitem"><a href="" id="limit50" ng-click="paginate(50)">50</a></li>					        
					        <li role="menuitem"><a href="" id="limit100" ng-click="paginate(100)">100</a></li>
					      </ul>
					    </div>
						 records per page
					</span>
					<input type="hidden" name="perpage" id="perpage" value="10">
				</div>	
				
				<div class="pull-right pagination">
					<ul class="pagination">
						<li class="page-first"><a href="" ng-click="pager(1,1)">&lt;&lt;</a></li>
						<li class="page-pre"><a href="" ng-click="pager(-1)">&lt;</a></li>
						<li class="page-next"><a href="" ng-click="pager(1)">&gt;</a></li>
						<li class="page-last"><a href="" ng-click="pager(1,0,1)">&gt;&gt;</a></li>
						<input type="hidden" name="page" id="page" value="1">
					</ul>
				</div>
			</div>';
	}

	return $html;
});