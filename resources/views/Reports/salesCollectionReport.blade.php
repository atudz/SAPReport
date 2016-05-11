{!!Html::breadcrumb(['Sales & Collection','Reports'])!!}
{!!Html::pageheader('Sales & Collection Report')!!}

<div class="row">
	<div class="col-sm-12">
		<div class="panel panel-default">
		<div class="panel-body">		
			<!-- Filter -->			
			{!!Html::fopen('Toggle Filter')!!}
				<div class="col-md-6">
					{!!Html::select('salesman','Salesman', $salesman,'')!!}
					{!!Html::select('company_code','Company Code', $companyCode,'')!!}
					{!!Html::input('text','customer_name','Customer Name')!!}						
					{!!Html::input('text','invoice_number','Invoice #')!!}
					{!!Html::input('text','or_number','OR #')!!}
				</div>					
				<div class="col-md-6">	
					{!!Html::datepicker('invoice_date','Invoice Date','true')!!}
					{!!Html::datepicker('collection_date','Collection Date','true')!!}																									 			
					{!!Html::datepicker('posting_date','Posting Date','true')!!}
				</div>			
			{!!Html::fclose()!!}
			<!-- End Filter -->
			
			{!!Html::topen(['no_download'=>$isGuest2,'no_pdf'=>$isGuest1])!!}
				{!!Html::theader($tableHeaders)!!}
				<tbody>
				<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">[[record.customer_code]]</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">[[record.customer_name]]</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_evaluated_objective','remarks',record.evaluated_objective_id,record.remarks,$index,'Remarks')">
	    						[[ record.remarks ]]
	  						</a>
	  					@else
	  						[[ record.remarks ]]
	  					@endif
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_sales_order_header','invoice_number',record.sales_order_header_id,record.invoice_number,$index,'Invoice Number','invoice_number')">
	    						[[ record.invoice_number | uppercase ]]
	  						</a>
	  					@else
	  						[[ record.invoice_number | uppercase ]]
	  					@endif
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('date','txn_sales_order_header','so_date',record.sales_order_header_id,record.invoice_date,$index,'Invoice Date','invoice_date')">
	    						<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>
	  						</a>						
	  					@else
	  						<span ng-bind="formatDate(record.invoice_date) | date:'MM/dd/yyyy'"></span>
	  					@endif
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.so_total_served)"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.so_total_item_discount)"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber([record.so_total_collective_discount])"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.total_invoice_amount)"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_return_header_discount','ref_no',record.reference_num,record.ref_no,$index,'CM Number','ref_no')">
	    						[[ record.ref_no | uppercase ]]
	  						</a>
	  					@else
	  						[[ record.ref_no | uppercase ]]
	  					@endif
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.other_deduction_amount)"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_return_header','return_slip_num',record.return_header_id,record.return_slip_num,$index,'Return Slip Number','return_slip_num')">
	    						[[record.return_slip_num | uppercase]]
	  						</a>
	  					@else
	  						[[record.return_slip_num | uppercase]]
	  					@endif
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.RTN_total_gross)"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.RTN_total_collective_discount)"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.RTN_net_amount)"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.total_invoice_net_amount)"></span>
					</td>
					<td>
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_header','or_date',record.collection_header_id,record.or_date,$index,'Collection Date','or_date')">
	    						<span ng-bind="formatDate(record.or_date) | date:'MM/dd/yyyy'"></span>
	  						</a>						
	  					@else
	  						<span ng-bind="formatDate(record.or_date) | date:'MM/dd/yyyy'"></span>
	  					@endif
					</td>
					<td>
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_header','or_number',record.collection_header_id,record.or_number,$index,'OR Number','or_number')">
	    						[[record.or_number | uppercase]]
	  						</a>
	  					@else
	  						[[record.or_number | uppercase]]
	  					@endif
					</td>
					<td>
						<span ng-bind="formatNumber(record.cash_amount)"></span>
						<!-- <a href="" class="editable-click" ng-click="editColumn('number','txn_collection_detail','payment_amount',record.collection_detail_id,record.cash_amount,$index,'Cash','cash_amount','','','0.01')">
							<span ng-bind="formatNumber(record.cash_amount)"></span>
  						</a> -->						
					</td>
					<td>
						<span ng-bind="formatNumber(record.check_amount)"></span>
						<!-- <a href="" class="editable-click" ng-click="editColumn('number','txn_collection_detail','payment_amount',record.collection_detail_id,record.check_amount,$index,'Cash','check_amount','','','0.01')">
							<span ng-bind="formatNumber(record.check_amount)"></span>
						</a> -->
					</td>
					<td>
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','bank',record.collection_detail_id,record.bank,$index,'Bank Name','bank')">
	    						[[record.bank | uppercase]]
	  						</a>
	  					@else
	  						[[record.bank | uppercase]]
	  					@endif
					</td>
					<td>
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','check_number',record.collection_detail_id,record.check_number,$index,'Check No','check_number')">
	    						[[record.check_number]]
	  						</a>
	  					@else
	  						[[record.check_number]]
	  					@endif
					</td>
					<td>
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('date','txn_collection_detail','check_date',record.collection_detail_id,record.check_date,$index,'Check Date','check_date')">
	    						<span ng-bind="formatDate(record.check_date) | date:'MM/dd/yyyy'"></span>
	  						</a>						
	  					@else
	  						<span ng-bind="formatDate(record.check_date) | date:'MM/dd/yyyy'"></span>
	  					@endif	
					</td>
					<td>
						@if($isAdmin)
							<a href="" class="editable-click" ng-click="editColumn('text','txn_collection_detail','cm_number',record.collection_detail_id,record.cm_number,$index,'CM No','cm_number')">
	    						[[record.cm_number | uppercase]]
	  						</a>
	  					@else
	  						[[record.cm_number | uppercase]]
	  					@endif
					</td>
					<td>
						<span ng-bind="formatDate(record.cm_date) | date:'MM/dd/yyyy'"></span>
					</td>
					<td>
						<span ng-bind="formatNumber(record.credit_amount)"></span>
					</td>
					<td rowspan="[[record.rowspan]]" ng-if="record.show">
						<span ng-bind="formatNumber(record.total_collected_amount)"></span>
					</td>									
				</tr>
				
				<!-- Summary -->
				<tr id="total_summary">
					<td class="bold">Total</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="bold">
						[[summary.so_total_served]]						
					</td>
					<td class="bold">
						[[summary.so_total_item_discount]]						
					</td>
					<td class="bold">
						[[summary.so_total_collective_discount]]						
					</td>
					<td class="bold">
						[[summary.total_invoice_amount]]						
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td class="bold">
						[[summary.RTN_total_gross]]						
					</td>
					<td class="bold">
						[[summary.RTN_total_collective_discount]]						
					</td>
					<td class="bold">
						[[summary.RTN_net_amount]]						
					</td>
					<td class="bold">
						[[summary.total_invoice_net_amount]]						
					</td>
					<td></td>
					<td></td>
					<td class="bold">
						[[summary.cash_amount]]						
					</td>
					<td class="bold">
						[[summary.check_amount]]						
					</td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td></td>
					<td class="bold">
						[[summary.total_collected_amount]]						
					</td>									
				</tr>
				</tbody>
				{!!Html::tfooter(true,27)!!}
			{!!Html::tclose(false)!!}
	
		</div>		
		</div>		
	</div>
</div>
