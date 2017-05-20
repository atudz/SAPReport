{!!Html::breadcrumb(['Sales Report','Per Peso'])!!}
{!!Html::pageheader('Per Peso')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				
				<!-- Filter -->			
				{!!Html::fopen('Toggle Filter')!!}
					<div class="col-md-6">
						@if($isSalesman)
							{!!Html::select('salesman_code','Salesman', $salesman,'')!!}
						@else
							{!!Html::select('salesman_code','Salesman', $salesman)!!}
						@endif
						{!!Html::select('area','Area', $areas)!!}
						{!!Html::select('company_code','Company Code', $companyCode)!!}						
						{!!Html::select('customer','Customer Name', $customers)!!}								
					</div>					
					<div class="col-md-6">							
						{!!Html::datepicker('return_date','Invoice Date/ Return Date',true)!!}
						{!!Html::datepicker('posting_date','Posting Date',true)!!}			
						{!!Html::input('text','invoice_number','Invoice #')!!}																			 		
					</div>			
				{!!Html::fclose()!!}
				<!-- End Filter -->
			
				{!!Html::topen(['no_download'=>$isGuest2])!!}
				{!!Html::theader($tableHeaders)!!}
					<tbody>
					<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>
						<td>[[record.so_number]]</td>
						<td>[[record.reference_num]]</td>
						<td>[[record.activity_code]]</td>
						<td>[[record.customer_code]]</td>
						<td>[[record.customer_name]]</td>
						<td>[[record.customer_address]]</td>
						<td>[[record.remarks]]</td>						
						<td>[[record.van_code]]</td>
						<td>[[record.device_code]]</td>
						<td>[[record.salesman_code]]</td>
						<td>[[record.salesman_name]]</td>
						<td>[[record.area]]</td>
						<td>
							@if($isAdmin || $isAuditor || $isAccounting)
								<a href="" class="editable-click" ng-click="editColumn('text',record.invoice_table,record.invoice_number_column,record.invoice_pk_id,record.invoice_number,$index,'Invoice No/Return Slip No','invoice_number')" ng-if="record.closed_period == 0">
	    							[[ record.invoice_number | uppercase]]
	  							</a>
	  							<span ng-if="record.closed_period == 1">[[ record.invoice_number | uppercase]]</span>
	  						@else
	  							[[ record.invoice_number | uppercase]]
	  						@endif
						</td>
						<td>
							@if($isAdmin || $isAuditor || $isAccounting)
								<a href="" class="editable-click" ng-click="editColumn('date',record.invoice_table,record.invoice_date_column,record.invoice_pk_id,record.invoice_date,$index,'Invoice Date/Return Date','invoice_date')" ng-if="record.closed_period == 0">
	    							<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
	  							</a>
	  							<span ng-if="record.closed_period == 1" ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
	  						@else
	  							<span ng-bind="record.invoice_date_formatted = (formatDate(record.invoice_date) | date:'MM/dd/yyyy')"></span>
	  						@endif
						</td>
						<td>
							@if($isAdmin || $isAuditor)
								<a href="" class="editable-click" ng-click="editColumn('date',record.invoice_table,record.invoice_posting_date_column,record.invoice_pk_id,record.invoice_posting_date,$index,'Invoice/Return Posting Date','invoice_posting_date')" ng-if="record.closed_period == 0">
	    							<span ng-bind="record.invoice_posting_date_formatted = (formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy')"></span>
	  							</a>
	  							<span ng-if="record.closed_period == 1" ng-bind="record.invoice_posting_date_formatted = (formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy')"></span>
	  						@else
	  							<span ng-bind="record.invoice_posting_date_formatted = (formatDate(record.invoice_posting_date) | date:'MM/dd/yyyy')"></span>
	  						@endif
						</td>
						<td>
							<span ng-bind="record.gross_served_amount = negate(record.gross_served_amount)"></span>
						</td>
						<td>
							<span ng-bind="record.vat_amount = negate(record.vat_amount)"></span>
						</td>
						<td>[[record.discount_rate]]</td>
						<td>
							<span ng-bind="record.discount_amount = negate(record.discount_amount)"></span>
						</td>
						<td>[[record.collective_discount_rate]]</td>
						<td>
							<span ng-bind="record.collective_discount_amount = negate(record.collective_discount_amount)"></span>
						</td>
						<td>[[record.discount_reference_num]]</td>
						<td>[[record.discount_remarks]]</td>						
						<td>
							<span ng-bind="record.total_invoice = negate(record.total_invoice)"></span>
						</td>
					</tr>
					
					<!-- Total Summary -->
					<tr id="total_summary">
						<th>Total</th>						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>						
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<td></td>
						<th>
							<span ng-bind="summary.gross_served_amount_formatted = negate(summary.gross_served_amount)"></span>
						</th>
						<th>
							<span ng-bind="summary.vat_amount_formatted = negate(summary.vat_amount)"></span>
						</th>
						<td></td>
						<th>
							<span ng-bind="summary.discount_amount_formatted = negate(summary.discount_amount)"></span>
						</th>
						<td></td>
						<th>
							<span ng-bind="summary.collective_discount_amount_formatted = negate(summary.collective_discount_amount)"></span>
						</th>
						<td></td>
						<td></td>						
						<th>
							<span ng-bind="summary.total_invoice_formatted = negate(summary.total_invoice)"></span>
						</th>
					</tr>
					
					</tbody>
					{!!Html::tfooter(true,24)!!}
				{!!Html::tclose()!!}
				
			</div>			
		</div>
	</div>
</div>
