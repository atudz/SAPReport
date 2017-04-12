<html>
<head>	
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<style>		
			
	</style>
</head>
<body>
	<table>
		<tbody>
			<tr>
				<th>Salesman Name:</th>
				<th>{{$replenishment->salesman}}</th>
				<th></th>											
			</tr>	
			<tr>
				<th>Junior Salesman:</th>
				<th>{{$replenishment->jr_salesman}}</th>
				<th></th>											
			</tr>
			<tr>
				<th>Van Code: </th>
				<th>{{$replenishment->van_code}}</th>
				<th></th>											
			</tr>
			<tr>
				<th>Adjustment date/time:</th>
				<th>{{format_date($replenishment->replenish_date,'m/d/Y g:i A')}}</th>
				<th align="right">REPORT#{{latest_revision('vaninventory')}}</th>											
			</tr>
			<tr>
				<th>Adjustment No:</th>
				<th>@if($replenishment->replenish){{$replenishment->replenish->reference_number}} @endif</th>
				<th align="right">REV#{{latest_revision('vaninventory')}}</th>											
			</tr>								
		</tbody>
	</table>
	<table>
		<thead>
			<tr>
				<th>Material Code</th>
				<th>Material Description</th>
				<th>Total Qty</th>							
			</tr>
		</thead>
					
		<tbody>
			@foreach($replenishment->items as $item)
				<tr>							
					<td>{{$item->item_code}}</td>
					<td>{{$item->description}}</td>
					<td class="quantity">{{$item->quantity}}</td>
				</tr>
			@endforeach									
		</tbody>				
	</table>	
	<table>
		<tbody>
			<tr>
				<th colspan="2">Generated By: {{auth()->user()->firstname}} {{auth()->user()->lastname}}</th>				
			</tr>
			<tr>
				<th colspan="2">Date Generated: {{date("m/d/Y g:i A")}}</th>
			</tr>
		</tbody>
	</table>	
</body>
</html>