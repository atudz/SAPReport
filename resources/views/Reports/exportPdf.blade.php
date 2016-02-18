<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>
		
		body {
			font-size: 10px;
		}
		
		table.no-border {
    		border-collapse: collapse;
    		font-size: 11px;
		}		
		table.no-border,
		.no-border th,
		.no-border td {
			border: 1px solid white;
			word-wrap: break-word;			
		}
		
		table.table-data {
			width: auto;
    		border-collapse: collapse;
    		font-size: {{$fontSize}};
		}		
		table.table-data,
		.table-data th,
		.table-data td {
			border: 1px solid black;
			word-wrap: break-word;			
		}
		
		.title {
			 margin: auto;
    		 width: 10%;
		}
		.records {
			 margin: auto;
    		 width: 65%;
		}
	</style>
</head>
<body>
	<div class="title">		
		@if(isset($header))
			<h3>{{$header}}</h3>			
		@endif
	</div>
	<table class="no-border">
			<tbody>				
				@if(isset($filters))
					@foreach($filters as $label=>$val)
						<tr>
							<td align="left"><strong>{{$label}}</strong></td>
							<td align="left">{{$val}}</td>
						</tr>
					@endforeach
				@endif
			</tbody>
		</table>
	<br>
	<div >
	<table class="table-data">		
		<tbody>
			@if($theadRaw)
				{!!$theadRaw!!}
			@else
				<tr>
					@foreach($columns as $column)
						<th align="left" >{!!$column['name']!!}</th>
					@endforeach
				</tr>
			@endif			
			@foreach($records as $record)
				<tr>
					@foreach($rows as $row)
						<td align="left" >
							@if(is_object($record) && isset($record->$row))
								@if(false !== strpos($row,'date'))
									{{ date('m/d/Y', strtotime($record->$row)) }}
								@elseif(false !== strpos($record->$row,'.') && is_numeric($record->$row))	
									{!!number_format($record->$row,2,'.',',')!!}
								@else
									{!!$record->$row!!}
								@endif
							@elseif(is_array($record) && isset($record[$row]))
								@if(false !== strpos($row,'date'))
									{{ date('m/d/Y', strtotime($record[$row])) }}
								@elseif(false !== strpos($record[$row],'.') && is_numeric($record[$row]))	
									{!!number_format($record[$row],2,'.',',')!!}								
								@else
									{!!$record[$row]!!}
								@endif									
							@endif
						</td>
					@endforeach
				</tr>
			@endforeach	
			
			@if(isset($summary) && $summary)
				<tr>
					<th>Total</th>
					@foreach($rows as $key=>$row)
						@if($key > 0)
							<th align="left" >
								@if(is_object($summary) && isset($summary->$row))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!$summary->$row!!}
										@else
											({!!number_format($summary->$row,2,'.',',')!!})
										@endif
									@else
										@if($row == 'quantity')
											{!!$summary->$row!!}
										@else
											{!!number_format($summary->$row,2,'.',',')!!}
										@endif
									@endif									
								@elseif(is_array($summary) && isset($summary[$row]))
									@if(in_array($row,['discount_amount','collective_discount_amount']))
										@if($row == 'quantity')
											{!!$summary[$row]!!}
										@else
											({!!number_format($summary[$row],2,'.',',')!!})
										@endif
									@else
										@if($row == 'quantity')
											{!!$summary[$row]!!}
										@else
											{!!number_format($summary[$row],2,'.',',')!!}
										@endif
									@endif
								@endif													
							</th>
						@endif						
					@endforeach
				</tr>			
			@endif			
		</tbody>
	</table>
	</div>
	<br>
	<table class="no-border">
		<tbody>
			<tr align="left">
				<th colspan="3">Generated By: {{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>				
			</tr>
			<tr align="left">
				<th colspan="3">Date Generated: {{date("F j, Y g:i A")}}</th>
			</tr>
		</tbody>
	</table>		
</body>
</html>