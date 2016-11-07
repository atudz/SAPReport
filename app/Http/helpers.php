<?php


use Carbon\Carbon;
use App\Factories\ModelFactory;

/**
 * Generate revision number,
 * @param unknown $reportType
 * @param unknown $prefix
 * @return string
 */
function generate_revision($reportType, $prefix='')
{
	$max = DB::table('report_revisions')->where('report',$reportType)->max('revision_number');
	$lastCount = str_replace($prefix, '', $max);
	$revision = $prefix . str_pad($lastCount+1, 7, '0', STR_PAD_LEFT);
	return $revision;
}


/**
 * Get latest revision number,
 * @param unknown $reportType
 * @param unknown $prefix
 * @return string
 */
function latest_revision($reportType, $prefix='REV')
{
	$max = DB::table('report_revisions')->where('report',$reportType)->max('revision_number');
	return $max;
}

/**
 * Negate number 
 * @param unknown $number
 * @return string|unknown
 */
function negate($number)
{
	return $number < 0 ? '('.abs($number).')' : $number;
}

/**
 * Format date
 * @param unknown $date
 * @param unknown $format
 * @return unknown
 */
function format_date($date, $format)
{
	return (new Carbon($date))->format($format);
}

/**
 * Get salesman
 * @param unknown $code
 * @return string
 */
function sr_salesman($code)
{
	$salesman = ModelFactory::getInstance('RdsSalesman')->where('salesman_code',$code)->first();
	return $salesman ? $salesman->salesman_name : '';
}

/**
 * Get salesman
 * @param unknown $code
 * @return string
 */
function sr_salesman_area($code)
{
	$area = ModelFactory::getInstance('RdsSalesman')->where('salesman_code',$code)->first();
	return $area ? $area->area_name : '';
}

/**
 * Get salesman
 * @param unknown $code
 * @return string
 */
function jr_salesman($code)
{
	$salesman = ModelFactory::getInstance('RdsSalesman')->where('salesman_code',$code)->first();
	return $salesman ? $salesman->jr_salesman_name : '';
}

/**
 * Add reference number
 * @param unknown $report
 * @param unknown $from
 * @param unknown $to
 * @param string $salesman
 */
function add_ref($report, $from, $to, $salesman='')
{
	$prepare = DB::table('report_references')
						->where('from',$from)
						->where('to',$to)
						->where('report',$report);
	if($salesman)
		$prepare->where('salesman',$salesman);
	$exist = $prepare->exists();
	if(!$exist)
	{
		$prepare = DB::table('report_references')
								->where('report',$report);
		if($salesman)
			$prepare->where('salesman',$salesman);
		
		$max = $prepare->max('reference_number');
		$today = new DateTime();
		$revision = str_pad($max+1, 7, '0', STR_PAD_LEFT);
		DB::table('report_references')->insert([
				'from' => $from,
				'to' => $to,
				'revision_number' => get_rev($report),
				'salesman' => $salesman ? $salesman : null,
				'report' => $report,
				'reference_number' => $revision,
				'created_at' => $today,
				'updated_at' => $today,
				'user_id' => auth()->user()->id,
		]);
	}		
}

/**
 * Get reference number
 * @param unknown $report
 * @param unknown $from
 * @param unknown $to
 * @param unknown $salesman
 * @return string
 */
function get_ref($report,$from,$to,$salesman)
{
	$prepare = DB::table('report_references')
						->where('from',$from)
						->where('to',$to)
						->where('report',$report);
	if($salesman)
		$prepare->where('salesman',$salesman);
	return $prepare->first();
}

/**
 * Get revision
 * @param unknown $report
 * @return unknown
 */
function get_rev($report)
{
	return DB::table('report_revisions')->where('report',$report)->max('revision_number');
}