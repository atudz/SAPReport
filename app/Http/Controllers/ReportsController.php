<?php

namespace App\Http\Controllers;

use App\Core\ControllerCore;
use App\Factories\ModelFactory;
use Illuminate\Http\Request;
use App\Factories\LibraryFactory;

class ReportsController extends ControllerCore
{

	/**
	 * Update databsae record
	 * @param unknown $table
	 * @param unknown $id
	 * @param unknown $value
	 * @return boolean
	 */
	public function save(Request $request)
	{
		$id = $request->get('id');
		$column = $request->get('column');
		ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => auth()->user()->id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=',$request->get('slug'))->value('id'),
            'action'        => 'saving editable column ' . $column . ' data having id ' . $id
        ]);

		$table = $request->get('table');
		if(false === strpos($column,'date'))
			$value = $request->get('value');
		else 
			$value = new \DateTime($request->get('value'));
		$comment = $request->get('comment');
		$report_type = $request->has('report_type') ? $request->get('report_type') : '';
		$report = $request->has('report') ? $request->get('report') : '';
		
		$stockTransNum = '';
		$prevInvoiceNum = '';
		$reference='';
		$syncTables = config('sync.sync_tables');
		if($pk = array_shift($syncTables[$table]))
		{
			if($table == 'txn_stock_transfer_in_header')
			{
				$stockTransNum = \DB::table($table)->where($pk,$id)->value($column);
			}
			
			$prevData = \DB::table($table)->where($pk,$id)->first();
			$before = isset($prevData->$column) ? $prevData->$column : '';
			if($column == 'invoice_number')
			{
				$prevInvoiceNum = $before;
				$reference = isset($prevData->reference_num) ? $prevData->reference_num : '';
			}
						
			\DB::table($table)->where($pk,$id)->lockForUpdate()->update([
					$column => $value,
					'updated_at' => new \DateTime(),
					'updated_by' => auth()->user()->id,
			]);

			$logId = \DB::table('table_logs')->insertGetId([
									'table' => $table,
									'column' => $column,
									'pk_id' => $id,
									'before' => $before,
									'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value, 
									'updated_at' => new \DateTime(),
									'created_at' => new \DateTime(),
									'updated_by' => auth()->user()->id,
									'comment' => $comment,
									'report_type' => $report_type,
					]);
			
			if($logId)
			{
				\DB::table('report_revisions')->insert([
						'revision_number' => generate_revision($report),
						'report' => $report,
						'updated_at' => new \DateTime(),
						'created_at' => new \DateTime(),
						'user_id' => auth()->user()->id,
						'table_log_id' => $logId
				]);
			}
		}
		
		if($table == 'txn_stock_transfer_in_header' && $stockTransNum && $column == 'stock_transfer_number')
		{
			$transfer = \DB::table('txn_stock_transfer_in_detail')->where($column,$stockTransNum)->first();			
			
			if($transfer)
			{
				\DB::table('txn_stock_transfer_in_detail')->where($column,$stockTransNum)->lockForUpdate()->update([
						$column => $value,
						'updated_at' => new \DateTime(),
						'updated_by' => auth()->user()->id,
				]);
					
				\DB::table('table_logs')->insertGetId([
									'table' => 'txn_stock_transfer_in_detail',
									'column' => $column,
									'pk_id' => $transfer->stock_transfer_in_detail_id,
									'before' => $transfer->stock_transfer_number,
									'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
									'updated_at' => new \DateTime(),
									'created_at' => new \DateTime(),
									'updated_by' => auth()->user()->id,
									'comment' => $comment,
									'report_type' => $report_type						
							]);								
			}
			
		}
		
		
		if($column == 'invoice_number' && $prevInvoiceNum)
		{
			$insertData = [];
			$data1 = \DB::table('txn_collection_invoice')->where($column,$prevInvoiceNum)->first();
			if($data1)
			{
				$prepare = \DB::table('txn_collection_invoice')->where($column,$prevInvoiceNum);
				if($reference)		
					$prepare->where('reference_num',$reference);
				
				$updated = $prepare->lockForUpdate()->update([
							$column => $value,
							'updated_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
				]);
				
				if(!$updated)
					$updated = \DB::table('txn_collection_invoice')->where($column,$prevInvoiceNum)->lockForUpdate()->update([
													$column => $value,
													'updated_at' => new \DateTime(),
													'updated_by' => auth()->user()->id,
								]);
					
				if($updated)
				{
					$insertData[] = [
							'table' => 'txn_collection_invoice',
							'column' => $column,
							'pk_id' => $data1->collection_invoice_id,
							'before' => $data1->invoice_number,
							'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
							'updated_at' => new \DateTime(),
							'created_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
							'comment' => $comment,
							'report_type' => $report_type,							
					];
				}
			}			
			
			
			if($table != 'txn_invoice')
			{
				$data2 = \DB::table('txn_invoice')->where($column,$prevInvoiceNum)->first();
				if($data2)
				{
					\DB::table('txn_invoice')->where($column,$prevInvoiceNum)->lockForUpdate()->update([
							$column => $value,
							'updated_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
					]);
						
					$insertData[] = [
							'table' => 'txn_invoice',
							'column' => $column,
							'pk_id' => $data2->invoice_id,
							'before' => $data2->invoice_number,
							'value' => ($value instanceof \DateTime) ? $value->format('Y-m-d H:i:s') : $value,
							'updated_at' => new \DateTime(),
							'created_at' => new \DateTime(),
							'updated_by' => auth()->user()->id,
							'comment' => $comment,
							'report_type' => $report_type,
					];
				}
			}
			
			if($insertData)
			{
			 	\DB::table('table_logs')->insert($insertData);			 			  
			}
		}
		
		ModelFactory::getInstance('UserActivityLog')->create([
            'user_id'       => auth()->user()->id,
            'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=',$request->get('slug'))->value('id'),
            'action'        => 'done saving editable column ' . $column . ' data having id ' . $id
        ]);
		$data['success'] = true;
		return response()->json($data);	
	}
	
	/**
	 * Sync reports from SFA db
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function sync()
	{
		ModelFactory::getInstance('UserActivityLog')->create([
			'user_id'       => auth()->user()->id,
		    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','sync-data')->value('id'),
		    'action'        => 'loading Sync Data data'
		]);

		$result = LibraryFactory::getInstance('Sync')->sync();		
		$data['logs'] = $result ? true : '';		

		ModelFactory::getInstance('UserActivityLog')->create([
			'user_id'       => auth()->user()->id,
		    'navigation_id' => ModelFactory::getInstance('Navigation')->where('slug','=','sync-data')->value('id'),
		    'action'        => 'finished loading Sync Data data'
		]);
		return response()->json($data);
	}
	
}
