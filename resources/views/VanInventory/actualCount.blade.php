{!!Html::breadcrumb(['Van Inventory','Actual Count Replenishment'])!!}
{!!Html::pageheader('Actual Count Replenishment')!!}

<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-body">
				@if($navigationActions['show_filter'])
					<!-- Filter -->
					{!!Html::fopen('Toggle Filter')!!}
						<div class="col-md-8">	
							{!!Html::select('salesman_code','Salesman <span class="required">*</span>', $salesman,$isSalesman ? '' : 'Select Salesman',['onblur'=>'validate(this)','onchange'=>'set_sheet(this)'])!!}
							{!!Html::datepicker('replenishment_date','Count date/time <span class="required">*</span>',false)!!}
							{!!Html::select('reference_number','Count Sheet No. <span class="required">*</span>',[],'Select Salesman',['disabled'=>'disabled'])!!}
						</div>			
					{!!Html::fclose()!!}
					<!-- End Filter -->
				@endif

				@if($navigationActions['show_table'])
					{!!Html::topen([
						'show_download'   => $navigationActions['show_download'],
						'show_print'      => $navigationActions['show_print'],
						'show_search'     => $navigationActions['show_search_field'],
						'show_add_button' => $navigationActions['show_add_button'],
						'add_link'        => 'actualcount.add',
						'edit_link'       => '[[editUrl]]',
						'edit_hide'       => '[[editHide]]'
					])!!}
						{!!Html::theader($tableHeaders,$navigationActions['can_sort_columns'])!!}
						<tbody>
							<tr ng-repeat="record in records|filter:query" id=[[$index]] class=[[record.updated]]>							
								<td>[[record.item_code]]</td>
								<td>[[record.description]]</td>
								<td>[[record.quantity]]</td>														
							</tr>									
						</tbody>				
						{!!Html::tfooter(true,6)!!}
					{!!Html::tclose()!!}			
				@endif
			</div>			
		</div>
	</div>
</div>

<script>
	function set_sheet(el)
	{
		var sel = $(el).val();
		var url = 'reports/salesman/sheet/'+sel;
		$.get(url,function(data){
			if(data){
				$('#reference_number').empty();
				$.each(data, function(k,v){
					$('#reference_number')
						.append($("<option></option>")
						.attr("value", k).text(v));
				});
				$('#reference_number').removeAttr('disabled');
			} else {				
				$('#reference_number').empty();
				$('#reference_number').append($("<option></option>").attr("value", '').text('No Count Sheet No.'));
				$('#reference_number').attr('disabled','disabled');
			}							
		});
			
	}	
</script>