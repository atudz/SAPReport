<?php


/**
 * Generate revision number,
 * @param unknown $reportType
 * @param unknown $prefix
 * @return string
 */
function generate_revision($reportType, $prefix='REV')
{
	$max = DB::table('revisions')->where('report_type',$reportType)->max('revision_number');
	$lastCount = str_replace($prefix, '', $max);
	$revision = $prefix . str_pad($lastCount, 5, '0', STR_PAD_LEFT);
	return $revision;
}